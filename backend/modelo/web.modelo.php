<?php

require_once "conexion.php";

class ModeloWeb {

    /*=============================================
    Obtener las películas disponibles
    =============================================*/
    static public function mdlObtenerPeliculasDisponibles($tabla, $item = null, $valor = null) {

        if($item != null && $valor != null) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch();

        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();

            return $stmt->fetchAll();

        }

        $stmt->close();
        $stmt = null;
    }

    /*=============================================
    Actualizar las películas en la cartelera
    =============================================*/
    static public function mdlActualizarCartelera($tabla, $peliculas) {
        
        // Primero, reseteamos las películas en cartelera a 0
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estreno = 1 WHERE id_p = :id");
        $stmt->bindParam(":id", $pelicula_id, PDO::PARAM_INT);
        
        // Luego, marcamos las películas seleccionadas como en cartelera
        foreach($peliculas as $pelicula_id) {
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estreno = 1 WHERE id_p = :id");
            $stmt->bindParam(":id", $pelicula_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        return "ok";

        $stmt->close();
        $stmt = null;
    }
    
}

?>
