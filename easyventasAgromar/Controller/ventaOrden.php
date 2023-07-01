<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('../Model/class.conexion.php');
  require_once('../Model/class.consultas.php');
   
  
$cod = "'".$_POST['cod']."'";
$num = $_POST['num'];
$id = $_POST['idventa'];
ini_set('date.timezone', 'America/Guatemala');
$anio = date('y');
$mes = date('m');
$dia = date('j');
$fecha = "'".$anio."-".$mes."-".$dia."'";
	
		$consultas = new Consultas();

    $registros = 8;
    
    if (isset($_POST['num']) && $_POST['num'] != "") {
        $pagina = $_POST['num'];
    }else{
        $pagina = 1;
    }

$inicio = (($pagina-1)*$registros);

    $num_registros = null;
    $consult = $consultas->cargarTotalventasOrden($cod,$fecha);
    
    foreach ($consult as $total) {
        $num_registros = $total['filas'];
    }
  
	$datos = $consultas->cargarVentasOrden($cod,$id);

    $totPaginas = ceil($num_registros/$registros);
    
         try{
            
               
                    echo '<table class="tcolor table table-striped table-hover table-condensed table-responsive">';

                        echo '<tr>';
                         echo '<td align="center" class="btn-primary">CANTIDAD</td>';
                            echo '<td align="center" class="btn-primary">CODIGO</td>';
                           echo '<td align="center" class="btn-primary">DESCRIPCION</th>';
                            echo '<td align="center" class="btn-primary">PRECIO UNITARIO</td>';
                           echo '<td align="center" class="btn-primary">TOTAL</td>';  
                           echo '<td align="center" class="btn-primary"> </td>';
                           echo '<td align="center" class="btn-primary"> </td>';
                           
                            
                        echo '</tr>';
                    if($datos != ""){
                    foreach($datos as $fila) { 
                       
                        echo '<tr>';
                            echo '<td align="center">'.$fila['cantidad'].'</td>';
                            echo '<td align="center">'.$fila['codigo'].'</td>';
                            echo '<td>'.$fila['descripcion'].'</td>';
                            echo '<td align="right">Q '.$fila['precio_publico'].'</td>';
                            echo '<td align="right">Q '.$fila['precio_venta'].'</td>';

                            $iddetalleV = "'".$fila['iddetalle_repuesto']."'";
                            $idproducto = "'".$fila['codigo']."'";
                            $precio = "'".$fila['precio_venta']."'";
                            $compra = "'".$fila['cantidad']."'";
                            $idventa = "'".$fila['id']."'";

                            echo '<td align="left"><button class="btn btn-warning" data-toggle="modal" data-target="#modalEliminarVenta"onclick="eliminar_ordenes('.$iddetalleV.','.$idproducto.','.$precio.','.$compra.','.$idventa.')"><img width="20px" height="20px"  src="img/eliminar.png"></button></td>';
                        echo '</tr>';
                    }
                }else{
                    echo " <h2>no hay datos para mostrar</h2>".$fecha;
                }
            
               
         
        }catch(Exception $e){
            echo "Ha ocurrido un error en la bd";

        }

        
?>