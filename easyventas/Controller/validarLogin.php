<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');
	$Datos = json_decode(file_get_contents("php://input"));
	// Si no hay datos, salir inmediatamente indicando un error 500
	if (!$Datos) {
		// https://parzibyte.me/blog/2021/01/17/php-enviar-codigo-error-500/
		http_response_code(500);
		exit;
	}
				

	$usuario = $Datos->usuario;
	$pass = $Datos->pass;

	session_start();
	echo $mensaje = null;
	if (strlen($usuario) >0 && strlen($pass) >0) {
		$consultas = new consultas();
		$datos = $consultas->validarLogin($usuario);
		if($datos != ""){
			foreach($datos as $fila) { 
	            if($fila['usuario'] == $usuario && password_verify( $pass, $fila['pass'])) {
                	session_start();
					$_SESSION['codigo'] = $fila['codigo'];
					$_SESSION['usuario'] = $usuario;
					$_SESSION['rol'] = $fila['rol'];
					$mensaje = "correcto";
                }else{
                	$mensaje = " Usuario o contraseña invalidos";
                }
	        }

		}else{
			$mensaje = "No hay datos para mostrar";
		}
	}else{
		$mensaje = "Debes llenar los campos";
	}
	print json_encode($mensaje);
?>