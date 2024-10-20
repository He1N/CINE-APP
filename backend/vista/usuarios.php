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
    <!--JQUERY y AJAX DATATABLES-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--SWEET ALERT-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    
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

            <!-- Modal de formulario añadir-->
            <div class="modal fade" id="formularioModal" tabindex="-1" aria-labelledby="formularioModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formularioModalLabel">Agregar Nuevo Administrador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="adminFormAdd" method="POST">
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
            <table class="table table-bordered table-striped dt-responsive tablaAdministradores" width="100%">
                <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th>Nombre</th>
                        <th>Contraseña</th>
                        <th>Rol</th>
                        <th>Editar</th> 
                        <th>Eliminar</th> 
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <br><br><br>
            <table  class="table table-striped display">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Contraseña</th>
                        <th>Rol</th>
                        <th>Editar</th> 
                        <th>Eliminar</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin) : ?>
                        <tr>
                            <td><?php echo $admin['id']; ?></td>
                            <td><?php echo $admin['nombre_usuario']; ?></td>
                            <td><?php echo str_repeat('*', strlen($admin['contrasena_usuario'])); ?></td> <!-- Contraseña oculta -->
                            <td><?php echo $admin['rol']; ?></td>
                            <td>
                                <!-- Botón para editar -->
                                <button type="button" class="btn btn-warning btn-block" data-bs-toggle="modal" data-bs-target="#formularioModalEditar" onclick="llenarFormulario(<?php echo $admin['id']; ?>, '<?php echo $admin['nombre_usuario']; ?>', '<?php echo $admin['contrasena_usuario']; ?>')">
                                    <i class="fas fa-edit"></i> <!-- Icono de editar -->
                                </button>
                            </td>
                            <td>
                                <!-- Botón para eliminar -->
                                <form id="adminFormDelete" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
                                    <button type="submit" name="eliminarAdmin" class="btn btn-danger btn-block">
                                        <i class="fas fa-trash-alt"></i> <!-- Icono de eliminar -->
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Modal de formulario editar -->
            <div class="modal fade" id="formularioModalEditar" tabindex="-1" aria-labelledby="formularioModalE" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formularioModalE">Editar Datos Administrador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="adminFormEdit" method="POST">
                                <input type="hidden" name="id" id="idAdmin"> <!-- Campo oculto para ID -->
                                <div class="mb-3">
                                    <label for="nombreAdmin" class="form-label">Nombre de Usuario:</label>
                                    <input type="text" class="form-control" id="nuevoNombre" name="nuevoNombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contrasenaAdmin" class="form-label">Contraseña:</label>
                                    <input type="password" class="form-control" id="nuevaContrasena" name="nuevaContrasena" required>
                                </div>
                                <button type="submit" name="editarAdmin" class="btn btn-success">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS de DataTables  -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/usuario.js"></script>
    <script>
        // Función para rellenar el formulario del modal con los datos seleccionados
        function llenarFormulario(id, nombre, contrasena) {
            document.getElementById('idAdmin').value = id; // Asignar el ID oculto
            document.getElementById('nuevoNombre').value = nombre; // Asignar el nombre al input
            document.getElementById('nuevaContrasena').value = contrasena; // Asignar la contraseña al input
        }
        function togglePassword(id) {
            var passwordField = document.getElementById('password_' + id);
            if (passwordField.style.fontFamily === 'password') {
                passwordField.style.fontFamily = 'Arial';
            } else {
                passwordField.style.fontFamily = 'password';
            }
        }
    </script>
</body>
</html>
