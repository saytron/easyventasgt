<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('../Model/class.conexion.php');
require_once('../Model/class.consultas.php');
$Datos = json_decode(file_get_contents("php://input"));
// Si no hay datos, salir inmediatamente indicando un error 500
if (!$Datos) {
    // https://parzibyte.me/blog/2021/01/17/php-enviar-codigo-error-500/
    http_response_code(500);
    exit;
}
$idVenta	= $Datos->idVenta;
$razon = $Datos->razon;
$consultas = new consultas();
$dato= $consultas->recuperarVentasFel($idVenta);
$uuid = $dato[0]['uuid'];

$data = '{
  "reason": "'.$razon.'"
}';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://app.felplex.com/api/entity/1316/invoices/'.$uuid);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_ENCODING , '');
curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
curl_setopt($curl, CURLOPT_TIMEOUT, 0);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

curl_setopt($curl, CURLOPT_HTTPHEADER, array(
  'Accept: application/json',
  'X-Authorization: B2y3rAvu9TBDDyYgABs67OxIJ4GfaIomUA5AIwDalaUdFY30tVRi4hqLoU1NIsjQ',
  'Content-Type: application/json'
));

$response = curl_exec($curl);
$json = json_decode($response, true);
$respuesta = $json['success'];
curl_close($curl);
//echo $response;
if($respuesta == true){
  $consultas->actualizarVentaFelAnulada($idVenta);
}

echo json_encode($data);



