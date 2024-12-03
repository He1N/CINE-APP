<?php

require_once "controlador/plantilla.controlador.php";
require_once "controlador/ruta.controlador.php";

require_once "controlador/usuario.controlador.php";
require_once "modelo/usuario.modelo.php";

require_once "controlador/peliculas.controlador.php";
require_once "modelo/peliculas.modelo.php";

require_once "controlador/web.controlador.php";
require_once "modelo/web.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();
?>