<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once '../Model/class.conexion.php';
$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");

$consulta = "select c.id_cliente as id, c.nit,c.nombre, c.nombre as cliente, c.direccion, c.email, t.descripcion as telefono from cliente c, telefono_cliente t where c.id_cliente = t.cliente_id_cliente";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;


?>