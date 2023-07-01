<?php
error_reporting(E_ALL ^ E_NOTICE);
include 'plantillaOrdenTrabajo.php';
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');
include 'cifrasEnLetras.php';
$identificador = $_GET['identificador'];
$facturado = $_GET['facturado'];
$cod = "'" . $_GET['cod'] . "'";
$id = $_GET['idfactura'];
$idCliente = $_GET['idcliente'];
ini_set('date.timezone', 'America/Guatemala');
$anio = date('y');
$mes = date('m');
$dia = date('j');
$fecha = "'" . $anio . "-" . $mes . "-" . $dia . "'";
$fecha2 = $dia . "-" . $mes . "-" . "20" . $anio;
$consultas = new Consultas();

if ($facturado == 0) {
  if (strlen($id) > 0) {
    $consultas->actualizarVentasFactura($id, $idCliente);
  }
} else if ($facturado == 4) {
  if (strlen($id) > 0) {
    $consultas->actualizarVentasCotizarFacturar($id, $idCliente);
  }
} else {
}


$usuario;
$id_cliente;
$nombre;
$apellidos;
$nit;
$direccion;
$fecha1;
$datosUsuario = $consultas->cargarUsuario($cod);
if ($datosUsuario != "") {
  foreach ($datosUsuario as $filas) {
    $usuario = $filas['n_usuario'];
  }
}


$datoscl = $consultas->cargarClientesFactura($idCliente);

if ($datoscl != "") {
  foreach ($datoscl as $filas) {
    $nombre = $filas['nombre'];
    $apellidos = $filas['apellidos'];
    $nit = $filas['nit'];
    $direccion = $filas['direccion'];
  }
}

$datos = $consultas->cargarVentasFacturar($cod, $id, $fecha);
if ($datos != "") {
  foreach ($datos as $fila) {
    $fecha1 = $fila['fecha'];
  }
}
//cambiamos el formato de la fecha recuperada de la consulta
function cambiaf_a_espanol($fecha)
{
  preg_match('/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
  $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
  return $lafecha;
}
$fechaFormato = cambiaf_a_espanol($fecha1); //guardamos el formato nuevo
$totalVendido = $consultas->cargarTotalVentasFacturar($cod, $id, "20" . $anio, $mes);

$pdf = new PDF('portrait','mm','letter',true);

$pdf->AddPage();

$pdf->SetFillColor(232, 232, 232);
$pdf->SetTextColor(20, 50, 150);

$pdf->SetFont('Arial', 'B', 12);


$pdf->Ln(10);

$pdf->Cell(195, 4, 'SALIDA DE BODEGA NO.: ' . $id, 0, 0, 'R');

$pdf->Ln(5);
$pdf->Cell(195, 6, 'Fecha: ' . $fechaFormato, 0, 1, 'R');

$pdf->Cell(30, 6, 'Nombre: ', 0, 0);
$pdf->Cell(76, 6, $nombre . ' ' . $apellidos, 0, 0, 'L');
$pdf->Cell(30, 6, '', 0, 0);
$pdf->Cell(37, 6, 'Nit: ', 0, 0, 'R');
$pdf->Cell(37, 6, $nit, 0, 1, 'L');

$pdf->Cell(30, 6, 'Direccion: ', 0, 0);
$pdf->Cell(76, 6, $direccion, 0, 0, 'L');
$pdf->Cell(30, 6, '', 0, 0);
$pdf->Cell(36, 6, 'USUARIO: ', 0, 0, 'R');
$pdf->Cell(23, 6, $usuario, 0, 1, 'R');

$pdf->Ln(5);
$pdf->SetTextColor(2, 0, 0);
$pdf->Cell(10, 6, 'Cant.', 0, 0, 'C', 1);
$pdf->Cell(30, 6, 'Codigo', 0, 0, 'C', 1);
$pdf->Cell(100, 6, 'Descripcion', 0, 0, 'C', 1);
$pdf->Cell(30, 6, 'P. Unitario', 0, 0, 'C', 1);
$pdf->Cell(25, 6, 'Total', 0, 1, 'C', 1);

$pdf->SetFont('Arial', '', 10);
if ($datos != "") {

  foreach ($datos as $fila) {
    $codigo = "'" . $fila['codigo'] . "'";
    $detalleP = $consultas->cargarDetalleProducto($codigo);
    $iddetP;
    foreach ($detalleP as $det) {
      $iddetP = $det['iddetalle_repuesto'];
    }
    $consultas->rebajarProducto($fila['cantidad'], $fila['codigo']);
    $consultas->rebajarDetalle($fila['cantidad'], $iddetP);
    $pdf->Cell(10, 6, $fila['cantidad'], 0, 0, 'C');
    $pdf->Cell(30, 6, $fila['codigo'], 0, 0, 'C');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(100, 6, utf8_decode(' ' . $fila['descripcion']), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 6, 'Q ' . $fila['precio_venta'] / $fila['cantidad'] . '  ', 0, 0, 'R');
    $pdf->Cell(25, 6, 'Q ' . $fila['precio_venta'] . '  ', 0, 1, 'R');
  }
}
$pdf->Ln(8);

if ($totalVendido != "") {
  foreach ($totalVendido as $filas) {
    $letras = valorEnLetras($filas['total']);
    $pdf->Cell(140, 8, 'Son' . $letras . '', 0, 0, 'L');
    $pdf->Cell(27, 8, 'Total:', 0, 0, 'C');
    $pdf->Cell(28, 8, 'Q ' . $filas['total'] . '  ', 1, 1, 'R');
  }
}
$pdf->Output();
