<?php
include 'datosConexion.php';
$host = SERVIDOR;
$user = USUARIO;
$password = PASS;
$db = BD;

$conection = @mysqli_connect($host,$user,$password,$db);

if(!$conection){
    echo "error en la conexion";
}else{
    echo "conexion exitosa";
}

?>