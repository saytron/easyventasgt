<?php
require 'serverside.php';
$table_data->get('vista_repuesto', 'codigo', array('codigo', 'descripcion','cantidad','precio'));
?>	