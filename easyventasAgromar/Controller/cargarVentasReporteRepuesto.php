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

$consulta = "select m.descripcion as marca, SUM(d.precio_venta) as venta FROM detalle_venta d, venta v, repuesto r, marca m WHERE v.idventa = d.venta_idventa AND r.marca_id_marca = m.id_marca AND d.usuario_codigo = '$pass' AND v.facturado in(0,1) AND month(d.fecha) = '$mes' AND year(d.fecha) = YEAR(NOW()) and r.codigo = d.repuesto_codigo GROUP BY m.descripcion";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;