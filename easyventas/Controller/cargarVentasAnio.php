<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once '../Model/class.conexion.php';
$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");
if (!isset($_SESSION)) {

    session_start();
    }
    $pass = $_SESSION['codigo'];
    $usuario = $_SESSION['usuario'];
    $rol = $_SESSION['rol'];
    ini_set('date.timezone', 'America/Guatemala');
	$anio = date('y');
	$mes = date('m');
	$dia = date('j');

$consulta = "select CONCAT(month(d.fecha), '/', year(d.fecha)) AS fecha,SUM(d.precio_venta) as venta FROM detalle_venta d, venta v WHERE v.idventa = d.venta_idventa AND d.usuario_codigo = '$pass' AND v.facturado in(0,1) AND year(d.fecha) = YEAR(NOW()) GROUP BY CONCAT(month(d.fecha), '/', year(d.fecha))";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;