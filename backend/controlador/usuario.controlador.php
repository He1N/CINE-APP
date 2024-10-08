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
        
        // Comparación directa de la contraseña sin usar password_verify()
        if ($usuario && $usuario['contrasena_usuario'] === $contrasenaUsuario) {
            session_start();
            $_SESSION['usuario'] = $usuario['nombre_usuario'];
            $_SESSION['rol'] = $usuario['rol'];
            header("Location: ../vista/dashboard.php");
            exit();
        } else {
            header("Location: ../vista/index.php?error=Credenciales incorrectas");
            exit();
        }
    }
    
}

// Aquí procesamos el envío del formulario
if (isset($_POST['iniciarSesion'])) {
    // Capturamos los valores enviados por el formulario
    $nombreUsuario = $_POST['nombreUsuario'];
    $contrasenaUsuario = $_POST['contrasenaUsuario'];

    // Creamos una instancia del controlador
    $controlador = new UsuarioControlador();

    // Llamamos a la función para iniciar sesión
    $controlador->iniciarSesion($nombreUsuario, $contrasenaUsuario);
}
?>
