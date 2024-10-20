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
    //AGREGAR NUEVO ADMIN
    public function registrarNuevoAdmin($nombreAdmin, $contrasenaAdmin) {
        $rolAdmin = 'admin';
    
        // Verificar si ya existe un usuario con el mismo nombre
        $verificar_admin = $this->conexion->prepare("SELECT * FROM usuario_admin WHERE nombre_usuario = :nombreAdmin");
        $verificar_admin->bindParam(':nombreAdmin', $nombreAdmin);
        $verificar_admin->execute();
    
        // Usamos fetch() para comprobar si hay un resultado
        if($verificar_admin->fetch()) {
            return false; // Retornar false si el usuario ya existe
        } else {
    
            // Insertar el nuevo administrador
            $query = $this->conexion->prepare("INSERT INTO usuario_admin (nombre_usuario, contrasena_usuario, rol) VALUES (:nombreAdmin, :contrasenaAdmin, :rolAdmin)");
            
            $query->bindParam(':nombreAdmin', $nombreAdmin);
            $query->bindParam(':contrasenaAdmin', $contrasenaAdmin); // Guardar la contraseña encriptada
            $query->bindParam(':rolAdmin', $rolAdmin);
    
            return $query->execute(); // Retornar true si la inserción fue exitosa
        }
    }
    //EDITAR ADMINISTRADOR
    public function editarAdmin($id, $nombreAdmin, $contrasenaAdmin) {
        $query = $this->conexion->prepare("UPDATE usuario_admin SET nombre_usuario = :nombreAdmin, contrasena_usuario = :contrasenaAdmin WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->bindParam(':nombreAdmin', $nombreAdmin);
        $query->bindParam(':contrasenaAdmin', $contrasenaAdmin);
        
        return $query->execute(); // Retorna true si la actualización fue exitosa
    }
    //ELIMINAR ADMINISTRADOR
    public function eliminarAdmin($id) {
        $query = $this->conexion->prepare("DELETE FROM usuario_admin WHERE id = :id");
        $query->bindParam(':id', $id);
        
        return $query->execute(); // Retorna true si la eliminación fue exitosa
    }
    //VER TABLA ADMINISTRADORES
    public function verTablaAdmin() {
        // Preparar la consulta SQL
        $query = $this->conexion->prepare("SELECT * FROM usuario_admin");
        
        // Ejecutar la consulta
        $query->execute();
        
        // Retornar los resultados en un array asociativo
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>

