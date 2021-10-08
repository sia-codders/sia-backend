<?php
 $dbUse = 'admin';
     $dbPass = 'admin@2021*';
     $dbPort = '5432';
     $dbHost = '104.128.64.217';
     $dbBase = 'condominio';
$conn = pg_connect("host=$dbHost dbname=$dbBase user=$dbUse password=$dbPass port=$dbPort");
$query = "insert into usuario(correo, contrasenia, nombrecompleto, token, usucreo, fechacreo, usumodifico, fechamodifico,activo) "
        . "values('scr@gmail.com3', '12345', 'David Clavijo','12344 07-10-2021 09:35:14 pm','Santiago Clavijo','2021-09-03', null, null, true)";
//
       $query = pg_query($conn, $query);
       // $query = pg_query($query);
if($query)
  echo "Inserción completa!";
else{
  echo "Ocurri&oacute; un error! ".pg_last_error();
}

        
