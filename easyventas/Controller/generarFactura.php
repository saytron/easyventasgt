<?php
error_reporting(E_ALL ^ E_NOTICE);
require('pdf_mc_table.php');
$formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');
//include 'cifrasEnLetras.php';
$arg_nitCliente = "";
if (isset($_GET['identificador'])) {
  $identificador = $_GET['identificador'];
}
if (isset($_GET['facturado'])) {
  $facturado = $_GET['facturado'];
}
if (isset($_GET['cod'])) {
  $cod =  $_GET['cod'] ;
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


$uuid = '';
$certifier = '';
$taxCode = '';
$invoiceUrl = '';
$satSerie = '';
$satNo = '';
$satAuthorization = '';
$certificationDate = '';
if (isset($_GET['uuid'])) {
  $uuid = $_GET['uuid'];
  $certifier = $_GET['certifier'];
  $taxCode = $_GET['taxCode'];
  //$invoiceUrl = $_GET['invoiceUrl'];
  $satSerie = $_GET['satSerie'];
  $satNo = $_GET['satNo'];
  $satAuthorization = $_GET['satAuthorization'];
  $certificationDate = $_GET['certificationDate'];
}

ini_set('date.timezone', 'America/Guatemala');
$anio = date('y');
$mes = date('m');
$dia = date('j');
$fecha = "'" . $anio . "-" . $mes . "-" . $dia . "'";
$fecha2 = $dia . "-" . $mes . "-" . "20" . $anio;
$consultas = new Consultas();

if ($arg_nitCliente == 'CF') {
  $datosCliente = $consultas->buscarClienteNombre($nombreCliente);
  foreach ($datosCliente as $filas) {
    $idCliente = (int) $filas['id_cliente'];
  }
}else{
  $idCliente = $_GET['idcliente'];
}
$CorrelativoInterno = $id;
$datosC = '';
if (isset($_GET['estado']) && $_GET['estado'] == 0) {
  if ($facturado == 0) {

    if (strlen($id) > 0) {
      $consultas->actualizarVentasFel($id, $idCliente, $uuid, $certifier, $taxCode, $invoiceUrl, $satSerie, $satNo, $satAuthorization, $certificationDate);
      $consultas->guardarIdFactura($id);
    }
  }
}
//verificamos que el correlativo sea menor a 1279 para no generar un error interno al consultar el id de la factura
if ($id > 1279 && isset($_GET['estado']) == 1) {
  $datosC = $consultas->cargarCorrelativoInterno($id);
  if (!empty($datosC)) {
    foreach ($datosC as $fila) {
      $CorrelativoInterno = $fila['idfacturaFel'];
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
$emailPropietario = email;


if (isset($_GET['cod'])) {
  $usuario;
  $id_cliente;
  $nombre;
  $apellidos;
  $nit;
  $direccion;
  $fecha1;
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
$email = "";
$datoscl = $consultas->cargarClientesFactura($idCliente);

if ($datoscl != "") {
  foreach ($datoscl as $filas) {
    $nombre = $filas['nombre'];
    $apellidos = $filas['apellidos'];
    $nit = $filas['nit'];
    $direccion = $filas['direccion'];
    $email = $filas['email'];
    $cliente = $nombre . ' ' . $apellidos;
    
  }
}
$fecha1 = '';
$datos = $consultas->cargarVentasFacturar($cod, $id, $fecha);
if ($datos != "") {
  foreach ($datos as $fila) {
    $fecha1 = $fila['fecha'];
  }
} else {
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

//header
$noDte = "";
$serieDte = "";
$sat_authorization = "";
$satCertifier = "";
$certification_date = "";
$estadoDte = '';
$tax_code = '';
$datosFel = "";
$datosFel = $consultas->recuperarVentasFel($id);
if (empty($datosFel)) {
} else {
  foreach ($datosFel as $filas) {
    if ($filas['sat_no'] != NULL) {
      $noDte = $filas['sat_no'];
      $serieDte = $filas['sat_serie'];
      $sat_authorization = $filas['sat_authorization'];
      $satCertifier = $filas['certifier'];
      $certification_date = $filas['certification_date'];
      $estadoDte = $filas['estado_dte'];
      $tax_code = $filas['tax_code'];
    }
  }
}

$derecha = 0;
$textoIzqierda = 0;
$total = 0;
$n = 0;
if ($totalVendido != "") {
  foreach ($totalVendido as $filas) {
    $n = (float)$filas['total'];
    $izquierda = intval(floor($n));
    $derecha = intval(($n - floor($n)) * 100);
    $textoIzqierda = $formatterES->format($izquierda);
    $total = $filas['total'];
  }
}


$pdf = new PDF_MC_Table('portrait','mm','letter',true);

$pdf->datosNegocio($razon_social, $direccion1, $direccion2, $propietario, $nitPropietario, $telefonoPropietario);
$pdf->recuperarDatosCertifier($textoIzqierda, $derecha, $total, $sat_authorization, $satCertifier, $tax_code, $certification_date);
$pdf->recuperarDatosFactura($fechaFormato, $noDte, $serieDte, $CorrelativoInterno, $usuario);
$pdf->recuperarDatosCliente($cliente, $nombre, $apellidos, $direccion, $nit);
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




if ($estadoDte == 1) {
  $pdf->image('../img/anulado.png', 12, 110, 180, 80);
}
$pdf->Close();

$pdf->Output('', $noDte . $nombre . '.pdf');


if ($facturado != 1 && $cliente != "" && $email != "") {
//guardamos el archivo en el servidor
  $pdf->Output('F', $noDte . $nombre . '.pdf');

  //enviamos el email conel pdf adjunto

  $to = $email;

  //sender
  $from = $emailPropietario;
  $fromName = $razon_social;
  //formateamos las variables para reescribirlas en minusculas con letra inicial mayuscula
  $clienteMinusculas = strtolower($nombreCliente);
  $clienteFormato = ucwords($clienteMinusculas);
  $razon_socialMinusculas = strtolower($razon_social);
  $razon_socialFormato = ucwords($razon_socialMinusculas);
  //email subject
  $subject = 'factura de referencia '.$noDte;

  //attachment file path
  $file = './' . $noDte . $nombre . '.pdf';

  //email body content
  $htmlContent = '<h1></h1>
    
    ';

  //header for sender info
  $headers = "From: $fromName" . " <" . $from . ">";



  //boundary 
  $semi_rand = md5(time());
  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

  //headers for attachment 
  $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

  //multipart boundary 
  $message  = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n";
  $message .= "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
      <meta charset='UTF-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>Mensaje</title>
    
      <style>
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }
    
        .container {
          max-width: 1000px;
          width: 90%;
          margin: 0 auto;
        }
        .bg-dark {
          background: #fff;
          margin-top: 40px;
          padding: 20px 0;
        }
        .alert {
          font-size: 1.5em;
          position: relative;
          padding: .75rem 1.25rem;
          margin-bottom: 2rem;
          border: 1px solid transparent;
          border-radius: .25rem;
          
        }
        .alert-primary {
          color: #004085;
          background-color: #cce5ff;
          border-color: #b8daff;
          
        }
    
        .img-fluid {
          max-width: 90%;

          height: auto;
        }
    
        .mensaje {
          width: 80%;
          font-size: 20px;
          margin: 0 auto 40px;
          color:  #0e2384;
        }
    
        .texto {
          margin-top: 20px;
        }
    
        .footer {
          width: 100%;
          background:  #122476;
          text-align: center;
          color: #ddd;
          padding: 10px;
          font-size: 14px;
        }

        .footer span {
          text-decoration: underline;
        }
      </style>
    </head>
    <body>
      <div class='container'>
        <div class='bg-dark'>
          <div class='alert alert-primary'>
          <strong><h2>Hola $clienteFormato $razon_socialFormato ha emitido una factura a tu nombre.</h2></strong> 
          <p></p>
          <stron>GRACIAS POR PREFERINRNOS!</stron>
          </div>
    
          <div class='mensaje'>
            <img class='img-fluid' src='https://easyventasgt.com/webTecnofer/easyventas/img/4.png' alt='Mensaje'>
    
            <div class='texto'>Su factura esta lista para descargar, vuelva pronto.
              <p>No. de documento: $noDte</p>
              <p>Serie: $serieDte</p>
              <p>Fecha de emision: $fechaFormato</p>
              <p>Monto: Q $total</p>
            </div>
          </div>
    
          <div class='footer'>
            PUEDES LLAMARNOS A LOS <span>$telefonoPropietario</span>
          </div>
        </div>
      </div>
    
  " . "\n";
  //preparing attachment
  if (!empty($file) > 0) {
    if (is_file($file)) {
      $message .= "--{$mime_boundary}\n";
      $fp =    @fopen($file, "rb");
      $data =  @fread($fp, filesize($file));

      @fclose($fp);
      $data = chunk_split(base64_encode($data));
      $message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\n" .
        "Content-Description: " . basename($file) . "\n" .
        "Content-Disposition: attachment;\n" . " filename=\"" . basename($file) . "\";     size=" . filesize($file) . ";\n" .
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
    }
  }

  $message .= "</html></body>";
  $message .= "--{$mime_boundary}--";

  $returnpath = "-f" . $from;

  //send email
  $mail = @mail($to, $subject, $message, $headers, $returnpath);

  //email sending status
  echo $mail ? "<h1>Mail sent.</h1>" : "<h1>Mail sending failed.</h1>";

  //eliminar archivo pdf para no llenar el servidor con documentos
  if (unlink('./' . $noDte . $nombre . '.pdf')) {
    // Archivo fue borrado satisfactoriamente
  } else {
    // tuvimos un problema borrando el archivo
  }
}
