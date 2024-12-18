<?php

class ControladorUsuarios {
   
    /*=============================================
        Iniciar Sesión
    =============================================*/

    public function ctrIngresoAdministradores(){

		if(isset($_POST["ingresoUsuario"])){

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingresoUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingresoPassword"])){

			   	//$encriptarPassword = crypt($_POST["ingresoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			   	$tabla = "usuario_admin";
			    $item = "usuario";
			    $valor = $_POST["ingresoUsuario"];

				$respuesta = ModeloUsuarios ::mdlMostrarAdministradores($tabla, $item, $valor);
				
				if($respuesta["usuario"] == $_POST["ingresoUsuario"] && $respuesta["password"] == $_POST["ingresoPassword"]){

					if($respuesta["estado"] == 1){

						$_SESSION["validarSesionBackend"] = "ok";
				 		$_SESSION["idBackend"] = $respuesta["id"];

				 		echo '<script>

							window.location = "'.$_SERVER["REQUEST_URI"].'";

				 		</script>';

			 		}else{

			 			echo "<div class='alert alert-danger mt-3 small'>ERROR: El usuario está desactivado</div>";

			 		}

				}else{

					echo "<div class='alert alert-danger mt-3 small'>ERROR: Usuario y/o contraseña incorrectos</div>";
				}	

			}else{

				echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";

			}

		}

	}
   
    /*=============================================
        Mostrar Administradores
    =============================================*/

    static public function ctrMostrarAdministradores($item, $valor){

		$tabla = "usuario_admin";

		$respuesta = ModeloUsuarios::mdlMostrarAdministradores($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
        Mostrar Usuarios Registrados
    =============================================*/
	
	static public function ctrMostrarUsuariosRegistrados($item, $valor){

		$tabla = "usuario_registrado";

		$respuesta = ModeloUsuarios::mdlMostrarUsuariosRegistrados($tabla, $item, $valor);

		return $respuesta;

	}

    /*=============================================
        Ingresar Administradores
    =============================================*/
	public function ctrRegistroAdministrador(){

		if(isset($_POST["registroNombre"])){

			if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["registroNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["registroUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["registroPassword"])){

			   	$encriptarPassword = crypt($_POST["registroPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$tabla = "usuario_admin";

				$datos = array("nombre" => $_POST["registroNombre"],
							   "usuario" =>  $_POST["registroUsuario"],
							   "password" => $encriptarPassword,
							   "estado" => 0);

				
				$respuesta = ModeloUsuarios::mdlRegistroAdministradores($tabla, $datos);
				
				if($respuesta == "ok"){

					echo'<script>

						swal({
								type:"success",
							  	title: "¡CORRECTO!",
							  	text: "El administrador ha sido creado correctamente",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){

								if(result.value){   
								    window.location = "administradores";
								  } 
						});

					</script>';

				}


			}else{

				echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";
			}

		}


	}
    
    /*=============================================
	Editar administrador
	=============================================*/

	public function ctrEditarAdministrador(){

		if(isset($_POST["editarNombre"])){

			if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["editarNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarUsuario"])){

			   	if($_POST["editarPassword"] != ""){

			   		if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){

			   			$password = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');  			

			   		}else{

			   			echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";

			   			return;

			   		}

			   	}else{

			   		$password = $_POST["passwordActual"];
			   	}

				$tabla = "usuario_admin";

				$datos = array("id"=> $_POST["editarId"],
							   "nombre" => $_POST["editarNombre"],
							   "usuario" =>  $_POST["editarUsuario"],
							   "password" => $password);

				
				$respuesta = ModeloUsuarios::mdlEditarAdministrador($tabla, $datos);
				
				if($respuesta == "ok"){

					echo'<script>

						swal({
								type:"success",
							  	title: "¡CORRECTO!",
							  	text: "El administrador ha sido editado correctamente",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){

								if(result.value){   
								    window.location = "administradores";
								  } 
						});

					</script>';

				}


			}else{

				echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";
			}

		}

	}
    /*=============================================
	Eliminar Administrador
	=============================================*/

	static public function ctrEliminarAdministrador($id){

		$tabla = "usuario_admin";

		$respuesta = ModeloUsuarios::mdlEliminarAdministrador($tabla, $id);

		return $respuesta;

	}
    
}

?>
