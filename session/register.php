<?php
session_start();

require '../db/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashea la contraseña
  $rol = 2;

  $sttm = $conn->prepare('SELECT * FROM user WHERE email = ?');
  $sttm->bindParam(1, $email);
  $sttm->execute();

  if ($sttm->rowCount() > 0) {
    $_SESSION['alert'] = [
      'message' => 'El correo ya está registrado. Intenta con otro.',
      'category' => 'error'
    ];
  } else {
   
    $sttm = $conn->prepare('INSERT INTO user (name, email, password,rol) VALUES (?, ?, ?,?)');
    $sttm->bindParam(1, $name);
    $sttm->bindParam(2, $email);
    $sttm->bindParam(3, $password);
    $sttm->bindParam(4, $rol );

    if ($sttm->execute()) {
      $_SESSION['user'] = [
        'rol' =>$rol,
        'name' => $name
      ];
      $_SESSION['alert'] = [
        'message' => 'Usuario registrado exitosamente. ¡Bienvenido!',
        'category' => 'success'
      ];

      header('Location: ../index.php');
      exit();
    } else {
      $_SESSION['alert'] = [
        'message' => 'Error al registrar usuario.',
        'category' => 'error'
      ];
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Nav Personalizado</title>
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
  <div class="row d-flex justify-content-center register align-items-center ">
    <div class="col-lg-12 col-xl-11">

      <div class="card-body p-md-5">
        <div class="row justify-content-center">
          <div class="container inicio col-md-12 col-lg-6 col-xl-12 order-2 order-lg-1">
            <h1>Iniciar Session</h1>
            <form action="register.php" method="POST" class="mx-1 mx-md-4">
              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                <div data-mdb-input-init class="form-outline flex-fill d-flex mb-0">


                  <input type="text" id="form3Example1c" name="name" placeholder="Tu nombre" class="form-control" />
                </div>
              </div>
              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                <div data-mdb-input-init class="form-outline flex-fill mb-0">
                  <input type="email" id="form3Example3c" name="email" placeholder="Email" class="form-control" />
                </div>
              </div>

              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                <div data-mdb-input-init class="form-outline flex-fill mb-0">
                  <input type="password" id="form3Example4c" name="password" placeholder="Contraseña" class="form-control" />
                </div>
              </div>

              <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                <div data-mdb-input-init class="form-outline flex-fill mb-0">
                  <input type="password" id="form3Example4cd" placeholder="Repetir Contraseña" class="form-control" />
                </div>
              </div>
              <button class="btn " type="submit">Registrarse</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/alert.js"></script>

</body>

</html>