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

                if (isset($pelicula['reparto'])) {
                    $pelicula['actores'] = array_map('htmlspecialchars', explode(',', $pelicula['reparto']));
                }

                if (isset($pelicula['img_reparto'])) {
                    $pelicula['img_actores'] = array_map('htmlspecialchars', explode(',', $pelicula['img_reparto']));
                }

                if (isset($pelicula['img_banner'])) {
                    $pelicula['img_banner'] = htmlspecialchars($pelicula['img_banner']);
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
            $pelicula['img_banner'] = htmlspecialchars($pelicula['img_banner']);

            if (!empty($pelicula['actores'])) {
                $pelicula['actores'] = array_map('htmlspecialchars', $pelicula['actores']);
            }

            if (!empty($pelicula['img_actores'])) {
                $pelicula['img_actores'] = array_map('htmlspecialchars', $pelicula['img_actores']);
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

                if (isset($pelicula['reparto'])) {
                    $pelicula['actores'] = array_map('htmlspecialchars', explode(',', $pelicula['reparto']));
                }

                if (isset($pelicula['img_reparto'])) {
                    $pelicula['img_actores'] = array_map('htmlspecialchars', explode(',', $pelicula['img_reparto']));
                }

                if (isset($pelicula['img_banner'])) {
                    $pelicula['img_banner'] = htmlspecialchars($pelicula['img_banner']);
                }
            }

            return $peliculas;
        } catch (Exception $e) {
            error_log("Error al obtener películas en cartelera: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerFechasDisponibles($idPelicula) {
        try {
            $id = filter_var($idPelicula, FILTER_VALIDATE_INT);
            if (!$id) {
                throw new Exception("ID de película inválido");
            }

            $fechas = $this->modelo->obtenerFechasDisponibles($id);
            return array_map('htmlspecialchars', $fechas);
        } catch (Exception $e) {
            error_log("Error al obtener fechas disponibles: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerHorasDisponibles($idPelicula, $fecha) {
        try {
            $id = filter_var($idPelicula, FILTER_VALIDATE_INT);
            if (!$id) {
                throw new Exception("ID de película inválido");
            }

            if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
                throw new Exception("Formato de fecha inválido");
            }

            $horas = $this->modelo->obtenerHorasDisponibles($id, $fecha);
            
            // Procesar y sanitizar los datos
            foreach ($horas as &$hora) {
                $hora['hora'] = htmlspecialchars($hora['hora']);
                $hora['formato'] = htmlspecialchars($hora['formato']);
                $hora['nombre_sala'] = htmlspecialchars($hora['nombre_sala']);
                $hora['asientos_disponibles'] = intval($hora['asientos_disponibles']);
            }

            return $horas;
        } catch (Exception $e) {
            error_log("Error al obtener horas disponibles: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerEstrenosRecientes() {
        try {
            $peliculas = $this->modelo->obtenerEstrenosRecientes();
            return $this->procesarPeliculas($peliculas);
        } catch (Exception $e) {
            error_log("Error al obtener estrenos recientes: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerFuturosEstrenos() {
        try {
            $peliculas = $this->modelo->obtenerFuturosEstrenos();
            return $this->procesarPeliculas($peliculas);
        } catch (Exception $e) {
            error_log("Error al obtener futuros estrenos: " . $e->getMessage());
            return [];
        }
    }

    private function procesarPeliculas($peliculas) {
        if (empty($peliculas)) {
            return [];
        }

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

            if (isset($pelicula['reparto'])) {
                $pelicula['actores'] = array_map('htmlspecialchars', explode(',', $pelicula['reparto']));
            }

            if (isset($pelicula['img_reparto'])) {
                $pelicula['img_actores'] = array_map('htmlspecialchars', explode(',', $pelicula['img_reparto']));
            }

            if (isset($pelicula['img_banner'])) {
                $pelicula['img_banner'] = htmlspecialchars($pelicula['img_banner']);
            }
        }

        return $peliculas;
    }
}

