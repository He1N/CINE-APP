<?php
require_once '../modelo/conexion.php';

class ReservaModelo {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function crearReserva($datos) {
        try {
            $sql = "INSERT INTO reserva (pelicula_id, pelicula_nombre, fecha_reserva, hora_reserva, sala, formato, asientos, total, cliente_nombres, cliente_apellidos, cliente_dni) 
                    VALUES (:pelicula_id, :pelicula_nombre, :fecha_reserva, :hora_reserva, :sala, :formato, :asientos, :total, :cliente_nombres, :cliente_apellidos, :cliente_dni)";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':pelicula_id', $datos['pelicula_id'], PDO::PARAM_INT);
            $stmt->bindParam(':pelicula_nombre', $datos['pelicula_nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':fecha_reserva', $datos['fecha_reserva'], PDO::PARAM_STR);
            $stmt->bindParam(':hora_reserva', $datos['hora_reserva'], PDO::PARAM_STR);
            $stmt->bindParam(':sala', $datos['sala'], PDO::PARAM_STR);
            $stmt->bindParam(':formato', $datos['formato'], PDO::PARAM_STR);
            $stmt->bindParam(':asientos', $datos['asientos'], PDO::PARAM_STR);
            $stmt->bindParam(':total', $datos['total'], PDO::PARAM_STR);
            $stmt->bindParam(':cliente_nombres', $datos['cliente_nombres'], PDO::PARAM_STR);
            $stmt->bindParam(':cliente_apellidos', $datos['cliente_apellidos'], PDO::PARAM_STR);
            $stmt->bindParam(':cliente_dni', $datos['cliente_dni'], PDO::PARAM_STR);

            $stmt->execute();
            return $this->conexion->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al crear reserva: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerAsientosOcupados($peliculaId, $fecha, $hora) {
        try {
            $sql = "SELECT asientos FROM reserva WHERE pelicula_id = :pelicula_id AND fecha_reserva = :fecha_reserva AND hora_reserva = :hora_reserva";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':pelicula_id', $peliculaId, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_reserva', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':hora_reserva', $hora, PDO::PARAM_STR);
            $stmt->execute();
            
            $asientosOcupados = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $asientosOcupados = array_merge($asientosOcupados, explode(',', $row['asientos']));
            }
            return array_unique($asientosOcupados);
        } catch (PDOException $e) {
            error_log("Error al obtener asientos ocupados: " . $e->getMessage());
            return [];
        }
    }

    public function guardarAsientosReservados($idReserva, $asientos) {
        try {
            $sql = "UPDATE reserva SET asientos = :asientos WHERE id = :id_reserva";
            $stmt = $this->conexion->prepare($sql);
            $asientosString = implode(',', $asientos);
            $stmt->bindParam(':asientos', $asientosString, PDO::PARAM_STR);
            $stmt->bindParam(':id_reserva', $idReserva, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al guardar asientos reservados: " . $e->getMessage());
            return false;
        }
    }
}
?>

