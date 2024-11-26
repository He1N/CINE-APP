$(".tablaPeliculas").DataTable({
    "ajax":"ajax/tablaPeliculas.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language": {
  
       "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
  
     }
  
  })

  $(document).on('click', '#btnEditarPelicula', function () {
    var idPelicula = $(this).data('id'); // Obtener el ID de la película desde data-id

    // Petición AJAX para obtener los datos de la película
    $.ajax({
        url: 'ajax/peliculas.ajax.php',
        method: 'POST',
        data: { idPelicula: idPelicula },
        dataType: 'json',
        success: function (respuesta) {
            $('#editarId').val(respuesta.id_p); // Cambiar 'id' por 'id_p'
            $('#editarNombre').val(respuesta.nombre);
            $('#editarDirector').val(respuesta.director);
            $('#editarReparto').val(respuesta.reparto);
            $('#editarGaleria').val(respuesta.galeria);
            $('#editarVideo').val(respuesta.video);
            $('#editarDuracion').val(respuesta.duracion);
            $('#editarFechaEstreno').val(respuesta.fecha_estreno);
            $('#editarClasificacion').val(respuesta.clasificacion);
            $('#editarGenero').val(respuesta.genero);
            $('#editarDescripcion').val(respuesta.descripcion);
    
            $('#modalEditarPelicula').modal('show');
        },
        error: function (error) {
            console.error("Error al obtener datos:", error);
        }
    });
    
});


$(document).on('click', '.btnEliminarPelicula', function () {

    var idPelicula = $(this).data('id'); // Obtener el ID de la película desde data-id
    console.log("ID de la película:", idPelicula);

    // Confirmación antes de eliminar
    swal({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(function(result){
        if (result.value) {

            var datos = new FormData();
            datos.append("idEliminarPelicula",idPelicula);

            $.ajax({
                url: 'ajax/peliculas.ajax.php',
                method: 'POST',
                data: datos,
	            cache: false,
	            contentType: false,
	            processData: false,
                success: function (respuesta) {
                    if(respuesta == "ok"){

                        swal({
                        type: "success",
                        title: "¡CORRECTO!",
                        text: "El administrador ha sido borrado correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                       }).then(function(result){
  
                          if(result.value){
  
                            window.location = "administradores";
  
                          }
                      
                      })
  
                    }
                },
                error: function (error) {
                    console.error("Error en la eliminación:", error);
                }
            });
        }
    });
});


$(document).ready(function () {
    $(".tablaActores").DataTable({
        ajax: "ajax/actores.ajax.php",
        columns: [
            { data: "id" },
            {
                data: "foto",
                render: function (data) {
                    return `<img src="${data}" class="img-thumbnail" style="width: 50px; height: 50px;">`;
                },
            },
            { data: "nombre" },
            {
                data: "id",
                render: function (data) {
                    return `<button class="btn btn-danger btnEliminarActor" data-id="${data}"><i class="fas fa-trash"></i></button>`;
                },
            },
        ],
    });
});
