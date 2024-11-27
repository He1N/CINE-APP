<?php
require_once 'conexion.php';

class PeliculaModelo {
    private $conexion;
    private $tabla = "pelicula";

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function obtenerProximosEstrenos() {
        try {
            $sql = "SELECT id, 
                           nombre,
                           director,
                           reparto,
                           img_reparto,
                           duracion,
                           CONCAT(DAY(fecha_estreno), ' de ',
                           CASE MONTH(fecha_estreno)
                               WHEN 1 THEN 'enero'
                               WHEN 2 THEN 'febrero'
                               WHEN 3 THEN 'marzo'
                               WHEN 4 THEN 'abril'
                               WHEN 5 THEN 'mayo'
                               WHEN 6 THEN 'junio'
                               WHEN 7 THEN 'julio'
                               WHEN 8 THEN 'agosto'
                               WHEN 9 THEN 'septiembre'
                               WHEN 10 THEN 'octubre'
                               WHEN 11 THEN 'noviembre'
                               WHEN 12 THEN 'diciembre'
                           END) as fecha_estreno,
                           clasificacion,
                           descripcion,
                           genero,
                           lenguaje,
                           imagen,
                           img_banner,
                           trailer_url,
                           puntuación
                    FROM {$this->tabla} 
                    ORDER BY fecha_estreno ASC";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerProximosEstrenos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorId($id) {
        try {
            $sql = "SELECT id, 
                           nombre,
                           director,
                           reparto,
                           img_reparto,
                           duracion,
                           CONCAT(DAY(fecha_estreno), ' de ',
                           CASE MONTH(fecha_estreno)
                               WHEN 1 THEN 'enero'
                               WHEN 2 THEN 'febrero'
                               WHEN 3 THEN 'marzo'
                               WHEN 4 THEN 'abril'
                               WHEN 5 THEN 'mayo'
                               WHEN 6 THEN 'junio'
                               WHEN 7 THEN 'julio'
                               WHEN 8 THEN 'agosto'
                               WHEN 9 THEN 'septiembre'
                               WHEN 10 THEN 'octubre'
                               WHEN 11 THEN 'noviembre'
                               WHEN 12 THEN 'diciembre'
                           END) as fecha_estreno,
                           clasificacion,
                           descripcion,
                           genero,
                           lenguaje,
                           imagen,
                           img_banner,
                           trailer_url,
                           puntuación
                    FROM {$this->tabla} 
                    WHERE id = :id";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($pelicula) {
                // Convertir el reparto en array si existe
                if (!empty($pelicula['reparto'])) {
                    $pelicula['actores'] = array_map('trim', explode(',', $pelicula['reparto']));
                } else {
                    $pelicula['actores'] = [];
                }
                
                // Convertir img_reparto en array si existe
                if (!empty($pelicula['img_reparto'])) {
                    $pelicula['img_actores'] = array_map('trim', explode(',', $pelicula['img_reparto']));
                } else {
                    $pelicula['img_actores'] = [];
                }
                
                // Convertir lenguajes en array si existe
                if (!empty($pelicula['lenguaje'])) {
                    $pelicula['lenguajes'] = array_map('trim', explode('/', $pelicula['lenguaje']));
                } else {
                    $pelicula['lenguajes'] = [];
                }
                
                return $pelicula;
            }
            
            return null;
        } catch (PDOException $e) {
            error_log("Error en obtenerPorId: " . $e->getMessage());
            return null;
        }
    }

