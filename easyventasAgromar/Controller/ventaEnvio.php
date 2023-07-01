<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('../Model/class.conexion.php');
  require_once('../Model/class.consultas.php');
   
  
$cod = $_POST['cod'];
$id = $_POST['idventa'];
ini_set('date.timezone', 'America/Guatemala');
$anio = date('y');
$mes = date('m');
$dia = date('j');
$fecha = "'".$anio."-".$mes."-".$dia."'";
	
		$consultas = new Consultas();
   
  
	$datos = $consultas->cargarVentasEnvios($cod,$id);


    
         try{
            
               
            echo '<table class="table table-striped table-hover table-condensed table-responsive" style="width:100%;">';

            echo '<tr class="bg-danger">';
                echo '<th class="text-light">CANT.</th>';
                echo '<th class="text-light">COD.</th>';
                echo '<th class="text-light">DESCRIPCION</th>';
                echo '<th class="text-light">PRECIO UNITARIO</th>';
                echo '<th class="text-light">TOTAL</th>';  
                echo '<th class="text-light"> </th>';
                echo '<th class="text-light"> </th>';
               
                
            echo '</tr>';
                    if($datos != ""){
                    foreach($datos as $fila) { 
                       
                        echo '<tr>';
                            echo '<td align="center">'.$fila['cantidad'].'</td>';
                            echo '<td align="center">'.$fila['codigo'].'</td>';
                            echo '<td>'.$fila['detalleProducto'].'</td>';
                            echo '<td align="right">Q ' . $fila['precio_venta'] / $fila['cantidad']. '</td>';
                            echo '<td align="right">Q '.$fila['precio_venta'].'</td>';

                            $iddetalleV = "'".$fila['iddetalle_repuesto']."'";
                            $idproducto = "'".$fila['codigo']."'";
                            $precio = "'".$fila['precio_venta']."'";
                            $compra = "'".$fila['cantidad']."'";
                            $idventa = "'".$fila['id']."'";
                            $pass = "'".$fila['usuario']."'";
                            $idDetalleVenta = "'".$fila['idventa']."'";
                            $precioU  = "'".$fila['precio_publico']."'";
                            $descripcionDetalle = "'".$fila['detalleProducto']."'";
                            echo '<td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalActualizarDetalleEnvio"onclick="actualizar_detalle_venta(' . $iddetalleV . ',' . $idproducto . ',' . $precio . ',' . $compra . ',' . $idventa . ',' . $precioU . ',' . $descripcionDetalle . ',' . $pass . ','.$idDetalleVenta.');"><span class="material-symbols-outlined">
                            edit
                            </span></button></td>';
                            echo '<td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarVenta"onclick="eliminar_envio(' . $iddetalleV . ',' . $idproducto . ',' . $precio . ',' . $compra . ',' . $idventa . ',' . $pass . ','.$idDetalleVenta.');"><span class="material-symbols-outlined">
                            delete
                            </span></button></td>';
                           
                        echo '</tr>';
                    }
                }else{
                    echo " <h2>no hay datos para mostrar</h2>".$fecha;
                }
            
               
         
        }catch(Exception $e){
            echo "Ha ocurrido un error en la bd";

        }

        
?>