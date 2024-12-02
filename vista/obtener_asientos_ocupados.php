<?php
require_once '../controlador/reserva.controlador.php';

if (isset($_GET['id_pelicula']) && isset($_GET['fecha']) && isset($_GET['hora'])) {
    $reservaControlador = new ReservaControlador();
    $asientosOcupados = $reservaControlador->obtenerAsientosOcupados($_GET['id_pelicula'], $_GET['fecha'], $_GET['hora']);
    echo json_encode($asientosOcupados);
} else {
    echo json_encode(['error' => 'Parámetros insuficientes']);
}

