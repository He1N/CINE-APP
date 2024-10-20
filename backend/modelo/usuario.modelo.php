<?php
    require_once "conexion.php";

    class UsuarioModelo {
    private $conexion;

    public function __construct() {
        // Crear una nueva conexión utilizando el método conectar() de la clase Conexion
        $this->conexion = Conexion::conectar();
    }

    public function obtenerUsuarioPorNombre($nombreUsuario) {
        // Usar la instancia de PDO para preparar la consulta
        $query = $this->conexion->prepare("SELECT * FROM usuario_admin WHERE nombre_usuario = :nombreUsuario");
        $query->bindParam(':nombreUsuario', $nombreUsuario);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function registrarNuevoAdmin($nombreAdmin, $contrasenaAdmin) {
        $rolAdmin = 'admin';
        $query = $this->conexion->prepare("INSERT INTO usuario_admin (nombre_usuario, contrasena_usuario, rol) VALUES (:nombreAdmin, :contrasenaAdmin, :rolAdmin);");
        
        $query->bindParam(':nombreAdmin', $nombreAdmin);
        $query->bindParam(':contrasenaAdmin', $contrasenaAdmin);
        $query->bindParam(':rolAdmin', $rolAdmin);
        
        return $query->execute(); // Retorna true si la inserción fue exitosa
    }
    
    public function verTablaAdmin() {
        // Preparar la consulta SQL
        $query = $this->conexion->prepare("SELECT * FROM usuario_admin");
        
        // Ejecutar la consulta
        $query->execute();
        
        // Retornar los resultados en un array asociativo
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
        // Nueva función para eliminar un administrador por su ID
    public function eliminarAdmin($id) {
        $query = $this->conexion->prepare("DELETE FROM usuario_admin WHERE id = :id");
        $query->bindParam(':id', $id);
        
        return $query->execute(); // Retorna true si la eliminación fue exitosa
    }

    // Nueva función para editar un administrador
    public function editarAdmin($id, $nombreAdmin, $contrasenaAdmin) {
        $query = $this->conexion->prepare("UPDATE usuario_admin SET nombre_usuario = :nombreAdmin, contrasena_usuario = :contrasenaAdmin WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->bindParam(':nombreAdmin', $nombreAdmin);
        $query->bindParam(':contrasenaAdmin', $contrasenaAdmin);
        
        return $query->execute(); // Retorna true si la actualización fue exitosa
    }

}
?>

