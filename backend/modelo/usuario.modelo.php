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
}
?>

