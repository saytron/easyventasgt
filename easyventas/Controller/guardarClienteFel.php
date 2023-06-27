<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');

$nitCliente	= strtoupper($_POST['nit']);
$nombreCliente = strtoupper($_POST['nombre']);
$direccionCliente = strtoupper($_POST['direccion']);
$email = $_POST['email'];
$consultas = new consultas();
$cliente = '';
//realizamos una consulta para buscar el cliente por su nombre
$clienteCF = $consultas->buscarClienteNombre($nombreCliente);

//si la consulta devuelve un array vacio el cliente no existe en la bd y se procede a ingresarlo
if(empty($clienteCF)){
   //ingresamos el cliente nuevo en la bd
   $consultas->insertarCliente($nitCliente,$nombreCliente,$email,$direccionCliente);
   //recuperamos el id del cliente nuevo
   $id_cliente = $consultas->buscarClienteNombre($nombreCliente);
  
   //recorremos el array para insertar el id del cliente en una variable
   foreach($id_cliente as $filas){

	   $cliente = $filas['id_cliente'];
   }
   
}else{
//si existe el cliente unicamente recorremos el array clientecf para recuperar el id y actualizamos el cliente
   foreach($clienteCF as $filas){
	   $cliente = $filas['id_cliente'];
      $consultas->actualizarCliente($cliente, $nitCliente, $nombreCliente, $email, $direccionCliente);
   }
}
//guardamos el numero de telefono par poder tener el cliente activo tiene que tener un dato en el campo telefono
//de lo contrario el cliente no aparece en las consultas que hagamos
if(empty($clienteCF)){
   $consultas->insertarTelefonoCliente('0', $cliente);
}
//imprimimos el id para poder recuperarlo en con javascript
print_r($cliente);

