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
        //print_r('ANTES DE INSERT');
        print_r($script); 
        
        $resp = false;
        $conn = pg_connect("host=$this->dbHost dbname=$this->dbBase user=$this->dbUse password=$this->dbPass port=$this->dbPort");
        $querysql = "insert into usuario(correo, contrasenia, nombrecompleto, token, usucreo, fechacreo, usumodifico, fechamodifico,activo) "
        . "values('scr@gmail.com3', '12345', 'David Clavijo','12344 07-10-2021 09:35:14 pm','Santiago Clavijo','2021-09-03', null, null, true)";
        $query = pg_query($conn,$querysql);
        if($query)
            $resp = true;
          else{
            echo "Ocurri&oacute; un error! ".pg_last_error();
            die();
            
          }
          return $resp;
        pg_close($this->conn);
        
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
