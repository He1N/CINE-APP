<?php 

if($admin["perfil"] != "Administrador"){
  echo '<script>
    window.location = "banner";
  </script>';
  return;
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
      </div>
    </section>
  </div>
</div>
