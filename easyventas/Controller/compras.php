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

	$id =  $_POST['iddetalle'];
	$cantidad = $_POST['cantidad'];
	$precio = $_POST['precio'];
	$precioVenta = $_POST['precioVenta'];
	$idproducto = $_POST['idproducto'];
	$validar_numeros = "1234567890.";

	ini_set('date.timezone', 'America/Guatemala');
    $fecha = date('y-m-j');
	
		$mensaje = null;
		if ($rol == 2){
			if (strlen($id) >0 && strlen($cantidad) > 0 && strlen($precio) >0) {

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
		$consultas->actualizarCantidad($idproducto,$cantidad,$precioVenta);
		
		$mensaje = $consultas->agregarCompraProducto2($id,$cantidad,$precio,$fecha);

		
			
		}else{
		

		$mensaje = "<h2>Debes llenar los campos</h2>".$idproducto;

		}

		}else{
			$mensaje = "<h2>No tienes suficientes privilegios para realizar esta tarea</h2>";
		}
		

		echo $mensaje;
		
?>