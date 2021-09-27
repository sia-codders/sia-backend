<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

//Llama libreria helper
require_once('../Helpers/Helpers.php');
$obj_helper = new Helpers();

//Llama libreia Mensaje
require_once('../Helpers/Mensajes.php');
$obj_mensaje = new Mensajes();

//Variable respuesta json
$respuesta_consulta = null;

//Por que tipo de metodo se envia la informacion
$method = $_SERVER['REQUEST_METHOD'];
$salto_de_linea = "\n";
echo $salto_de_linea;

if ($method == 'POST') {
    //llamamos al controlador
    require_once('./UsuarioSelectController.php');
        if ($_POST && isset($_POST['json']) && isset(getallheaders()['token'])) {
        //cuando los parametros POST esten OK              
        $json = $_POST['json'];
        $tokenEnviado = getallheaders()['token'];
        if ($obj_helper->validar_token($tokenEnviado)) {
            //R1 : PENDIENTE GENERAR UN VALIDADOS DE NUMEROS, CUANDO ENVIE S-I
            $controlador = new UsuarioSelectController($json);
            //$data_respuesta_base alamacena un JSON
            $data_respuesta_base = $controlador->generar_respuesta();
            $estado_respuesta="";
            $filas_respuesta=0;
            $array_respuesta=null;
            
            if (count($data_respuesta_base)>0)
            {
                $estado_respuesta= $data_respuesta_base['estado'];
                $filas_respuesta= $data_respuesta_base['filas'];
                $array_respuesta= $data_respuesta_base['datos_base'];
            }

            if ($estado_respuesta == 'OK') {
                if ($filas_respuesta == '0') {
                    $obj_helper->retorno_respuesta($obj_mensaje->mensajeOK, $obj_mensaje->NO_existe_coincidencias, $filas_respuesta, $array_respuesta);
                } else {
                    $obj_helper->retorno_respuesta($obj_mensaje->mensajeOK, $obj_mensaje->SI_existe_coincidencias, $filas_respuesta, $array_respuesta);
                }
            } else {
                $obj_helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->no_realizacion_busqueda, $filas_respuesta, $array_respuesta);
            }
        } else {
            $obj_helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->no_tiene_permiso, $filas_respuesta, $array_respuesta);
        }
    } else {
        //cuando los parametros enviados en HTTP no esten correctos
        $obj_helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->revisar_parametros_enviados, $filas_respuesta, $array_respuesta);
    }
} else {
    //cuando el metodo HTTP de consulta no es el solicitado
    $obj_helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->se_requiere_metodo_post, $filas_respuesta, $array_respuesta);
}
