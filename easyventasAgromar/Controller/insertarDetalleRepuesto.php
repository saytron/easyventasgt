<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');

	$cantidad = $_POST["cantidad"];
	$proveedor = $_POST["proveedor"];
	$ubicacion = $_POST["ubicacion"];
	$repuesto = $_POST["repuesto"];
	$usuario = $_POST["usuario"];
	$precio = $_POST["precio"];
	$validar_numeros = "1234567890.";
	$actualizar_cantidad;
	ini_set('date.timezone', 'America/Guatemala');
               $fecha = date('y-m-j');
	$mensaje = null;
		if (strlen($cantidad) >0 && strlen($proveedor) >0 && strlen($ubicacion) > 0 && strlen($repuesto) >0) {

				$consultas = new consultas();

				for ($i=0; $i<strlen($precio); $i++){
      		if (strpos($validar_numeros, substr($precio,$i,1))===false){
         echo "Caracteres no validos para el campo precio";
         return false;
      }
   }
   for ($i=0; $i<strlen($cantidad); $i++){
      		if (strpos($validar_numeros, substr($cantidad,$i,1))===false){
         echo "Caracteres no validos para el campo cantidad";
         return false;
      }
   }
		$mensaje = $consultas->insertarDetalleProducto($fecha,$cantidad,$proveedor,$ubicacion,$repuesto,$usuario, $precio);
		$actualizar_cantidad = $consultas->actualizarCantidad2($repuesto,$cantidad);
		
			
		}else{
		

		$mensaje = "<h2>Debes llenar los campos</h2>";

		}

		echo $cantidad;
		return true;
		
?>