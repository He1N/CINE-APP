<div class="content-wrapper" style="min-height: 717px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Películas</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Películas</li>

          </ol>

        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="row">

        <!--=====================================
        Listado de Películas
        ======================================-->

        <div class="col-12 col-xl-5">

           <div class="card card-primary card-outline">
             
            <!-- header-card -->

            <div class="card-header pl-2 pl-sm-3">
          
              <a href="habitaciones" class="btn btn-primary btn-sm">Agregar nueva película</a>

              <div class="card-tools">
                
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>

              </div>      

            </div>

            <!-- body-card -->

            <div class="card-body">
              
              <table class="table table-bordered table-striped dt-responsive tablaPeliculas" width="100%">
                
                <thead>

                  <tr>

                    <th style="width:10px">#</th> 
                    <th>Nombre de la Película</th>
                    <th style="width:10px">Acciones</th>          

                  </tr>   

                </thead>

                <tbody>
                  

                </tbody>

              </table>

            </div>

           </div>
          
        </div>

        <!--=====================================
        Editor de Películas
        ======================================-->


        <?php

        if(isset($_GET["id_p"])){

          $pelicula = ControladorPeliculas::ctrMostrarPeliculas($_GET["id_p"]);

        }else{

          $pelicula = null;

        }


        ?>

        <div class="col-12 col-xl-7">

        <div class="card card-primary card-outline">
        
        <!-- header-card -->
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Detalles de la Película</h3>
        </div>

        <!-- body-card -->
        <div class="card-body">
        <?php if ($pelicula): ?>
        <div class="row">
            <!-- Galería -->
            <div class="col-12 mb-4 text-center">
            <strong>Galería:</strong>
            <?php if (!empty($pelicula["galeria"])): ?>
                <div class="card text-center">
                <img 
                    src="<?php echo $pelicula["galeria"]; ?>" 
                    class="card-img-top img-fluid mx-auto d-block" 
                    style="max-width: 100%; max-height: 300px; object-fit: contain;" 
                    alt="Imagen de <?php echo $pelicula["nombre"]; ?>"
                >
                <div class="card-body">
                    <p class="text-muted">Imagen promocional de la película</p>
                </div>
                </div>
            <?php else: ?>
                <p class="text-muted">No hay imagen disponible para esta película.</p>
            <?php endif; ?>
            </div>

            <!-- Trailer -->
            <div class="col-12 mb-4 text-center">
            <strong>Tráiler:</strong>
            <?php if (!empty($pelicula["video"])): ?>
                <div class="embed-responsive embed-responsive-16by9">
                <iframe 
                    class="embed-responsive-item" 
                    style="width: 100%; height: 500px; border: none;" 

                    src="https://www.youtube.com/embed/<?php echo obtenerIdYoutube($pelicula["video"]); ?>" 
                    allowfullscreen>
                </iframe>
                </div>
            <?php else: ?>
                <p class="text-muted">No hay tráiler disponible para esta película.</p>
            <?php endif; ?>
            </div>

            <!-- Detalles -->
            <div class="col-md-6 mb-3">
            <strong>Nombre:</strong>
            <p><?php echo $pelicula["nombre"]; ?></p>
            </div>
            <div class="col-md-6 mb-3">
            <strong>Director:</strong>
            <p><?php echo $pelicula["director"]; ?></p>
            </div>
            <div class="col-md-6 mb-3">
            <strong>Reparto:</strong>
            <p><?php echo $pelicula["reparto"]; ?></p>
            </div>
            <div class="col-md-6 mb-3">
            <strong>Duración:</strong>
            <p><?php echo $pelicula["duracion"]; ?> minutos</p>
            </div>
            <div class="col-md-6 mb-3">
            <strong>Fecha de Estreno:</strong>
            <p><?php echo $pelicula["fecha_estreno"]; ?></p>
            </div>
            <div class="col-md-6 mb-3">
            <strong>Clasificación:</strong>
            <p><?php echo $pelicula["clasificacion"]; ?></p>
            </div>
            <div class="col-md-12 mb-3">
            <strong>Descripción:</strong>
            <p><?php echo $pelicula["descripcion"]; ?></p>
            </div>
            <div class="col-md-6 mb-3">
            <strong>Género:</strong>
            <p><?php echo $pelicula["genero"]; ?></p>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            Selecciona una película para ver los detalles.
        </div>
        <?php endif; ?>

        <?php
        // Función para extraer el ID del video de YouTube desde una URL
        function obtenerIdYoutube($url) {
        preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches);
        return $matches[1] ?? '';
        }
        ?>

  </div>

</div>

</div>



      </div>

    </div>

  </section>
  <!-- /.content -->

</div>