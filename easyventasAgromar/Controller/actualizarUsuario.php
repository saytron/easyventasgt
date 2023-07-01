<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');

	$codigo = $_POST['codigo'];
	$usuario = $_POST['usuario'];
	$password = $_POST['pass'];
	$opciones = [
        'cost' => 12,
    ];
    $passEncript = password_hash($password, PASSWORD_BCRYPT, $opciones);
	
		$mensaje = null;
		if (strlen($codigo) >0 && strlen($usuario) >0 ) {

				$consultas = new consultas();
		$mensaje = $consultas->actualizarUsuarios($usuario, $codigo,$passEncript);

		
			
		}else{
		

		$mensaje = "<h2>Debes llenar los campos</h2>";

		}

		echo $mensaje;
		
?>