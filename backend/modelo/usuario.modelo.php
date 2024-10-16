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
    public function registrarAdmin($nombreUsuario, $contrasena, $rol = 'admin') {
        var_dump("Entrando a registrarAdmin");
        
        $query = $this->conexion->prepare("INSERT INTO usuario_admin (nombre_usuario, contrasena_usuario, rol) VALUES (:nombreUsuario, :contrasena, :rol)");
    
        $query->bindParam(':nombreUsuario', $nombreUsuario);
        $query->bindParam(':contrasena', $contrasena);
        $query->bindParam(':rol', $rol);
    
        // Muestra los valores para verificar
        var_dump($nombreUsuario, $contrasena, $rol);
    
        if ($query->execute()) {
            var_dump("Inserción exitosa");
            return true;
        } else {
            var_dump("Fallo en la inserción");
            var_dump($query->errorInfo()); // Mostrar errores de SQL si existen
            return false;
        }
    }
    
    
}
?>

