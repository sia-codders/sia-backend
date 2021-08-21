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
        if(pg_query($this->conn,$script)){
            return true;
        }
        else
        {
            return false;
        }
        pg_close($this->conn);
    }
        
}
