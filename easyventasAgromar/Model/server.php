<?php
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');
//definimos los recursos disponibles
$allowResourceTypes = [
    'producto',
    'marca',
    'proveedor',
    'moto',
    'cliente',
    'codigo'
];
//validamos que el recurso este disponible
$resourceType = $_GET['resource_type'];
if(!in_array($resourceType, $allowResourceTypes)){
 die;
}
//levantamos el id del recurso buscado
$resourceId = array_key_exists('resource_id',$_GET) ? $_GET['resource_id'] : '';
$mensaje = '';
//generamos la respuesta asumeindo que el pedido es correcto
switch(strtoupper($_SERVER['REQUEST_METHOD'])){
    case 'GET':
        $consultas = new consultas();
if (empty($resourceId)){
    $mensaje = $consultas->cargarProducto();
}else{
    $productos = $consultas->cargarProducto();
    if(array_key_exists($resourceId, $productos)){
        $mensaje = $consultas->buscarProductoId($_GET['resource_type']);
    }
    
}
     

     print json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        break;
    case 'POST':
        break;
    case 'PUT':
        break;
    case 'DELETE':
        break;

}
?>