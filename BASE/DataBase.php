<?php

class DataBase{
    private $dbUse='admin';
    private $dbPass='admin@2021*';
    private $dbPort='5432';
    private $dbHost='104.128.64.217';
    private $dbBase;
    private $conn;
    
    public function __construct($baseName){
          $this->dbBase = $baseName;
          $this->conn = pg_connect("host=$this->dbHost dbname=$this->dbBase user=$this->dbUse password=$this->dbPass port=$this->dbPort");
    }
    
    public function execute($script) 
    {
        $resp = false;
        if(pg_query($this->conn,$script)){
            pg_close($this->conn);
            $resp = true;
        }
        pg_close($this->conn);
        return $resp;
    }
//    public function consultar_uno($script)
//    {
//        $data = pg_query($this->conn,$script);        
//        $resultado = pg_fetch_row($data);
//        pg_close($this->conn);        
//        return $resultado;
//    }
//     public function consultar_todos($script)
//    {
//        $data = pg_query($this->conn,$script);
//        $resultado = pg_fetch_all($data);
//        pg_close($this->conn);
//        return $resultado;
//    }
    public function consultar_script($script)
    {
        $data = pg_query($this->conn,$script);
        $resultado = pg_fetch_all($data);
        pg_close($this->conn);
        return $resultado;
    }
}
