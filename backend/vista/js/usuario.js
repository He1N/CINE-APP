
//AGREGAR ADMIN FUNCION JAVASCRIPT
$(document).ready(function() {
    $('#adminFormAdd').submit(function(event) {
        event.preventDefault(); // Evita el envío tradicional del formulario

        $.ajax({
            type: 'POST',
            url: '../controlador/usuario.controlador.php',
            data: $(this).serialize(),
            success: function(response) {
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
        recargarTabla();
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
                $('body').append(response); 
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

// DATATABLE USUARIOS ADMINISTRADORES
$(".tablaAdministradores").DataTable({
    "ajax": "../ajax/tablaAdministradores.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language": {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_",
        "sInfoEmpty": "Mostrando registros del 0 al 0",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    },
    "error": function (xhr, error, code) {
        console.log(xhr); // Muestra el error en la consola
    }
});
function recargarTabla() {
    table.ajax.reload(null, false);
}





