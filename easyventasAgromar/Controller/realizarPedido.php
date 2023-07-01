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


	$proveedor = $_POST['nit'];
	
	$validar_numeros = "1234567890.";


		$mensaje = null;
		
			if (strlen($proveedor) >0) {

				$consultas = new consultas();
				
  
		        $mensaje = $consultas->realizarPedido($proveedor);

		
			
		    }
            else{
		

		        $mensaje = "<h2>Debes llenar los campos</h2>";

		    }

	
		

		echo $mensaje;
		return true;
		
?>