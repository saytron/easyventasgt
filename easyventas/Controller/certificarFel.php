<?php
error_reporting(E_ALL ^ E_NOTICE);

require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');

header("Access-Control-Allow-Origin: *");

if (!isset($_SESSION)) {

    session_start();
}
$pass = $_SESSION['codigo'];
$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];


ini_set('date.timezone', 'America/Guatemala');
$Object = new DateTime();
$hora = $Object->format("H:i:s ");


$DateAndTime = Date('y-m-d', time());
$fechaHora = '20' . $DateAndTime . 'T' . $hora;
$Datos = json_decode(file_get_contents("php://input"));
// Si no hay datos, salir inmediatamente indicando un error 500
if (!$Datos) {
    // https://parzibyte.me/blog/2021/01/17/php-enviar-codigo-error-500/
    http_response_code(500);
    exit;
}
$nit        = $Datos->nit;
$name       = $Datos->nombre;
$direccion  = $Datos->direccion;
$idFactura  = $Datos->idfactura;
$opcFactura   = $Datos->opcFactura;
//para certificar un cliente CF
$toCf = 0;
if ($nit == 'CF') {
    $toCf = 1;
} else {
    $toCf = 0;
}

$opcion = "";
if($opcFactura == 0){
  $opcion = 'NIT';
}else if ($opcFactura == 1){
  $opcion = 'CUI';
}else if ($opcFactura == 2){
  $opcion = 'PASTPORT';
}

$consultas = new consultas();
$array = $consultas->cargarJsonFel($idFactura, $pass);
$totalPrecio = $consultas->cargarTotalVentasDetalle($idFactura, $pass);

$totalPrecioFactura = $totalPrecio[0]['total'];
$curl = curl_init();
$producto = json_encode($array);

$data = ' {
"type": "FPEQ",
"datetime_issue": "' . $fechaHora . '",
"items": ' . $producto . ',
"total": ' . $totalPrecioFactura . ',
"total_tax": "0",
"emails": [
    {
        "email": "example@exammple.com"
    }
],
"emails_cc": [
    {
        "email": ""
    }
],
"to_cf": ' . $toCf . ',
"to": {
    "tax_code_type": "' . $opcion . '",
    "tax_code": "' . $nit . '",
    "tax_name": "' . $name . '",
    "address":  {
        "street": "' . $direccion . '",
        "city": "",
        "state": "",
        "zip": "01001",
        "country": "GT"
    }
},

"exempt_phrase": null

}';


if ($totalPrecioFactura >= 2500 && $nit == 'CF') {
    echo '2';
} else {

    curl_setopt($curl, CURLOPT_URL, 'https://app.felplex.com/api/entity/1316/invoices/await');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_ENCODING, '');
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'X-Authorization: B2y3rAvu9TBDDyYgABs67OxIJ4GfaIomUA5AIwDalaUdFY30tVRi4hqLoU1NIsjQ',
        'Content-Type: application/json'
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}

return true;
