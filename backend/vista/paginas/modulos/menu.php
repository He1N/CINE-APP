<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:#2f3653">

  <!--=====================================
  LOGO
  ======================================-->
  <a href="inicio" class="brand-link">
  
    <img src="vista/images/plantilla/logo.png" class="brand-image img-circle elevation-3" style="opacity: .8">
    
    <span class="brand-text font-weight-light">Cinesmero Admin</span>

  </a>

  <!--=====================================
  MENÚ
  ======================================-->

  <div class="sidebar">

    <nav class="mt-2">
      
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- botón Ver página Cinesmero -->

        <li class="nav-item">
          
          <a href="<?php echo $ruta; ?>" class="nav-link active" target="_blank">
            
            <i class="nav-icon fas fa-globe"></i>
            
            <p>Ver sitio</p>

          </a>

        </li>

        <?php if ($admin["perfil"] == "Administrador"): ?>


        <!-- Botón página Dashboard -->

        <li class="nav-item">

          <a href="?pagina=inicio" class="nav-link">

          <i class="nav-icon fas fa-tachometer-alt"></i>

            <p>Dashboard</p>

          </a>

        </li>

        <!-- Botón página usuarios -->

       
          
          <li class="nav-item">

            <a href="?pagina=usuarios" class="nav-link">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>Usuarios</p>
            </a>


          </li>

          <?php endif ?>

        <!-- Botón página entradas -->

        <li class="nav-item">
          <a href="?pagina=entradas" class="nav-link">
          <i class="nav-icon fas fa-film"></i>
          <p>
              Salas de cine
            </p>
          </a>
        </li>

        <!-- Botón página peliculas -->

        <li class="nav-item">
          
          <a href="?pagina=peliculas" class="nav-link">
            
          <i class="nav-icon fas fa-video"></i>
            
            <p>Peliculas</p>
          
          </a>

        </li>

        <!-- Botón página ofertas -->

        <li class="nav-item">
          
          <a href="?pagina=web" class="nav-link">
            
          <i class="nav-icon fas fa-tools"></i>
            
            <p>Control Web</p>
          
          </a>

        </li>

        

      </ul>

    </nav>
  
  </div>

</aside>