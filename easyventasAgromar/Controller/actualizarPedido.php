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


	$codigo = $_POST['codigo'];
	
	$validar_numeros = "1234567890.";


		$mensaje = null;
		
			if (strlen($codigo) >0) {

				$consultas = new consultas();
				
  
		        $mensaje = $consultas->actualizarPedido($codigo);

		
			
		    }
            else{
		

		        $mensaje = "<h2>Debes llenar los campos</h2>";

		    }

	
		

		echo $mensaje;
		return true;
		
?>