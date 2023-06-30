<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');

	$id = $_POST['id'];
	$nombre = strtoupper($_POST['nombre']);
	$direccion = strtoupper($_POST['direccion']);
	$fecha = $_POST['fecha'];
	
		$mensaje = null;
		if (strlen($nombre) >0 && strlen($direccion) >0 && strlen($fecha) > 0 ) {

				$consultas = new consultas();
		$mensaje = $consultas->actualizarEmpleados($id,$nombre, $direccion,$fecha);

		
			
		}else{
		
   
		$mensaje = "<h2>Debes llenar los campos</h2>";

		}

		echo $mensaje;
		
?>