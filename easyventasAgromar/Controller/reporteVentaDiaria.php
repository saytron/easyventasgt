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
    $cod = $_GET['usuarioR'];
  	ini_set('date.timezone', 'America/Guatemala');
	  $fecha2 = $_GET['fechaReporte'];
	  $newDate = date("d/m/Y", strtotime($fecha2));
	
	$consultas = new Consultas();

	//variables para los datos del negocio
	include '../Model/datosNegocio.php';
	$razon_social = razon_social;
	$direccion1 = direccion1;
	$direccion2 = direccion2;
	$propietario = propietario;
	$nitPropietario = nit;
	$telefonoPropietario = telefono;
		$inicio = 0;
		$registros = 0;
	$datos = $consultas->cargarVentaDiaria($pass,$fecha2);
  $totalVendido = $consultas->totalVendido($pass,$fecha2);

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
  	$pdf->Cell(14,8,'Cant.',0,0,'L',1);
  	$pdf->Cell(121,8,'Descripcion',0,0,'L',1);
  	$pdf->Cell(29,8,'Precio Unitarario',0,0,'R',1);
  	$pdf->Cell(25,8,'Precio Total',0,1,'R',1);

  	//datos de la tabla
	  $pdf->SetFont('Arial','',10);
	  $pdf->SetTextColor(2,0,0);
	  $pdf->SetDrawColor( 240, 238, 238 );
	 if($datos != ""){
	   foreach ($datos as $fila) {
	   $pdf->Cell(14,6,$fila['cantidad'],'B',0,'C');
	  
	  $cellWidth = 120;
	  while($pdf->GetStringWidth($fila['detalleProducto'].' '.$fila['codigo']) > $cellWidth){
		$pdf->SetFontSize($fontSize -= 0.1);
	  }
	  $pdf->Cell($cellWidth,6,utf8_decode($fila['codigo'].' '.$fila['detalleProducto']),'B',0,'L');
	  $pdf->SetFont('Arial','',10);
	  
	  $precioUnitario=$fila['precio_venta'] / $fila['cantidad'];
	  $pdf->Cell(29,6,number_format($precioUnitario, 2).'  ','B',0,'R');
	  $pdf->Cell(25,6,''.number_format($fila['precio_venta'],2).'  ','B',1,'R');
	   }
  }
  $pdf->Ln(6);
  $pdf->Cell(20,6,'',0,0,'C');
      $pdf->Cell(93,6,'',0,0,'C');
	  $pdf->SetFont('Arial','',14);
      if($totalVendido != ""){
      foreach ($totalVendido as $filas) {
		$pdf->Cell(47,8,'Total:',0,0,'C');
		if($filas['total'] == ''){

		}else{
			$pdf->Cell(30,8,'Q '.number_format($filas['total'],2).'  ',1,1,'R');

		}
        }
      }
  	$pdf->Output();
?>


