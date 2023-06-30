<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');

	$codigo = $_POST["codigo"];
	$usuario = $_POST["usuario"];
	$empleado = $_POST["empleado"];
	$rol = $_POST["rol"];
	$opciones = [
        'cost' => 12,
    ];
    $passEncript = password_hash($codigo, PASSWORD_BCRYPT, $opciones);
	
	$cod = $codigo . $usuario;
	
		$mensaje = null;
		if (strlen($codigo) >0 && strlen($usuario) >0 && strlen($empleado) > 0) {

				$consultas = new consultas();

				$duplicateUser = $consultas->buscarUsuario($cod);
				if($duplicateUser != ''){
					$mensaje = $consultas->insertarUsuario($cod, $usuario, $empleado, $rol,$passEncript);

				}else{
					$mensaje = "<h2>Codigo de usuario repetido</h2>";
				}

		
			
		}else{
		

		$mensaje = "<h2>Debes llenar los campos</h2>";

		}

		echo $mensaje;
		
?>