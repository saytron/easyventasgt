<?php
$Datos = json_decode(file_get_contents("php://input"));
// Si no hay datos, salir inmediatamente indicando un error 500
if (!$Datos) {
    // https://parzibyte.me/blog/2021/01/17/php-enviar-codigo-error-500/
    http_response_code(500);
    exit;
}

$nitSat	= $Datos->nitFel;
$nitAsk = $_GET['nit'];
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, 'https://dev.app.felplex.com/api/entity/30/find/NIT/'.$nitAsk);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_ENCODING , '');
curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
curl_setopt($curl, CURLOPT_TIMEOUT, 0);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'X-Authorization: qUsFnR0sJIUMkBRBKgxbm0QVp6vL8vRiFcQRtIy76JIfbIoOhVx0bJt652EsK412'
  ));


$response = curl_exec($curl);

curl_close($curl);
echo $response;
return true;