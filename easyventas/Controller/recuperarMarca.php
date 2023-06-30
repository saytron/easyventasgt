<?php
include_once '../Model/class.conexion.php';
$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");
$codigo = $_POST['codigo'];
$consulta ="SELECT * FROM repuesto where codigo = '$codigo'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll();
$idmarca = "";
foreach($data as $filas){
    $idmarca = $filas['marca_id_marca'];
}

$consulta = "select descripcion as marca from marca where id_marca = $idmarca";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);

?>