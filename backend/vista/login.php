
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- css -->
    <link rel="stylesheet" href="css/login.css">
    <!--FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Istok+Web:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

</head>
<body>
<div class="container-fluid">
        
        <div class="row">
            <!-- Columna para la imagen de fondo -->
            <div class="col-md-7 image-left">
            </div>

            <!-- Columna para el formulario -->
            <div class="col-md-5 form-right">
                <div class="form-container">
                     <!-- Agregar la imagen del logo arriba del título -->
                    <div id="logo"></div>
                    <h2 class="login-title text-center mb-4">Iniciar Sesión</h2>
                    <hr><br>

                    <!-- Formulario de inicio de sesión -->
                    <form action="../controlador/usuario.controlador.php" method="POST">
                        <!-- Campo de usuario con ícono -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" placeholder="Ingrese su usuario" required>
                        </div>

                        <!-- Campo de contraseña con ícono -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="contrasenaUsuario" name="contrasenaUsuario" placeholder="Ingrese su contraseña" required>
                            <span class="input-group-text icon-eye"><i class="fas fa-eye"></i></span>
                        </div>

                        <!-- Verificar si hay un mensaje de error en la URL -->
                        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                            <div class="alert alert-danger" role="alert">
                                <p>Usuario o contraseña inválidos.</p>
                            </div>
                        <?php endif; ?>
                        <br><br>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-custom btn-lg" name="iniciarSesion">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar JS de Bootstrap y Font Awesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle para mostrar u ocultar la contraseña
        document.querySelector('.icon-eye').addEventListener('click', function () {
            const passwordInput = document.getElementById('contrasenaUsuario');
            const eyeIcon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
