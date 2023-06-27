<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');

	if (!isset($_SESSION)) {

		session_start();
		}
		$pass = $_SESSION['codigo'];
		$usuario = $_SESSION['usuario'];
	
	$accion = $_POST['accion'];
	
	$consultas = new consultas();
	//comprovamos que no haya codigos repetidos
	
	$mensaje;
		
   
  
	$consultas->generarCotizacion($pass);
  


   $datos = $consultas->recuperarVentaGenerada2($pass);
   if($datos != ""){
      foreach($datos as $fila) { 
      	$mensaje = $fila['filas'];
      }
    }
	

		echo $mensaje;
	

?>