<?php

require_once "../controlador/peliculas.controlador.php";
require_once "../modelo/peliculas.modelo.php";

class TablaPeliculas{

    /*=============================================
	Tabla Categorías
	=============================================*/ 

    public function mostrarTabla(){

		$peliculas = ControladorPeliculas::ctrMostrarPeliculas(null);

		if(count($peliculas)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($peliculas as $key => $value) {

			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<a href='index.php?pagina=peliculas&id_p=".$value["id_p"]."' class='btn btn-secondary btn-sm'><i class='far fa-eye'></i></a>";	


			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$value["nombre"].'",
						"'.$acciones.'"
						
				],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Peliculas
=============================================*/ 

$tabla = new TablaPeliculas();
$tabla -> mostrarTabla();