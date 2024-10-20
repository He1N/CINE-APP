
//AGREGAR ADMIN FUNCION JAVASCRIPT
$(document).ready(function() {
    $('#adminFormAdd').submit(function(event) {
        event.preventDefault(); // Evita el envío tradicional del formulario

        $.ajax({
            type: 'POST',
            url: '../controlador/usuario.controlador.php',
            data: $(this).serialize(),
            success: function(response) {
                // Aquí se insertan los mensajes de SweetAlert directamente desde el controlador
                $('body').append(response); // Ejecuta el script de SweetAlert que viene en la respuesta
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al enviar el formulario.'
                });
            }
        });
    });
});

//EDITAR ADMIN FUNCION JAVASCRIPT
$(document).ready(function() {
    $('#adminFormEdit').submit(function(event) {
        event.preventDefault(); // Evita el envío tradicional del formulario

        $.ajax({
            type: 'POST',
            url: '../controlador/usuario.controlador.php',
            data: $(this).serialize(),
            success: function(response) {
                // Aquí se insertan los mensajes de SweetAlert directamente desde el controlador
                $('body').append(response); // Ejecuta el script de SweetAlert que viene en la respuesta
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al enviar el formulario.'
                });
            }
        });
    });
});

//ELIMINAR ADMIN FUNCION JAVASCRIPT
$(document).ready(function() {
    $('#adminFormDelete').submit(function(event) {
        event.preventDefault(); // Evita el envío tradicional del formulario

        $.ajax({
            type: 'POST',
            url: '../controlador/usuario.controlador.php', // Cambia a tu ruta PHP
            data: $(this).serialize(), // Envía los datos del formulario
            success: function(response) {
                // Aquí se insertan los mensajes de SweetAlert directamente desde el controlador
                $('body').append(response); // Ejecuta el script de SweetAlert que viene en la respuesta
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al enviar el formulario.'
                });
            }
        });
    });
});

