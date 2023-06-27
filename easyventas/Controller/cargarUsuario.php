<?php
  error_reporting(E_ALL ^ E_NOTICE);
function cargarUsuario($id,$num,$cod){

try{
             $consultas = new Consultas();
             $datos = $consultas->buscarUsuario($id);
             echo '<table class="tcolor table table-striped table-hover">';
             echo '<tr>';
             echo '<th class="btn-primary">CODIGO</th>';
             echo '<th class="btn-primary">USUARIO</th>';
             echo '<th class="btn-primary">ROL</th>';
             echo '<th class="btn-primary"></th>';
              echo '<th class="btn-primary"></th>';
             echo '</tr>';
             if($datos != ""){
                foreach($datos as $fila) { 
                    
                     $nombre = "'".$fila['nombre']."'";
                     $codigo = "'".$fila['codigo']."'";       
                    echo '<tr>';
                    echo '<td>'.$fila['codigo'].'</td>';
                    echo '<td>'.$fila['nombre'].'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                     echo '<td align="right"><a class="btn btn-primary" href="empleado.php?id='.$id.'&nombre='.$fila['nombre'].'&num='.$num.'&eliminar='.$fila['codigo'].'"><img width="40px" height="40px"  src="img/deleteUser.png"></a></td>';
                     echo '<td align="left"><button class="btn btn-primary" data-toggle="modal" data-target="#modalActualizarUsuario" onclick="actualizarUsuario('.$nombre.','.$codigo.');"><img width="40px" height="40px"  src="img/editar.png"></button></td>';
                    echo '<tr>';
                }
             }else{

             }
            
             echo '</table>';

        }catch(Exception $e){
            echo "Ha ocurrido un error en la bd";
        }

}
    
?>
