<?php
require_once '../modelo/reserva.modelo.php';

class ReservaControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new ReservaModelo();
    }

    public function crearReserva($datos) {
        try {
            // Validar datos
            $validacion = $this->validarDatos($datos);
            if (!$validacion['valido']) {
                return [
                    'exito' => false, 
                    'mensaje' => 'Datos de reserva inválidos: ' . $validacion['mensaje']
                ];
            }

            // Intentar crear la reserva
            $idReserva = $this->modelo->crearReserva($datos);

            if ($idReserva) {
                return [
                    'exito' => true, 
                    'mensaje' => 'Reserva creada con éxito', 
                    'id_reserva' => $idReserva
                ];
            } else {
                return [
                    'exito' => false, 
                    'mensaje' => 'Error al crear la reserva en la base de datos'
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ReservaControlador::crearReserva: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error interno del servidor'
            ];
        }
    }

    private function validarDatos($datos) {
        $camposRequeridos = [
            'pelicula_id', 'pelicula_nombre', 'fecha_reserva', 
            'hora_reserva', 'sala', 'formato', 'asientos', 
            'total', 'cliente_nombres', 'cliente_apellidos', 'cliente_dni'
        ];
        
        foreach ($camposRequeridos as $campo) {
            if (!isset($datos[$campo]) || empty($datos[$campo])) {
                return ['valido' => false, 'mensaje' => "El campo $campo es requerido."];
            }
        }

        if (!is_numeric($datos['pelicula_id'])) {
            return ['valido' => false, 'mensaje' => 'El ID de la película debe ser numérico.'];
        }

        if (!preg_match("/^\d{8}$/", $datos['cliente_dni'])) {
            return ['valido' => false, 'mensaje' => 'El DNI debe tener 8 dígitos.'];
        }

        if (!is_numeric(str_replace(',', '.', $datos['total'])) || floatval(str_replace(',', '.', $datos['total'])) <= 0) {
            return ['valido' => false, 'mensaje' => 'El total debe ser un número positivo.'];
        }

        return ['valido' => true, 'mensaje' => ''];
    }

    public function obtenerAsientosOcupados($peliculaId, $fecha, $hora) {
        return $this->modelo->obtenerAsientosOcupados($peliculaId, $fecha, $hora);
    }

    public function guardarAsientosReservados($idReserva, $asientos) {
        return $this->modelo->guardarAsientosReservados($idReserva, $asientos);
    }
}
?>

