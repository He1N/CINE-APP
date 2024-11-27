<body style="margin: 0; padding: 0; font-family: 'Source Sans Pro', sans-serif;">

  <div style="display: flex; height: 100vh;">

    <!-- Imagen de fondo -->
    <div style="flex: 1; background: url('vista/images/login/fondo.jpg') no-repeat center center; background-size: cover;">
    </div>

    <!-- Formulario de inicio de sesión -->
    <div style="flex: 1; background-color: #2f3653; display: flex; align-items: center; justify-content: center;">
      <div style="width: 100%; max-width: 400px; text-align: center; color: #fff;">

        <!-- Logo -->
        <img src="vista/images/login/logo.png" alt="Cinesmero Admin" style="max-width: 400px; margin-bottom: 20px;">

        <h2 style="font-weight: bold; margin-bottom: 30px;">Iniciar Sesión</h2>

        <form method="post" style="width: 100%;">

          <!-- Campo de usuario -->
          <div style="margin-bottom: 20px;">
            <input type="text" class="form-control" placeholder="Ingrese su usuario" name="ingresoUsuario" 
                   style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 5px;">
          </div>

          <!-- Campo de contraseña -->
          <div style="margin-bottom: 20px; position: relative;">
            <input type="password" class="form-control" placeholder="Ingrese su contraseña" name="ingresoPassword" 
                   style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 5px;">
            <i class="fas fa-eye" style="position: absolute; right: 15px; top: 12px; cursor: pointer; color: #aaa;"></i>
          </div>

          <!-- Botón de ingresar -->
          <button type="submit" class="btn btn-primary btn-block" 
                  style="width: 100%; padding: 12px; background-color: #ffd400; color: #000; font-weight: bold; border: none; border-radius: 5px;">
            Ingresar
          </button>

          <?php
          $ingreso = new ControladorUsuarios();
          $ingreso -> ctrIngresoAdministradores(); 
          ?>  

        </form>
      </div>
    </div>
  </div>

</body>
