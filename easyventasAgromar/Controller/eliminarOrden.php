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
    $idVenta = $_POST['idventa'];
	$id =  $_POST['iddetalle'];
	$cantidad = $_POST['cantidad'];
	$precio = $_POST['precio'];
	$idproducto = $_POST['idproducto'];
	$validar_numeros = "1234567890.";

	
		$mensaje = null;
		
			if (strlen($id) >0 && strlen($cantidad) > 0 && strlen($precio) >0 && strlen($idproducto) >0 && strlen($idVenta) >0) {

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
		$consultas->actualizarCantidad2($idproducto,$cantidad);
        $consultas->agregarCompraProducto($id,$cantidad,$precio);
		$mensaje = $consultas->eliminarOrden($idVenta);
        

		
			
		}else{
		

		$mensaje = "<h2>Debes llenar los campos</h2>".$cantidad;

		}

		

		echo $mensaje;
		
?>