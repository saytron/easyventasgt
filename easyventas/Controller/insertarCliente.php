<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');
	$telefono =(String) $_POST['telefono'];
	$nit = $_POST["nit"];
	$nombre = $_POST["nombre"];
	$email = $_POST["email"];
	$direccion = $_POST["direccion"];
	
	$validar_campo = "abcdefghijklmnopqrstuvwxyz 1234567890.-/ABCDEFGHIJKLMNOPKRSTUVWXYZ";
	$nit_validado;
	
	$consultas = new consultas();
	//comprovamos que no haya codigos repetidos
	//realizamos una consulta para buscar el cliente por su nombre
$clienteCF = $consultas->buscarClienteNombre($nombre);

//si la consulta devuelve un array vacio el cliente no existe en la bd y se procede a ingresarlo
if(empty($clienteCF)){
		echo $mensaje = null;
		if (strlen($nit) >0 && strlen($nombre) >0 && strlen($direccion) >0) {
			
			for ($i=0; $i<strlen($nit); $i++){
      		if (strpos($validar_campo, substr($nit,$i,1))===false){
         echo "Caracteres no validos para el campo precio";
         return false;
      }
   }
   
   $mensaje = $consultas->insertarCliente($nit, $nombre, $email, $direccion);
   $id_cliente = $consultas->buscarClienteMax();
   $cliente;
   foreach($id_cliente as $filas){
	   $cliente = $filas['id_cliente'];
   }

   $consultas->insertarTelefonoCliente($telefono, $cliente);
   
} else{
		

		$mensaje = "<h2>Debes llenar los campos</h2>";

		}
	}else{
		$mensaje = '<h2>Cliente ya existe</h2>';
	}
		echo $mensaje;
		return true;
	

?>