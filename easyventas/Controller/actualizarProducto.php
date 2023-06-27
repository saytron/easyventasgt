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

$codigo = $_POST['codigopr'];
$descripcion = strtoupper($_POST['descripcionpr']);
$cantidad = $_POST['cantidadpr'];
$precio = $_POST['preciopr'];
$validar_numeros = "1234567890.";
$imagenProductoE = $_POST['imagenProductoE'];


$mensaje = null;
if ($rol == 2) {
	if (strlen($codigo) > 0 && strlen($descripcion) > 0 && strlen($cantidad) > 0 && strlen($precio) > 0) {

		$consultas = new consultas();
		for ($i = 0; $i < strlen($precio); $i++) {
			if (strpos($validar_numeros, substr($precio, $i, 1)) === false) {
				echo "Caracteres no validos para el campo precio";
				return false;
			}
		}


		if ($_FILES['imagenProductoEdit']['name'] == NULL) {
		
			$consultas->actualizarProducto($codigo, $descripcion, $cantidad, $precio, $imagenProductoE);
          $mensaje = 1;
		} else {
			$foto = $_FILES['imagenProductoEdit'];
			if ($foto["type"] == "image/jpg" or $foto["type"] == "image/jpeg" or $foto["type"] == "image/png" or $foto["type"] == "image/webp") {
				$ruta = "../img/productos/" . md5($foto["tmp_name"]) . ".webp";
				 $consultas->actualizarProducto($codigo, $descripcion, $cantidad, $precio, $ruta);
              $mensaje = 2;
				move_uploaded_file($foto['tmp_name'], $ruta);
				unlink($imagenProductoE);
			} else {
				$mensaje = 3;
			}
		}
      
	} else {


		$mensaje = 4;
	}
} else {
	$mensaje = "<h2>No tienes suficientes privilegios para realizar esta tarea</h2>";
}


echo $mensaje;
return true;
