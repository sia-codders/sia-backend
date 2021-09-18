<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
//Variable respuesta json
$respuesta_consulta = null;
//Por que tipo de metodo se envia la informacion
$method = $_SERVER['REQUEST_METHOD'];
$salto_de_linea = "\n";
echo $salto_de_linea;
if ($method == 'GET') {
    require_once('./UsuarioController.php');
    require_once('../Helpers/Helpers.php');

    if ($_GET && isset($_GET['json']) && isset(getallheaders()['token'])) {
        //cuando los parametros GET esten OK 
        $json = $_GET['json'];
        $token = getallheaders()['token'];

        $helper = new Helpers();
        if ($helper->validar_token($token)) {
            $controlador = new UsuarioController($json);
            $data_respuesta = $controlador->generar_respuesta();
            if ($data_respuesta['estado'] == 'OK') {
                $helper->retorno_respuesta("OK", "DATOS CORRECTOS",NULL, $data_respuesta['datos_base']);
            } else {
                $helper->retorno_respuesta("ERROR", "NO EXISTEN BASES PARA ESTE USUARIO",NULL, "VACIO");
            }
        } else {
            $helper->retorno_respuesta("ERROR", "NO TIENE PERMISO, USUARIO DESCONOCIDO",NULL, "VACIO");
        }
    } else {
        //cuando los parametros esten not OK 
        $helper->retorno_respuesta("ERROR", "REVISAR PARAMETROS ENVIADOS",NULL, "VACIO");
    }
} else {
    $helper->retorno_respuesta("ERROR", "No, NO, NO, Es consulta, se requiere Método GET", NULL,"VACIO");
}