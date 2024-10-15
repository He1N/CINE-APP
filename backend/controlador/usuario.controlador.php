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
        
        if ($usuario && password_verify($contrasenaUsuario, $usuario['contrasena_usuario'])) {
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

    public function registrarNuevoAdmin($nombre, $contrasena) {
        // Muestra un mensaje cuando se llegue a este punto
        var_dump("Entrando a registrarNuevoAdmin");
        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];
    
        // Verifica el valor de las variables
        var_dump($nombre);
        var_dump($contrasena);
    
        $this->modelo->registrarAdmin($nombre, $contrasena);
    
        header("Location: ./dashboard.php");
        exit();
    }
    
    
}

// Procesar el envío del formulario
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


?>
