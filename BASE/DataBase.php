<?php

class DataBase {

    private $dbUse = 'admin';
    private $dbPass = 'admin@2021*';
    private $dbPort = '5432';
    private $dbHost = '104.128.64.217';
    private $dbBase;
    private $conn;

    public function __construct($baseName) {
        $this->dbBase = $baseName;
        $this->conn = pg_connect("host=$this->dbHost dbname=$this->dbBase user=$this->dbUse password=$this->dbPass port=$this->dbPort")
                or die("Error al conectar: " . pg_last_error());
    }

    public function execute($script) {
        print_r('ANTES DE INSERT');
        print_r($script); 
        
        $resp = false;
        if (pg_query($this->conn, $script)) {
            $resp = true;
        }
        pg_close($this->conn);
        return $resp;
    }

    public function insert($array_parametros, $table_name) {

        print_r('hola3');
        print_r($this->conn);
        $resp = pg_insert($this->conn, $table_name, $array_parametros, PGSQL_DML_ESCAPE);
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
    public function consultar_script($script) {
        $data = pg_query($this->conn, $script);
        $resultado = pg_fetch_all($data);
        pg_close($this->conn);
        return $resultado;
    }

}
