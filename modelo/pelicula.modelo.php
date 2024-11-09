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
}