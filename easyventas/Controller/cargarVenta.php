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
$fecha = "'".$anio."-".$mes."-".$dia."'";
	


$consulta = "select d.iddetalle_venta as idventa, a.iddetalle_repuesto as id, r.codigo, r.descripcion, d.cantidad, d.precio_venta, r.precio as precio_publico, d.precio_venta as total_venta from repuesto r, detalle_venta d, detalle_repuesto a, venta v WHERE
r.codigo = a.repuesto_codigo and d.detalle_repuesto_iddetalle_repuesto = a.iddetalle_repuesto AND r.codigo = d.repuesto_codigo AND d.venta_idventa = v.idventa AND d.usuario_codigo = '$pass' and d.fecha = $fecha AND v.facturado = 0 ORDER BY d.fecha asc";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;