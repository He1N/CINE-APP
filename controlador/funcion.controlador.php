<?php
require_once '../modelo/funcion.modelo.php';

class FuncionControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new FuncionModelo();
    }

    public function obtenerFuncionesPorPelicula($idPelicula) {
        try {
            $idPelicula = filter_var($idPelicula, FILTER_VALIDATE_INT);
            if (!$idPelicula) {
                throw new Exception("ID de película inválido");
            }

            $funciones = $this->modelo->obtenerFuncionesPorPelicula($idPelicula);
            
            if (empty($funciones)) {
                return [];
            }

            // Procesar cada función
            foreach ($funciones as &$funcion) {
                $funcion['fecha'] = htmlspecialchars($funcion['fecha']);
                $funcion['hora'] = htmlspecialchars($funcion['hora']);
                $funcion['formato'] = htmlspecialchars($funcion['formato']);
                $funcion['sala'] = htmlspecialchars($funcion['sala']);
                $funcion['asientos_disponibles'] = intval($funcion['asientos_disponibles']);
            }

            return $funciones;
        } catch (Exception $e) {
            error_log("Error al obtener funciones por película: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerFuncionPorId($id) {
        try {
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id) {
                throw new Exception("ID de función inválido");
            }

            $funcion = $this->modelo->obtenerFuncionPorId($id);
            
            if (!$funcion) {
                throw new Exception("Función no encontrada");
            }

            // Procesar los datos para la vista
            $funcion['fecha'] = htmlspecialchars($funcion['fecha']);
            $funcion['hora'] = htmlspecialchars($funcion['hora']);
            $funcion['formato'] = htmlspecialchars($funcion['formato']);
            $funcion['sala'] = htmlspecialchars($funcion['sala']);
            $funcion['asientos_disponibles'] = intval($funcion['asientos_disponibles']);

            return $funcion;
        } catch (Exception $e) {
            error_log("Error al obtener función por ID: " . $e->getMessage());
            return null;
        }
    }

    public function crearFuncion($pelicula_id, $fecha, $hora, $formato, $sala, $asientos_disponibles) {
        try {
            $pelicula_id = filter_var($pelicula_id, FILTER_VALIDATE_INT);
            $asientos_disponibles = filter_var($asientos_disponibles, FILTER_VALIDATE_INT);

            if (!$pelicula_id || !$asientos_disponibles) {
                throw new Exception("Datos de función inválidos");
            }

            $fecha = htmlspecialchars($fecha);
            $hora = htmlspecialchars($hora);
            $formato = htmlspecialchars($formato);
            $sala = htmlspecialchars($sala);

            $resultado = $this->modelo->crearFuncion($pelicula_id, $fecha, $hora, $formato, $sala, $asientos_disponibles);

            if (!$resultado) {
                throw new Exception("Error al crear la función");
            }

            return true;
        } catch (Exception $e) {
            error_log("Error al crear función: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarAsientosDisponibles($id, $asientos_disponibles) {
        try {
            $id = filter_var($id, FILTER_VALIDATE_INT);
            $asientos_disponibles = filter_var($asientos_disponibles, FILTER_VALIDATE_INT);

            if (!$id || !$asientos_disponibles) {
                throw new Exception("Datos de actualización inválidos");
            }

            $resultado = $this->modelo->actualizarAsientosDisponibles($id, $asientos_disponibles);

            if (!$resultado) {
                throw new Exception("Error al actualizar los asientos disponibles");
            }

            return true;
        } catch (Exception $e) {
            error_log("Error al actualizar asientos disponibles: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarFuncion($id) {
        try {
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id) {
                throw new Exception("ID de función inválido");
            }

            $resultado = $this->modelo->eliminarFuncion($id);

            if (!$resultado) {
                throw new Exception("Error al eliminar la función");
            }

            return true;
        } catch (Exception $e) {
            error_log("Error al eliminar función: " . $e->getMessage());
            return false;
        }
    }
}