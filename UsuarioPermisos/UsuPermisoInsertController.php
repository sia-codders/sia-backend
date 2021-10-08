<?php
require_once '../BASE/DataBase.php';
class UsuPermisoInsertController
{
    /*Detalle: Tablas a trabajar: usuario - usuario_permisos - modulos_sistemas
     * Creado por: Santiago Clavijo             Fecha: 2021-09-22
     */
    
    private $data_recibida;
    private $db='condominio';
    private $nombre, $detalle, $usuCreo;    
    private $respuesta;
    
    public function __construct($json,$tipo_script) {
        $this->data_recibida = json_decode($json);        
        $this->nombre= pg_escape_string($this->data_recibida->nombre); 
        $this->detalle= pg_escape_string($this->data_recibida->detalle); 
        $this->usuCreo= pg_escape_string($this->data_recibida->usuCreo);
        $this->insertar_estado_civil();        
    }
    private function insertar_estado_civil(){
        $dbName = new DataBase($this->db);
        $sentencia = "INSERT INTO public.estado_civil
                       (nombre, detalle, usucreo, fechacreo, usumodifico, fechamodifico, activo)
                        VALUES('$this->nombre', '$this->detalle', '$this->usuCreo',now(),null, null, true);";       
        $this->respuesta = $dbName->execute($sentencia);
    }   
    public function generar_respuesta() {
        if(isset($this->respuesta))
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
