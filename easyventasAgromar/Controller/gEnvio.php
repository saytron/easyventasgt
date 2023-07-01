<?php
	error_reporting(E_ALL ^ E_NOTICE);
	require('plantillaEnvio.php');
	require_once('../Model/class.conexion.php');
  	require_once('../Model/class.consultas.php');
   // include 'cifrasEnLetras.php';
   if (isset($_GET['identificador'])){$identificador = $_GET['identificador'];}
   if (isset($_GET['facturado'])){$facturado = $_GET['facturado'];}
   if (isset($_GET['cod'])){$cod = $_GET['cod']; $codigo = $_GET['cod'];}
   if (isset($_GET['idfactura'])){$id = $_GET['idfactura'];}
   if (isset($_GET['idcliente'])){ $idCliente = $_GET['idcliente'];}
   
  	ini_set('date.timezone', 'America/Guatemala');
	$anio = date('y');
	$mes = date('m');
	$dia = date('j');
	$fecha = "'".$anio."-".$mes."-".$dia."'";
  $fecha2 = $dia."-".$mes."-"."20".$anio;
	$consultas = new Consultas();
  
  if(isset($_GET['estado']) && $_GET['estado'] == 0){

    if($facturado == 0){
      if (strlen($id) > 0) {
        $consultas->actualizarVentasEnvios($id,$idCliente);
      }
    }
  }
  
