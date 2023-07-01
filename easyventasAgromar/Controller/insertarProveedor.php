<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');

	$nit = $_POST["nit"];
	$nombre = $_POST["nombre"];
	$direccion = $_POST["direccion"];
	

		echo $mensaje = null;
		if (strlen($nit) >0 && strlen($nombre) > 0 && strlen($direccion) > 0 ) {

				$consultas = new consultas();
		$mensaje = $consultas->insertarProveedor($nit,$nombre,$direccion);

		
			
		}else{
		

		$mensaje = "<h2>Debes llenar los campos</h2>";

		}

		echo $mensaje;
		
?>