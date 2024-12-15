<?php
function conexionBD(){
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "agenda";

    $conexion = mysqli_connect($host, $user, $password, $database);

    if($conexion->connect_error){
        die("Error en la conexion");
    }
    return $conexion;
}