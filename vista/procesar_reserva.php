<?php
// Prevent any output before headers
ob_start();

// Set error handling to suppress HTML error output
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('html_errors', 0);

// Set JSON header immediately
header('Content-Type: application/json');

try {
    // Include required files inside try-catch to prevent include errors from outputting HTML
    require_once '../controlador/reserva.controlador.php';
    
    // Verify AJAX request
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        throw new Exception('Acceso no autorizado');
    }

    // Verify POST method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Clean any output that might have been generated
    ob_clean();

    // Get and sanitize POST data
    $datosReserva = [
        'pelicula_id' => filter_input(INPUT_POST, 'pelicula_id', FILTER_SANITIZE_NUMBER_INT),
        'pelicula_nombre' => filter_input(INPUT_POST, 'pelicula_nombre', FILTER_SANITIZE_STRING),
        'fecha_reserva' => filter_input(INPUT_POST, 'fecha_reserva', FILTER_SANITIZE_STRING),
        'hora_reserva' => filter_input(INPUT_POST, 'hora_reserva', FILTER_SANITIZE_STRING),
        'sala' => filter_input(INPUT_POST, 'sala', FILTER_SANITIZE_STRING),
        'formato' => filter_input(INPUT_POST, 'formato', FILTER_SANITIZE_STRING),
        'asientos' => filter_input(INPUT_POST, 'asientos', FILTER_SANITIZE_STRING),
        'total' => filter_input(INPUT_POST, 'total', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
        'cliente_nombres' => filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING),
        'cliente_apellidos' => filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING),
        'cliente_dni' => filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING)
    ];

    // Validate required fields
    foreach ($datosReserva as $key => $value) {
        if ($value === false || $value === null || $value === '') {
            throw new Exception("Campo requerido faltante o inválido: $key");
        }
    }

    // Additional validations
    if (!preg_match("/^\d{8}$/", $datosReserva['cliente_dni'])) {
        throw new Exception('El DNI debe tener 8 dígitos.');
    }

    if (!is_numeric(str_replace(',', '.', $datosReserva['total'])) || floatval(str_replace(',', '.', $datosReserva['total'])) <= 0) {
        throw new Exception('El total debe ser un número positivo.');
    }

    $reservaController = new ReservaControlador();
    $resultado = $reservaController->crearReserva($datosReserva);

    if ($resultado['exito']) {
        // Guardar los asientos reservados
        $asientosReservados = explode(',', $datosReserva['asientos']);
        $reservaController->guardarAsientosReservados($resultado['id_reserva'], $asientosReservados);

        // Agregar todos los datos necesarios a la respuesta
        $resultado['pelicula_nombre'] = $datosReserva['pelicula_nombre'];
        $resultado['fecha_reserva'] = $datosReserva['fecha_reserva'];
        $resultado['hora_reserva'] = $datosReserva['hora_reserva'];
        $resultado['sala'] = $datosReserva['sala'];
        $resultado['formato'] = $datosReserva['formato'];
        $resultado['asientos'] = $datosReserva['asientos'];
        $resultado['total'] = $datosReserva['total'];
        $resultado['cliente_nombres'] = $datosReserva['cliente_nombres'];
        $resultado['cliente_apellidos'] = $datosReserva['cliente_apellidos'];
        $resultado['cliente_dni'] = $datosReserva['cliente_dni'];
    }

    // Clean output buffer before sending response
    ob_clean();
    echo json_encode($resultado);

} catch (Exception $e) {
    // Log error for debugging
    error_log("Error en procesar_reserva.php: " . $e->getMessage());
    
    // Clean output buffer before sending error response
    ob_clean();
    echo json_encode([
        'exito' => false,
        'mensaje' => 'Error al procesar la reserva: ' . $e->getMessage()
    ]);
}

// End output buffering and exit
ob_end_flush();
exit;