    public function existePelicula($id) {
        try {
            $sql = "SELECT COUNT(*) FROM {$this->tabla} WHERE id = :id";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error en existePelicula: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPeliculasEnCartelera() {
        try {
            $sql = "SELECT id, 
                           nombre,
                           director,
                           reparto,
                           img_reparto,
                           duracion,
                           CONCAT(DAY(fecha_estreno), ' de ',
                           CASE MONTH(fecha_estreno)
                               WHEN 1 THEN 'enero'
                               WHEN 2 THEN 'febrero'
                               WHEN 3 THEN 'marzo'
                               WHEN 4 THEN 'abril'
                               WHEN 5 THEN 'mayo'
                               WHEN 6 THEN 'junio'
                               WHEN 7 THEN 'julio'
                               WHEN 8 THEN 'agosto'
                               WHEN 9 THEN 'septiembre'
                               WHEN 10 THEN 'octubre'
                               WHEN 11 THEN 'noviembre'
                               WHEN 12 THEN 'diciembre'
                           END) as fecha_estreno,
                           clasificacion,
                           descripcion,
                           genero,
                           lenguaje,
                           imagen,
                           img_banner,
                           trailer_url,
                           puntuación
                    FROM {$this->tabla} 
                    WHERE fecha_estreno <= CURDATE() 
                    ORDER BY fecha_estreno DESC";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerPeliculasEnCartelera: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerFechasDisponibles($idPelicula) {
        try {
            $sql = "SELECT DISTINCT fecha FROM funcion WHERE id_pelicula = :id_pelicula ORDER BY fecha";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_pelicula', $idPelicula, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Error en obtenerFechasDisponibles: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerHorasDisponibles($idPelicula, $fecha) {
        try {
            $sql = "SELECT f.hora, f.formato, s.nombre_sala, s.asientos_disponibles 
                    FROM funcion f
                    JOIN sala s ON f.id_sala = s.id
                    WHERE f.id_pelicula = :id_pelicula AND f.fecha = :fecha 
                    ORDER BY f.formato, f.hora";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_pelicula', $idPelicula, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerHorasDisponibles: " . $e->getMessage());
            return [];
        }
    }

    // Nuevas funciones para manejar estrenos recientes y futuros estrenos

    public function obtenerEstrenosRecientes() {
        try {
            $sql = "SELECT id, 
                           nombre,
                           director,
                           reparto,
                           img_reparto,
                           duracion,
                           CONCAT(DAY(fecha_estreno), ' de ',
                           CASE MONTH(fecha_estreno)
                               WHEN 1 THEN 'enero'
                               WHEN 2 THEN 'febrero'
                               WHEN 3 THEN 'marzo'
                               WHEN 4 THEN 'abril'
                               WHEN 5 THEN 'mayo'
                               WHEN 6 THEN 'junio'
                               WHEN 7 THEN 'julio'
                               WHEN 8 THEN 'agosto'
                               WHEN 9 THEN 'septiembre'
                               WHEN 10 THEN 'octubre'
                               WHEN 11 THEN 'noviembre'
                               WHEN 12 THEN 'diciembre'
                           END) as fecha_estreno,
                           clasificacion,
                           descripcion,
                           genero,
                           lenguaje,
                           imagen,
                           img_banner,
                           trailer_url,
                           puntuación
                    FROM {$this->tabla} 
                    WHERE estreno = TRUE
                    ORDER BY fecha_estreno DESC";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerEstrenosRecientes: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerFuturosEstrenos() {
        try {
            $sql = "SELECT id, 
                           nombre,
                           director,
                           reparto,
                           img_reparto,
                           duracion,
                           CONCAT(DAY(fecha_estreno), ' de ',
                           CASE MONTH(fecha_estreno)
                               WHEN 1 THEN 'enero'
                               WHEN 2 THEN 'febrero'
                               WHEN 3 THEN 'marzo'
                               WHEN 4 THEN 'abril'
                               WHEN 5 THEN 'mayo'
                               WHEN 6 THEN 'junio'
                               WHEN 7 THEN 'julio'
                               WHEN 8 THEN 'agosto'
                               WHEN 9 THEN 'septiembre'
                               WHEN 10 THEN 'octubre'
                               WHEN 11 THEN 'noviembre'
                               WHEN 12 THEN 'diciembre'
                           END) as fecha_estreno,
                           clasificacion,
                           descripcion,
                           genero,
                           lenguaje,
                           imagen,
                           img_banner,
                           trailer_url,
                           puntuación
                    FROM {$this->tabla} 
                    WHERE estreno = FALSE
                    ORDER BY fecha_estreno ASC";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerFuturosEstrenos: " . $e->getMessage());
            return [];
        }
    }
}

