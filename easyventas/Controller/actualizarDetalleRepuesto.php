<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
    require_once('../Model/class.consultas.php');
    
    if (!isset($_SESSION)) {

		session_start();
		}
		$pass = $_SESSION['codigo'];
		$usuario = $_SESSION['usuario'];
		$rol = $_SESSION['rol'];

	$cantidad = $_POST["cantidad"];
	$oldBodega = $_POST["oldBodega"];
	$proveedor = $_POST["proveedor"];
	$ubicacion = $_POST["ubicacion"];
	$repuesto = $_POST["idrepuesto"];
	$codigoRepuesto = $_POST['codigoPr'];
	$usuario = $_POST["usuario"];
	$precio = $_POST["precio"];
	$validar_numeros = "1234567890.";
	$actualizar_cantidad;
	ini_set('date.timezone', 'America/Guatemala');
               $fecha = date('y-m-j');
    $mensaje = null;
    if($rol == 2){
		if (strlen($cantidad) >0 && strlen($proveedor) >0 && strlen($ubicacion) > 0 && strlen($repuesto) >0 && strlen($oldBodega) > 0) {

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
		$mensaje = $consultas->actualizarDetalleProducto($cantidad,$oldBodega,$proveedor,$ubicacion,$repuesto,$usuario, $precio);
		$datos = $consultas->recuperarCantidadDetalleRepuesto($codigoRepuesto);
		$cantidadTotal = "";
		foreach($datos as $filas){
			$cantidadTotal = $filas['cantidad'];
		}
		$consultas->actualizarCantidadRepuesto($cantidadTotal,$codigoRepuesto);
			
		}else{
		

		$mensaje = "2"; //<h2>Debes llenar los campos</h2>";

        }
        
    }else{
        $mensaje = "3"; // "<h2>No tienes suficientes privilegios para realizar esta tarea</h2>";
    }

		echo $mensaje;
		return true;
		
?>