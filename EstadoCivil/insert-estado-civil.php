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
if ($method == 'POST') {
    require_once('./EstadoCivilInsertController.php');
    require_once('../Helpers/Helpers.php');

    if ($_POST && isset($_POST['json']) && isset(getallheaders()['token'])) {
        //cuando los parametros POST esten OK 
        $tipo_script ='i'; //insert        
        $json = $_POST['json'];
        $token = getallheaders()['token'];
        $helper = new Helpers();
        if ($helper->validar_token($token)) {
            $controlador = new EstadoCivilInsertController($json,$tipo_script);
            //$data_respuesta alamcena un JSON
            $data_respuesta = $controlador->generar_respuesta();
            if ($data_respuesta['estado'] == 'OK') {
                $helper->retorno_respuesta("OK", "DATOS INSERTADOS",$data_respuesta['filas'], $data_respuesta['datos_base']);
            } else {
                $helper->retorno_respuesta("ERROR", "DATOS NO INSERTADOS", $data_respuesta['filas'],$data_respuesta['datos_base']);
            }
        } else {
            $helper->retorno_respuesta("ERROR", "NO TIENE PERMISO, USUARIO DESCONOCIDO","0", "VACIO");
        }
    } else {
        //cuando los parametros esten not OK 
        $helper->retorno_respuesta("ERROR", "REVISAR PARAMETROS ENVIADOS", "0", "VACIO");
    }
} else {
    $helper->retorno_respuesta("ERROR", "No, NO, NO, Es consulta, se requiere Método POST","0","VACIO");
}
