<?php
error_reporting(E_ALL ^ E_NOTICE);
require('plantillaCatalogo.php');
$formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');
//include 'cifrasEnLetras.php';


if (isset($_GET['idCatalogo'])) {
  $idCatalogo = $_GET['idCatalogo'];
}else{
  $idCatalogo = 0;
}
if (isset($_GET['totalCatalogo'])) {
  $totalCatalogo = $_GET['totalCatalogo'];
}
$tituloCatalogo = "";
if (isset($_GET['tituloCatalogo'])) {
    $tituloCatalogo = $_GET['tituloCatalogo'];
  }

ini_set('date.timezone', 'America/Guatemala');
$anio = date('y');
$mes = date('m');
$dia = date('j');
$fechaFormato = date('j-m-y');
$consultas = new Consultas();

$datos = $consultas->buscarCatalogo($idCatalogo);

$pdf = new PLANTILLA_CATALOGO('portrait','mm','letter',true);

//PASAMOS LOS DATOS A LA PLANTILLA 

$pdf->recuperarDatosCatalogo($tituloCatalogo);
$pdf->recuperarDatosFactura($fechaFormato);
//$pdf->recuperarDatosCliente($cliente,$nombre,$apellidos,$direccion,$nit);
//CREAMOS LA PAGINA  TAMANIO CARTA
$pdf->AddPage('portrait', 'letter');
$pdf->SetMargins(10, 10, 20, 10);

//datos de la tabla
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(2, 0, 0);
$pdf->SetDrawColor( 255, 255, 255 );

$pdf->SetLineWidth(1); //es el tamanio del borde
$pdf->Ln(2);
//multicell   
//declaramos el tama;o de cada columna
$pdf->SetWidths(array(14, 120, 30, 25));
//declaramos la posicion del contenido de cada columna
$pdf->SetPosition(array('C', 'L', 'R', 'R'));

if ($datos != "") {
    $total = 0;
   
  foreach ($datos as $fila) {
    $total = $total + ($fila['cantidad'] * $fila['precio']); 
    
    $precio = $fila['cantidad'] * $fila['precio'];
    $pdf->Row(array($fila['cantidad'], $fila['codigo'].' '.$fila['descripcion'] . ' MARCA ' . $fila['marca'], ' Q ' . number_format($fila['precio'], 2), ' Q ' . number_format($precio, 2)));
  }
  $pdf->recuperarDatosTotales($total);
  
}
$pdf->Ln(3);


$pdf->Output();
