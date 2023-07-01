<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');

	$nombre = $_POST['nombre'];
	$direccion = $_POST['direccion'];
	
	$nacimiento = $_POST['fechaNac'];

		$mensaje = null;
		if (strlen($nombre) >0 && strlen($direccion) >0 && strlen($nacimiento) > 0) {

				$consultas = new consultas();
		$mensaje = $consultas->insertarEmpleado($nombre, $direccion, $nacimiento);

		
			
		}else{
		

		$mensaje = "<h2>Debes llenar los campos</h2>".$nacimiento;

		}

		echo $mensaje;
		
?>