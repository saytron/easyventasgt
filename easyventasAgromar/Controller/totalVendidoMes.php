<?php
error_reporting(E_ALL ^ E_NOTICE);
	if (!isset($_SESSION)) {

		session_start();
		
		}
		$pass = $_SESSION['codigo'];
		$usuario = $_SESSION['usuario'];
		$rol = $_SESSION['rol'];
		
		
	
		include 'plantillaOrdenTrabajo.php';
	require_once('../Model/class.conexion.php');
  	require_once('../Model/class.consultas.php');

  	ini_set('date.timezone', 'America/Guatemala');
	  
	  $newDate = date("d/m/Y");

	$consultas = new Consultas();

	//variables para los datos del negocio
	include '../Model/datosNegocio.php';
	$razon_social = razon_social;
	$direccion1 = direccion1;
	$direccion2 = direccion2;
	$propietario = propietario;
	$nitPropietario = nit;
	$telefonoPropietario = telefono;

	$datos = $consultas->cargarVentasMes($pass);
  $totalVendido = $consultas->cargarTotalVendidoMes($pass);

  	$pdf = new PDF();

  	$pdf->AddPage();
    $fontSize = 12;

     //header

    //imagenes
    $pdf->image('../img/banner1.png', 10, 18, 50);
    $pdf->image('../img/datosFactura.png', 150, 7, 50,35);
    //$pdf->image('../img/datosCliente.png', 9, 44, 192,25);	

			$pdf->SetFont('Arial','B',13);
			
      $pdf->Ln(-3);
      $pdf->SetTextColor(0,0,0);
			$pdf->Cell(186,5, $razon_social,0,1,'C');
      $pdf->Ln(2);
      $pdf->SetFont('Arial','','9');
      $pdf->SetTextColor(1,43,84);
      $pdf->Cell(186,5, $propietario,0,1,'C');
			$pdf->Cell(186,5, $direccion1,0,1,'C');
			$pdf->Cell(186,5, $direccion2,0,1,'C');
			$pdf->Cell(186,5, $nitPropietario,0,1,'C');
			$pdf->Cell(186,5, $telefonoPropietario,0,1,'C');
  
   
    $pdf->SetTextColor(255,255,255);
    
  	$pdf->SetFont('Arial','B',11);

    $pdf->Ln(-29);
    $pdf->Cell(187,4,'REPORTE DE VENTAS',0,1,'R');
    
    $pdf->SetFont('Arial','B',10);
    $pdf->Ln(4);
   
    //fecha
    $pdf->Cell(142,6,'',0,0,'L');
    $pdf->SetFont('Arial','',9);
    $pdf->SetTextColor(252,26,4);
    $pdf->Cell(20,6,'Fecha: ',0,0,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(25,6,$newDate,0,1,'R');
    //usuario
    $pdf->Cell(142,6,'',0,0,'L');
    $pdf->SetTextColor(252,26,4);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(27,6,'Vendedor: ',0,0,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(18,6,$usuario,0,1,'R');
    
   
   
    //datos de la cabecera de la tabla
    $pdf->SetLineWidth(0.5); //es el tamanio del borde
    $pdf->SetFont('Arial','B',9);
    $pdf->SetFillColor(22,162,94);
    $pdf->SetTextColor(255,255,255);
    $pdf->Ln(15);
  	$pdf->Cell(14,8,'',0,0,'L',1);
  	$pdf->Cell(121,8,'Fecha',0,0,'L',1);
  	$pdf->Cell(29,8,'',0,0,'R',1);
  	$pdf->Cell(25,8,'Total',0,1,'R',1);

  	//datos de la tabla
	  $pdf->SetFont('Arial','',10);
	  $pdf->SetTextColor(2,0,0);
	  $pdf->SetDrawColor( 240, 238, 238 );
	 if($datos != ""){
	   foreach ($datos as $fila) {
	   $pdf->Cell(14,6,'','B',0,'C');
	  
	  $cellWidth = 120;
	  while($pdf->GetStringWidth($fila['fecha']) > $cellWidth){
		$pdf->SetFontSize($fontSize -= 0.1);
	  }
	  $pdf->Cell($cellWidth,6,utf8_decode($fila['fecha']),'B',0,'L');
	  $pdf->SetFont('Arial','',10);
	  
	  
	  $pdf->Cell(29,6,'','B',0,'R');
	  $pdf->Cell(25,6,''.number_format($fila['total'],2).'  ','B',1,'R');
	   }
  }else{
    $pdf->Cell(25,6,'hola mundo  ','B',1,'R');
  }
  $pdf->Ln(6);
  $pdf->Cell(20,6,'',0,0,'C');
      $pdf->Cell(93,6,'',0,0,'C');
	  $pdf->SetFont('Arial','',14);
      if($totalVendido != ""){
      foreach ($totalVendido as $filas) {
		$pdf->Cell(47,8,'Total:',0,0,'C');
		if($filas['totalMes'] == ''){

		}else{
			$pdf->Cell(30,8,'Q '.number_format($filas['totalMes'],2).'  ',1,1,'R');

		}
        }
      }
  	$pdf->Output();
?>
