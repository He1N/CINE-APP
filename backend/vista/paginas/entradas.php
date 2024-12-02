
<div class="wrapper">

<!-- Content Wrapper -->
<div class="content-wrapper" style="min-height: 717px;">
    <!-- Content Header -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Salas de Cine</h1>
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
                        <div class="card-header bg-primary text-white">
                            <h3 class="mb-0">Administrar Salas de Cine</h3>
                        </div>
                        <div class="card-body">
                            <form action="?pagina=entradas" method="POST">
                                <!-- Selección de Sala -->
                                <div class="mb-3">
                                    <label for="sala" class="form-label">Sala:</label>
                                    <select id="sala" name="id_sala" class="form-select" required>
                                        <?php
                                        // Conexión a la base de datos
                                        $conexion = new PDO("mysql:host=localhost;dbname=cine", "root", "");

                                        // Consulta para obtener las salas
                                        $salas = $conexion->query("SELECT id_sala, nombre_sala FROM sala");
                                        foreach ($salas as $sala) {
                                            echo "<option value='{$sala['id_sala']}'>{$sala['nombre_sala']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Selección de Película en Cartelera -->
                                <div class="mb-3">
                                    <label for="pelicula" class="form-label">Película:</label>
                                    <select id="pelicula" name="id_pelicula" class="form-select" required>
                                        <?php
                                        // Consulta para obtener películas en cartelera
                                        $peliculas = $conexion->query("SELECT id_p, nombre FROM pelicula WHERE en_cartelera = 1");
                                        foreach ($peliculas as $pelicula) {
                                            echo "<option value='{$pelicula['id_p']}'>{$pelicula['nombre']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Selección de Fecha y Hora -->
                                <div class="mb-3">
                                    <label for="fecha" class="form-label">Fecha:</label>
                                    <input type="date" id="fecha" name="fecha" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="hora" class="form-label">Hora:</label>
                                    <input type="time" id="hora" name="hora" class="form-control" required>
                                </div>

                                <!-- Botón para Guardar -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Guardar Programación</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        
        </div>
    </section>
  </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $conexion = new PDO("mysql:host=localhost;dbname=cine", "root", "");

    // Obtener datos del formulario
    $id_sala = $_POST['id_sala'];
    $id_pelicula = $_POST['id_pelicula'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Insertar en la tabla programacion
    $query = $conexion->prepare("INSERT INTO programacion (id_sala, id_pelicula, fecha, hora) VALUES (?, ?, ?, ?)");
    $resultado = $query->execute([$id_sala, $id_pelicula, $fecha, $hora]);

    if ($resultado) {
        echo "<script>alert('Programación guardada correctamente.'); window.location.href = '?pagina=entradas';</script>";
    } else {
        echo "<script>alert('Error al guardar la programación.'); window.history.back();</script>";
    }
}
?>
