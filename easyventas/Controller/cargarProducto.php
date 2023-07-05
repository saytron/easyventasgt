<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once '../Model/class.conexion.php';
$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");

$consulta = "SELECT r.codigo, r.descripcion, sum(d.cantidad) as cantidad, r.precio, r.url_imagen, m.descripcion as marca FROM repuesto r, detalle_repuesto d, marca m where r.codigo=d.repuesto_codigo and m.id_marca = r.marca_id_marca group by r.codigo";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;