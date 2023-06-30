<?php

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, 'https://app.felplex.com/api/entity/1316/credits');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_ENCODING , '');
curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
curl_setopt($curl, CURLOPT_TIMEOUT, 0);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'X-Authorization: B2y3rAvu9TBDDyYgABs67OxIJ4GfaIomUA5AIwDalaUdFY30tVRi4hqLoU1NIsjQ'
  ));


$response = curl_exec($curl);

curl_close($curl);
echo $response;
return true;