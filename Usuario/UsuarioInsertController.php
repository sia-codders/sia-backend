<?php

require_once '../MasterCrud/MasterCrudInsert.php';
require_once '../Usuario/UsuarioSelectController.php';

class UsuarioInsertController {
    /* Detalle: Tablas a trabajar: usuario 
     * Creado por: Santiago Clavijo             Fecha: 2021-09-22 */

    private $dbName;
    private $correo, $contrasenia, $nombre_completo;
    private $usuCreo;
    private $respuesta;
    private $referencia_a_buscar;
    private $obj_master_insert;

    public function __construct($json) {

        $data_recibida = json_decode($json);
        $this->dbName = 'condominio';

        $this->correo = pg_escape_string($data_recibida->correo);
        $this->contrasenia = pg_escape_string($data_recibida->contrasenia);
        $this->nombre_completo = pg_escape_string($data_recibida->nombre_completo);
        $this->usuCreo = pg_escape_string($data_recibida->usuCreo);
        $data_recibida->referencia_a_buscar = pg_escape_string($data_recibida->correo);
        $data_recibida->tipo_script = "s-c"; //select  por correo
        $this->obj_master_insert = new MasterCrudInsert($this->dbName);

        $json = json_encode($data_recibida);

        $obj_select_controller = new UsuarioSelectController($json);
        $arreglo_respuesta = $obj_select_controller->generar_respuesta();
        if ($arreglo_respuesta['filas'] == '0') {
            $this->insertar_usuario();
        } else {
            $this->respuesta = $arreglo_respuesta['datos_base'];
        }
    }

    private function insertar_usuario() {
        $table_name = "public.usuario";
//        $array_parametros = Array('correo' => $this->correo, 'contrasenia' => $this->contrasenia,
//            'nombrecompleto' => $this->nombre_completo, 'token' => $this->contrasenia . '' . date('d-m-Y h:i:s a', time()),
//            'usucreo' => $this->usuCreo, 'fechacreo' => "current_timestamp", 'usumodifico' => "", 'fechamodifico' => null, 'activo' => true);
         $sentencia = "INSERT INTO public.usuario "
          . "(correo, contrasenia, nombrecompleto, token, usucreo, fechacreo, usumodifico, fechamodifico, activo) "
          . "VALUES('$this->correo', '$this->contrasenia', '$this->nombre_completo','{$this->contrasenia} ".date('d-m-Y h:i:s a', time())
          . "','$this->usuCreo', current_date, null, null, true);"; 
        
        $this->respuesta = $this->obj_master_insert->insertar_base($sentencia);
       
    }

    public function generar_respuesta() {
        return $this->obj_master_insert->genera_respuesta($this->respuesta);
    }

}
