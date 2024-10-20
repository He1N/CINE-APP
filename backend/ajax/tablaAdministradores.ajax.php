<?php 
require_once "../controlador/usuario.controlador.php";
require_once "../modelo/usuario.modelo.php";

class TablaAdmin{

	/*=============================================
	Tabla Administradores
	=============================================*/ 
	public function mostrarTabla(){

		$respuesta = UsuarioControlador::mostrarTablaAdmin(); // Obteniendo los datos desde el controlador

		// Si no hay resultados, devolver un JSON vacío
		if(count($respuesta) == 0){
			$datosJson = '{"data":[]}';
			echo $datosJson;
			return;
		}

		// Inicializamos el JSON con la estructura que espera DataTables
		$datosJson = '{
		"data":[';

		// Recorrer cada resultado obtenido de la base de datos
		foreach ($respuesta as $key => $value) {

			// Generar los botones de acción (editar y eliminar)
			$acciones = "<div class='btn-group'>
				<button class='btn btn-warning btn-sm editarAdministrador' data-toggle='modal' data-target='#editarAdministrador' idAdministrador='".$value["id"]."'>
					<i class='fas fa-pencil-alt text-white'></i>
				</button>
				<button class='btn btn-danger btn-sm eliminarAdministrador' idAdministrador='".$value["id"]."'>
					<i class='fas fa-trash-alt'></i>
				</button>
			</div>";

			// Formatear los datos para el JSON
			$datosJson .= '[
				"'.($key+1).'", 
				"'.$value["nombre_usuario"].'",
				"'.str_repeat('*', strlen($value["contrasena_usuario"])).'",
				"'.$value["rol"].'"
			],';
		}

		// Eliminar la última coma y cerrar el JSON
		$datosJson = substr($datosJson, 0, -1);
		$datosJson .= ']}';

		// Enviar el JSON generado
		echo $datosJson;
	}
}


/*=============================================
Tabla Administradores
=============================================*/ 

$tabla = new TablaAdmin();
$tabla -> mostrarTabla();