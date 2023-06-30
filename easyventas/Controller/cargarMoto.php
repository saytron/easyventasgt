<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once '../Model/class.conexion.php';
$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");

$consulta = "select r.id_moto, r.linea, r.color, r.chasis, r.motor, r.modelo, r.precio, m.descripcion as marca from moto r, marca m where r.marca_id_marca = m.id_marca and r.vendido = 0";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;

