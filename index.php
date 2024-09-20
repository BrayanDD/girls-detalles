<?php


require 'partials/header.php';
require 'db/conn.php';


$sttm = $conn->prepare('SELECT * FROM product');
$sttm->execute();
$products = $sttm->fetchAll(PDO::FETCH_ASSOC);


$product_detail = null;


$sttms = $conn->prepare('SELECT * FROM categoria');
$sttms->execute();
$categorias = $sttms->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container-alert " id="alert-box">

  <?php require 'partials/alert.php'; ?>
</div>
<div class="container">
  <h1 class="mt-2">¡Lo más popular!</h1>
  <?php 
  if(isset($_SESSION['user']['rol'])  == 1) {
    ?>
    <a href="categorias/add_product.php"></a><button class="btn">Añadir</button>
    <?php
   }
  ?>
  <div class="container-card">
    <!-- <div class="button-container">
      <button type="button" class="btn siguiente">
        < </button>
    </div> -->

    <div class="cards pt-2">

      <?php 
      
      foreach ($products as $product): ?>
        <div class="col-md-4  col-12">
          <div class="card mx-auto align-items-center">
            <img src="img/<?= $product['photo']; ?>" class="mt-1 card-img-top" alt="Imagen de producto">
            <div class="card-body">
              <h5 class="card-title"><?= $product['name']; ?></h5>
              <p class="card-text">COP $<?= $product['price']; ?></p>

              <form action="index.php" method="post">
                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal" data-name="<?= htmlspecialchars($product['name']) ?>"
                  data-price="<?= htmlspecialchars($product['price']) ?>"
                  data-description="<?= htmlspecialchars($product['description']) ?>"
                  data-photo="img/<?= htmlspecialchars($product['photo']) ?>">>Info</button>
                <a class="btn ms-2">Añadir</a>

              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- <div class="button-container">
      <button type="button" class="btn siguiente">></button>
    </div> -->
  </div>

  <h1 class="mt-3">¡Lo que ofrecemos!</h1>
  <?php 
  if(isset($_SESSION['user']['rol'])  == 1) {
    ?>
    <a href="categorias/add_categoria.php"></a><button class="btn">Añadir</button>
    <?php
   }
  ?>
  <div class="container-categorias d-flex flex-wrap">
    <?php foreach ($categorias as $categoria): ?>


      <div class="categorias col-12 col-md-3 mb-3 align-items-center">
       
        <a href="categorias/index.php?id_categoria=<?= $categoria['id']; ?>">
          <h2><?= $categoria['name']; ?></h2>
        </a>

      </div>
    <?php endforeach; ?>

  </div>
</div>

<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <img id="product-photo" src="" alt="Imagen del producto" class="img-fluid" style="max-width: 100px;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nombre:</strong> <span id="product-name"></span></p>
                <p><strong>Precio:</strong> <span id="product-price"></span></p>
                <p><strong>Descripción:</strong> <span id="product-description"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="d-flex">
              <img id="product-photo" src="" alt="Imagen del producto" class="img-fluid" >
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  
              <div class="info-product">
                  <h1 id="product-name"> </h1>
                  <p><strong>Precio:</strong> <span id="product-price"></span></p>
                  <p><strong>Descripción:</strong> <span id="product-description"></span></p>
              </div>
              
            </div>
            
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    var exampleModal = document.getElementById('exampleModal');

    exampleModal.addEventListener('show.bs.modal', function(event) {
        // Botón que activó el modal
        var button = event.relatedTarget;

        // Extraer la información de los atributos data-*
        var productName = button.getAttribute('data-name');
        var productPrice = button.getAttribute('data-price');
        var productDescription = button.getAttribute('data-description');
        var productPhoto = button.getAttribute('data-photo');  // Obtener la URL de la imagen

        // Actualizar el contenido del modal
        var modalBodyName = exampleModal.querySelector('#product-name');
        var modalBodyPrice = exampleModal.querySelector('#product-price');
        var modalBodyDescription = exampleModal.querySelector('#product-description');
        var modalProductPhoto = exampleModal.querySelector('#product-photo');  // Seleccionar la imagen

        modalBodyName.textContent = productName;
        modalBodyPrice.textContent = 'COP $' + productPrice;
        modalBodyDescription.textContent = productDescription;

        // Actualizar la imagen
        modalProductPhoto.src = productPhoto;
    });
});

</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/alert.js"></script>
</body>

</html>