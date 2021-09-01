<?php
require_once '../BASE/DataBase.php';
class Helpers{
    
    public function validar_token($token){
        $tokenAngular = "c33de536beab5630f799fb0cd4a8d30a";
        if($tokenAngular==$token)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}