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


	$idMoto = $_POST["idMoto"];
	$idCliente = $_POST["idCliente"];
  
	
	$validar_numeros = "1234567890.";
	$chasis_validado;
    ini_set('date.timezone', 'America/Guatemala');
               $fecha = date('y-m-j');
	
	$consultas = new consultas();
	

		echo $mensaje = null;
		if (strlen($idMoto) >0 && strlen($idCliente) >0 ) {
				
   $consultas->actualizarMoto($idMoto);
   $mensaje = $consultas->insertarDetalleMoto($fecha, $idMoto, $idCliente, $pass);
   
} else{
		

		$mensaje = "<h2>Debes llenar Seleccionar una moto y un cliente de lo contrario la venta no procedera</h2>";

		}

		echo $mensaje;
		return true;
	

?>