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
     // Ventas diarias
     $sqlDaily = "SELECT DATE(fecha_hora_transaccion) AS fecha, SUM(total) AS total_dia
     FROM reserva
     GROUP BY DATE(fecha_hora_transaccion)
     ORDER BY fecha ASC";
      $stmtDaily = $conn->prepare($sqlDaily);
      $stmtDaily->execute();
      $ventasDiarias = $stmtDaily->fetchAll(PDO::FETCH_ASSOC);

      // Ventas mensuales
      $sqlMonthly = "SELECT DATE_FORMAT(fecha_hora_transaccion, '%Y-%m') AS mes, SUM(total) AS total_mes
            FROM reserva
            GROUP BY mes
            ORDER BY mes ASC";
      $stmtMonthly = $conn->prepare($sqlMonthly);
      $stmtMonthly->execute();
      $ventasMensuales = $stmtMonthly->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo "Error en las consultas: " . $e->getMessage();
  $peliculaMax = null;
  $peliculaMin = null;
  $ventasDiarias = [];
  $ventasMensuales = [];
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
        <!-- Gráficos -->
        <div class="row mt-5">
          <div class="col-6">
            <div class="card">
              <div class="card-header">
                <i class="fas fa-chart-line"></i> Ventas Diarias y Mensuales
              </div>
              <div class="card-body">
                <canvas id="ventasChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<!-- Agregar Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Datos de ventas diarias
  const ventasDiarias = <?= json_encode($ventasDiarias); ?>;
  const labelsDiarias = ventasDiarias.map(item => item.fecha);
  const dataDiarias = ventasDiarias.map(item => parseFloat(item.total_dia));

  // Datos de ventas mensuales
  const ventasMensuales = <?= json_encode($ventasMensuales); ?>;
  const labelsMensuales = ventasMensuales.map(item => item.mes);
  const dataMensuales = ventasMensuales.map(item => parseFloat(item.total_mes));

  // Configuración del gráfico
  const ctx = document.getElementById('ventasChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: [...labelsDiarias, ...labelsMensuales],
      datasets: [
        {
          label: 'Ventas Diarias',
          data: dataDiarias,
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 2,
          fill: false,
          tension: 0.1
        },
        {
          label: 'Ventas Mensuales',
          data: dataMensuales,
          borderColor: 'rgba(153, 102, 255, 1)',
          borderWidth: 2,
          fill: false,
          tension: 0.1
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        }
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Tiempo'
          }
        },
        y: {
          title: {
            display: true,
            text: 'Total ($)'
          }
        }
      }
    }
  });
</script>