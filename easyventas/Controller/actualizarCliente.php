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

$id =  $_POST['id'];
$nit = $_POST['nit'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$validar_numeros = "1234567890.";


$mensaje = null;

if (strlen($id) > 0 && strlen($nit) > 0 && strlen($nombre)  > 0 && strlen($direccion) > 0) {

	$consultas = new consultas();

	$mensaje = $consultas->actualizarCliente($id, $nit, $nombre, $email, $direccion);
	$consultas->actualizarTelefonoCliente($id,$telefono);
} else {


	$mensaje = "<h2>Debes llenar los campos</h2>";
}




echo $mensaje;
return true;
