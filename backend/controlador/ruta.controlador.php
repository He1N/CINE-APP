<?php

define('BASE_URL', 'http://localhost/CINE-APP/');
define('BACKEND_URL', 'http://localhost/CINE-APP/backend/');

class ControladorRuta {
    static public function ctrRuta() {
        return BASE_URL;
    }

    static public function ctrRutaBackend() {
        return BACKEND_URL;
    }
}

?>