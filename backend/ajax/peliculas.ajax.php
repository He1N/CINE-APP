<?php

require_once "../controlador/peliculas.controlador.php";
require_once "../modelo/peliculas.modelo.php";

if (isset($_POST["idPelicula"])) {
    $id = $_POST["idPelicula"];
    $pelicula = ControladorPeliculas::ctrObtenerPelicula($id);
    echo json_encode($pelicula);
}

if (isset($_POST["idEliminarPelicula"])) {
    $idPelicula = $_POST["idEliminarPelicula"];
    
    $respuesta = ControladorPeliculas::ctrEliminarPelicula($idPelicula);

    echo $respuesta; // Retornar "ok" o "error"
}
?>