//variables para los datos del negocio
include '../Model/datosNegocio.php'; //AQUI ESTAN GUARDADOS LOS DATOS DEL NEGOCIO
$razon_social = razon_social;
$direccion1 = direccion1;
$direccion2 = direccion2;
$propietario = propietario;
$nitPropietario = nit;
$telefonoPropietario = telefono;

  $usuario = "";
  $id_cliente = "";
  $nombre = "";
  $apellidos = "";
  $nit = "";
  $direccion = "";
  $fecha1 = $fecha;
  $telefono = "";
  $cliente = "";
  $saldo = "";
  $datosUsuario = $consultas->cargarUsuario($cod);
  if($datosUsuario != ""){
    foreach ($datosUsuario as $filas) {
        $usuario = $filas['n_usuario'];
        
      }
    }
 
  $datoscl = $consultas->cargarClientesFactura($idCliente);

  if($datoscl != ""){
      foreach ($datoscl as $filas) {
          $nombre = $filas['nombre'];
          $apellidos = $filas['apellidos'];
          $nit = $filas['nit'];
          $direccion = $filas['direccion'];
          $telefono = $filas['telefono'];
          $cliente= $nombre.' '.$apellidos;
        }
      }
   
        $datos = $consultas->cargarVentasEnvios($cod,$id);
        $datosAbono = $consultas->cargarVentasAbonos($cod,$id);
        if($datos != ""){
          foreach ($datos as $filas) {
              $fecha1 = $filas['fecha'];
             
            }
          }
          
          //cambiamos el formato de la fecha recuperada de la consulta
          function cambiaf_a_espanol($fecha){
            preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
            $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
            return $lafecha;
        }
        $fechaFormato = cambiaf_a_espanol($fecha1);//guardamos el formato nuevo

        $totalVendido = $consultas->cargarTotalPrecioEnvios($cod,$id,"20".$anio,$mes);
        $totalVendidoGlobal = 0;
     
	
		$pdf = new GENERAR_PDF_ENVIO('portrait','mm','letter',true);

    $fontSize=12;
  	$pdf->AddPage();
    //header

    //imagenes
    $pdf->image('../img/banner1.png', 10, 18, 50);
    $pdf->image('../img/datosFactura.png', 150, 7, 50,35);
    $pdf->image('../img/datosCliente.png', 9, 44, 192,25);	

			$pdf->SetFont('Arial','B',13);
			
      $pdf->Ln(-3);
      $pdf->SetTextColor(0,0,0);
      //DATOS DEL PROPIETARIO
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
    
  	$pdf->SetFont('Arial','B',13);

    $pdf->Ln(-29);
    $pdf->Cell(173,4,'ENVIO',0,1,'R');
    
    $pdf->SetFont('Arial','B',10);
    $pdf->Ln(4);
    //correlativo
    $pdf->Cell(142,4,'',0,0,'L');
    $pdf->SetTextColor(252,26,4);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(20,4,'No. Documento: ',0,0,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(25,4,$id,0,1,'R');
    //fecha
    $pdf->Cell(142,6,'',0,0,'L');
    $pdf->SetFont('Arial','',9);
    $pdf->SetTextColor(252,26,4);
    $pdf->Cell(20,6,'Fecha: ',0,0,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(25,6,$fechaFormato,0,1,'R');
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

    $cellWidth2 = 100;
    while($pdf->GetStringWidth($cliente) > $cellWidth2){
      $pdf->SetFontSize($fontSize -= 0.1);
    }
    
    $pdf->SetTextColor(252,26,4);
    $pdf->Cell(28,6,' Nombre: ',0,0,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($cellWidth2,6,$cliente,0,1,'L');
    $cellWidth1 = 100;
    while($pdf->GetStringWidth($direccion) > $cellWidth1){
      $pdf->SetFontSize($fontSize -= 0.1);
    }
    $pdf->SetTextColor(252,26,4);
    $pdf->Cell(28,6,' Direccion: ',0,0,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($cellWidth1,6,$direccion,0,0,'L');
    $pdf->Ln(-7);
    $pdf->SetTextColor(252,26,4);
    $pdf->Cell(165,6,'Nit: ',0,0,'R');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(21,6,$nit,0,1,'R');
    $pdf->SetTextColor(252,26,4);
    $pdf->Cell(165,6,'Telefono: ',0,0,'R');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(21,6,$telefono,0,1,'R');
  
   //datos cabecera de la tabla
   $pdf->SetLineWidth(0.5);
   $pdf->SetFont('Arial','B',9);
  
   
   //$pdf->SetFillColor(22,162,94);
   $pdf->SetFillColor(0, 47, 122);
   $pdf->SetTextColor(255,255,255);
   $pdf->Ln(5);
   $pdf->Cell(14.5,8,'Cant.',0,0,'L',1);
   $pdf->Cell(120,8,'Descripcion',0,0,'L',1);
   $pdf->Cell(30,8,'Precio Unitarario',0,0,'R',1);
   $pdf->Cell(25,8,'Precio Total',0,1,'R',1);

   //datos de la tabla
     $pdf->SetFont('Arial','',10);
     $pdf->SetTextColor(2,0,0);
     $pdf->SetDrawColor( 240, 238, 238 );
//multicell   
    //declaramos el tama;o de cada columna
$pdf->SetWidths(array(14,120,30,25));
//declaramos la posicion del contenido de cada columna
$pdf->SetPosition(array('C','L','R','R'));
$pdf->Ln(2);
   if($datos != ""){
     foreach ($datos as $fila) {
           $precioUnitario=$fila['precio_venta'] / $fila['cantidad'];
      	 	$pdf->Row(array($fila['cantidad'],$fila['codigo']. ' '.$fila['detalleProducto'],' Q '.number_format($precioUnitario,2),' Q '.number_format($fila['precio_venta'],2)));  
           
        }
	}
  $pdf->Ln(2);
  $pdf->SetFillColor(0, 47, 122);
  $pdf->Cell(189,1,'',0,0,'L',1);
  $totalVenta = 0;
  $totalVendidoGlobal = 0;
  $saldo = 0;
          
    if($totalVendido != ""){
    foreach ($totalVendido as $filas) {
      $totalVenta = $filas['total'];
     
    }
  }
      $pdf->Ln(2);
      $pdf->SetFont('Arial','',10);
 $estado = 0;
	 if($datos != ""){
  	 	foreach ($datosAbono as $fila) {
          $estado = 0;
        if($fila['estado'] == 0){
          $fechaFormato2 = cambiaf_a_espanol($fila['fecha']);//guardamos el formato nuevo
          $pdf->SetFont('Arial','',10);
          $pdf->Cell(160,6,'ABONO EN FECHA '.$fechaFormato2,0,0,'R');
			    $pdf->Cell(30,6,'Q '.$fila['precio_venta'].'  ',0,1,'R');
          $totalVendidoGlobal =  $fila['precio_venta'];
       }
  	 	}
	}
  $pdf->Ln(2);
  
  if($estado == 0){
    if($totalVendido != ""){
      foreach ($totalVendido as $filas) {
    
      $saldo = $filas['total'] - $totalVendidoGlobal;
 
        }
      }
  }
  //$letras = valorEnLetras($saldo);
  $pdf->SetFont('Arial','B',11);
 // $pdf->Cell(110,8,'Son'.$letras.'',0,1,'L');
  $pdf->SetFont('Arial','B',12);

  $pdf->Cell(158,8,'Total:',0,0,'R');
  $pdf->Cell(32,8,'Q '.number_format($saldo,2).'  ',0,1,'R');

  $pdf->Ln(7);
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(180,8,'_________________________',0,1,'C');
  $pdf->Cell(180,6,'Firma',0,1,'C');
  	$pdf->Output();
