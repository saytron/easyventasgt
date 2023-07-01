<?php

error_reporting(E_ALL ^ E_NOTICE);
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');
$Datos = json_decode(file_get_contents("php://input"));
// Si no hay datos, salir inmediatamente indicando un error 500
if (!$Datos) {
    // https://parzibyte.me/blog/2021/01/17/php-enviar-codigo-error-500/
    http_response_code(500);
    exit;
}
        $idproducto = $Datos->idproducto;
		$descripcionDetalle = $Datos->descripcionDetalle;
		$compra = $Datos->compra;
		$precioU = $Datos->precioU;
		$precio = $Datos->precio;
		$iddetalle = $Datos->iddetalle;
        $compraOld = $Datos->compraOld;
        $iddetalleVenta = $Datos->iddetalleVenta;
        $difCompra = $compraOld - $compra;


    $consultas = new consultas();
    if($difCompra < 0){
        $cant = -$difCompra;
        $consultas->rebajarProducto($cant, $idproducto);
        $consultas->rebajarDetalle($cant, $iddetalleVenta);
    }else if($difCompra > 0){
        $consultas->actualizarCantidad2($idproducto,$difCompra);
        $consultas->agregarDetalle($difCompra, $iddetalleVenta);
    }else{}
     $mensaje = $consultas->actualizarEnvioDetalle($compra, $iddetalle, $precio, $descripcionDetalle);

     print json_encode($mensaje, JSON_UNESCAPED_UNICODE);

return true;