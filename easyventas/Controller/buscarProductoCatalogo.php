<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once '../Model/class.conexion.php';
$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");
$idProducto = utf8_decode($_GET['idProducto']);
$consulta = "SELECT r.codigo, concat(r.descripcion,' MARCA ',m.descripcion) as producto FROM repuesto r, marca m where m.id_marca = r.marca_id_marca and concat(r.codigo,' ',r.descripcion,' marca ',m.descripcion) = '$idProducto'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;