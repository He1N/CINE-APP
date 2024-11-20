<?php

class ControladorPeliculas{

    /*=============================================
	MOSTRAR PELICULAS CON INNER JOIN
	=============================================*/

    static public function ctrMostrarPeliculas($valor){

		$tabla = "pelicula";

		$respuesta = ModeloPeliculas::mdlMostrarPeliculas($tabla, $valor);

		return $respuesta;

	}

}

?>