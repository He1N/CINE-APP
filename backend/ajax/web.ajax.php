<?php

require_once "../controlador/web.controlador.php";
require_once "../modelo/web.modelo.php";

header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON

try {
    // Verificamos si es una solicitud POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtenemos los datos de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);

        // Debug: Verificar si los datos llegan correctamente
        file_put_contents('debug.txt', print_r($data, true), FILE_APPEND); // Esto guardará los datos en un archivo

        if (isset($data['action']) && $data['action'] === 'guardarCartelera') {
            // Aquí obtenemos las películas desde el request
            $peliculas = $data['peliculas'];

            // Verifica que realmente se hayan enviado películas
            if (empty($peliculas)) {
                echo json_encode(['success' => false, 'message' => 'No se recibieron películas']);
                exit;
            }

            // Instanciamos el modelo
            $resultado = ModeloWeb::mdlActualizarCartelera('pelicula', $peliculas);

            // Respondemos al cliente con un mensaje de éxito o error
            if ($resultado === "ok") {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar la cartelera']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
} catch (Exception $e) {
    // Capturamos cualquier error inesperado y respondemos con un error
    echo json_encode(['success' => false, 'message' => 'Hubo un error en el servidor', 'error' => $e->getMessage()]);
}

?>
