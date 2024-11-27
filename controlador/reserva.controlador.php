<?php
require_once '../modelo/reserva.modelo.php';

class ReservaControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new ReservaModelo();
    }

    public function crearReserva($datos) {
        // Validación de datos
        if (empty($datos['pelicula_id']) || empty($datos['pelicula_nombre']) || 
            empty($datos['fecha_reserva']) || empty($datos['hora_reserva']) || 
            empty($datos['formato']) || empty($datos['asientos']) || 
            empty($datos['total']) || empty($datos['cliente_nombres']) || 
            empty($datos['cliente_apellidos']) || empty($datos['cliente_dni'])) {
            return "Todos los campos son obligatorios.";
        }

        // Validación adicional según sea necesario
        if (!is_numeric($datos['pelicula_id']) || $datos['pelicula_id'] <= 0) {
            return "ID de película inválido.";
        }

        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $datos['fecha_reserva'])) {
            return "Formato de fecha inválido.";
        }

        if (!preg_match("/^\d{2}:\d{2}$/", $datos['hora_reserva'])) {
            return "Formato de hora inválido.";
        }

        if (!is_numeric($datos['total']) || $datos['total'] <= 0) {
            return "Total inválido.";
        }

        // Intentar crear la reserva
        if ($this->modelo->crearReserva($datos)) {
            return true;
        } else {
            return "Error al crear la reserva. Por favor, inténtalo de nuevo más tarde.";
        }
    }

    public function obtenerReservaPorId($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            return "ID de reserva inválido.";
        }

        $reserva = $this->modelo->obtenerReservaPorId($id);
        if ($reserva) {
            return $reserva;
        } else {
            return "No se encontró la reserva.";
        }
    }

    public function obtenerReservasPorUsuario($dni) {
        if (empty($dni) || strlen($dni) != 8) {
            return "DNI inválido.";
        }

        $reservas = $this->modelo->obtenerReservasPorUsuario($dni);
        if ($reservas) {
            return $reservas;
        } else {
            return "No se encontraron reservas para este usuario.";
        }
    }
}