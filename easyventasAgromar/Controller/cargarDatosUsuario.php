<?php
include_once '../Model/class.conexion.php';
$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");
if (!isset($_SESSION)){session_start();}
$pass = $_SESSION['codigo'];
$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];

$consulta ="SELECT * FROM empleado e, usuario u where u.empleado_id_empleado = e.id_empleado and u.codigo = '$pass' ";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
