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

$existencia 	= $Datos->existencia;
$venta			= $Datos->venta;
$idventa 		= $Datos->idventa;
$idventaProduto = $Datos->idventaProducto;
$iddetalle 		= $Datos->iddetalle;
$usuario 		= $Datos->usuario;
$precio 		= $Datos->precio;
$descripcion 	= $Datos->descripcion;
$descuento 		= $Datos->descuento;

	$prDesc = "";
	$totVenta = "";
	//si existe un descuento se lo aplicamos al precio del producto
	if($descuento != ""){
		
		$prDesc = $precio - ($precio * $descuento);
		$totVenta = $venta * $prDesc;
	}else{
		$totVenta = $venta * $precio;
	}
	
	$validar_numeros = "1234567890.";
	$cantidadValidada;
	$facturaValidada;
	ini_set('date.timezone', 'America/Guatemala');
    $fecha = date('y-m-j');
	$consultas = new consultas();
	$type = '';
	$mensaje = null;
if ($idventaProduto == 0) {
	$mensaje = "3"; //debes generar una venta
} else {
	$detalleRepuesto = $consultas->buscarTotProducto($idventa);
	foreach($detalleRepuesto as $filas) {
		$type = $filas['type'];
	}

	$validarFacturado = $consultas->recuperarVentaFacturada($idventaProduto);
	if($validarFacturado != ""){
		foreach($validarFacturado as $facturado){
			$facturaValidada = $facturado['facturado'];
		}
	}else{
		echo $facturaValidada;
	}

    $validarCantidad = $consultas->recuperarCantidad($idventa);
	if ($validarCantidad != "") {
		foreach($validarCantidad as $fila) {
			$cantidadValidada = $fila['cantidad'];
		}
	}else{
			echo "No hay datos para mostrar";
	}

	
	if (strlen($venta) >0 && strlen($idventa) >0 && strlen($iddetalle) > 0 && strlen($usuario) >0) {
		
			for ($i=0; $i<strlen($precio); $i++){
      			if (strpos($validar_numeros, substr($precio,$i,1))===false){
         			echo "Caracteres no validos para el campo precio";
         			return false;
      			}
  			}
  			for ($i=0; $i<strlen($venta); $i++){
      			if (strpos($validar_numeros, substr($venta,$i,1))===false){
         			echo "Caracteres no validos para el campo cantidad";
         			return false;
      			}
  			}
  			if($facturaValidada == 1 || $facturaValidada == 2){
				$mensaje = "3"; //debes generar una venta
			  }
   			else if($facturaValidada == 0 ){
			   
				if($existencia < $venta || $existencia == 0){
					$mensaje = "2"; //no tienes producto para vender
				}else{
					$consultas->rebajarProducto($venta,$idventa);
					$consultas->rebajarDetalle($venta,$iddetalle);
					$mensaje = $consultas->guardarDetalleVenta($fecha,$venta,$totVenta,$iddetalle,$usuario,$idventa,$idventaProduto,$descripcion,$type);	
				
				}
			}else{
				$mensaje = "5"; // "hubo un error al ingresar la venta";
			   }
	
			
	}else{
		

		$mensaje = "4";//debes colocar una cantidad a vender

	}
}
echo json_encode($mensaje);
return true;


?>