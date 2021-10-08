<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

//Llama libreria helper
require_once('../Helpers/Helpers.php');
$obj_helper = new Helpers();

//por cual tipo de metodo es enviada la informacion
$method = $_SERVER['REQUEST_METHOD'];

//parametros a enviar 1.-Nombre del controlador, 2.- Metodo, 3.- el arregllo POST, 4.- el arreglo Cabecera, 5.- el nombre del token
$obj_helper->validar_metodoHTTP_POST_select("UsuarioSelectController", $method, $_POST, getallheaders(), getallheaders()['nombre_token']);
