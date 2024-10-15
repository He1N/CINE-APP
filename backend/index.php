<?php
require_once("controlador/usuario.controlador.php");
$controlador = new UsuarioControlador();
if (method_exists($controlador, $accion)) {
    $controlador->$accion();
} else {
    // Manejar el caso de una acción no válida
    echo "Acción no válida.";
}

?>