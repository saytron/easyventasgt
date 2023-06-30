<?php
error_reporting(E_ALL ^ E_NOTICE);
$cliente = $_GET['cliente'];
$producto = $_GET['producto'];
$monto = $_GET['monto'];
$abono = $_GET['abono'];
$meses = $_GET['meses'];
$saldo = $monto - $abono;
if($abono != null){
$fijo = ($saldo / $meses);}
$interes = $saldo * 0.04;
$total = $fijo + $interes;
$tot1;
$tot2;
$tot3;
$contador = 1;

if (!isset($_SESSION)) {
  session_start();
  }
  $pass = $_SESSION['codigo'];
  $usuario = $_SESSION['usuario'];
  $rol = $_SESSION['rol'];
  
	
include 'plantillaOrdenTrabajo.php';
	require_once('../Model/class.conexion.php');
  	require_once('../Model/class.consultas.php');
    include 'cifrasEnLetras.php';
  	ini_set('date.timezone', 'America/Guatemala');
	$anio = date('y');
	$mes = date('m');
	$dia = date('j');
	$fecha = "'".$anio."-".$mes."-".$dia."'";
  $fecha2 = $dia."-".$mes."-"."20".$anio;
	
  

  	$pdf = new PDF();

  	$pdf->AddPage();
    $fontSize = 12;

     //header

    //imagenes
    $pdf->image('../img/banner1.png', 10, 18, 50);
    $pdf->image('../img/datosFactura.png', 150, 7, 50,35);
    $pdf->image('../img/datosCliente.png', 9, 44, 192,25);	

			$pdf->SetFont('Arial','B',13);
			
      $pdf->Ln(-3);
      $pdf->SetTextColor(0,0,0);
			$pdf->Cell(105,5, 'AGROMAR',0,1,'R');
      $pdf->Ln(2);
      $pdf->SetFont('Arial','','9');
      $pdf->SetTextColor(1,43,84);
      $pdf->Cell(126,5, 'FEDERICO ADALBERTO FLORES ORELLANA',0,1,'R');
			$pdf->Cell(125,5, 'CALLE PRINCIPAL FRONTERAS RIO DULCE',0,1,'R');
			$pdf->Cell(110,5, 'LIVINGSTON IZABAL',0,1,'R');
			$pdf->Cell(103,5, 'NIT: 734368-K',0,1,'R');
			$pdf->Cell(118,5, 'TELEFONOS: 7930-5140, 7930-5451',0,1,'R');
  
   
    $pdf->SetTextColor(255,255,255);
    
  	$pdf->SetFont('Arial','B',12);

    $pdf->Ln(-29);
    $pdf->Cell(184,4,'CREDITO HONDA',0,1,'R');
    
    $pdf->SetFont('Arial','B',10);
    $pdf->Ln(4);
    //correlativo
    $pdf->Cell(142,4,'',0,0,'L');
    $pdf->SetTextColor(252,26,4);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(20,4,'',0,0,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',18);
    $pdf->Cell(25,4,'',0,1,'R');
    //fecha
    $pdf->Cell(142,6,'',0,0,'L');
    $pdf->SetFont('Arial','',9);
    $pdf->SetTextColor(252,26,4);
    $pdf->Cell(20,6,'Fecha: ',0,0,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(25,6,$fecha2,0,1,'R');
    //usuario
    $pdf->Cell(142,6,'',0,0,'L');
    $pdf->SetTextColor(252,26,4);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(27,6,'Vendedor: ',0,0,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(18,6,$usuario,0,1,'R');
    //datos del cliente
    $pdf->Ln(12);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(195,6,'CLIENTE',0,1,'C');
    $pdf->Ln(2);
    $pdf->SetFont('Courier','B',11);

    
    
    $pdf->SetTextColor(252,26,4);
    $pdf->Cell(50,6,' NOMBRE: ',0,0,'L');
    $cellWidth2 = 120;
    while($pdf->GetStringWidth($cliente) > $cellWidth2){
      $pdf->SetFontSize($fontSize -= 0.1);
    }
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($cellWidth2,6,$cliente,0,1,'L');
    $pdf->SetFont('Courier','B',11);
    $pdf->SetTextColor(252,26,4);
    $pdf->Cell(50,6,' MONTO A FINANCIAR: ',0,0,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Courier','B',11);
    $pdf->Cell(50,6,'Q '.number_format($monto,2),0,0,'L');
    $pdf->Ln(-7);
    $pdf->SetFont('Courier','B',11);
    $pdf->SetTextColor(252,26,4);
    $pdf->Cell(155,6,'ABONO: ',0,0,'R');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(30,6,' Q '.number_format($abono,2),0,1,'L');
    $pdf->Ln(0);
    $pdf->SetFont('Courier','B',11);
    $pdf->SetTextColor(252,26,4);
    $pdf->Cell(155,6,'No. de cuotas: ',0,0,'R');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(21,6,' '.$meses,0,1,'L');

    //datos de la cabecera de la tabla
    $pdf->SetLineWidth(0.5); //es el tamanio del borde
    $pdf->SetFont('Arial','B',9);
    $pdf->SetFillColor(22,162,94);
    $pdf->SetTextColor(255,255,255);
    $pdf->Ln(11);
    $pdf->SetDrawColor( 240, 238, 238 );
  	$pdf->Cell(30,6,'fecha de pago',1,0,'C',1);
  	$pdf->Cell(30,6,'saldo',1,0,'C',1);
  	$pdf->Cell(30,6,'cuota fija',1,0,'C',1);
  	$pdf->Cell(30,6,'intereses',1,0,'C',1);
      $pdf->Cell(28,6,'Total a pagar',1,0,'C',1);
      $pdf->Cell(40,6,'Control de pagos',1,1,'C',1);
                   

  		$pdf->SetFont('Arial','',10);
          $fecha = date('y-m-j');
          $nuevafecha = strtotime ( '+'.$contador.' month' , strtotime ( $fecha ) ) ;
          $nuevafecha = date ( 'j-m-20y' , $nuevafecha );
         // $nuevafecha = '29-02-2022';
          if($nuevafecha >= '29-02-2022'){
            $nuevafecha = '28-02-2022';
          }
           
           //datos de la tabla
          $pdf->SetFont('Arial','',10);
          $pdf->SetTextColor(0,0,0);
          $pdf->SetDrawColor( 240, 238, 238 );
          $pdf->Cell(30,6, $nuevafecha,1,0,'C');    
          $pdf->Cell(30,6,'Q '.round($saldo, 2),1,0,'C');
          $pdf->Cell(30,6,'Q '.round($fijo, 2),1,0,'C');
          $pdf->Cell(30,6,'Q '.round($interes, 2),1,0,'C');
          $pdf->Cell(28,6,'Q '.round($total, 2),1,0,'C');
          $pdf->Cell(40,6,'',1,1,'C');
                   
                
                  $tot1 = $tot1+$fijo;
                  $tot2 = $tot2 + $interes;
                  $tot3 = $tot3 + $total;
                  
                for ($i=1; $i < $meses ; $i++) { 
                  $saldo = $saldo - $fijo;
                  $interes = $saldo * 0.04;
                  $total = $fijo + $interes;
                  $tot1 = $tot1+$fijo;
                  $tot2 = $tot2 + $interes;
                  $tot3 = $tot3 + $total;

                  $contador = $contador + 1;

$nuevafecha = strtotime ( '+'.$contador.' month' , strtotime ( $fecha ) ) ;

$nuevafecha = date ( 'j-m-20y' , $nuevafecha );
//$nuevafecha = '29-02-2022';
          if($nuevafecha >= '29-02-2022'){
            $nuevafecha = '28-02-2022';
          }
 
$pdf->Cell(30,6, $nuevafecha,1,0,'C');    
          $pdf->Cell(30,6,'Q '.round($saldo, 2),1,0,'C');
          $pdf->Cell(30,6,'Q '.round($fijo, 2),1,0,'C');
          $pdf->Cell(30,6,'Q '.round($interes, 2),1,0,'C');
          $pdf->Cell(28,6,'Q '.round($total, 2),1,0,'C');
          $pdf->Cell(40,6,'',1,1,'C');
                   
                }
            
  $pdf->Ln(2);
          $pdf->Cell(30,6, '',1,0,'C',1);
          $pdf->Cell(30,6,'TOTALES: ',1,0,'C',1);
          $pdf->Cell(30,6,'Q '.round($tot1, 2),1,0,'C',1);
          $pdf->Cell(30,6,'Q '.round($tot2, 2),1,0,'C',1);
          $pdf->Cell(28,6,'Q '.round($tot3, 2),1,0,'C',1);
          $pdf->Cell(40,6,'',1,1,'C',1);
  	$pdf->Output();
?>