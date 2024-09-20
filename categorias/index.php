<?php
require '../partials/header.php';
require '../db/conn.php';

// Número de productos por página
$products_per_page = 9;

// Verificar en qué página estamos
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

// Calcular el desplazamiento (OFFSET) para la consulta SQL
$offset = ($page - 1) * $products_per_page;
$product_detail = null;

// Consulta para obtener el número total de productos de la categoría
if (isset($_GET['id_categoria'])) {
    $sttm = $conn->prepare('SELECT COUNT(*) FROM product WHERE id_categoria = ?');
    $sttm->bindParam(1, $_GET['id_categoria']);
    $sttm->execute();
    $total_products = $sttm->fetchColumn();

    // Calcular el número total de páginas
    $total_pages = ceil($total_products / $products_per_page);

    // Consulta para obtener productos con paginación
    $sttm = $conn->prepare('
        SELECT pro.*, cat.name AS category_name
        FROM product pro
        INNER JOIN categoria cat ON pro.id_categoria = cat.id
        WHERE pro.id_categoria = ?
        LIMIT ? OFFSET ?
    ');

    $sttm->bindParam(1, $_GET['id_categoria'], PDO::PARAM_INT);
    $sttm->bindParam(2, $products_per_page, PDO::PARAM_INT);
    $sttm->bindParam(3, $offset, PDO::PARAM_INT);
    $sttm->execute();
    $products = $sttm->fetchAll(PDO::FETCH_ASSOC);
}

?>
<div class="container-alert " id="alert-box">

<?php require '../partials/alert.php'; ?>
</div>
<div class="container">
    <?php if (!empty($products)): ?>
        <h1><?= htmlspecialchars($products[0]['category_name']) ?></h1>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <div class="card mx-auto align-items-center">
                        <img src="../img/<?= htmlspecialchars($product['photo']) ?>" class="mt-1 card-img-top" alt="Producto">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text">Precio: $<?= htmlspecialchars($product['price']) ?></p>
                            <form action="index.php" method="POST">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    data-name="<?= htmlspecialchars($product['name']) ?>"
                                    data-price="<?= htmlspecialchars($product['price']) ?>"
                                    data-description="<?= htmlspecialchars($product['description']) ?>">
                                    Info
                                </button>
                                <a href="#" class="btn ms-2">Añadir</a>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <nav>
            <ul class="pagination justify-content-center mt-4">

                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?id_categoria=<?= $_GET['id_categoria'] ?>&page=<?= $page - 1 ?>">Anterior</a>
                </li>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?id_categoria=<?= $_GET['id_categoria'] ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?id_categoria=<?= $_GET['id_categoria'] ?>&page=<?= $page + 1 ?>">Siguiente</a>
                </li>
            </ul>
        </nav>

    <?php else: ?>
        <h1>No se encontraron productos para esta categoría.</h1>
    <?php endif; ?>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del producto</h1>
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

            // Actualizar el contenido del modal
            var modalTitle = exampleModal.querySelector('.modal-title');
            var modalBodyName = exampleModal.querySelector('#product-name');
            var modalBodyPrice = exampleModal.querySelector('#product-price');
            var modalBodyDescription = exampleModal.querySelector('#product-description');

            modalTitle.textContent = 'Detalles del producto';
            modalBodyName.textContent = productName;
            modalBodyPrice.textContent = 'COP $' + productPrice;
            modalBodyDescription.textContent = productDescription;
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/alert.js"></script>

</body>

</html>