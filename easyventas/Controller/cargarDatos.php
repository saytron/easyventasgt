<?php
error_reporting(E_ALL ^ E_NOTICE);

    function cargarMarca(){

         $consultas = new Consultas();
         $datos = $consultas->cargarMarca();
         
         foreach($datos as $f) { 
           
            echo '<option class="dropdown-toggle " width="100%" id="marca" value="'.$f['id_marca'].'">'.$f['descripcion'].'</option>';
           
          }
    }
     function cargarCliente(){

         $consultas = new Consultas();
         $datos = $consultas->cargarCliente();
         
         foreach($datos as $f) { 
           
            echo '<option class="dropdown-toggle " width="100%" id="marca" value="'.$f['id_cliente'].'">'.$f['descripcion'].'</option>';
           
          }
    }

   
    function cargarRol(){

         $consultas = new Consultas();
         $datos = $consultas->cargarRol();
         
         foreach($datos as $f) { 
           
            echo '<option class="dropdown-toggle " width="100%" id="rolU" value="'.$f['idrol'].'">'.$f['descripcion'].'</option>';
           
          }
    }

    function cargarProveedor(){

         $consultas = new Consultas();
         $datos = $consultas->cargarProveedor();
         
         foreach($datos as $f) { 
           
            echo '<option class="dropdown-toggle " width="100%" id="rolU" value="'.$f['nit'].'">'.$f['nombre'].'</option>';
           
          }
    }


    function cargarUbicacion(){

         $consultas = new Consultas();
         $datos = $consultas->cargarUbicacion();
         
         foreach($datos as $f) { 
           
            echo '<option class="dropdown-toggle " width="100%" id="rolU" value="'.$f['id_ubicacion'].'">'.$f['descripcion'].'</option>';
           
          }
    }

?>
