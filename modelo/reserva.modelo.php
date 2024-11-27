<?php
require_once 'conexion.php';

class ReservaModelo {
    private $conexion;
    private $tabla = "reserva";

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function crearReserva($datos) {
        try {
            $sql = "INSERT INTO {$this->tabla} (pelicula_id, pelicula_nombre, fecha_reserva, hora_reserva, formato, asientos, total, cliente_nombres, cliente_apellidos, cliente_dni) 
                    VALUES (:pelicula_id, :pelicula_nombre, :fecha_reserva, :hora_reserva, :formato, :asientos, :total, :cliente_nombres, :cliente_apellidos, :cliente_dni)";
            
            $stmt = $this->conexion->prepare($sql);
            
            $stmt->bindParam(':pelicula_id', $datos['pelicula_id'], PDO::PARAM_INT);
            $stmt->bindParam(':pelicula_nombre', $datos['pelicula_nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':fecha_reserva', $datos['fecha_reserva'], PDO::PARAM_STR);
            $stmt->bindParam(':hora_reserva', $datos['hora_reserva'], PDO::PARAM_STR);
            $stmt->bindParam(':formato', $datos['formato'], PDO::PARAM_STR);
            $stmt->bindParam(':asientos', $datos['asientos'], PDO::PARAM_STR);
            $stmt->bindParam(':total', $datos['total'], PDO::PARAM_STR);
            $stmt->bindParam(':cliente_nombres', $datos['cliente_nombres'], PDO::PARAM_STR);
            $stmt->bindParam(':cliente_apellidos', $datos['cliente_apellidos'], PDO::PARAM_STR);
            $stmt->bindParam(':cliente_dni', $datos['cliente_dni'], PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al crear reserva: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerReservaPorId($id) {
        try {
            $stmt = $this->conexion->prepare("SELECT * FROM {$this->tabla} WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener reserva: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerReservasPorUsuario($dni) {
        try {
            $stmt = $this->conexion->prepare("SELECT * FROM {$this->tabla} WHERE cliente_dni = :dni ORDER BY fecha_hora_transaccion DESC");
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener reservas del usuario: " . $e->getMessage());
            return false;
        }
    }
}