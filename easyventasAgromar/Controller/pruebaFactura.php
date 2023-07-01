<?php
error_reporting(E_ALL ^ E_NOTICE);

ini_set('date.timezone', 'America/Guatemala');
$Object = new DateTime();  
$hora = $Object->format("H:i:s ");  


$DateAndTime = Date('y-m-d', time());  
echo '20'.$DateAndTime.'T'.$hora;
