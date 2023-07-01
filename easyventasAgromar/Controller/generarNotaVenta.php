<?php
	error_reporting(E_ALL ^ E_NOTICE);
	include 'plantillaNotaVenta.php';
	require_once('../Model/class.conexion.php');
  	require_once('../Model/class.consultas.php');
      
    //include 'cifrasEnLetras.php';
    if (isset($_GET['cod'])){$cod = $_GET['cod'];}
    if (isset($_GET['idfactura'])){ $id = $_GET['idfactura'];}
    if (isset($_GET['idcliente'])){$idCliente = $_GET['idcliente'];}
    $id = 0;
   
    
  
	$consultas = new Consultas();
  if (isset($_GET['chasis'])){$chasis = $_GET['chasis'];}
    
  
  $datos = $consultas->cargarNotaVenta($chasis);

  if($datos != ""){
      foreach ($datos as $filas) {
          $fecha = $filas['fecha'];
          $fecha2 = date("d/m/Y", strtotime($fecha));

          $linea = $filas['linea'];
          $chasis = $filas['chasis'];
          $motor = $filas['motor'];
          $color = $filas['color'];
          $modelo = $filas['modelo'];
          $marca = $filas['marca'];
          $precio = $filas['precio'];

          $cliente = $filas['comprador'];
          $direccion = $filas['direccion'];
          $vendedor = $filas['vendedor'];
          $telefonoCl = $filas['telefono'];
          $nit = $filas['nit'];
          $modelo = $filas['modelo'];


        }
      }

	
  	$pdf = new PDF('portrait','mm','letter',true);

  	$pdf->AddPage();

    $pdf->SetFillColor(232,232,232);
    $pdf->SetTextColor(0,0,0);
    
  	$pdf->SetFont('Arial','B',14);

    
    $pdf->Ln(10);
    $pdf->SetFont('Arial','',14);
    $pdf->Cell(190,6,'Fronteras, Rio Dulce, '.$fecha2,0,1,'R');
    $pdf->SetFont('Arial','B',16);
    $pdf->Ln(5);
    $pdf->Cell(110,4,'NOTA DE VENTA',0,0,'R');
    $pdf->Ln(8);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6,'DATOS DEL CLIENTE ',0,1);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6, 'NOMBRE: ',0,0,'L');
    $pdf->Cell(30,6,$cliente,0,1,'L');
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6,'DIRECCION: ',0,0);
    $pdf->Cell(30,6,$direccion,0,1);
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6,'NIT: ',0,0,'L');
    $pdf->Cell(30,6,$nit,0,1,'L');
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6, 'CELULAR: ',0,0,'L');
    $pdf->Cell(30,6, $telefonoCl,0,1,'L');

    $pdf->Ln(4);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6,'DATOS DE LA MOTOCICLETA',0,1);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6,'MARCA:',0,0);
    $pdf->Cell(30,6,$marca,0,1);
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6,'MODELO: ',0,0,'L');
    $pdf->Cell(30,6,$modelo,0,1,'L');
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6,'LINEA: ',0,0,'L');
    $pdf->Cell(30,6,$linea,0,1,'L');
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6,'CHASIS: ',0,0,'L');
    $pdf->Cell(30,6,$chasis,0,1,'L');
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6,'MOTOR: ',0,0,'L');
    $pdf->Cell(30,6,$motor,0,1,'L');
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6,'COLOR: ',0,0,'L');
    $pdf->Cell(30,6,$color,0,1,'L');
    $pdf->Cell(5,6,'',0,0);
    $pdf->Cell(30,6,'PRECIO: ',0,0,'L');
    $pdf->Cell(30,6,'Q '.$precio,0,1,'L');

    $pdf->Ln(4);
    $pdf->Cell(30,6,'',0,0,'L');
    $pdf->Cell(50,6,'Se les ruega a las autoridades correspondientes prestarles las',0,1);
    $pdf->Cell(30,6,'',0,0,'L');
    $pdf->Cell(50,6,'consideraciones necesarias al portador del presente documento, ya',0,1);
    $pdf->Cell(30,6,'',0,0,'L');
    $pdf->Cell(50,6,'que se encuentra en tramite las placas y papeleria del vehiculo',0,1);
    $pdf->Cell(30,6,'',0,0,'L');
    $pdf->Cell(50,6,'detallado anteriormente.',0,1);
    

  $pdf->Ln(18);
  $pdf->Cell(10,6,'',0,0,'L');
  $pdf->Cell(40,6,'FIRMA.______________________',0,0);
  $pdf->Cell(35,6,'',0,0,'L');  
  $pdf->Cell(120,6,'FIRMA.______________________',0,1);

  $pdf->SetFont('Arial','',10);
  $pdf->Cell(20,6,'',0,0,'L');
  $pdf->Cell(40,6,$vendedor,0,0,'C');
  $pdf->Cell(35,6,'',0,0,'L');  
  $pdf->Cell(50,6,$cliente,0,1,'C');
  
  $pdf->Cell(20,6,'',0,0,'L');
  $pdf->Cell(40,6,'EJECUTIVO(A) DE VENTAS',0,0,'C');
  $pdf->Cell(35,6,'',0,0,'L');  
  $pdf->Cell(50,6,'CLIENTE',0,1,'C'); 

  $pdf->SetFont('Arial','',14);
  $pdf->Ln(10);
    $pdf->Cell(30,6,'',0,0,'L');
    $pdf->Cell(50,6,'NOTA: para tramite de placas es obligatorio adjuntar los siguientes',0,1);
    $pdf->Cell(30,6,'',0,0,'L');
    $pdf->Cell(50,6,'documentos:',0,1);

    $pdf->Ln(10);
    $pdf->Image('../img/punto.png',36,239,-3800);
    $pdf->Image('../img/punto.png',36,245,-3800);
    $pdf->Image('../img/punto.png',36,251,-3800);
    $pdf->Cell(30,6,'',0,0,'L');
    $pdf->Cell(50,6,'Fotocopia de DPI',0,1);
    $pdf->Cell(30,6,'',0,0,'L');
    $pdf->Cell(50,6,'Fotocopia de nit actualizado en la sat',0,1);
    $pdf->Cell(30,6,'',0,0,'L');
    $pdf->Cell(50,6,'Boleto de ornato original',0,1);
     
  	$pdf->Output();
?>