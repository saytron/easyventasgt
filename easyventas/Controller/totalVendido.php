<?php
/*
error_reporting(E_ALL ^ E_NOTICE);
 require_once('../Model/class.conexion.php');
  require_once('../Model/class.consultas.php');
if(isset($_POST['mes'])){$arg_mes = $_POST['mes'];}
if(isset($_POST['anio'])){$arg_anio = $_POST['anio'];}


$arg_codigoUsuario = "'".$_POST['codigo']."'";
ini_set('date.timezone', 'America/Guatemala');
$anio = date('y');
$mes = date('m');
$dia = date('j');
$fecha = "'20".$anio."-".$mes."-".$dia."'";

$consultas = new Consultas();

$datos = $consultas->totalVendidoMes($arg_codigoUsuario,'20'.$anio,$mes);
$venta = $consultas->totalVendidoDiario($fecha, $arg_codigoUsuario);
             
try{        
             
   if($venta != ""){

      echo '<div class="card bg-gray-200">';
         foreach($venta as $filas) { 
            if($filas['totales'] == ""){

            }else{
               echo '<div class="container text-primary text-center">';
               echo '<div class=" card border-left-primary">DIARIO: </h4><br> <h4>Q '.$filas['totales'].'</div>';
               echo '</div>';
            }

         }
              
      }else{
            echo " <h2>no hay datos para mostrar</h2>";
      }
            
      if($datos != ""){

         foreach($datos as $fila) { 
            echo '<div class="container text-danger text-center">';
            echo '<div class="card border-left-danger"><span>MENSUAL: </h4><br> <h4>Q '.$fila['total'].'</span></div>';
            echo '</div>';
            $comision = round(($fila['total'] * 0.01),2);
            echo '<div class="container">';
            echo '<div class="card border-left-info text-info text-center"><span>COMISION:</span><span> Q '. $comision.'</span></div>';
            echo '</div>';
         }
         echo '</div>';
      }else{
                echo " <h2>no hay datos para mostrar</h2>";
      }
   }catch(Exception $e){
      echo "Ha ocurrido un error en la bd";
   }
*/
    
?>