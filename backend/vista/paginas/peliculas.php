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
          
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#agregarPelicula">Agregar nueva película</button>

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
                    <th style="width:10px">Agregar</th>          
                    
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
            <!-- Botón de editar -->
            <?php if ($pelicula): ?>
                <button class="btn btn-warning btn-sm float-right" id="btnEditarPelicula" data-id="<?php echo $pelicula['id_p']; ?>" data-toggle="modal" data-target="#modalEditarPelicula">
                    <i class="fas fa-edit"></i> Editar
                </button>
            <?php endif; ?>
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
                <!-- Otros detalles... -->
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
<!--=====================================
Modal Agregar Pelicula
======================================-->
<div class="modal fade" id="agregarPelicula" tabindex="-1" role="dialog" aria-labelledby="agregarPeliculaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="agregarPeliculaLabel">Agregar Nueva Película</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <!-- Nombre -->
            <div class="col-md-6 mb-3">
              <label for="nombre">Nombre:</label>
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la película" required>
            </div>
            <!-- Director -->
            <div class="col-md-6 mb-3">
              <label for="director">Director:</label>
              <input type="text" class="form-control" id="director" name="director" placeholder="Director de la película" required>
            </div>
            <!-- Reparto -->
            <div class="col-md-12 mb-3">
              <label for="reparto">Reparto:</label>
              <input type="text" class="form-control" id="reparto" name="reparto" placeholder="Actores principales (separados por comas)" required>
            </div>
            <!-- Galería -->
            <div class="col-md-12 mb-3">
              <label for="galeria">Imagen (URL):</label>
              <input type="text" class="form-control" id="galeria" name="galeria" placeholder="URL de la imagen promocional" required>
            </div>
            <!-- Video -->
            <div class="col-md-12 mb-3">
              <label for="video">Tráiler (YouTube):</label>
              <input type="text" class="form-control" id="video" name="video" placeholder="Enlace al tráiler en YouTube">
            </div>
            <!-- Duración -->
            <div class="col-md-6 mb-3">
              <label for="duracion">Duración (min):</label>
              <input type="number" class="form-control" id="duracion" name="duracion" placeholder="Duración en minutos" required>
            </div>
            <!-- Fecha de estreno -->
            <div class="col-md-6 mb-3">
              <label for="fecha_estreno">Fecha de Estreno:</label>
              <input type="date" class="form-control" id="fecha_estreno" name="fecha_estreno" required>
            </div>
            <!-- Clasificación -->
            <div class="col-md-6 mb-3">
              <label for="clasificacion">Clasificación:</label>
              <select class="form-control" id="clasificacion" name="clasificacion" required>
                <option value="G">G</option>
                <option value="PG">PG</option>
                <option value="PG-13">PG-13</option>
                <option value="R">R</option>
                <option value="NC-17">NC-17</option>
              </select>
            </div>
            <!-- Género -->
            <div class="col-md-6 mb-3">
              <label for="genero">Género:</label>
              <input type="text" class="form-control" id="genero" name="genero" placeholder="Género de la película (separado por comas)" required>
            </div>
            <!-- Descripción -->
            <div class="col-md-12 mb-3">
              <label for="descripcion">Descripción:</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Sinopsis de la película" required></textarea>
            </div>
          </div>
        </div>
        <?php 

             $registroPelicula = new ControladorPeliculas();
             $registroPelicula -> ctrAgregarPelicula();

        ?>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar Película</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--=====================================
Modal Editar Pelicula
======================================-->

<!-- Modal Editar Película -->
<div class="modal fade" id="modalEditarPelicula" tabindex="-1" role="dialog" aria-labelledby="modalEditarPeliculaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="modalEditarPeliculaLabel">Editar Película</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditarPelicula" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="editarNombre">Nombre:</label>
                            <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                        </div>
                        <!-- Director -->
                        <div class="col-md-6 mb-3">
                            <label for="editarDirector">Director:</label>
                            <input type="text" class="form-control" id="editarDirector" name="director" required>
                        </div>
                        <!-- Reparto -->
                        <div class="col-md-12 mb-3">
                            <label for="editarReparto">Reparto:</label>
                            <input type="text" class="form-control" id="editarReparto" name="reparto" required>
                        </div>
                        <!-- Galería -->
                        <div class="col-md-12 mb-3">
                            <label for="editarGaleria">Imagen (URL):</label>
                            <input type="text" class="form-control" id="editarGaleria" name="galeria" required>
                        </div>
                        <!-- Video -->
                        <div class="col-md-12 mb-3">
                            <label for="editarVideo">Tráiler (YouTube):</label>
                            <input type="text" class="form-control" id="editarVideo" name="video">
                        </div>
                        <!-- Duración -->
                        <div class="col-md-6 mb-3">
                            <label for="editarDuracion">Duración (min):</label>
                            <input type="number" class="form-control" id="editarDuracion" name="duracion" required>
                        </div>
                        <!-- Fecha de estreno -->
                        <div class="col-md-6 mb-3">
                            <label for="editarFechaEstreno">Fecha de Estreno:</label>
                            <input type="date" class="form-control" id="editarFechaEstreno" name="fecha_estreno" required>
                        </div>
                        <!-- Clasificación -->
                        <div class="col-md-6 mb-3">
                            <label for="editarClasificacion">Clasificación:</label>
                            <select class="form-control" id="editarClasificacion" name="clasificacion" required>
                                <option value="G">G</option>
                                <option value="PG">PG</option>
                                <option value="PG-13">PG-13</option>
                                <option value="R">R</option>
                                <option value="NC-17">NC-17</option>
                            </select>
                        </div>
                        <!-- Género -->
                        <div class="col-md-6 mb-3">
                            <label for="editarGenero">Género:</label>
                            <input type="text" class="form-control" id="editarGenero" name="genero" required>
                        </div>
                        <!-- Descripción -->
                        <div class="col-md-12 mb-3">
                            <label for="editarDescripcion">Descripción:</label>
                            <textarea class="form-control" id="editarDescripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <?php
                    $editarPelicula = new ControladorPeliculas();
                    $editarPelicula->ctrEditarPelicula();
                ?>

                <div class="modal-footer">
                    <input type="hidden" id="idPelicula" name="idPelicula">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

