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
        
        // Comparar contraseña (aquí puedes mejorar usando password_verify)
        if ($usuario && $usuario['contrasena_usuario'] === $contrasenaUsuario) {
            session_start();
            $_SESSION['usuario'] = $usuario['nombre_usuario'];
            $_SESSION['rol'] = $usuario['rol'];

            // Redirigir al dashboard si el inicio de sesión es exitoso
            header("Location: ../vista/dashboard.php");
            exit();
        } else {
            // Si el login falla, devolver un mensaje de error
            header("Location: ../vista/login.php?error=1");
            exit();
        }
    }
}

// Procesar el envío del formulario
if (isset($_POST['iniciarSesion'])) {
    // Capturar los valores del formulario
    $nombreUsuario = $_POST['nombreUsuario'];
    $contrasenaUsuario = $_POST['contrasenaUsuario'];

    // Crear instancia del controlador
    $controlador = new UsuarioControlador();

    // Llamar la función de iniciar sesión
    $controlador->iniciarSesion($nombreUsuario, $contrasenaUsuario);
}
?>
