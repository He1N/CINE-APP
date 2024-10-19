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
        $usuarioAdmin = $this->modelo->registrarNuevoAdmin($nombreAdmin,$contrasenaAdmin);
        header("Location: ../vista/usuarios.php");
        exit();
    }
    
    public function mostrarTablaAdmin() {
        // Llamar al modelo para obtener todos los administradores
        $admins = $this->modelo->verTablaAdmin();
        return $admins;   
    }
     // Función para eliminar un administrador
     public function eliminarAdmin($id) {
        $this->modelo->eliminarAdmin($id); // Llamar al modelo para eliminar
        header("Location: ../vista/usuarios.php");
        exit();
    }

    // Función para editar un administrador
    public function editarAdmin($id, $nuevoNombre, $nuevaContrasena) {
        $editarAdmin = $this->modelo->editarAdmin($id, $nuevoNombre, $nuevaContrasena); // Llamar al modelo para editar
        header("Location: ../vista/usuarios.php");
        exit();
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
        header("Location: ../vista/usuarios.php");
        exit();
    }
}

// Procesar las solicitudes POST para editar o eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador = new UsuarioControlador();

    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'eliminar') {
            // Llamar a la función eliminar
            $id = $_POST['id'];
            $controlador->eliminarAdmin($id);
        } 
    }
}

if (isset($_POST['editarAdmin'])) {
    $id = $_POST['id'];
    $nuevoNombre = $_POST['nuevoNombre'];
    $nuevaContrasena = $_POST['nuevaContrasena'];
    if($nuevoNombre && $nuevaContrasena) {
        $controlador = new UsuarioControlador();

        $controlador->editarAdmin($id,$nuevoNombre,$nuevaContrasena);
    }else {
        header("Location: ../vista/usuarios.php");
        exit();
    }
}
?>
