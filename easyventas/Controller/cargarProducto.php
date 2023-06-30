<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once '../Model/class.conexion.php';
$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");

$consulta = "SELECT r.codigo, r.descripcion, r.cantidad, r.precio, r.url_imagen, m.descripcion as marca FROM repuesto r, marca m where m.id_marca = r.marca_id_marca";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;