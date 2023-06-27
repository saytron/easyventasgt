<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');
	$iddetalle = $_POST['iddetalle'];
	$pedir = $_POST['pedir'];
	
	$validar_numeros = "1234567890.";
	$cantidadValidada;
	$facturaValidada;
	ini_set('date.timezone', 'America/Guatemala');
    $fecha = date('y-m-j');
	$consultas = new consultas();

	$mensaje = null;
	    if (strlen($iddetalle) >0 && strlen($pedir) >0) {
		
			for ($i=0; $i<strlen($pedir); $i++){
      			if (strpos($validar_numeros, substr($pedir,$i,1))===false){
         			echo "Caracteres no validos para el campo precio";
         			return false;
      			}
  			}
  			
					
					$mensaje = $consultas->pedirProducto($pedir,$iddetalle);	
	

	    }else{
		

		$mensaje = "Debes colocar una cantidad a pedir";

	}

echo $mensaje;
return true;


?>