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
if ($method == 'POST') {
    require_once('./EstadoCivilInsertController.php');
    
    if ($_POST && isset($_POST['json']) && isset(getallheaders()['token'])) {
        //cuando los parametros POST esten OK 
        $tipo_script ='i'; //insert        
        $json = $_POST['json'];
        $token = getallheaders()['token'];
        if ($helper->validar_token($token)) {
            $controlador = new EstadoCivilInsertController($json,$tipo_script);
            //$data_respuesta alamcena un JSON
            $data_respuesta = $controlador->generar_respuesta();
            if ($data_respuesta['estado'] == 'OK') {
                $helper->retorno_respuesta($obj_mensaje->mensajeOK, $obj_mensaje->datos_insertador,$data_respuesta['filas'], $data_respuesta['datos_base']);
            } else {
                $helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->datos_no_insertador, $data_respuesta['filas'],$data_respuesta['datos_base']);
            }
        } else {
            $helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->no_tiene_permiso,"0", $obj_mensaje->mensajeVacio);
        }
    } else {
        //cuando los parametros esten not OK 
        $helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->revisar_parametros_enviados, "0", $obj_mensaje->mensajeVacio);
    }
} else {
    $helper->retorno_respuesta($obj_mensaje->mensajeERROR, $obj_mensaje->se_requiere_metodo_post,"0",$obj_mensaje->mensajeVacio);
}
