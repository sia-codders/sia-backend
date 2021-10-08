<?php
require_once '../BASE/DataBase.php';
class PropietarioSelectController
{
    private $data_recibida; //->JSON
    private $dato_a_buscar; //->ID, O REFERNCIA
    private $tipo_busqueda; //1=POR ID, 2= REFERNCIA,  3=TODOS
    private $db='conjuntosdes';
    private $respuesta; //->DATOS DE LA BASE
    public function __construct($json) {
        $this->data_recibida = json_decode($json);        
        $this->dato_a_buscar= pg_escape_string($this->data_recibida->dato_a_buscar);  
        $this->tipo_busqueda=$this->data_recibida->tipo_busqueda;
        $this->select_propietario();
    }
    private function select_propietario(){
        switch ($this->tipo_busqueda) {
            case 1://POR ID
                $this->respuesta = $this->select_propietario_por_id();
                break;
            case 2://POR REFERNCIA
                $this->respuesta = $this->select_propietario_por_referencia();
                break;
            case 3://TODOS
                $this->respuesta = $this->select_propietario_todos();
                break;
        }
    }
    private function select_propietario_por_id(){
        //ID: Codigo Unico deel propietario
        $dbName = new DataBase($this->db);
        $sentencia = "select b.idbaseusuario ,b.nombre,b.ipserver,
                        b.nombre_condominio,b.foto_path,b.ciudad 
                        from bases b , usuarios u ,base_usuarios bu 
                        where u.email = '$this->email'
                        and  bu.idusuarios =u.idusuarios
                        and  bu.idbaseusuario = b.idbaseusuario ;";       
         return $dbName->consultar_todos($sentencia);
    }    
    private function select_propietario_por_referencia(){
        //Referencia: Parte del Nombre, o Parte de RUC
        $dbName = new DataBase($this->db);
        $sentencia = "select b.idbaseusuario ,b.nombre,b.ipserver,
                        b.nombre_condominio,b.foto_path,b.ciudad 
                        from bases b , usuarios u ,base_usuarios bu 
                        where u.email = '$this->email'
                        and  bu.idusuarios =u.idusuarios
                        and  bu.idbaseusuario = b.idbaseusuario ;";       
        $this->respuesta = $dbName->consultar_todos($sentencia);
    }
    private function select_propietario_todos(){
        //Llama a todos los propietarios
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
