<?php
require_once 'conexion.php';

class FuncionModelo {
    private $conexion;
    private $tabla = "funcion";

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function obtenerFuncionesPorPelicula($idPelicula) {
        try {
            $sql = "SELECT id, fecha, hora, formato, sala, asientos_disponibles 
                    FROM {$this->tabla} 
                    WHERE pelicula_id = :pelicula_id 
                    AND fecha >= CURDATE() 
                    ORDER BY fecha, hora";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':pelicula_id', $idPelicula, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerFuncionesPorPelicula: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerFuncionPorId($id) {
        try {
            $sql = "SELECT id, pelicula_id, fecha, hora, formato, sala, asientos_disponibles 
                    FROM {$this->tabla} 
                    WHERE id = :id";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerFuncionPorId: " . $e->getMessage());
            return null;
        }
    }

    public function crearFuncion($pelicula_id, $fecha, $hora, $formato, $sala, $asientos_disponibles) {
        try {
            $sql = "INSERT INTO {$this->tabla} (pelicula_id, fecha, hora, formato, sala, asientos_disponibles) 
                    VALUES (:pelicula_id, :fecha, :hora, :formato, :sala, :asientos_disponibles)";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':pelicula_id', $pelicula_id, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':hora', $hora);
            $stmt->bindParam(':formato', $formato);
            $stmt->bindParam(':sala', $sala);
            $stmt->bindParam(':asientos_disponibles', $asientos_disponibles, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en crearFuncion: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarAsientosDisponibles($id, $asientos_disponibles) {
        try {
            $sql = "UPDATE {$this->tabla} 
                    SET asientos_disponibles = :asientos_disponibles 
                    WHERE id = :id";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':asientos_disponibles', $asientos_disponibles, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en actualizarAsientosDisponibles: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarFuncion($id) {
        try {
            $sql = "DELETE FROM {$this->tabla} WHERE id = :id";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en eliminarFuncion: " . $e->getMessage());
            return false;
        }
    }
}