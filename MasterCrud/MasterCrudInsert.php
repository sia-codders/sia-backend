<?php

require_once '../BASE/DataBase.php';

class MasterCrudInsert
{
    //Creada por: Santiago      Fecha: 2021-09-26 23:13
    private $dbName;
    
    public function __construct($nombre_base) {
        //Creada por: Santiago      Fecha: 2021-09-30 23:13  
        $this->dbName = new DataBase($nombre_base);
    }   
    
    public function insertar_base($script){
        //Creada por: Santiago      Fecha: 2021-09-30 23:13    U-Mod: 2021-10-06 1:48     
        //return  $this->dbName->insert($array_parametros,$table_name);        
        return  $this->dbName->execute($script);
    } 
    public function genera_respuesta($respuesta) 
    {
       //Creada por: Santiago      Fecha: 2021-10-01 23:13
        $array_resp=null;
        if (isset($respuesta)) {
            if ($respuesta) {
                 $array_resp= array(
                    'estado' => 'OK',
                    'datos_base' => $respuesta,
                    'filas' => '1'
                );
            } else {                
                $array_resp= array(
                    'estado' => 'OK',
                    'datos_base' => $respuesta,
                    'filas' => '0'
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
