<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require_once('../Model/class.conexion.php');
	require_once('../Model/class.consultas.php');

	$codigo = $_POST["codigoP"];
	$descripcion = strtoupper($_POST["descripcionP"]);
	$cantidad = '0';
	$precio = $_POST["precioP"];
	$marca = $_POST["idMarcaInsert"];
	$tipo = $_POST["region"];

	$cantidadR = $_POST["cantidadP"];
	$proveedor = $_POST["idProveedorInsert"];
	$ubicacion = $_POST["idBodegaInsert"];
	$usuario = $_POST["usuarioP"];
	$precioR = $_POST["precioCP"];
	$actualizar_cantidad;
	$validar_numeros = "1234567890.";
	$codigo_validado = '';

	

	ini_set('date.timezone', 'America/Guatemala');
               $fecha = date('y-m-j');
	
	$consultas = new consultas();
	//comprovamos que no haya codigos repetidos
	$validar_codigo = $consultas->buscarProductoValidado($codigo);
	if($validar_codigo != ""){
	foreach ($validar_codigo as $fila) {
		$codigo_validado = $fila['codigo'];
	}
}
	if ($codigo == $codigo_validado) {
		echo "Este codigo ya existe";
	
	}else{
		echo $mensaje = null;
		if (strlen($codigo) >0 && strlen($descripcion) >0 && strlen($precio) > 0 && strlen($marca) >0) {
			
			for ($i=0; $i<strlen($precio); $i++){
      		if (strpos($validar_numeros, substr($precio,$i,1))===false){
         echo "Caracteres no validos para el campo precio";
         return false;
      }
   }
   for ($i=0; $i<strlen($cantidad); $i++){
      		if (strpos($validar_numeros, substr($cantidad,$i,1))===false){
         echo "Caracteres no validos para el campo cantidad";
         return false;
      }
   }
  
  if(isset($_FILES['imagenProducto']) && $_FILES['imagenProducto'] != ""){
	   $foto = $_FILES['imagenProducto'];
	   if($foto["type"] == "image/jpg" OR $foto["type"] == "image/jpeg" OR $foto["type"] == "image/png" or $foto["type"] == "image/webp"){
        $ruta = "../img/productos/".md5($foto["tmp_name"]).".webp"; 
		$mensaje = $consultas->insertarProducto($codigo, $descripcion, $cantidad, $precio, $marca,$ruta,$tipo);
		$consultas->insertarDetalleProducto($fecha,$cantidadR,$proveedor,$ubicacion,$codigo,$usuario, $precioR);
		$actualizar_cantidad = $consultas->actualizarCantidad2($codigo,$cantidadR);
		move_uploaded_file($foto['tmp_name'], $ruta);
	}else{
        $mensaje = "Formato no valido para el campo imagen";
        
    }
	
	}else{
		$mensaje = $consultas->insertarProducto($codigo, $descripcion, $cantidad, $precio, $marca,$ruta,$tipo);
		$consultas->insertarDetalleProducto($fecha,$cantidadR,$proveedor,$ubicacion,$codigo,$usuario, $precioR);
		$actualizar_cantidad = $consultas->actualizarCantidad2($codigo,$cantidadR);
		

	}
    

   
} else{
		

		$mensaje = "<h2>Debes llenar los campos</h2>";

		}

		echo $mensaje;
		return true;
	}

?>