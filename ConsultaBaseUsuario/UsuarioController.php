<?php
require_once '../BASE/DataBase.php';
class UsuarioController
{
    private $dataPost;
    private $email;
    private $db='conjuntosdes';
    private $respuesta;
    public function __construct($json) {
        $this->dataPost = json_decode($json);        
        $this->email= pg_escape_string($this->dataPost->email); 
        $this->consultar_usuario();
    }
    private function consultar_usuario(){
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
        if($this->respuesta)
        {
            return array(
                'estado'=>'ok',
                'data'=> $this->respuesta
            );
        }
        else
        {
            return array(
                'estado'=>'error'                
            );
        }
    } 
}
