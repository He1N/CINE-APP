<?php

require_once "conexion.php";


class ModeloPeliculas{

    /*=============================================
	MOSTRAR PELICULAS CON INNER JOIN
	=============================================*/
    static public function mdlMostrarPeliculas($tabla, $valor){

		if($valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id = :id");

			$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $tabla.id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}
    /*=============================================
	AGREGAR PELICULA
	=============================================*/

    static public function mdlAgregarPelicula($tabla, $datos) {

            $stmt = Conexion::conectar()->prepare(
                "INSERT INTO $tabla (nombre, director, reparto, imagen, trailer_url, duracion, fecha_estreno, clasificacion, genero, descripcion) 
                 VALUES (:nombre, :director, :reparto, :imagen, :trailer_url, :duracion, :fecha_estreno, :clasificacion, :genero, :descripcion)"
            );

            // Vincular parámetros
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":director", $datos["director"], PDO::PARAM_STR);
            $stmt->bindParam(":reparto", $datos["reparto"], PDO::PARAM_STR);
            $stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
            $stmt->bindParam(":trailer_url", $datos["trailer_url"], PDO::PARAM_STR);
            $stmt->bindParam(":duracion", $datos["duracion"], PDO::PARAM_INT);
            $stmt->bindParam(":fecha_estreno", $datos["fecha_estreno"], PDO::PARAM_STR);
            $stmt->bindParam(":clasificacion", $datos["clasificacion"], PDO::PARAM_STR);
            $stmt->bindParam(":genero", $datos["genero"], PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

            // Ejecutar y verificar la inserción
            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }

        $stmt->close();

        $stmt = null;
    }
    public static function mdlObtenerPelicula($tabla, $id) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
        $stmt->close();
        $stmt = null;
    }
    public static function mdlEditarPelicula($tabla, $datos) {
        
            // Preparar la consulta de actualización
            $stmt = Conexion::conectar()->prepare(
                "UPDATE $tabla SET 
                    nombre = :nombre,
                    director = :director,
                    reparto = :reparto,
                    imagen = :imagen,
                    trailer_url = :trailer_url,
                    duracion = :duracion,
                    fecha_estreno = :fecha_estreno,
                    clasificacion = :clasificacion,
                    genero = :genero,
                    descripcion = :descripcion
                WHERE id = :id"
            );
    
            // Asociar parámetros con los valores de $datos
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":director", $datos["director"], PDO::PARAM_STR);
            $stmt->bindParam(":reparto", $datos["reparto"], PDO::PARAM_STR);
            $stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
            $stmt->bindParam(":trailer_url", $datos["trailer_url"], PDO::PARAM_STR);
            $stmt->bindParam(":duracion", $datos["duracion"], PDO::PARAM_INT);
            $stmt->bindParam(":fecha_estreno", $datos["fecha_estreno"], PDO::PARAM_STR);
            $stmt->bindParam(":clasificacion", $datos["clasificacion"], PDO::PARAM_STR);
            $stmt->bindParam(":genero", $datos["genero"], PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
            $stmt->close();
            $stmt = null;
    }
    public static function mdlEliminarPelicula($tabla, $id) {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    
        $stmt = null;
    }
    
        
}
class ModeloActores {

    /*=============================================
    MOSTRAR ACTORES
    =============================================*/
    static public function mdlMostrarActores($tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /*=============================================
    AGREGAR ACTOR
    =============================================*/
    static public function mdlAgregarActor($tabla, $datos) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, foto) VALUES (:nombre, :foto)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }
}


?>