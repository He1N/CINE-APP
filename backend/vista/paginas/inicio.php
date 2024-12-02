<?php 

if($admin["perfil"] != "Administrador"){
  echo '<script>
    window.location = "banner";
  </script>';
  return;
}

// Conexión con PDO
// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=cine", "root", "");
try {
    // Película con más reservas
    $sqlMax = "SELECT p.nombre, p.imagen, COUNT(r.id) AS total_reservas 
               FROM pelicula p
               JOIN reserva r ON p.id = r.pelicula_id
               GROUP BY p.id
               ORDER BY total_reservas DESC 
               LIMIT 1";
    $stmtMax = $conn->prepare($sqlMax);
    $stmtMax->execute();
    $peliculaMax = $stmtMax->fetch(PDO::FETCH_ASSOC);

    // Película con menos reservas
    $sqlMin = "SELECT p.nombre, p.imagen, COUNT(r.id) AS total_reservas 
               FROM pelicula p
               LEFT JOIN reserva r ON p.id = r.pelicula_id
               GROUP BY p.id
               ORDER BY total_reservas ASC 
               LIMIT 1";
    $stmtMin = $conn->prepare($sqlMin);
    $stmtMin->execute();
    $peliculaMin = $stmtMin->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error en las consultas: " . $e->getMessage();
    $peliculaMax = null;
    $peliculaMin = null;
}

?>

<div class="wrapper">
  
  <!-- Content Wrapper -->
  <div class="content-wrapper" style="min-height: 717px;">
    <!-- Content Header -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="?pagina=inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Analíticas</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Dashboard Cards -->
          <div class="col-3">
            <div class="card bg-primary text-white">
              <div class="card-header">
                <i class="fas fa-users"></i> Total de Usuarios
              </div>
              <div class="card-body">
                <h5 class="card-title">1,250</h5>
                <p class="card-text">Usuarios registrados.</p>
              </div>
            </div>
          </div>

          <div class="col-3">
            <div class="card bg-success text-white">
              <div class="card-header">
                <i class="fas fa-dollar-sign"></i> Ventas Mensuales
              </div>
              <div class="card-body">
                <h5 class="card-title">$12,345</h5>
                <p class="card-text">Ventas realizadas este mes.</p>
              </div>
            </div>
          </div>

          <div class="col-3">
            <div class="card bg-warning text-white">
              <div class="card-header">
                <i class="fas fa-eye"></i> Visitas del Sitio
              </div>
              <div class="card-body">
                <h5 class="card-title">5,678</h5>
                <p class="card-text">Visitas este mes.</p>
              </div>
            </div>
          </div>

          <div class="col-3">
            <div class="card bg-danger text-white">
              <div class="card-header">
                <i class="fas fa-exclamation-triangle"></i> Alertas Críticas
              </div>
              <div class="card-body">
                <h5 class="card-title">3</h5>
                <p class="card-text">Alertas sin resolver.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Cards for Movie Analytics -->
        <div class="row mt-4">
          <!-- Película con más reservas -->
          <div class="col-6">
            <div class="card bg-info text-white">
              <div class="card-header">
                <i class="fas fa-film"></i> Película con Más Reservas
              </div>
              <div class="card-body text-center">
                <img src="<?= $peliculaMax ? $peliculaMax['imagen'] : 'vista/default.png'; ?>" 
                     alt="Imagen de <?= $peliculaMax ? $peliculaMax['nombre'] : 'película'; ?>" 
                     class="img-fluid mb-3" 
                     style="max-height: 200px;">
                <h5 class="card-title">
                  <?= $peliculaMax ? $peliculaMax['nombre'] : 'Sin datos'; ?>
                </h5>
                <p class="card-text">
                  Reservas: <?= $peliculaMax ? $peliculaMax['total_reservas'] : '0'; ?>
                </p>
              </div>
            </div>
          </div>

          <!-- Película con menos reservas -->
          <div class="col-6">
            <div class="card bg-secondary text-white">
              <div class="card-header">
                <i class="fas fa-film"></i> Película con Menos Reservas
              </div>
              <div class="card-body text-center">
                <img src="<?= $peliculaMin ? $peliculaMin['imagen'] : 'ruta/default.jpg'; ?>" 
                     alt="Imagen de <?= $peliculaMin ? $peliculaMin['nombre'] : 'película'; ?>" 
                     class="img-fluid mb-3" 
                     style="max-height: 200px;">
                <h5 class="card-title">
                  <?= $peliculaMin ? $peliculaMin['nombre'] : 'Sin datos'; ?>
                </h5>
                <p class="card-text">
                  Reservas: <?= $peliculaMin ? $peliculaMin['total_reservas'] : '0'; ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
