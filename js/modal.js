

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
