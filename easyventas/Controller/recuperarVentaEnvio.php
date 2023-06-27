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
	
	
	$consultas = new consultas();
	//Recuperamos la venta generada para la venta para la paginacion
	
    $mensaje;
    $facturado;
		
   $datos = $consultas->recuperarEnvioGenerado($pass);
   if($datos != ""){
      foreach($datos as $fila) { 
        $facturado = $fila['facturado'];
      	$mensaje = $fila['filas'];
      }
    }
	
        
            echo $mensaje;
		
	

?>