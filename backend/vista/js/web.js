// Guardar la cartelera (enviar las películas seleccionadas al servidor)
$('#guardarCartelera').on('click', function () {
    var peliculasEnCartelera = [];
  
    // Recopilar los ID de las películas en la cartelera
    $('#cartelera .list-group-item').each(function () {
      peliculasEnCartelera.push($(this).data('id'));
    });
  
    // Verificar que se seleccionaron películas
    if (peliculasEnCartelera.length > 0) {
      $.ajax({
        url: 'ajax/web.ajax.php', // Ruta al archivo PHP
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
          peliculas: peliculasEnCartelera,
          action: 'guardarCartelera',
        }),
        success: function (response) {
          if (response.success) {
            alert('Cartelera guardada exitosamente.');
          } else {
            alert('Hubo un problema al guardar la cartelera: ' + response.message);
          }
        },
        error: function (xhr, status, error) {
          console.error('Error en la solicitud AJAX:', error);
          alert('Hubo un problema con la solicitud al servidor.');
        },
      });
    } else {
      alert('No has seleccionado ninguna película.');
    }
  });
  