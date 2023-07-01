<?php
	error_reporting(E_ALL ^ E_NOTICE);
	
	include 'plantillaFactura.php';
	require_once('../Model/class.conexion.php');
  	require_once('../Model/class.consultas.php');
	  $cod = "'".$_GET['codigo']."'";
  	ini_set('date.timezone', 'America/Guatemala');
	$anio = date('y');
	$mes = date('m');
	$dia = date('j');
	$fecha = $anio."-".$mes."-".$dia;
	$newDate = date("d/m/Y", strtotime($fecha));
	$consultas = new Consultas();

	$datos = $consultas->cargarVentaDiaria($cod,$inicio,$registros,$fecha);
  $totalVendido = $consultas->totalVendido($cod,$fecha);

  	$pdf = new PDF();

  	$pdf->AddPage();

  	$pdf->SetTextColor(4,57,111);
    
  	$pdf->SetFont('Arial','B',12);

     $pdf->Ln(6);
     $pdf->Cell(160,6,'REPORTE DE VENTAS EN FECHA',0,0,'R');
    $pdf->Cell(30,6,$newDate,0,0,'R');
    
    
    $pdf->Ln(10);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(8,128,248);
	$pdf->SetTextColor(0,0,0);
  	$pdf->Cell(10,6,'Cant.','LB',0,'C',1);
  	$pdf->Cell(30,6,'Codigo','B',0,'C',1);
  	$pdf->Cell(105,6,'Descripcion','B',0,'C',1);
  	$pdf->Cell(22,6,'P. Unitario','B',0,'C',1);
  	$pdf->Cell(23,6,'Total','B',1,'C',1);

  		$pdf->SetFont('Arial','',8);
  	 if($datos != ""){
  	 	foreach ($datos as $fila) {
  	 	$pdf->Cell(10,6,$fila['cantidad'],'B',0,'C');
			$pdf->Cell(30,6,$fila['codigo'],'B',0,'C');
			//$pdf->SetLineWidth(3);
			$pdf->Cell(105,6,utf8_decode(' '.$fila['descripcion']),'B',0,'L');
			$pdf->Cell(22,6,'Q '.$fila['precio_venta'] / $fila['cantidad'].'  ','B',0,'R');
			$pdf->Cell(23,6,'Q '.$fila['precio_venta'].'  ','B',1,'R');
  	 	}
	}
  $pdf->Ln(6);
  $pdf->Cell(20,6,'',0,0,'C');
      $pdf->Cell(93,6,'',0,0,'C');
	  $pdf->SetFont('Arial','',14);
      if($totalVendido != ""){
      foreach ($totalVendido as $filas) {
		$pdf->Cell(47,8,'Total:',0,0,'C');
		$pdf->Cell(30,8,'Q '.$filas['total'].'  ',1,1,'R');
        }
      }
  	$pdf->Output();
?>