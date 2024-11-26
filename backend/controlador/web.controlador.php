<?php


class ControladorWeb {

    // Método para obtener las películas disponibles
    public function obtenerPeliculasDisponibles() {
        // Llamamos al método del modelo que obtiene las películas
        $tabla = "pelicula"; // Nombre de la tabla de películas en la base de datos
        return ModeloWeb::mdlObtenerPeliculasDisponibles($tabla); // Llamamos al modelo
    }

    // Método para guardar las películas en cartelera
    public function guardarCartelera($peliculas) {
        // Llamamos al método del modelo que actualiza las películas en cartelera
        $tabla = "pelicula"; // Nombre de la tabla de películas en la base de datos
        return ModeloWeb::mdlActualizarCartelera($tabla, $peliculas); // Llamamos al modelo
    }
}

?>
