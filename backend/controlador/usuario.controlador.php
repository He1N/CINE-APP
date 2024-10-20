<?php
// Incluir el modelo
require_once '../modelo/usuario.modelo.php';

class UsuarioControlador {
    private $modelo;

    public function __construct() {
        // Instancia del modelo de usuario
        $this->modelo = new UsuarioModelo();
    }

    // Función para iniciar sesión
    public function iniciarSesion($nombreUsuario, $contrasenaUsuario) {
        $usuario = $this->modelo->obtenerUsuarioPorNombre($nombreUsuario);

        if ($usuario && $usuario['contrasena_usuario'] === $contrasenaUsuario) {
            session_start();
            $_SESSION['usuario'] = $usuario['nombre_usuario'];
            $_SESSION['rol'] = $usuario['rol'];
            // Redirigir al dashboard si el inicio de sesión es exitoso
            header("Location: ../vista/dashboard.php");
            exit();
        } else {
            header("Location: ../vista/index.php?error=Credenciales incorrectas");
            // Si el login falla, devolver un mensaje de error
            header("Location: ../vista/login.php?error=1");
            exit();
        }
    }
     // Función para crear un administrador
    public function nuevoAdmin($nombreAdmin, $contrasenaAdmin) {
        $usuarioAdmin = $this->modelo->registrarNuevoAdmin($nombreAdmin, $contrasenaAdmin);

        if ($usuarioAdmin) {
            // Si el registro es exitoso, devolvemos una respuesta de éxito
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: '¡Administrador creado!',
                        text: 'El nuevo administrador se ha registrado correctamente.'
                    });
                  </script>";
        } else {
            // Si hay un error en el registro
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al registrar el administrador.'
                    });
                  </script>";
        }
    }
    // Función para editar un administrador
    public function editarAdmin($id, $nuevoNombre, $nuevaContrasena) {
        $editarAdmin = $this->modelo->editarAdmin($id, $nuevoNombre, $nuevaContrasena); // Llamar al modelo para editar
        if ($editarAdmin) {
            // Si el registro es exitoso, devolvemos una respuesta de éxito
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: '¡Campos editados!',
                        text: 'Los campos se han editado correctamente.'
                    });
                </script>";

        } else {
            // Si hay un error en el registro
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al editar el administrador.'
                    });
                  </script>";
        }
    }
    // Función para eliminar un administrador
    public function eliminarAdmin($id) {
        $eliminarAdmin = $this->modelo->eliminarAdmin($id); // Llamar al modelo para eliminar
    
        if ($eliminarAdmin) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'elimi editados!',
                        text: 'Los campos se han editado correctamente.'
                    });
                </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al editar el administrador.'
                    });
                  </script>";
        }
    }
    

    static public function mostrarTablaAdmin() {
        // Obtener los datos desde la base de datos
		$respuesta = UsuarioModelo::verTablaAdmin();
        return $respuesta;

    }
    
    
}

// Procesar el envío del formulario LOGIN.PHP
if (isset($_POST['iniciarSesion'])) {
    // Capturar los valores del formulario
    $nombreUsuario = $_POST['nombreUsuario'] ?? null;
    $contrasenaUsuario = $_POST['contrasenaUsuario'] ?? null;

    if ($nombreUsuario && $contrasenaUsuario) {
        // Crear instancia del controlador
        $controlador = new UsuarioControlador();

        // Llamar la función de iniciar sesión
        $controlador->iniciarSesion($nombreUsuario, $contrasenaUsuario);
    } else {
        // Redirigir si faltan datos
        header("Location: ../vista/login.php?error=campos_vacios");
        exit();
    }
}
// Procesar el envío del formulario del nuevo administrador

if (isset($_POST['nombreAdmin']) && isset($_POST['contrasenaAdmin'])) {
    $nombreAdmin = $_POST['nombreAdmin'];
    $contrasenaAdmin = $_POST['contrasenaAdmin'];

    if ($nombreAdmin && $contrasenaAdmin) {
        $controlador = new UsuarioControlador();
        $controlador->nuevoAdmin($nombreAdmin, $contrasenaAdmin);
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor, completa todos los campos.'
                });
              </script>";
    }
}
// Procesar el envío del formulario de editar administrador

if(isset($_POST['nuevoNombre']) && isset($_POST['nuevaContrasena'])){
    $id = $_POST['id'];
    $nuevoNombre = $_POST['nuevoNombre'];
    $nuevaContrasena = $_POST['nuevaContrasena'];

    if($nuevoNombre && $nuevaContrasena) {
        $controlador = new UsuarioControlador();
        $controlador->editarAdmin($id,$nuevoNombre,$nuevaContrasena);
    }else {
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor, completa todos los campos.'
                });
              </script>";
    }
}
// Procesar el envío del formulario de eliminar administrador

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminarAdmin'])) {
    $id = $_POST['id'];

    if ($id) {
        $controlador = new UsuarioControlador();
        $controlador->eliminarAdmin($id);
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor, completa todos los campos.'
                });
              </script>";
    }
}

?>
