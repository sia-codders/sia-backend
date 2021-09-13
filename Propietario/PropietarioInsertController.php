<?php
require_once '../BASE/DataBase.php';
class PropietarioInsertController
{
    private $data_recibida;
    private $email;
    private $db='conjuntosdes';
    private $respuesta;
    public function __construct($json) {
        $this->data_recibida = json_decode($json);        
        $this->email= pg_escape_string($this->data_recibida->email); 
    }
    private function insert_propietario(){
        $dbName = new DataBase($this->db);
        $sentencia = "select b.idbaseusuario ,b.nombre,b.ipserver,
                        b.nombre_condominio,b.foto_path,b.ciudad 
                        from bases b , usuarios u ,base_usuarios bu 
                        where u.email = '$this->email'
                        and  bu.idusuarios =u.idusuarios
                        and  bu.idbaseusuario = b.idbaseusuario ;";       
        $this->respuesta = $dbName->consultar_todos($sentencia);
    }
    public function generar_respuesta() {
        if(isset($this->respuesta))
        {
            return array(
                'estado'=>'OK',
                'datos_base'=> $this->respuesta
            );
        }
        else
        {
            return array(
                'estado'=>'ERROR',
                'datos_base'=>'vacio'               
            );
        }
    } 
}
