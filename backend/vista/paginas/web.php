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

        <div class="container mt-5">
    <div class="card shadow">
        
        <div class="card-body">
            <form action="?pagina=web" method="POST">
                <table id="tablaPeliculas" class="table table-striped table-hover" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>En cartelera</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Conexión a la base de datos
                        $conexion = new PDO("mysql:host=localhost;dbname=cine", "root", "");

                        // Consulta de las películas
                        $peliculas = $conexion->query("SELECT id, nombre, descripcion, estreno, imagen FROM pelicula");

                        foreach ($peliculas as $pelicula) {
                            echo "<tr>
                                    <td>{$pelicula['id']}</td>
                                    <td>
                                        <img src='{$pelicula['imagen']}' alt='{$pelicula['nombre']}' style='width: 80px; height: auto; border-radius: 5px;'>
                                    </td>
                                    <td>{$pelicula['nombre']}</td>
                                    <td>" . substr($pelicula['descripcion'], 0, 50) . "...</td>
                                    <td class='text-center'>
                                        <input type='checkbox' name='cartelera[{$pelicula['id']}]' value='1' " . ($pelicula['estreno'] ? "checked" : "") . ">
                                    </td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#tablaPeliculas').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true
        });
    });
</script>

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
    $conexion->exec("UPDATE pelicula SET estreno = 0");

    // Actualiza las seleccionadas a "en cartelera"
    if (!empty($seleccionados)) {
        $ids = implode(',', array_map('intval', $seleccionados));
        $conexion->exec("UPDATE pelicula SET estreno = 1 WHERE id IN ($ids)");
    }

   
}
?>
