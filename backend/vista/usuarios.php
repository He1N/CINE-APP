<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    // Si no está autenticado, redirigir al inicio de sesión
    header('Location: ../vista/login.php');
    exit;
}
require_once '../controlador/usuario.controlador.php';

// Crear una instancia del controlador
$controlador = new UsuarioControlador();

// Obtener los administradores
$admins = $controlador->mostrarTablaAdmin();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="css/panel.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <div class="wrapper">

        <?php
        include 'layout/sidebar.php';  
        ?>
        <?php 
        include 'layout/topbar.php';
        ?>
       
        
    
        <div class="container my-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Usuarios</h2>
                <!-- Botón para abrir el modal de formulario -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formularioModal">Nuevo Administrador</button>
            </div>

            <!-- Modal de formulario -->
            <div class="modal fade" id="formularioModal" tabindex="-1" aria-labelledby="formularioModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formularioModalLabel">Agregar Nuevo Administrador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../controlador/usuario.controlador.php" method="POST">
                                <div class="mb-3">
                                    <label for="nombreAdmin" class="form-label">Nombre de Usuario:</label>
                                    <input type="text" class="form-control" id="nombreAdmin" name="nombreAdmin" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contrasenaAdmin" class="form-label">Contraseña:</label>
                                    <input type="password" class="form-control" id="contrasenaAdmin" name="contrasenaAdmin" required>
                                </div>
                                <button type="submit" name="nuevoAdmin" class="btn btn-success">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de administradores -->
            <h2>Lista de Administradores</h2><br>
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Contraseña</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin) : ?>
                        <tr>
                            <td><?php echo $admin['id']; ?></td>
                            <td><?php echo $admin['nombre_usuario']; ?></td>
                            <td><?php echo $admin['contrasena_usuario']; ?></td>
                            <td><?php echo $admin['rol']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
