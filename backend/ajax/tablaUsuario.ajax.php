<?php

require_once "../controlador/usuario.controlador.php";
require_once "../modelo/usuario.modelo.php";

class TablaUsuario {

    /*=============================================
    Tabla Administradores
    =============================================*/ 

    public function mostrarTabla() {

        $respuesta = ControladorUsuarios::ctrMostrarAdministradores(null, null);

        if (count($respuesta) == 0) {
            echo json_encode(["data" => []]);
            return;
        }

        $data = [];

        foreach ($respuesta as $key => $value) {
            $acciones = "<div class='btn-group'>
                            <button class='btn btn-warning btn-sm editarAdministrador' data-toggle='modal' data-target='#editarAdministrador' idAdministrador='".$value["id"]."'>
                                <i class='fas fa-pencil-alt text-white'></i></button>
                            <button class='btn btn-danger btn-sm eliminarAdministrador' idAdministrador='".$value["id"]."'>
                                <i class='fas fa-trash-alt'></i></button>
                        </div>";

            $data[] = [
                ($key + 1),
                $value["foto"],
                $value["nombre"],
                $value["usuario"],
                $value["password"],
                $acciones
            ];
        }

        header('Content-Type: application/json');
        echo json_encode(["data" => $data]);
    }
}

/*=============================================
Tabla Administradores
=============================================*/ 

$tabla = new TablaUsuario();
$tabla->mostrarTabla();
