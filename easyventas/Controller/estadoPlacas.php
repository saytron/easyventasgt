<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('../Model/class.conexion.php');
  require_once('../Model/class.consultas.php');
 $estadoPlacas = $_POST['estadoPlacas'];  
 $iddetalleMoto = $_POST['iddetalleMoto'];
  
$consultas = new Consultas();
$mensaje = $data = $consultas->estadoPlacas($estadoPlacas,$iddetalleMoto);
echo $mensaje;

?>


