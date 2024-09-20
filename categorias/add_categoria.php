<?php
session_start();
require '../db/conn.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $name = $_POST['name'];
   
  
   
            $sttm = $conn->prepare('INSERT INTO categoria (name) VALUES (?');
            $sttm->bindParam(1, $name);
       
            if ($sttm->execute()) {
           

                // Redirigir con mensaje de éxito
                $_SESSION['alert'] = [
                    'message' => 'Categoria agregada exitosamente',
                    'category' => 'success'
                ];
                header('Location: ../index.php');
                exit;

            } else {
                $_SESSION['alert'] = [
                    'message' => 'Error al agregar la categoria',
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
    <title>Girls detalles</title>
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
                        <h1>Agregar Categoria</h1>

                        <form action="add_categoria.php" method="POST" enctype="multipart/form-data" class="mx-1 mx-md-4">

                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-box fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="text" name="name" placeholder="Nombre de la categoria" class="form-control" required />
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