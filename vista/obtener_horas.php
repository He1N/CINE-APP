<?php
require_once '../controlador/pelicula.controlador.php';

header('Content-Type: application/json');

function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

// Verificar el método de la solicitud
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendJsonResponse(['error' => 'Método no permitido'], 405);
}

// Obtener y validar los parámetros
$idPelicula = isset($_GET['id_pelicula']) ? filter_var($_GET['id_pelicula'], FILTER_VALIDATE_INT) : null;
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;

if (!$idPelicula || !$fecha) {
    sendJsonResponse(['error' => 'Parámetros inválidos'], 400);
}

// Validar el formato de la fecha
if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
    sendJsonResponse(['error' => 'Formato de fecha inválido'], 400);
}

try {
    $peliculaController = new PeliculaControlador();
    $horasDisponibles = $peliculaController->obtenerHorasDisponibles($idPelicula, $fecha);

    if (empty($horasDisponibles)) {
        sendJsonResponse(['message' => 'No hay horas disponibles para la fecha seleccionada'], 200);
    } else {
        sendJsonResponse($horasDisponibles);
    }
} catch (Exception $e) {
    error_log("Error en obtener_horas.php: " . $e->getMessage());
    sendJsonResponse(['error' => 'Error interno del servidor'], 500);
}

