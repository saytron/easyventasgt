<?php
error_reporting(E_ALL ^ E_NOTICE);
function eliminarUsuario($arg_eliminar){
        try{
             $consultas = new Consultas();
             $datos = $consultas->eliminarUsuarios($arg_eliminar);
            echo $datos;
          
        }catch(Exception $e){
            echo "Ha ocurrido un error en la bd";
        }
         
    }

?>