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

    public function retorno_respuesta($estado, $mensaje, $filas, $datos_a_responder) {
        $response = array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'filas' => $filas,
            'datos' => $datos_a_responder
        );
        echo json_encode($response);
    }

    public function valida_dato_numero($posible_numero) {
        //Creado Por: Santiago  /  Fecha: 2021-09-12 22:11
        //Detalle: Valida que el dato ingresado sea un numero entero o float
        if (is_numeric($posible_numero)){
            return true;
        }else{
            return false;
        }
    }

}
