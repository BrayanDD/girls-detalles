
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Girls Detalles</title>
    <link rel="icon" href="img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+q6nD/t9gGKrB6Gd8VtR2s3wLpc5e" crossorigin="anonymous" defer></script>

    <link rel="stylesheet" href="/detalles/scss/scss.scss">
</head>
<body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-custom ">
        <div class="container-fluid">
           <img src="/detalles/img/logo.png" class="logo ms-3 me-3" alt="">
          <a class="navbar-brand" href="/detalles/index.php">Girls Detalles |</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse " id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Anchetas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Ramos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Para Hombre</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contáctame</a>
              </li>
            </ul>
            <?php 
            session_start();

           
            if(!isset($_SESSION["user"])){   ?>
              <div class="d-flex ms-auto me-3">
                <a href="/detalles/session/session.php"><button type="button" class="btn btn-signin me-2">Iniciar Seccion</button></a>
                <a href="/detalles/session/register.php"><button type="button" class="btn btn-register">Registrarse</button></a>
              </div>
              <?php  }else{
                echo $_SESSION['user']['name'];
              } ?>
          </div>
        </div>
      </nav>
    </header>