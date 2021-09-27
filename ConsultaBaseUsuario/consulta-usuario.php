<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

//Llama libreia helper
require_once('../Helpers/Helpers.php');
$helper = new Helpers();
//Llama libreia helper
require_once('../Helpers/Mensajes.php');
$obj_mensaje = new Mensajes();
//Variable respuesta json
$respuesta_consulta = null;
//Por que tipo de metodo se envia la informacion
$method = $_SERVER['REQUEST_METHOD'];
$salto_de_linea = "\n";
echo $salto_de_linea;
if ($method == 'GET') {
    require_once('./UsuarioController.php');

    if ($_GET && isset($_GET['json']) && isset(getallheaders()['token'])) {
        //cuando los parametros GET esten OK 
        $json = $_GET['json'];
        $token = getallheaders()['token'];

        if ($helper->validar_token($token)) {
            $controlador = new UsuarioController($json);
            $data_respuesta = $controlador->generar_respuesta();
            if ($data_respuesta['estado'] == 'OK') {
                $helper->retorno_respuesta($obj_mensaje->mensajeOK, $obj_mensaje->datos_correctos, NULL, $data_respuesta['datos_base']);
            } else {
                $helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->no_bases_usuario, NULL, $obj_mensaje->mensajeVacio);
            }
        } else {
            $helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->no_tiene_permiso, NULL, $obj_mensaje->mensajeVacio);
        }
    } else {
        //cuando los parametros esten not OK 
        $helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->revisar_parametros_enviados, NULL, $obj_mensaje->mensajeVacio);
    }
} else {
    $helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->se_requiere_metodo_get, NULL, $obj_mensaje->mensajeVacio);
}