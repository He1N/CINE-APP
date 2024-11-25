<?php

require_once "../controlador/peliculas.controlador.php";
require_once "../modelo/peliculas.modelo.php";

if (isset($_POST["idPelicula"])) {
    $id = $_POST["idPelicula"];
    $pelicula = ControladorPeliculas::ctrObtenerPelicula($id);
    echo json_encode($pelicula);
}
