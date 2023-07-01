<?php

error_reporting(E_ALL ^ E_NOTICE);
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');
if (isset($_POST['opcion'])) {
    $opc = $_POST['opcion'];
}
if (isset($_POST['descripcion'])) {
    $descripcion = $_POST['descripcion'];
}
if (isset($_POST['rol'])) {
    $rol = $_POST['rol'];
}
if (isset($_POST['telefono'])) {
    $telefono = $_POST['telefono'];
}
if (isset($_POST['idTelefono'])) {
    $idcliente = $_POST['idTelefono'];
}
if (isset($_POST['nit'])) {
    $nit = $_POST['nit'];
}
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}
if (isset($_POST['direccion'])) {
    $direccion = $_POST['direccion'];
}

//insertamos diferentes datos a la bd marca,proveedor, rol, telefono,
$mensaje = null;
switch ($opc) {
    case 1:
        // ----------------insertamos la marca-----------------
        if (strlen($descripcion) > 0) {
            $consultas = new consultas();
            $mensaje = $consultas->insertarMarca($descripcion);
        } else {
            $mensaje = "<h2>Debes llenar los campos</h2>";
        }
        break;
    case 2:
        // ---------------insertamos el rol---------------------
        if (strlen($rol) > 0) {
            $consultas = new consultas();
            $mensaje = $consultas->insertarRol($rol);
        } else {
            $mensaje = "<h2>Debes llenar los campos</h2>";
        }
        break;
    case 3:
        // ------------insertar telefono del cliente ------------
        if (strlen($telefono) > 0) {
            $consultas = new consultas();
            $mensaje = $consultas->insertarTelefonoCliente($telefono, $idcliente);
        } else {
            $mensaje = "<h2>Debes llenar los campos</h2>";
        }
        break;
    case 4:
        // ---------------insertamos la bodega -----------------------
        if (strlen($descripcion) > 0) {
            $consultas = new consultas();
            $mensaje = $consultas->insertarBodega($descripcion);
        } else {
            $mensaje = "<h2>Debes llenar los campos</h2>";
        }
        break;
    case 5:
        // --------------------- insertamos proveedores --------------------------
        if (strlen($nit) >0 && strlen($nombre) > 0 && strlen($direccion) > 0 ) {

            $consultas = new consultas();
            $mensaje = $consultas->insertarProveedor($nit,$nombre,$direccion);  
        }else{
            $mensaje = "<h2>Debes llenar los campos</h2>";
        }
        break;
    default:
        break;
}


echo $mensaje;
