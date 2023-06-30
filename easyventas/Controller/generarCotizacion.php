<?php
error_reporting(E_ALL ^ E_NOTICE);
require('plantillaCotizar.php');
$formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');
//include 'cifrasEnLetras.php';
$idCliente = 0;
$arg_nitCliente = "";
if (isset($_GET['identificador'])) {
  $identificador = $_GET['identificador'];
}
if (isset($_GET['facturado'])) {
  $facturado = $_GET['facturado'];
}
if (isset($_GET['cod'])) {
  $cod = $_GET['cod'];
  $codigo = $_GET['cod'];
}
if (isset($_GET['idfactura'])) {
  $id = $_GET['idfactura'];
}
if (isset($_GET['nombreCliente'])) {
  $nombreCliente = $_GET['nombreCliente'];
}
if (isset($_GET['nit'])) {
  $arg_nitCliente = $_GET['nit'];
}
if (isset($_GET['idcliente'])) {
  $idCliente = $_GET['idcliente'];
}
ini_set('date.timezone', 'America/Guatemala');
$anio = date('y');
$mes = date('m');
$dia = date('j');
$fecha = "'" . $anio . "-" . $mes . "-" . $dia . "'";
$fecha2 = $dia . "-" . $mes . "-" . "20" . $anio;
$consultas = new Consultas();

if (isset($_GET['estado']) && $_GET['estado'] == 0) {
  if ($facturado == 2) {
    if (strlen($id) > 0) {
      $consultas->actualizarVentasCotizar($id, $idCliente);
    }
  }
}
//variables para los datos del negocio
include '../Model/datosNegocio.php';
$razon_social = razon_social;
$direccion1 = direccion1;
$direccion2 = direccion2;
$propietario = propietario;
$nitPropietario = nit;
$telefonoPropietario = telefono;


if (isset($_GET['cod'])) {
  $usuario;
  $id_cliente;
  $nombre;
  $apellidos;
  $nit;
  $direccion;
  $fecha1;
  $telefono;
}

$datosUsuario = $consultas->cargarUsuario($cod);
if ($datosUsuario != "") {
  foreach ($datosUsuario as $filas) {
    $usuario = $filas['n_usuario'];
  }
}

$nombre = "";
$apellidos = "";
$nit = "";
$direccion = "";
$cliente = "";
$telefono = "";
$datoscl = $consultas->cargarClientesFactura($idCliente);

if ($datoscl != "") {
  foreach ($datoscl as $filas) {
    $nombre = $filas['nombre'];
    $apellidos = $filas['apellidos'];
    $nit = $filas['nit'];
    $direccion = $filas['direccion'];
    $telefono = $filas['telefono'];
    $cliente = $nombre . ' ' . $apellidos;
  }
}
$fecha1 = '';
$datos = $consultas->cargarVentasFacturar($cod, $id, $fecha);
if ($datos != "") {
  foreach ($datos as $fila) {
    $fecha1 = $fila['fecha'];
  }
}else{
  $fecha1 = date('y-m-d');
}
//cambiamos el formato de la fecha recuperada de la consulta
function cambiaf_a_espanol($fecha)
{
  preg_match('/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
  $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
  return $lafecha;
}
$fechaFormato = cambiaf_a_espanol($fecha1); //guardamos el formato nuevo
$totalVendido = $consultas->cargarTotalVentasFacturar($codigo, $id, "20" . $anio, $mes);
$derecha = 0;
$textoIzqierda = 0;
$total = 0;
$n=0;
if ($totalVendido != "") {
  foreach ($totalVendido as $filas) {
    $n = (double)$filas['total'];
    $izquierda = intval(floor($n));
    $derecha = intval(($n - floor($n)) * 100);
    $textoIzqierda = utf8_decode($formatterES->format($izquierda));
    $total = $filas['total'];
  }
}
$pdf = new PLANTILLA_COTIZAR('portrait','mm','letter',true);

//PASAMOS LOS DATOS A LA PLANTILLA 
$pdf->datosNegocio($razon_social,$direccion1,$direccion2,$propietario,$nitPropietario,$telefonoPropietario);
$pdf->recuperarDatosTotales($textoIzqierda, $derecha, $total);
$pdf->recuperarDatosFactura($fechaFormato,$id,$usuario);
$pdf->recuperarDatosCliente($cliente,$nombre,$apellidos,$direccion,$nit);
//CREAMOS LA PAGINA  TAMANIO CARTA
$pdf->AddPage('portrait', 'letter');
$pdf->SetMargins(10, 10, 20, 10);

//datos de la tabla
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(2, 0, 0);

$pdf->Ln(2);
//multicell   
//declaramos el tama;o de cada columna
$pdf->SetWidths(array(14, 120, 30, 30));
//declaramos la posicion del contenido de cada columna
$pdf->SetPosition(array('C', 'L', 'R', 'R'));

if ($datos != "") {
  foreach ($datos as $fila) {
    $precioUnitario = $fila['precio_venta'] / $fila['cantidad'];
    $pdf->Row(array($fila['cantidad'], $fila['codigo'] . ' ' . $fila['detalleProducto'], ' Q ' . number_format($precioUnitario, 2), ' Q ' . number_format($fila['precio_venta'], 2)));
  }
}
$pdf->Ln(3);


$pdf->Output();
