<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');

	$linea = $_POST["linea"];
	$color = $_POST["color"];
	$chasis = $_POST["chasis"];
	$motor = $_POST["motor"];
    $modelo = $_POST["modelo"];
    $precio = $_POST["precio"];
    $marca = $_POST["marca"];
    
	$validar_numeros = "1234567890.";
	$chasis_validado;
	
	$consultas = new consultas();
	//comprovamos que no haya codigos repetidos
	$validar_chasis = $consultas->buscarMotoValidada($chasis);
	if($validar_chasis != ""){
	foreach ($validar_chasis as $fila) {
		$chasis_validado = $fila['chasis'];
	}
}
	if ($chasis == $chasis_validado) {
		echo "Esta moto ya existe";
	
	}else{

		echo $mensaje = null;
		if (strlen($linea) >0 && strlen($color) >0 && strlen($chasis) > 0 && strlen($motor) >0 && strlen($modelo) >0 && strlen($precio) >0 && strlen($marca) >0) {
			
			for ($i=0; $i<strlen($precio); $i++){
      		if (strpos($validar_numeros, substr($precio,$i,1))===false){
         echo "Caracteres no validos para el campo precio";
         return false;
      }
   }
   
   $mensaje = $consultas->insertarMotos($linea, $color, $chasis, $motor, $modelo, $precio, $marca);
   
} else{
		

		$mensaje = "<h2>Debes llenar los campos</h2>";

		}

		echo $mensaje;
		return true;
	}

?>