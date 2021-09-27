<?php
require_once '../BASE/DataBase.php';
class UsuPermisoInsertController
{
    /*Detalle: Tablas a trabajar: usuario 
     * Creado por: Santiago Clavijo             Fecha: 2021-09-22
     */
    
    private $data_recibida;
    private $db='condominio';
    private $correo, $contrasenia, $nombre_completo;
    private $usuCreo;
    private $respuesta;
    
    public function __construct($json) {
        $this->data_recibida = json_decode($json);        
        $this->correo= pg_escape_string($this->data_recibida->correo); 
        $this->contrasenia= pg_escape_string($this->data_recibida->contrasenia); 
        $this->nombre_completo= pg_escape_string($this->data_recibida->nombre_completo); 
        $this->usuCreo= pg_escape_string($this->data_recibida->usuCreo);
        $this->insertar_estado_civil();        
    }
    private function insertar_usuario(){
        $dbName = new DataBase($this->db);
        $sentencia = "INSERT INTO public.usuario "
                . "(correo, contrasenia, nombrecompleto, token, usucreo, fechacreo, usumodifico, fechamodifico, activo) "
                . "VALUES('$this->correo', '$this->contrasenia', '$this->nombre_completo',null,$this->usuCreo, now(), '', '', true);";       
        $this->respuesta = $dbName->execute($sentencia);
    }   
    public function generar_respuesta() {
        if(isset($this->respuesta) && count($this->respuesta)>0)
        {
            return array(
                'estado'=>'OK',
                'datos_base'=> $this->respuesta,
                'filas'=>'1' //1 para indicar que se realizo con exito la insercion
            );
        }
        else
        {
            return array(
                'estado'=>'ERROR',
                'datos_base'=>'vacio',
                'filas'=>'0' //0 para indicar que no se realizo con exito la insercion
            );
        }
    } 
}
