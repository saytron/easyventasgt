<?php
/*
error_reporting(E_ALL ^ E_NOTICE);
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');
$Datos = json_decode(file_get_contents("php://input"));
// Si no hay datos, salir inmediatamente indicando un error 500
if (!$Datos) {
    // https://parzibyte.me/blog/2021/01/17/php-enviar-codigo-error-500/
    http_response_code(500);
    exit;
}

$idCatalogo = $Datos->idCatalogo;

 //$codProducto = $_POST['codigo'];


    $consultas = new consultas();

     $mensaje = $consultas->buscarCatalogo($idCatalogo);

     print json_encode($mensaje, JSON_UNESCAPED_UNICODE);

return true;*/



error_reporting(E_ALL ^ E_NOTICE);
include_once '../Model/class.conexion.php';
$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");

    $consulta ="SELECT *from catalogo";

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;