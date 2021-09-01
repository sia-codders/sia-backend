<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
//Por que tipo de metodo se envia la informacion
$method = $_SERVER['REQUEST_METHOD'];
$salto_de_linea = "\n";
echo $salto_de_linea;
if ($method == 'POST') {
    require_once('./UsuarioController.php'); 
    require_once('../Helpers/Helpers.php'); 
    
    if ($_POST && isset($_POST['json']) && isset(getallheaders()['token'])) {
        //cuando los parametros POST esten OK 
        $json = $_POST['json'];
        $token= getallheaders()['token']; 
        
        $helper = new Helpers();
        if ($helper->validar_token($token)){        
            $controlador = new UsuarioController($json);
            $data = $controlador->generar_respuesta();
            if ($data['estado'] == 'ok') {
                $response = array(
                    'estado' => 'OK',
                    'mensaje' => 'DATOS CORRECTOS',
                    'datos' => $data['data']
                );
            } else {
                $response = array(
                    'estado' => 'error',
                    'mensaje' => 'NO EXISTEN BASES PARA ESTE USUARIO'
                );
            }
        }
        else{
            $response = array(
                'estado' => 'error',
                'mensaje' => 'NO TIENE PERMISOS, USUARIO DESCONOCIDO'
            );
        }
    } else {
        //cuando los parametros POST esten not OK 
        $response = array(
            'estado' => 'error',
            'mensaje' => 'NO EXISTE PARAMETROS'
        );
    }    
} else {
    $response = array(
        'estado' => 'error',
        'mensaje' => 'No, NO, NO, Solo trabajamos con el Metodo POST'
    );
}
echo json_encode($response);