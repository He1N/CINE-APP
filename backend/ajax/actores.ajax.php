<?php
require_once "../controlador/peliculas.controlador.php";
require_once "../modelo/peliculas.modelo.php";

$actores = ControladorPeliculas::ctrMostrarActores();

echo json_encode(["data" => $actores]);
