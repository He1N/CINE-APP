<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/ruta.controlador.php";

require_once "controlador/usuario.controlador.php";
require_once "modelo/usuario.modelo.php";


$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();
?>