<?php

require_once '../BASE/DataBase.php';

class MasterCrudSelect
{
    //Creada por: Santiago      Fecha: 2021-09-26 23:13
    private $db = 'condominio';
    private $dbName;
    
    public function __construct() {
        //Creada por: Santiago      Fecha: 2021-09-26 23:13  
        $this->dbName = new DataBase($this->db);
    }   
    
    public function consultar_base($script) {
        //Creada por: Santiago      Fecha: 2021-09-26 23:13       
        return  $this->dbName->consultar_script($script);
    } 
    
    public function genera_respuesta($respuesta) 
    {
        //Creada por: Santiago      Fecha: 2021-09-26 23:13
        $array_resp=null;
        if (isset($respuesta)) {
            if (empty($respuesta)) {
                 $array_resp= array(
                    'estado' => 'OK',
                    'datos_base' => $respuesta,
                    'filas' => '0'
                );
            } else {                
                $array_resp= array(
                    'estado' => 'OK',
                    'datos_base' => $respuesta,
                    'filas' => count($respuesta)
                );
            }
        } else {
            $array_resp= array(
                'estado' => 'ERROR',
                'datos_base' => $respuesta,
                'filas' => '0'
            );
        }
        return $array_resp;
        
    }
    
}
