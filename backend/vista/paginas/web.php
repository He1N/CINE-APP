<?php 
// Incluimos el controlador

if($admin["perfil"] != "Administrador"){
  echo '<script>
    window.location = "banner";
  </script>';
  return;
}

// Instanciamos el controlador
$controlador = new ControladorWeb();

// Obtener las películas disponibles
$peliculasDisponibles = $controlador->obtenerPeliculasDisponibles();
?>

<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="inicio" class="nav-link">Inicio</a>
      </li>
    </ul>
  </nav>

  <!-- Content Wrapper -->
  <div class="content-wrapper" style="min-height: 717px;">
    <!-- Content Header -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Control de Cartelera</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Control de Cartelera</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Películas Disponibles -->
          <div class="col-12 col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Películas Disponibles</h3>
              </div>
              <div class="card-body">
                <ul id="peliculasDisponibles" class="list-group">
                  <?php
                    // Mostrar las películas desde el controlador
                    foreach ($peliculasDisponibles as $pelicula) {
                      echo '<li class="list-group-item" data-id="' . $pelicula['id_p'] . '">' . $pelicula['nombre'] . '</li>';
                    }
                  ?>
                </ul>
              </div>
            </div>
          </div>

          <!-- Cartelera -->
          <div class="col-12 col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Películas en Cartelera</h3>
              </div>
              <div class="card-body">
                <ul id="cartelera" class="list-group">
                  <!-- Las películas seleccionadas irán aquí -->
                </ul>
              </div>
              <div class="card-footer">
                <button id="guardarCartelera" class="btn btn-success">Guardar Cartelera</button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
</div>

<!-- Cargar la librería SortableJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
  // Inicializamos Sortable para la lista de películas disponibles y la cartelera
  new Sortable(document.getElementById('peliculasDisponibles'), {
    group: 'shared', // Esto permite arrastrar entre dos listas
    animation: 150   // Animación suave al arrastrar
  });

  new Sortable(document.getElementById('cartelera'), {
    group: 'shared',
    animation: 150
  });

  // Guardar la cartelera (enviar las películas seleccionadas al servidor)
  document.getElementById('guardarCartelera').addEventListener('click', function() {
    var peliculasEnCartelera = [];
    // Recopilar los ID de las películas en la cartelera
    document.querySelectorAll('#cartelera .list-group-item').forEach(function(item) {
      peliculasEnCartelera.push(item.getAttribute('data-id'));
    });

    if (peliculasEnCartelera.length > 0) {
      // Enviar los datos al servidor
      fetch('guardar_cartelera.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ peliculas: peliculasEnCartelera })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Cartelera guardada exitosamente.');
        } else {
          alert('Hubo un problema al guardar la cartelera.');
        }
      });
    } else {
      alert('No has seleccionado ninguna película.');
    }
  });
</script>
