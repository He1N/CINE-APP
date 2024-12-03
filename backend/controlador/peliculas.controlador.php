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
    static public function ctrAgregarPelicula() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["formulario"]) && $_POST["formulario"] === "agregarPelicula") {
            // Validar que todos los campos requeridos estén presentes
            if (
                isset($_POST["nombre"]) &&
                isset($_POST["director"]) &&
                isset($_POST["reparto"]) &&
                isset($_POST["imagen"]) &&
                isset($_POST["trailer_url"]) &&
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
                    "imagen" => $_POST["imagen"],
                    "trailer_url" => $_POST["trailer_url"],
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
                    echo '<script>
    
                        swal({
                                type: "success",
                                title: "¡CORRECTO!",
                                text: "La película fue agregada correctamente.",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                        }).then(function(result) {
                            if (result.value) {
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
    
    // Método para obtener una película
    public static function ctrObtenerPelicula($id) {
        $tabla = "pelicula";
        return ModeloPeliculas::mdlObtenerPelicula($tabla, $id);
    }
    /*=============================================
	Editar Pelicula
	=============================================*/
        public static function ctrEditarPelicula() {
            if (isset($_POST["editarId"])) { // Asegúrate de que se envía el ID desde el formulario
                $tabla = "pelicula";
                $datos = array(
                    "id" => $_POST["editarId"], // El ID de la película que se está editando
                    "nombre" => $_POST["nombre"],
                    "director" => $_POST["director"],
                    "reparto" => $_POST["reparto"],
                    "imagen" => $_POST["imagen"],
                    "trailer_url" => $_POST["trailer_url"],
                    "duracion" => $_POST["duracion"],
                    "fecha_estreno" => $_POST["fecha_estreno"],
                    "clasificacion" => $_POST["clasificacion"],
                    "genero" => $_POST["genero"],
                    "descripcion" => $_POST["descripcion"]
                );
                
                // Puedes imprimir los datos en consola usando JavaScript (en caso de que el frontend lo maneje)
                echo "<script>
                        console.log('Datos enviados:', " . json_encode($datos) . ");
                      </script>";
        
                // Llamar al modelo para actualizar los datos
                $respuesta = ModeloPeliculas::mdlEditarPelicula($tabla, $datos);
                if ($respuesta == "ok") {
                    echo '<script>
                        swal({
                            type: "success",
                            title: "Pelicula editada correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then((result) => {
                            if (result.value) {
                                window.location = "index.php?pagina=peliculas";
                            }
                        });
                    </script>';
                } else {
                    echo "<div class='alert alert-danger mt-3 small'>ERROR: No se pudo editar la pelicula</div>";
                }
            }
        }
    /*=============================================
	Eliminar Pelicula
	=============================================*/ 
        public static function ctrEliminarPelicula($id) {
            $tabla = "pelicula";
            $respuesta = ModeloPeliculas::mdlEliminarPelicula($tabla, $id);
            return $respuesta;
        }
        
    
    /*=============================================
        MOSTRAR ACTORES
        =============================================*/
        static public function ctrMostrarActores() {
            $tabla = "actor";
            return ModeloActores::mdlMostrarActores($tabla);
        }


    /*=============================================
    AGREGAR ACTOR
    =============================================*/
    static public function ctrAgregarActor() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["nombreActor"]) && isset($_POST["fotoActor"])) {
                $tabla = "actor";
                $datos = [
                    "nombre" => $_POST["nombreActor"],
                    "foto" => $_POST["fotoActor"]
                ];

                $respuesta = ModeloActores::mdlAgregarActor($tabla, $datos);

                if ($respuesta == "ok") {
                    echo '<script>
                        swal({
                            type: "success",
                            title: "¡Actor agregado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then((result) => {
                            if (result.value) {
                                window.location = "index.php?pagina=peliculas";
                            }
                        });
                    </script>';
                } else {
                    echo "<div class='alert alert-danger mt-3 small'>ERROR: No se pudo agregar el actor</div>";
                }
            }
        }
    }


}

?>