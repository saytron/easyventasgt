<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');
$idventaProduto;
$descuento = 0;
$precio = 0;

	$existencia = $_POST['existencia'];
	$venta = $_POST['venta'];
	$idventa = $_POST['idventa'];
	$idventaProduto = $_POST['idventaProducto'];
	$iddetalle = $_POST['iddetalle'];
	$usuario = $_POST['usuario'];
	$precio = $_POST['precio'];
	$mObra = $_POST['mObra'];
	if(isset($_POST['descuento'])){ $descuento = $_POST['descuento'];
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
	
	$validarFacturado = $consultas->recuperarOrdenFacturado($idventaProduto);
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

	$mensaje = null;
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
  			if($facturaValidada == 1 ):
				$mensaje = "<h1>!Por favor Genera una Venta </h1>";
   			elseif($facturaValidada == 0 ):
				if($existencia < $venta){
					$mensaje = "<h2>No tienes suficiente producto para vender</h2";
				}else if($existencia == 0){
					$mensaje = "<h2>No tienes producto tu existencia es: ".$existencia."</h2";
				}else{
					$consultas->rebajarProducto($venta,$idventa);
					$consultas->rebajarDetalle($venta,$iddetalle);
					$mensaje = $consultas->guardarDetalleOrden($fecha,$venta,$totVenta,$iddetalle,$usuario,$idventa,$idventaProduto,$mObra);	
				
				}
	
   			else:
				echo "hubo un error al ingresar la venta";
   			endif;
	
			
	}else{
		

		$mensaje = "Debes colocar una candidad a vender";

	}

echo $mensaje;
return true;


?>