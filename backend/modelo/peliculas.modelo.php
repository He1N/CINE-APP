<?php

require_once "conexion.php";


class ModeloPeliculas{

    /*=============================================
	MOSTRAR PELICULAS CON INNER JOIN
	=============================================*/
    static public function mdlMostrarPeliculas($tabla, $valor){

		if($valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_p = :id_p");

			$stmt -> bindParam(":id_p", $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $tabla.id_p DESC");

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

        try {
            $stmt = Conexion::conectar()->prepare(
                "INSERT INTO $tabla (nombre, director, reparto, galeria, video, duracion, fecha_estreno, clasificacion, genero, descripcion) 
                 VALUES (:nombre, :director, :reparto, :galeria, :video, :duracion, :fecha_estreno, :clasificacion, :genero, :descripcion)"
            );

            // Vincular parámetros
            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":director", $datos["director"], PDO::PARAM_STR);
            $stmt->bindParam(":reparto", $datos["reparto"], PDO::PARAM_STR);
            $stmt->bindParam(":galeria", $datos["galeria"], PDO::PARAM_STR);
            $stmt->bindParam(":video", $datos["video"], PDO::PARAM_STR);
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

        } catch (Exception $e) {
            // Manejar errores
            return "error: " . $e->getMessage();
        }

        $stmt = null;
    }
}


?>