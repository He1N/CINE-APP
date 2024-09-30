<?php
#CONEXIÓN A LA BASE DE DATOS -> CINEMA
Class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=",
						"root",
						"");

		$link->exec("set names utf8");

		return $link;

	}

}

?>