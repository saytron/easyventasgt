<?php
require 'serverside.php';
$table_data->get('repuesto', 'codigo', array('codigo', 'descripcion','cantidad','precio'));
?>	