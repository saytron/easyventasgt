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


$descripcion = strtoupper($_POST['descripcionpr']);
$validar_numeros = "1234567890.";
$imagenProductoE = $_POST['imagenProductoE'];
$precio = $_POST['preciopr'];
$cantidad = $_POST["cantidadAcDet"];
$oldBodega = $_POST["oldBodega"];
$proveedor = $_POST["proveedorId"];
$ubicacion = $_POST["bodegaId"];
$repuesto = $_POST["codigopr"];
$codigoRepuesto = $_POST['codigoAcDet'];//codigo de detalle_repuesto
$usuario = $_POST["usuarioAcDet"];
$precioCompra = $_POST["precioAcDet"];
$validar_numeros = "1234567890.";
$actualizar_cantidad;
ini_set('date.timezone', 'America/Guatemala');
$fecha = date('y-m-j');
$mensaje = null;
if ($rol == 2) {
	if (strlen($cantidad) > 0 && strlen($proveedor) > 0 && strlen($ubicacion) > 0 && strlen($repuesto) > 0 && strlen($oldBodega) > 0) {

		$consultas = new consultas();

		for ($i = 0; $i < strlen($precio); $i++) {
			if (strpos($validar_numeros, substr($precio, $i, 1)) === false) {
				echo "Caracteres no validos para el campo precio";
				return false;
			}
		}
		for ($i = 0; $i < strlen($cantidad); $i++) {
			if (strpos($validar_numeros, substr($cantidad, $i, 1)) === false) {
				echo "Caracteres no validos para el campo cantidad";
				return false;
			}
		}

		if ($_FILES['imagenProductoEdit']['name'] == NULL) {

			$consultas->actualizarProducto($repuesto, $descripcion, $cantidad, $precio, $imagenProductoE);
			$mensaje = $consultas->actualizarDetalleProducto($cantidad, $oldBodega, $proveedor, $ubicacion, $codigoRepuesto, $usuario, $precioCompra);
			$datos = $consultas->recuperarCantidadDetalleRepuesto($codigoRepuesto);
			$cantidadTotal = "";
			foreach ($datos as $filas) {
				$cantidadTotal = $filas['cantidad'];
			}
			$consultas->actualizarCantidadRepuesto($cantidadTotal, $codigoRepuesto);
			
		} else {
			$foto = $_FILES['imagenProductoEdit'];
			if ($foto["type"] == "image/jpg" or $foto["type"] == "image/jpeg" or $foto["type"] == "image/png" or $foto["type"] == "image/webp") {
				$ruta = "../img/productos/" . md5($foto["tmp_name"]) . ".webp";
				$consultas->actualizarProducto($repuesto, $descripcion, $cantidad, $precio, $ruta);
				$mensaje = $consultas->actualizarDetalleProducto($cantidad, $oldBodega, $proveedor, $ubicacion, $codigoRepuesto, $usuario, $precioCompra);
				$datos = $consultas->recuperarCantidadDetalleRepuesto($codigoRepuesto);
				$cantidadTotal = "";
				foreach ($datos as $filas) {
					$cantidadTotal = $filas['cantidad'];
				}
				$consultas->actualizarCantidadRepuesto($cantidadTotal, $codigoRepuesto);
				
				move_uploaded_file($foto['tmp_name'], $ruta);
				unlink($imagenProductoE);
			} else {
				$mensaje = 3;
			}
		}
	} else {


		$mensaje = 2; //<h2>Debes llenar los campos</h2>";

	}
} else {
	$mensaje = "3"; // "<h2>No tienes suficientes privilegios para realizar esta tarea</h2>";
}

echo $mensaje;
return true;

?>



