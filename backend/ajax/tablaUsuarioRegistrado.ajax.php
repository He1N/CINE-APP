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

		$datosJson .='[
				      "'.($key+1).'",
                      "'.$value["foto"].'",
				      "'.$value["nombres"].'",
					  "'.$value["apellidos"].'",
					  "'.$value["correo"].'",
				      "'.$value["contrasena"].'",
                      "'.$value["tipo_usuario"].'",
                      "'.$value["dni"].'"
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
