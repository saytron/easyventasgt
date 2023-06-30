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
if($rol == '2'){
    $consulta ="select idventa,facturado as estado, IF(facturado = 1, (SELECT concat('NIT: ',nit,' ',nombre,' ',apellidos) FROM cliente where id_cliente = cliente_nit),'SIN ASIGNAR') as facturado, usuario, cliente_nit as cliente, estado_dte,fecha, sat_no, IF(estado_dte = 1, ('ANULADA'),IF(facturado = 0,'PENDIENTE','FACTURADO')) as estadodte from venta WHERE facturado IN(0,1) ORDER BY idventa ASC";

}else{
    $consulta ="select idventa,facturado as estado, IF(facturado = 1, (SELECT concat('NIT: ',nit,' ',nombre,' ',apellidos) FROM cliente where id_cliente = cliente_nit),'SIN ASIGNAR') as facturado, usuario, cliente_nit as cliente, estado_dte,fecha, sat_no, IF(estado_dte = 1, ('ANULADA'),IF(facturado = 0,'PENDIENTE','FACTURADO')) as estadodte from venta WHERE usuario = '$pass' and facturado IN(0,1) ORDER BY idventa ASC";
}
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;

