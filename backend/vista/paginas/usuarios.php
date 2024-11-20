
<div class="content-wrapper" style="min-height: 717px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Usuarios</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Administradores</li>

          </ol>

        </div>

      </div>

    </div><!-- /.container-fluid -->
    <div class="col-sm-6">

          <h2>Administradores</h2>

    </div>
  </section>
   <!-- Main content -->
   <section class="content">

    <div class="container-fluid">

      <div class="row">

        <div class="col-12">

        <!-- Default box -->
        <div class="card card-info card-outline">

          <div class="card-header">

            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearAdministrador">Crear nuevo administrador</button>

          </div>
          <!-- /.card-header -->

            <div class="card-body">
                  
                  <table class="table table-bordered table-striped dt-responsive tablaUsuario" width="100%">
                    
                    <thead>
                      
                      <tr>
                        
                        <th style="width:10px">#</th>
                        <th>Foto de Perfil</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Contraseña</th>
                        <th>Acciones</th>

                      </tr>

                    </thead>

                    <tbody>


                    </tbody>

                  </table>

            </div>
        </div>
      </div>
    </div>

  </section>
  <div class="col-sm-6">
          <h2>Usuarios de la web</h2>
  </div>

   <!-- Main content -->
 <section class="content">

<div class="card card-primary card-outline">

  <div class="card-body">

    <table class="table table-bordered table-striped dt-responsive tablaUsuarioRegistrado" width="100%">
    
      <thead>

        <tr>

          <th style="width:10px">#</th>
          <th>Foto</th> 
          <th>Nombre</th>
          <th>Contraseña</th>
          <th>Email</th>
          <th>Tipo de Usuario</th> 
          <th>DNI</th>     
          <th>Acciones</th>
        </tr>   

      </thead>

      <tbody>

      <!--   <tr>
          
          <td>1</td>

          <td>
            <img src="vistas/img/usuarios/3/279.png" class="rounded-circle" width="50px">
          </td> 
          
          <td>
            Juan Fernando Urrego
          </td> 

          <td>
            correotutorialesatualcance@gmail.com
          </td>            

          <td>
            3
          </td> 

          <td>
            1
          </td> 

        </tr>  -->

      </tbody>

    </table>

  </div>

</div>
<!-- /.card -->
</section>
</div>

    
<!--=====================================
Modal Crear Administrador
======================================-->

<div class="modal" id="crearAdministrador">

  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post">
      
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Crear Administrador</h4>

           <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

          <!-- input nombre -->
          
          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-user"></span>

            </div>

            <input type="text" class="form-control" name="registroNombre" placeholder="Ingresa el nombre" required>   

          </div>

          <!-- input usuario -->

          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-user-lock"></span>

            </div>

            <input type="text" class="form-control" name="registroUsuario" placeholder="Ingresa el usuario" required>   

          </div>

          <!-- input password -->

          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-lock"></span>

            </div>

            <input type="password" class="form-control" name="registroPassword" placeholder="Ingresa la contraseña" required>   

          </div>

           

           <?php 

             $registroAdministrador = new ControladorUsuarios();
             $registroAdministrador -> ctrRegistroAdministrador();

           ?>

        </div>

        <div class="modal-footer d-flex justify-content-between">
          
          <div>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>

          <div>
             <button type="submit" class="btn btn-primary">Guardar</button>
          </div>

        </div>

      </form>

    </div>

  </div>

</div>
<!--=====================================
Modal Editar Administrador
======================================-->

<div class="modal" id="editarAdministrador">

  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post">
      
        <div class="modal-header bg-info">
          
          <h4 class="modal-title">Editar Administrador</h4>

           <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

          <input type="hidden" name="editarId">

          <!-- input nombre -->
          
          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-user"></span>

            </div>

            <input type="text" class="form-control" name="editarNombre" value required>   

          </div>

          <!-- input usuario -->

          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-user-lock"></span>

            </div>

            <input type="text" class="form-control" name="editarUsuario" value required>   

          </div>

          <!-- input password -->

          <div class="input-group mb-3">
             
            <div class="input-group-append input-group-text">
              
               <span class="fas fa-lock"></span>

            </div>

            <input type="password" class="form-control" name="editarPassword" placeholder="Cambie la contraseña"> 
            <input type="hidden" name="passwordActual">     

          </div>

           <?php 

             $editarAdministrador = new ControladorUsuarios();
             $editarAdministrador -> ctrEditarAdministrador();

           ?>

        </div>

        <div class="modal-footer d-flex justify-content-between">
          
          <div>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>

          <div>
             <button type="submit" class="btn btn-primary">Guardar</button>
          </div>

        </div>

      </form>

    </div>

  </div>

</div>
