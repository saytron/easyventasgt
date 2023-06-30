<?php
error_reporting(E_ALL ^ E_NOTICE);
if (!isset($_SESSION)) {

    session_start();
    }
    $pass = $_SESSION['codigo'];
    $usuario = $_SESSION['usuario'];
  

include_once '../Model/class.conexion.php';
$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");

$consulta = "select r.id_moto, r.linea, r.color, r.chasis, r.motor, r.modelo, concat('Q ',r.precio) as precio, m.descripcion as marca, concat(c.nombre,' ',c.apellidos) as cliente, d.fecha as fecha, d.estadoPlacas as estadoPlacas, d.iddetalle_moto as iddetMoto from cliente c, moto r, marca m, detalle_moto d where r.marca_id_marca = m.id_marca and c.id_cliente =d.cliente_id_cliente1 and r.id_moto = d.moto_id_moto and r.vendido = 1 and d.usuario_codigo = '$pass'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;