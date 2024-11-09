<?php
require_once '../modelo/pelicula.modelo.php';

class PeliculaControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new PeliculaModelo();
    }

    public function obtenerProximosEstrenos() {
        try {
            $peliculas = $this->modelo->obtenerProximosEstrenos();
            
            if (empty($peliculas)) {
                return [];
            }

            // Procesar cada película
            foreach ($peliculas as &$pelicula) {
                // Asegurar que todos los campos necesarios existan
                $pelicula['nombre'] = htmlspecialchars($pelicula['nombre']);
                $pelicula['fecha_estreno'] = htmlspecialchars($pelicula['fecha_estreno']);
                
                if (isset($pelicula['descripcion'])) {
                    $pelicula['descripcion'] = htmlspecialchars($pelicula['descripcion']);
                }
                
                if (isset($pelicula['director'])) {
                    $pelicula['director'] = htmlspecialchars($pelicula['director']);
                }
                
                if (isset($pelicula['genero'])) {
                    $pelicula['genero'] = htmlspecialchars($pelicula['genero']);
                }

                if (isset($pelicula['lenguaje'])) {
                    $pelicula['lenguaje'] = htmlspecialchars($pelicula['lenguaje']);
                }

                if (isset($pelicula['trailer_url'])) {
                    $pelicula['trailer_url'] = htmlspecialchars($pelicula['trailer_url']);
                }

                if (isset($pelicula['puntuación'])) {
                    $pelicula['puntuación'] = htmlspecialchars($pelicula['puntuación']);
                }
            }

            return $peliculas;
        } catch (Exception $e) {
            error_log("Error al obtener próximos estrenos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPeliculaPorId($id) {
        try {
            // Validar el ID
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id) {
                throw new Exception("ID de película inválido");
            }

            // Obtener datos de la película
            $pelicula = $this->modelo->obtenerPorId($id);
            if (!$pelicula) {
                throw new Exception("Película no encontrada");
            }

            // Procesar los datos para la vista
            $pelicula['nombre'] = htmlspecialchars($pelicula['nombre']);
            $pelicula['fecha_estreno'] = htmlspecialchars($pelicula['fecha_estreno']);
            $pelicula['descripcion'] = htmlspecialchars($pelicula['descripcion']);
            $pelicula['director'] = htmlspecialchars($pelicula['director']);
            $pelicula['genero'] = htmlspecialchars($pelicula['genero']);
            $pelicula['lenguaje'] = htmlspecialchars($pelicula['lenguaje']);
            $pelicula['trailer_url'] = htmlspecialchars($pelicula['trailer_url']);
            $pelicula['puntuación'] = htmlspecialchars($pelicula['puntuación']);

            if (!empty($pelicula['actores'])) {
                $pelicula['actores'] = array_map('htmlspecialchars', $pelicula['actores']);
            }

            if (!empty($pelicula['lenguajes'])) {
                $pelicula['lenguajes'] = array_map('htmlspecialchars', $pelicula['lenguajes']);
            }

            return $pelicula;
        } catch (Exception $e) {
            error_log("Error al obtener película por ID: " . $e->getMessage());
            return null;
        }
    }

    public function obtenerPeliculasEnCartelera() {
        try {
            $peliculas = $this->modelo->obtenerPeliculasEnCartelera();
            
            if (empty($peliculas)) {
                return [];
            }

            // Procesar cada película
            foreach ($peliculas as &$pelicula) {
                $pelicula['nombre'] = htmlspecialchars($pelicula['nombre']);
                $pelicula['fecha_estreno'] = htmlspecialchars($pelicula['fecha_estreno']);
                
                if (isset($pelicula['descripcion'])) {
                    $pelicula['descripcion'] = htmlspecialchars($pelicula['descripcion']);
                }
                
                if (isset($pelicula['director'])) {
                    $pelicula['director'] = htmlspecialchars($pelicula['director']);
                }
                
                if (isset($pelicula['genero'])) {
                    $pelicula['genero'] = htmlspecialchars($pelicula['genero']);
                }

                if (isset($pelicula['lenguaje'])) {
                    $pelicula['lenguaje'] = htmlspecialchars($pelicula['lenguaje']);
                }

                if (isset($pelicula['trailer_url'])) {
                    $pelicula['trailer_url'] = htmlspecialchars($pelicula['trailer_url']);
                }

                if (isset($pelicula['puntuación'])) {
                    $pelicula['puntuación'] = htmlspecialchars($pelicula['puntuación']);
                }
            }

            return $peliculas;
        } catch (Exception $e) {
            error_log("Error al obtener películas en cartelera: " . $e->getMessage());
            return [];
        }
    }
}