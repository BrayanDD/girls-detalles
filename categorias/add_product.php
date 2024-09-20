<?php
session_start();
require '../db/conn.php';

$cat = $conn->prepare('SELECT * FROM categoria');
$cat->execute();
$categorias = $cat->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recibir los datos del formulario
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Separar el id de categoría y el nombre de categoría
    list($categoria_id, $categoria_name) = explode('|', $_POST['categoria']);
    
    // Manejar la imagen
    $photo = $_FILES['photo'];

    if ($photo['error'] === 0) {
        // Crear la ruta del directorio en plural (ejemplo: "anchetas/")
        $categoria_plural = $categoria_name . 's'; // Esto puede ser ajustado si la pluralización es más compleja
        $upload_dir = '../img/' . $categoria_plural . '/';

        // Verificar si el directorio existe, si no, crearlo
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Subir temporalmente la imagen con el nombre original
        $photo_name = basename($photo['name']);
        $upload_file = $upload_dir . $photo_name;

        if (move_uploaded_file($photo['tmp_name'], $upload_file)) {
            // Insertar los datos en la base de datos (sin nombre de imagen definitivo aún)
            $sttm = $conn->prepare('INSERT INTO product (name, description, photo, price, id_categoria) VALUES (?, ?, ?, ?, ?)');
            $sttm->bindParam(1, $name);
            $sttm->bindParam(2, $description);
            $sttm->bindParam(3, $photo_name); // Se coloca el nombre temporalmente
            $sttm->bindParam(4, $price);
            $sttm->bindParam(5, $categoria_id);

            if ($sttm->execute()) {
                // Obtener el último ID insertado (del producto)
                $lastInsertId = $conn->lastInsertId();

                // Generar el nuevo nombre de la imagen: singular + ID del producto (ejemplo: "ancheta1.jpeg")
                $new_photo_name = $categoria_name . $lastInsertId . '.' . pathinfo($photo_name, PATHINFO_EXTENSION);

                // Renombrar el archivo subido
                $new_upload_file = $upload_dir . $new_photo_name;
                rename($upload_file, $new_upload_file);

                // Actualizar el campo "photo" en la base de datos con el nuevo nombre de la imagen
                $update = $conn->prepare('UPDATE product SET photo = ? WHERE id = ?');
                $update->bindParam(1, $new_photo_name);
                $update->bindParam(2, $lastInsertId);
                $update->execute();

                // Redirigir con mensaje de éxito
                $_SESSION['alert'] = [
                    'message' => 'Producto agregado exitosamente',
                    'category' => 'success'
                ];
                header('Location: index.php?id_categoria='.$categoria_id);
                exit;

            } else {
                $_SESSION['alert'] = [
                    'message' => 'Error al agregar el producto',
                    'category' => 'error'
                ];
            }
        } else {
            $_SESSION['alert'] = [
                'message' => 'Error al subir la imagen',
                'category' => 'error'
            ];
        }
    } else {
        $_SESSION['alert'] = [
            'message' => "Error con la imagen: " . $photo['error'],
            'category' => 'error'
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario de Producto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+q6nD/t9gGKrB6Gd8VtR2s3wLpc5e" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="../scss/scss.scss">
</head>

<body>
    <div class="container-alert " id="alert-box">

        <?php require '../partials/alert.php'; ?>
    </div>
    <div class="row d-flex justify-content-center register align-items-center">
        <div class="col-lg-12 col-xl-11">
            <div class="card-body p-md-5">
                <div class="row justify-content-center">
                    <div class="container col-md-12 col-lg-6 col-xl-12 order-2 order-lg-1">
                        <h1>Agregar Producto</h1>

                        <form action="add_product.php" method="POST" enctype="multipart/form-data" class="mx-1 mx-md-4">

                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-box fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="text" name="name" placeholder="Nombre del Producto" class="form-control" required />
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-align-left fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <textarea name="description" placeholder="Descripción del Producto" class="form-control" required></textarea>
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-image fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="file" name="photo" class="form-control" accept="image/*" required />
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-dollar-sign fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="number" name="price" placeholder="Precio del Producto" class="form-control" required />
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-dollar-sign fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <select name="categoria" id="" class="form-select" aria-label="Default select example" required>
                                        <option select disabled>Selecionar Categoria</option>
                                        <?php foreach ($categorias as $categoria): ?>

                                            <option value="<?= $categoria['id']; ?>|<?= $categoria['name']; ?>"><?= $categoria['name']; ?></option>

                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Agregar Producto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/alert.js"></script>

</html>