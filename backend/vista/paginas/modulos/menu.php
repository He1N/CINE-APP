<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:#2f3653">

  <!--=====================================
  LOGO
  ======================================-->
  <a href="inicio" class="brand-link">
  
    <!--<img src="vistas/img/plantilla/icono.jpg" class="brand-image img-circle elevation-3" style="opacity: .8">
    -->
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

          <a href="inicio" class="nav-link">

            <i class="icon-dashboard"></i>

            <p>Dashboard</p>

          </a>

        </li>

        <!-- Botón página usuarios -->

       
          
          <li class="nav-item">

            <a href="usuarios" class="nav-link">

              <i class="nav-icon fas fa-users-cog"></i>

              <p>Usuarios</p>

            </a>

          </li>

          <?php endif ?>

        <!-- Botón página entradas -->

        <li class="nav-item">
          <a href="entradas" class="nav-link">
            <i class="nav-icon far fa-images"></i>
            <p>
              Banner
            </p>
          </a>
        </li>

        <!-- Botón página peliculas -->

        <li class="nav-item">
          
          <a href="peliculas" class="nav-link">
            
            <i class="nav-icon fas fa-shopping-bag"></i>
            
            <p>Planes</p>
          
          </a>

        </li>

        <!-- Botón página ofertas -->

        <li class="nav-item">
          
          <a href="ofertas" class="nav-link">
            
            <i class="nav-icon fas fa-list-ul"></i>
            
            <p>Categorías</p>
          
          </a>

        </li>

        

      </ul>

    </nav>
  
  </div>

</aside>