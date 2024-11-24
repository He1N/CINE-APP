<?php

// Incluir el controlador y modelo necesarios
require_once "../controlador/peliculas.controlador.php";
require_once "../modelo/peliculas.modelo.php";

// Verificar si se está realizando una solicitud Ajax para obtener datos de una película
if (isset($_POST["id"])) {
    $respuesta = ControladorPeliculas::ctrObtenerPelicula();
    return;
}
