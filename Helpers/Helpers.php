<?php

require_once '../BASE/DataBase.php';
require_once '../Helpers/Mensajes.php';

class Helpers {

    private function validar_token($token) {
        $tokenAngular = "c33de536beab5630f799fb0cd4a8d30a";
        $respuesta = false;
        if ($tokenAngular == $token) {
            $respuesta = true;
        }
        return $respuesta;
    }

    //Creado por: Santiago          Fecha: 2021-09-29
    //Detalle: Tranforma en json la respuesta echo por la base de datos
    private function retornar_respuesta($estado, $mensaje, $filas, $datos_a_responder) {
        $response = array(
            'estado' => $estado,
            'mensaje' => $mensaje,
            'filas' => $filas,
            'datos' => $datos_a_responder
        );
        echo json_encode($response);
    }

    //Creado por: Santiago          Fecha: 2021-09-29
    //Detalle: Realiza las validacion estadar principales, cuando obtenemos una respuesta de la base de datos
    private function validar_select_respuestas_bdd($nombre_controlador, $tokenEnviado, $json) {
        //Llama libreria Mensaje
        $obj_mensaje = new Mensajes();
        $estado_respuesta = $obj_mensaje->mensajeERROR;
        $filas_respuesta = $obj_mensaje->numero_cero;
        $array_respuesta = null;

        if ($this->validar_token($tokenEnviado)) {
            //R1 : PENDIENTE GENERAR UN VALIDADOS DE NUMEROS,                       

            //*** MEGA IMPORTANTE: CREO EL OBJETO DEL CONTROLADOR A UTILIZAR
            $controlador = new $nombre_controlador($json);
            //$data_respuesta_base alamacena un JSON
            $data_respuesta_base = $controlador->generar_respuesta();

            if (count($data_respuesta_base) > 0) {
                $estado_respuesta = $data_respuesta_base['estado'];
                $filas_respuesta = $data_respuesta_base['filas'];
                $array_respuesta = $data_respuesta_base['datos_base'];
            }

            if ($estado_respuesta == $obj_mensaje->mensajeOK) {
                if ($filas_respuesta == $obj_mensaje->numero_cero) {
                    $this->retornar_respuesta($obj_mensaje->mensajeOK, $obj_mensaje->NO_existe_coincidencias, $filas_respuesta, $array_respuesta);
                } else {
                    $this->retornar_respuesta($obj_mensaje->mensajeOK, $obj_mensaje->SI_existe_coincidencias, $filas_respuesta, $array_respuesta);
                }
            } else {
                $this->retornar_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->no_realizacion_busqueda, $filas_respuesta, $array_respuesta);
            }
        } else {
            $this->retornar_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->no_tiene_permiso, $filas_respuesta, $array_respuesta);
        }
    }

    private function validar_dato_numero($posible_numero) {
        //Creado Por: Santiago  /  Fecha: 2021-09-12 22:11
        //Detalle: Valida que el dato ingresado sea un numero entero o float
        $respuesta = false;
        if (is_numeric($posible_numero)) {
            $respuesta = true;
        }
        return $respuesta;
    }
    //Creado por: Santiago          Fecha: 2021-09-29
    //Detalle: Realiza las validacion de los parametros enviados por el metodo POST
    private function validar_parametros_envioHTTP_POST($post/* arreglo */, $nombre_json, $cabecera/* arreglo */, $nombre_token) {
        //Creado Por: Santiago  /  Fecha: 2021-09-26 17:43
        $respuesta = false;
        if (isset($post[$nombre_json]) && isset($cabecera[$nombre_token])) {
            $respuesta = true;
        }
        return $respuesta;
    }
    
    //Creado por: Santiago          Fecha: 2021-09-29
    //Detalle: Realiza las validacion de los parametros enviados por el metodo GET
    private function validar_parametros_envioHTTP_GET($get/* arreglo */, $nombre_json, $cabecera/* arreglo */, $nombre_token) {
        //Creado Por: Santiago  /  Fecha: 2021-09-26 17:43
        $respuesta = false;
        if (isset($get[$nombre_json]) && isset($cabecera[$nombre_token])) {
            $respuesta = true;
        }
        return $respuesta;
    }

    //Creado por: Santiago          Fecha: 2021-09-29
    //Detalle: Realiza las del metodo HTTP ENVIADO, si es o no valido para trabajar acorde el controlador 
    public function validar_metodoHTTP_POST($nombre_controlador,$metodo, $arreglo_post, $arreglo_cabecera, $nombre_token) {
        //Creado Por: Santiago  /  Fecha: 2021-09-29 17:43
        //Llama libreria Mensaje
        $obj_mensaje = new Mensajes();
        //Variables para respuestas
        $filas_respuesta = $obj_mensaje->numero_cero;
        $array_respuesta = null;
        if ($metodo == 'POST') {
            $nombre_json = $arreglo_post['nombre_json'];
            if ($this->validar_parametros_envioHTTP_POST($arreglo_post, $nombre_json, $arreglo_cabecera, $nombre_token)) {
                //cuando los parametros POST esten OK
                //llamamos al controlador
                /** * MEGA IMPORTANTE: Asignamos el nombre del controlador ** */
                require_once("./{$nombre_controlador}.php");

                $tokenEnviado = $arreglo_cabecera[$nombre_token];
                $json = $arreglo_post[$nombre_json];
                /** * MEGA IMPORTANTE: Realiza validacion estandar para las respuestas al FRONT END desde la base de datos** */
                $this->validar_select_respuestas_bdd($nombre_controlador, $tokenEnviado, $json);
            } else {
                //cuando los parametros enviados en HTTP no esten correctos
                $this->retornar_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->revisar_parametros_enviados, $filas_respuesta, $array_respuesta);
            }
        } else {
            //cuando el metodo HTTP de request no es el solicitado
            $this->retornar_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->se_requiere_metodo_post, $filas_respuesta, $array_respuesta);
        }
    }

}
