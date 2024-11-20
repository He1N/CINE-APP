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

    /*=============================================
	Agregar Pelicula
	=============================================*/
    static public function ctrAgregarPelicula(){

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Validar que todos los campos requeridos estén presentes
            if (
                isset($_POST["nombre"]) &&
                isset($_POST["director"]) &&
                isset($_POST["reparto"]) &&
                isset($_POST["galeria"]) &&
                isset($_POST["video"]) &&
                isset($_POST["duracion"]) &&
                isset($_POST["fecha_estreno"]) &&
                isset($_POST["clasificacion"]) &&
                isset($_POST["genero"]) &&
                isset($_POST["descripcion"])
            ) {
                // Preparar los datos para enviarlos al modelo
                $tabla = "pelicula";
                $datos = [
                    "nombre" => $_POST["nombre"],
                    "director" => $_POST["director"],
                    "reparto" => $_POST["reparto"],
                    "galeria" => $_POST["galeria"],
                    "video" => $_POST["video"],
                    "duracion" => $_POST["duracion"],
                    "fecha_estreno" => $_POST["fecha_estreno"],
                    "clasificacion" => $_POST["clasificacion"],
                    "genero" => $_POST["genero"],
                    "descripcion" => $_POST["descripcion"]
                ];
    
                // Llamar al modelo para guardar los datos
                $respuesta = ModeloPeliculas::mdlAgregarPelicula($tabla, $datos);
    
                // Manejar la respuesta del modelo
                if ($respuesta == "ok") {
                    echo'<script>

						swal({
								type:"success",
							  	title: "¡CORRECTO!",
							  	text: "La pelicula fue agregada correctamente.",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){

								if(result.value){   
								    window.location = "index.php?pagina=peliculas";
								  } 
						});

					</script>';
                    
                } else {
                    echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";

                }
            } else {
                echo '<script>
                        alert("Por favor, llena todos los campos.");
                      </script>';
            }
        }

	}
}

?>