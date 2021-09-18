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
    require_once('./EstadoCivilSelectController.php');
    require_once('../Helpers/Helpers.php');

    if ($_GET && isset($_GET['json']) && isset(getallheaders()['token'])) {
        //cuando los parametros GET esten OK              
        $json = $_GET['json'];
        $token = getallheaders()['token'];
        $helper = new Helpers();
        if ($helper->validar_token($token)) {
            //R1 : PENDIENTE GENERAR UN VALIDADOS DE NUMEROS, CUANDO ENVIE S-I
            $controlador = new EstadoCivilSelectController($json);
            //$data_respuesta alamcena un JSON
            $data_respuesta = $controlador->generar_respuesta();           
            
            if ($data_respuesta['estado'] == 'OK') {
                if($data_respuesta['filas'] == '0'){
                    $helper->retorno_respuesta("OK", "NO SE ENCONTRARON COINCIDENCIAS", $data_respuesta['filas'],$data_respuesta['datos_base']);
                }else{
                    $helper->retorno_respuesta("OK", "EXISTEN COINCIDENCIAS", $data_respuesta['filas'],$data_respuesta['datos_base']);
                }
            } else {
                $helper->retorno_respuesta("ERROR", "NO SE REALIZO LA BUSQUEDA",$data_respuesta['filas'], $data_respuesta['datos_base']);
            }
        } else {
            $helper->retorno_respuesta("ERROR", "NO TIENE PERMISO, USUARIO DESCONOCIDO","0"/*filas*/, "VACIO");
        }
    } else {
        //cuando los parametros esten not OK 
        $helper->retorno_respuesta("ERROR", "REVISAR PARAMETROS ENVIADOS", "0"/*filas*/,"VACIO");
    }
} else {
    $helper->retorno_respuesta("ERROR", "No, NO, NO, Es consulta, se requiere Método POST","0"/*filas*/, "VACIO");
}
