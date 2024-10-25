<?php
require_once '../modelo/usuario.modelo.php';

class UsuarioControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new UsuarioModelo();
    }

    public function login($correo, $contrasena) {
        $usuario = $this->modelo->login($correo, $contrasena);
        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombres'] . ' ' . $usuario['apellidos'];
            return true;
        }
        return false;
    }

    public function registrar($nombres, $apellidos, $dni, $correo, $contrasena) {
        // Validación de datos
        if (empty($nombres) || empty($apellidos) || empty($dni) || empty($correo) || empty($contrasena)) {
            return "Todos los campos son obligatorios.";
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return "El correo electrónico no es válido.";
        }

        if (strlen($contrasena) < 8) {
            return "La contraseña debe tener al menos 8 caracteres.";
        }

        // Verificar si el correo ya existe
        if ($this->modelo->correoExiste($correo)) {
            return "El correo electrónico ya está registrado.";
        }

        // Verificar si el DNI ya existe
        if ($this->modelo->dniExiste($dni)) {
            return "El DNI ya está registrado.";
        }

        // Intentar registrar al usuario
        if ($this->modelo->registrarUsuario($nombres, $apellidos, $dni, $correo, $contrasena)) {
            return true;
        } else {
            return "Error al registrar el usuario. Por favor, inténtalo de nuevo más tarde.";
        }
    }

    public function cerrarSesion() {
        session_start();
        session_unset();
        session_destroy();
        return true;
    }
}