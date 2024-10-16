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

    public function nuevoAdmin($nombreAdmin, $contrasenaAdmin) {
        $usuarioAdmin = $this->modelo->registrarNuevoAdmin($nombreAdmin,$contrasenaAdmin);
        header("Location: ../vista/dashboard.php");
        exit();
    }
    
    public function mostrarTablaAdmin() {
        // Llamar al modelo para obtener todos los administradores
        $admins = $this->modelo->verTablaAdmin();
        return $admins;   
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
// Procesar el envío del formulario USUARIOS.PHP

if (isset($_POST['nuevoAdmin'])) {
    $nombreAdmin = $_POST['nombreAdmin'];
    $contrasenaAdmin = $_POST['contrasenaAdmin'];

    if($nombreAdmin && $contrasenaAdmin) {
        $controlador = new UsuarioControlador();

        $controlador->nuevoAdmin($nombreAdmin,$contrasenaAdmin);
    }else {
        header("Location: ../vista/dashboard.php");
        exit();
    }
}


?>
