<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');


	$idMoto = $_POST['idMoto'];
    $linea = $_POST['linea'];
    $color = $_POST['color'];
    $chasis = $_POST['chasis'];
    $motor = $_POST['motor'];
    $model = $_POST['modelo'];
	$precio = $_POST['precio'];
	$validar_numeros = "1234567890.";

		$mensaje = null;
			if (strlen($idMoto) >0 && strlen($linea) > 0 && strlen($color) >0 && strlen($chasis) > 0 && strlen($motor) > 0 && strlen($model) > 0 && strlen($precio) > 0) {

				$consultas = new consultas();
				for ($i=0; $i<strlen($precio); $i++){
      		if (strpos($validar_numeros, substr($precio,$i,1))===false){
         echo "Caracteres no validos para el campo precio";
         return false;
      }
  }
  for ($i=0; $i<strlen($model); $i++){
    if (strpos($validar_numeros, substr($model,$i,1))===false){
echo "Caracteres no validos para el campo modelo";
return false;
}
}
		$mensaje = $consultas->actualizarMotocicleta($idMoto,$linea,$color,$chasis,$motor,$model,$precio);

		
			
		}else{
		

		$mensaje = "<h2>Debes llenar los campos</h2>";

		}

		echo $mensaje;
		return true;
		
?>