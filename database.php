<?php
//conexion ala base de datos
function connect(){
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "login";
    $conn = new mysqli($server,$user,$password,$db);
    if($conn->connect_errno){
        echo "Error al conectar con la base";
        exit;
    }
    return $conn;
    
}

