<?php
include_once '../Model/class.conexion.php';
$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");
$pass = "";
$idVenta = "";
if(isset($_POST['pass'])){$pass = $_POST['pass'];}
if(isset($_POST['idVenta'])){$idVenta = $_POST['idVenta'];}
if(isset($_GET['id'])){$idCorrelativo = $_GET['id'];}
switch($idCorrelativo){
    case 1:
        $consulta = "SELECT sum(precio_venta) as total FROM detalle_venta where usuario_codigo = '$pass' and venta_idventa = $idVenta";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        print json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 2:
        $consulta = "SELECT sum(precio_venta) as total FROM detenvio where usuario_codigo = '$pass' and envio_idventa = $idVenta";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        print json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    default:
            
}


?>