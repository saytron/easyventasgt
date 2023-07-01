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

$idTelefono = $_POST['idCliente'];
$direccion;

$objeto = new Conexion();
$conexion = $objeto->get_connection();
header("Access-Control-Allow-Origin: *");
$sql = "select c.id_cliente as id, c.nit, c.nombre,CONCAT(c.nombre,' ',c.apellidos) as cliente, c.apellidos, c.direccion, t.descripcion as telefono from cliente c, telefono_cliente t where c.id_cliente = t.cliente_id_cliente and c.id_cliente = '$idTelefono'";
$resultado = $conexion->prepare($sql);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;


?>