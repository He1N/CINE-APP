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

  $(document).on('click', '.btnEditarPelicula', function () {
    let idPelicula = $(this).data('id'); // Obtener el ID de la película

    // Solicitud Ajax para obtener los datos de la película
    $.ajax({
        url: 'ajax/peliculas.ajax.php', // Ruta al archivo recién creado
        method: 'POST',
        data: { id: idPelicula },
        dataType: 'json',
        success: function (respuesta) {
            // Precargar los datos en el formulario del modal
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
            $('#idPelicula').val(respuesta.id_p); // Campo oculto para el ID
        },
        error: function () {
            alert('Hubo un error al intentar obtener los datos de la película.');
        }
    });
});
