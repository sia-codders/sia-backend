<?php

require_once '../BASE/DataBase.php';

class Helpers {

    public function validar_token($token) {
        $tokenAngular = "c33de536beab5630f799fb0cd4a8d30a";
        if ($tokenAngular == $token) {
            return true;
        } else {
            return false;
        }
    }

    public function retorno_respuesta($estado, $mensaje, $datos_a_responder) {
        $response = array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'datos' => $datos_a_responder
        );
        echo json_encode($response);
    }

}
