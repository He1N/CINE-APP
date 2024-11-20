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

}


?>