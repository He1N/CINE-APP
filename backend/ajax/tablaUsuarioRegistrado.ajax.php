<?php 


require_once "../controlador/usuario.controlador.php";
require_once "../modelo/usuario.modelo.php";

class TablaUsuarioRegistrado{

    /*=============================================
	Tabla Usuario Registrado
	=============================================*/ 

	public function mostrarTabla(){


		$respuesta = ControladorUsuarios::ctrMostrarUsuariosRegistrados(null, null);

		if(count($respuesta) == 0){

			$datosJson = '{"data":[]}';

			echo $datosJson;

			return;

		}
        
		$datosJson = '{
	
		"data":[';

		foreach ($respuesta as $key => $value) {

		$acciones = "<div class='btn-group'><i class='fas fa-trash-alt'></i></button></div>";
		$datosJson .='[
				      "'.($key+1).'",
                      "'.$value["foto"].'",
				      "'.$value["nombres"].'",
				      "'.$value["contrasena"].'",
                      "'.$value["usuario"].'",
                      "'.$value["tipo_usuario"].'",
                      "'.$value["dni"].'",
					  "'.$acciones.'"
				    ],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .= ']}';


		echo $datosJson;

	}

}

/*=============================================
Tabla Administradores
=============================================*/ 

$tabla = new TablaUsuarioRegistrado();
$tabla -> mostrarTabla();
