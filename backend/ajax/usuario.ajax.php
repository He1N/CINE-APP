<?php

require_once "../controlador/usuario.controlador.php";
require_once "../modelo/usuario.modelo.php";

class AjaxUsuarios{

    /*=============================================
	    Mostrar Administrador
	=============================================*/	

    public $idAdministrador;

	public function ajaxMostrarAdministradores(){

		$item = "id";
		$valor = $this->idAdministrador;

		$respuesta = ControladorUsuarios::ctrMostrarAdministradores($item, $valor);

		echo json_encode($respuesta);

	}
	
	/*=============================================
	Eliminar Administrador
	=============================================*/	

	public $idEliminar;

	public function ajaxEliminarAdministrador(){

		$respuesta = ControladorUsuarios::ctrEliminarAdministrador($this->idEliminar);

		echo $respuesta;

	}
}
/*=============================================
Editar Administrador
=============================================*/
if(isset($_POST["idAdministrador"])){

	$editar = new AjaxUsuarios();
	$editar -> idAdministrador = $_POST["idAdministrador"];
	$editar -> ajaxMostrarAdministradores();

}
/*=============================================
Eliminar Administrador
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxUsuarios();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarAdministrador();

}