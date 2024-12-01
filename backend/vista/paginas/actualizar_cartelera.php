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
                      echo '<li class="list-group-item d-flex align-items-center" data-id="' . $pelicula['id_p'] . '">';
                      echo '<img src="' . $pelicula['galeria'] . '" alt="Poster de ' . htmlspecialchars($pelicula['nombre']) . '" class="img-thumbnail" style="width: 50px; height: 50px; margin-right: 10px;">';
                      echo '<div>';
                      echo '<strong>' . htmlspecialchars($pelicula['nombre']) . '</strong><br>';
                      echo '<small>Fecha de estreno: ' . htmlspecialchars($pelicula['fecha_estreno']) . '</small>';
                      echo '</div>';
                      echo '</li>';
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
                <button id="guardarCartelera" class="btn btn-success" data-id="<?php echo $pelicula['id_p']; ?>">Guardar Cartelera</button>
              </div>
            </div>
            
          </div>

        </div>
        <form action="?pagina=web" method="POST">
          <table>
              <thead>
                  <tr>
                      <th>Título</th>
                      <th>En cartelera</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  // Conexión a la base de datos
                  $conexion = new PDO("mysql:host=localhost;dbname=cine", "root", "");

                  // Consulta de las películas
                  $peliculas = $conexion->query("SELECT id_p, nombre, en_cartelera FROM pelicula");

                  foreach ($peliculas as $pelicula) {
                      echo "<tr>
                              <td>{$pelicula['nombre']}</td>
                              <td>
                                  <input type='checkbox' name='cartelera[{$pelicula['id_p']}]' value='1' " . ($pelicula['en_cartelera'] ? "checked" : "") . ">
                              </td>
                            </tr>";
                  }
                  ?>
              </tbody>
          </table>
          <button type="submit">Guardar cambios</button>
      </form>

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

  

</script>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $conexion = new PDO("mysql:host=localhost;dbname=cine", "root", "");

    // Obtén los IDs seleccionados
    $seleccionados = isset($_POST['cartelera']) ? array_keys($_POST['cartelera']) : [];

    // Actualiza todas las películas a "no en cartelera"
    $conexion->exec("UPDATE pelicula SET en_cartelera = 0");

    // Actualiza las seleccionadas a "en cartelera"
    if (!empty($seleccionados)) {
        $ids = implode(',', array_map('intval', $seleccionados));
        $conexion->exec("UPDATE pelicula SET en_cartelera = 1 WHERE id_p IN ($ids)");
    }

    // Redirecciona al administrador
}
?>
