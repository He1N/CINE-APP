<?php
require_once 'conexion.php';

class UsuarioModelo {
    private $conexion;
    private $tabla = "usuario_registrado";

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function login($correo, $contrasena) {
        $stmt = $this->conexion->prepare("SELECT id, nombres, apellidos, correo, contrasena FROM {$this->tabla} WHERE correo = :correo LIMIT 1");
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($contrasena, $usuario['contrasena'])) {
                return $usuario;
            }
        }
        return false;
    }

    public function registrarUsuario($nombres, $apellidos, $dni, $correo, $contrasena) {
        try {
            $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
            
            $stmt = $this->conexion->prepare("INSERT INTO {$this->tabla} (nombres, apellidos, dni, correo, contrasena) VALUES (:nombres, :apellidos, :dni, :correo, :contrasena)");
            
            $stmt->bindParam(":nombres", $nombres, PDO::PARAM_STR);
            $stmt->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(":dni", $dni, PDO::PARAM_STR);
            $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
            $stmt->bindParam(":contrasena", $contrasenaHash, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function correoExiste($correo) {
        try {
            $stmt = $this->conexion->prepare("SELECT COUNT(*) FROM {$this->tabla} WHERE correo = :correo");
            $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error al verificar correo: " . $e->getMessage());
            return false;
        }
    }

    public function dniExiste($dni) {
        try {
            $stmt = $this->conexion->prepare("SELECT COUNT(*) FROM {$this->tabla} WHERE dni = :dni");
            $stmt->bindParam(":dni", $dni, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error al verificar DNI: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerUsuarioPorId($id) {
    try {
        $stmt = $this->conexion->prepare("SELECT id, nombres, apellidos, dni, correo FROM {$this->tabla} WHERE id = :id LIMIT 1");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener usuario por ID: " . $e->getMessage());
        return false;
    }
}
}

