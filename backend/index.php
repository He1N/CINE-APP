<?php

require_once "controlador/plantilla.controlador.php";
require_once "controlador/ruta.controlador.php";

require_once "controlador/usuario.controlador.php";
require_once "modelo/usuario.modelo.php";


$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();
?>