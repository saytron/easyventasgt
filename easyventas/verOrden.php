<?php
error_reporting(E_ALL ^ E_NOTICE);
if (!isset($_SESSION)) {

  session_start();
  }
  if (isset($_SESSION['codigo'])){$pass = $_SESSION['codigo'];}
  if (isset($_SESSION['usuario'])){$usuario = $_SESSION['usuario'];}
  if (isset($_SESSION['rol'])){$rol = $_SESSION['rol'];}
  
  if (!isset($_SESSION['codigo'])) {
    header("location: login.php");
  }else {
    require_once('Model/class.conexion.php');
    require_once('Model/class.consultas.php');
    require_once('Controller/cargarDatos.php');
    require_once('Controller/Eliminar.php');
include ('lib/templates/header.php');

      if (isset($_GET['eliminar'])) {
        eliminarUsuario($_GET['eliminar']);
      }



if(isset($_POST['idventaProducto2'])){$idventaProducto2 = $_POST['idventaProducto2'];}


  $consultas = new consultas();
  $datos = $consultas->cargarMarca();
  $marca = array();
  foreach($datos as $filas){
    $com = utf8_encode($filas['descripcion']);
    array_push($marca, $com);
  }
  $datos2 = $consultas->cargarProveedor();
  $proveedor = array();
  foreach($datos2 as $filas){
    $com = utf8_encode($filas['nombre']);
    array_push($proveedor, $com);
  }

  $datos3 = $consultas->cargarUbicacion();
  $ubicacion = array();
  foreach($datos3 as $filas){
    $com = utf8_encode($filas['descripcion']);
    array_push($ubicacion, $com);
  }
  $idventaProducto = "";
  if(isset($_POST['idventaProducto2'])){
    $idventaProducto = $_POST['idventaProducto2'];
  }else{
    $datos4 = $consultas->recuperarVentaGenerada($pass);
    
    foreach($datos4 as $filas){
      $idventaProducto = utf8_encode($filas['filas']);
    }
  }
  
 ?>
  

 <title>ORDEN DE REPARACION</title>
</head>
<body>
<header>

</header> 
<?php
    $pagina = 4;
    include ('lib/templates/nav2.php');
  ?>
  <div id="app">
        <div class="container-fluid">
                   <!-- Aqui imprimmimos el producto-->
           
            <div class="card-body bg-light">
              <div class="table-responsive">  
                <table id="tabla" class="table table-sm table-hover table-striped table-bordered table-condensed text-primary " style="width:100%">
                  <thead>
                    <tr class="bg-primary">
                      <th>CODIGO</th>
                      <th>DESCRIPCION</th>
                      <th>CANTIDAD</th>
                      <th>PRECIO</th> 
                      <th></th>
                    </tr>
                  </thead>
                  
                  <tfoot>
                  </tfoot>
                </table> 
              </div>
            </div>                 
          </div>
        </div>
     
      </div>


   <!-- modal para detalle producto -->

<!-- Modal -->
<div class="modal fade" id="modalDetalleProductoOrden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-light">
        <h5 class="modal-title" id="exampleModalLabel"><label for=""  name="tituloProducto" id="tituloProducto"></label></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card shadow mb-4">  
          <div id="detalles" class="card-body py-auto">
           
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <?php if($rol == 2){ ?>
                <button  class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoDetalle" alt="Agregar Detalle" title="Agregar Detalle"><i class="material-icons">queue</i></button>
              <?php } ?>
        <button type="button" id="cerrar2" class="btn btn-danger" data-dismiss="modal" alt="cancelar" title="cancelar"><i class="material-icons">cancel</i></button>
      </div>
    </div>
  </div>
</div> 
    <!-- modal para nuevo detalle -->

<!-- Modal -->
<div class="modal fade" id="modalNuevoDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formDetalle">
             <input type="hidden" name="" id="posisiondet" value="<?php echo $num; ?>">
              <input class="form-control input-sm" type="hidden" id="codigodet" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
               <select class="btn btn-primary btn-lg btn-block" name="region" id="proveedordet"> 
           <option class="dropdown-toggle" value="">proveedor</option>
           <?php
           cargarProveedor();

          ?>
      </select>
      <select class="btn btn-primary btn-lg btn-block" name="region" id="bodegadet"> 
           <option class="dropdown-toggle" value="">bodega</option>
           <?php
           cargarUbicacion();

          ?>
      </select>
       <input class="form-control input-sm" type="text" id="cantidaddet" placeholder="Cantidad" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">   
       <input class="form-control input-sm" type="text" id="preciodet" placeholder="Precio de Compra" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">   
         <input class="form-control input-sm" type="hidden" id="usuariodet" value="<?php echo $pass; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">     
          
           </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="guardar_detalleProducto();" data-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div>  

<!-- modal para actualizar detalle -->

<!-- Modal -->
<div class="modal fade" id="modalActualizarDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-light">
        <h5 class="modal-title" id="exampleModalLabel">NUEVO DETALLE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formActualizarDetalle">
             <input type="hidden" name="" id="posicionAcDet" value="<?php echo $num; ?>">
              <input class="form-control input-sm" type="hidden" id="codigoAcDet" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
               <select class="btn btn-primary btn-lg btn-block" name="region" id="proveedorAcDet"> 
           <option class="dropdown-toggle" value="">proveedor</option>
           <?php
           cargarProveedor();

          ?>
        </select>
        <select class="btn btn-primary btn-lg btn-block" name="region" id="bodegaAcDet"> 
           <option class="dropdown-toggle" value="">bodega</option>
           <?php
           cargarUbicacion();

          ?>
        </select>
         <input class="form-control input-sm" type="text" id="cantidadAcDet" placeholder="Cantidad" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">   
         <input class="form-control input-sm" type="text" id="precioAcDet" placeholder="Precio de Compra" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">   
         <input class="form-control input-sm" type="hidden" id="usuarioAcDet" value="<?php echo $pass; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">     
          
           </form>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" onclick="actualizar_detalleProducto();" data-dismiss="modal">ACTUALIZAR</button>
      </div>
    </div>
  </div>
</div>  
  
<!--Modal para insertar proveedor -->
<!-- Modal -->
<div class="modal fade" id="modalNuevoProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text light">
        <h5 class="modal-title" id="exampleModalLabel">NUEVO PROVEEDOR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formProveedor">
            <input class="form-control" type="text" name="nit" id="nitpr" placeholder="Nit" style="text-transform: uppercase;" onkeyup="javascript:this.value.toUpperCase();">
            <input class="form-control" type="text" name="nombrep" id="nombrepr" placeholder="Nombre" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            <input class="form-control" type="text" name="direccionp" id="direccionpr" placeholder="Direccion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            
            
          
        </form>

      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" onclick="insertar_proveedor();" data-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div> 


<!--Modal para insertar bodega -->
<!-- Modal -->
<div class="modal fade" id="modalNuevaBodega" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-light">
        <h5 class="modal-title" id="exampleModalLabel">NUEVA UBICACION</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formBodega">
            <input class="form-control" type="text" name="descripcionbd" id="descripcionbd" placeholder="Ingresa la bodega" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            
            
          
        </form>

      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" onclick="insertar_bodega();" data-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div> 

<!--Modal para crear marca -->
<!-- Modal -->
<div class="modal fade" id="modalNuevaMarca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-light">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Marca</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formMarca">
            <input class="form-control" type="text" name="descripcionMarca" id="descripcionMarca" placeholder="Ingresa la Marca" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            
            
          
        </form>

      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" onclick="enviar_marca();" data-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div> 
<!-- modal para nuevo Producto -->

<!-- Modal -->
<div class="modal fade" id="modalNuevoProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-light">
        <h5 class="modal-title" id="exampleModalLabel">NUEVO PRODUCTO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post" id="formProducto">
            <input class="form-control" type="text" id="codigoP" placeholder="Codigo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
           <input class="form-control" type="text" id="descripcionP" placeholder="Descripcion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            <input class="form-control" type="text" id="cantidadP" value="" placeholder="CANTIDAD" >
            <input class="form-control" type="text" id="precioP" value="" placeholder="PRECIO AL PUBLICO">
           
           
           <select class="btn btn-primary btn-lg btn-block" name="region" id="marcaP"> 
           <option class="dropdown-toggle" value="">MARCA</option>
           <?php
           cargarMarca();

          ?>
            </select>
          
        <select class="btn btn-primary btn-lg btn-block" name="region" id="proveedorP"> 
        <option class="dropdown-toggle" value="">PROVEEDOR</option>
           <?php
           cargarProveedor();
          ?>
      </select>
      <select class="btn btn-primary btn-lg btn-block" name="region" id="bodegaP"> 
           <option class="dropdown-toggle" value="">BODEGA</option>
           <?php
           cargarUbicacion();

          ?>
      </select>
      <br>
       <input class="form-control input-sm" type="text" id="precioCP" placeholder="Precio de Compra" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">   
         <input class="form-control input-sm" type="hidden" id="usuarioP" value="<?php echo $pass; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">     
          
        </form>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" id="guardar_repuesto" data-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div>   

<!-- modal para actualizar producto -->

<!-- Modal -->
<div class="modal fade" id="modalActualizarProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-light">
        <h5 class="modal-title" id="exampleModalLabel">ACTUALIZAR PRODUCTO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php if($rol == 2){ ?>
      <div class="modal-body">
      
        <form method="post" id="formAcpr">
            <input class="form-control" type="hidden" id="idpr" placeholder="">
            CODIGO:<input class="form-control" type="text" id="codigopr" placeholder="Codigo" style="text-transform:uppercase;" disabled>
              DESCRIPCION:<input class="form-control" type="text" id="descripcionpr" placeholder="descripcion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              CANTIDAD:<input class="form-control" type="text" id="cantidadpr" placeholder="cantidad" >
               PRECIO:<input class="form-control" type="text" id="preciopr" placeholder="precio">
            
           
          
        </form>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" id="ActualizarProducto" data-dismiss="modal">Actualizar</button>
      </div>
      <?php }else{
        ?>
        <p  class="text-dagner"><center><h3>No tienes privilegios para modificar</h3></center></p>
        <?php
      } ?>
    </div>
  </div>
</div>   

<!--Modal para vender producto -->
<!-- Modal -->
<div class="modal fade" id="modalVenderProductoOrden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-light text-center">
        <h5 class="modal-title" id="exampleModalLabel">REBAJAR PRODUCTO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <form method="post" id="formVender">
          <input type="hidden" name="" id="idventa" value="">
          <input type="hidden" name="" id="idventaProducto" value="">
          <input type="hidden" name="" id="iddetalleP" value="">
          <input type="hidden" name="" id="cantidadPr" value="">
          <input type="hidden" name="" id="usuarioventa" value="<?php echo $pass; ?>">
          Precio:
          <div class="input-group-prepend">
            <span class="input-group-text">Q</span>
            <input class="form-control" type="text" id="precioVenta" value="" placeholder="Precio">
          </div>
          <select class="btn btn-primary btn-lg btn-block" name="region" id="mObra"> 
              <option class="dropdown-toggle" value="1">PRODUCTO</option>
              <option class="dropdown-toggle" value="0">MANO DE OBRA Y LUb</option>

            </select>
            <input class="form-control" type="number" name="vender" id="vender" placeholder="Cantidad a Vender" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            <p>
                <label  class="form-check-label" for="">descuentos</label>
                <br>
                <input type="radio" id="descuento" name="descuento" value="0.05" >
                <label  class="form-check-label" for="descuento">5%</label>
                <br>
                <input type="radio" id="descuento" name="descuento" value="0.07" >
                <label  class="form-check-label" for="descuento">7%</label>
                <br>
                <input type="radio" id="descuento" name="descuento" value="0.10" >
                <label  class="form-check-label" for="descuento">10%</label>
                <br>
                <input type="radio" id="descuento" name="descuento" value="0.125" >
                <label  class="form-check-label" for="descuento">12.5%</label>
                <br>
                <input type="radio" id="descuento" name="descuento" value="0.15" >
                <label for="descuento">15%</label>
            </p>
        </form>

      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" id="RebajarProducto" data-dismiss="modal">Rebajar</button>
      </div>
    </div>
  </div>
</div> 

<!--Modal para pedir producto -->
<!-- Modal -->
<div class="modal fade" id="modalPedirProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-light">
        <h5 class="modal-title" id="exampleModalLabel">PEDIR PRODUCTO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="formPedir">
            <input type="hidden" name="" id="idPedir" value="">
             
            <input class="form-control" type="number" name="pedir" id="pedir" placeholder="Cantidad a Pedir" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            
            
          
        </form>

      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" onclick="pedirProducto();" data-dismiss="modal">PEDIR</button>
      </div>
    </div>
  </div>
</div> 
<!--Modal agregar productos comprados-->
<!-- Modal -->
<div class="modal fade" id="modalCompraProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title bg-success text-light" id="exampleModalLabel">COMPRAS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formComprar" class="form form-group" >
            
             <input type="hidden" name="" id="iddetalleC" value="">
             <input type="hidden" name="" id="idproductoC" value="">

             <span class="text-primary">Precio de Compra:</span>
             <div class="input-group-prepend">
              <span class="input-group-text">Q</span>
             <input  class="form-control" type="text" id="precioCompraC" value="" placeholder="Precio">
            </div>
            <input class="form-control" type="number" name="" id="comprarC" placeholder="Cantidad comprada" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            
            
          
        </form>

      </div>
      
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" id="comprarProducto" data-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div> 
<?php } ?>

<footer>
<?php include ('lib/templates/footer.php'); ?>
</footer>
<script>vender
  $(document).ready(function
  (){
    var funcion = "listar";
      datatable = $('#tabla').DataTable({    
      "bProcessing": true,
        "bDeferRender": true,	
        "bServerSide": true,                
        "sAjaxSource": "serverside/serversideRepuesto.php",	
        "columnDefs": [ {
        "targets": -1,        
        "defaultContent":`
          <a class="detalles btn btn-warning btn-sm" data-toggle="modal" data-target="#modalDetalleProductoOrden" alt="detalles" title="ver detalles" ><i class="material-icons">receipt</i></a>
        `
        }
      ],
     
      select: true,
      language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": " _START_ al _END_ de _TOTAL_ registros",
                "infoEmpty": " 0 al 0 de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":">",
                    "sPrevious": "<"
			     },
			     "sProcessing":"Procesando...",
            },
             //para usar los botones
		
        responsive: "true",
        dom: 'Bfrtilp',       
        buttons:[ 
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
				className: 'btn btn-success'
			},
			{
				extend:    'pdfHtml5',
				text:      '<i class="fas fa-file-pdf"></i> ',
				titleAttr: 'Exportar a PDF',
				className: 'btn btn-danger'
			},
			{
				extend:    'print',
				text:      '<i class="fa fa-print"></i> ',
				titleAttr: 'Imprimir',
				className: 'btn btn-info'
			},
		]
	        
    });
    $('#tabla tbody').on('click','.actualizar', function
    (){
      fila = $(this).closest("tr");	        
    var codigo = fila.find('td:eq(0)').text(); //capturo el ID		            
    var descripcion = fila.find('td:eq(1)').text();
    var cantidad = fila.find('td:eq(2)').text();
    var precio = fila.find('td:eq(3)').text();
      $('#codigopr').val(codigo);
      $('#descripcionpr').val(descripcion);
      $('#cantidadpr').val(cantidad);
      $('#preciopr').val(precio);
      
     /* let data = datatable.row($(this).parents()).data();
      $('#codigopr').val(data.codigo);
      $('#descripcionpr').val(data.descripcion);
      $('#cantidadpr').val(data.cantidad);
      $('#preciopr').val(data.precio);*/
      
    });

    $('#tabla tbody').on('click','.detalles', function(){
      fila = $(this).closest("tr");	 
      let codigo = fila.find('td:eq(0)').text(); //capturo el ID		            
      let descripcion = fila.find('td:eq(1)').text();
      let cantidad = fila.find('td:eq(2)').text();
      let precio = fila.find('td:eq(3)').text();
      
      
      document.getElementById("tituloProducto").innerHTML = descripcion;
      $('#codigodet').val(codigo);
      $('#precioVentaC').val(precio);
     
      obtener_detalleOrden(codigo,descripcion,precio,codigo,<?php echo $rol; ?>,<?php echo $idventaProducto; ?>,'<?php echo $pass; ?>');
   });
    //evento para rebajar producto
    $("#comprarProducto").click(function(e){  
      e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    
	
	    var arg_iddetalleproducto = document.getElementById("iddetalleC").value
	    var arg_precio = document.getElementById("precioCompraC").value
	    var arg_cantidad = document.getElementById("comprarC").value
	    var arg_idproducto = document.getElementById("idproductoC").value
	    var url= "Controller/compras.php";
	    document.getElementById("formComprar").reset();

	    $.ajax({
		    type: "post",
		    url: url,
		    data:{
			
			    iddetalle:arg_iddetalleproducto,
			    precio:arg_precio,
			    cantidad:arg_cantidad,
			    idproducto:arg_idproducto
		    },
		    success:function(datos){
			    datatable.ajax.reload(null, false);
			    $('#comprarC').val('');
			      alertify.success(datos);


		    }
	    });
    });
    //evento para rebajar producto
    $("#RebajarProducto").click(function(e){
      e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página

      var arg_cantidad = document.getElementById("cantidadPr").value
      var arg_descuento = $('input[name=descuento]:checked', '#formVender').val()
      var arg_Venta=document.getElementById("vender").value
      var arg_idventa = document.getElementById("idventa").value
      var arg_iddetalleproducto = document.getElementById("iddetalleP").value
      var arg_usuario = document.getElementById("usuarioventa").value
      var arg_precio = document.getElementById("precioVenta").value
      var arg_idventaProducto = document.getElementById("idventaProducto").value
      var arg_mObra = document.getElementById("mObra").value
      var url= "Controller/venderProductoOrden.php";
      document.getElementById("formVender").reset();

      $.ajax({
        type: "post",
        url: url,
        data:{
          descuento:arg_descuento,
          existencia:arg_cantidad,
          idventa:arg_idventa,
          venta:arg_Venta,
          iddetalle:arg_iddetalleproducto,
          usuario:arg_usuario,
          idventaProducto:arg_idventaProducto,
          precio:arg_precio,
          mObra:arg_mObra
        },
        success:function(datos){
          datatable.ajax.reload(null, false);
  
          $('#idventaProducto').val(arg_idventaProducto);
          $('#usuarios').html('');
  
          if(datos === ""){
            alertify.success("<h2>producto rebajado con exito!</h2>");
          }else{
            alertify.error(datos);
          }
        }
      });
    });
    //evento para actualizar producto
    $("#ActualizarProducto").click(function(e){
      e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
      var arg_id=document.getElementById("idpr").value
	    var arg_codigo=document.getElementById("codigopr").value
	    var arg_descripcion=document.getElementById("descripcionpr").value
	    var arg_cantidad = document.getElementById("cantidadpr").value
	    var arg_precio = document.getElementById("preciopr").value
	    var url= "Controller/actualizarProducto.php";
	    document.getElementById("formAcpr").reset();
	    $.ajax({
		    type: "post",
		    url: url,
		    data:{
			    id:arg_id,
			    codigo:arg_codigo,
			    descripcion:arg_descripcion,
			    cantidad:arg_cantidad,
			    precio:arg_precio
		    },
		    success:function(datos){
          datatable.ajax.reload(null, false);
			    alertify.success(datos);
		    }
	    });
    });
    //evento para agregar producto
    $("#guardar_repuesto").click(function(e){
      e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
      var arg_codigo=document.getElementById("codigoP").value
	    var arg_descripcion=document.getElementById("descripcionP").value
	    var arg_cantidad=document.getElementById("cantidadP").value
  	  var arg_precio=document.getElementById("precioP").value
	    var arg_marca=document.getElementById("marcaP").value

	    var arg_proveedor=document.getElementById("proveedorP").value
	    var arg_ubicacion=document.getElementById("bodegaP").value
	    var arg_usuario=document.getElementById("usuarioP").value
	    var arg_precio_compra=document.getElementById("precioCP").value
	


	    var url= "Controller/insertarRepuesto.php";
	    document.getElementById("formProducto").reset();

	    $.ajax({
		    type: "post",
		    url: url,
		    data:{
			    codigo:arg_codigo,
			    descripcion:arg_descripcion,
			    cantidad:arg_cantidad,
			    precio:arg_precio,
			    marca:arg_marca,

			    proveedor:arg_proveedor,
			    ubicacion:arg_ubicacion,
			    usuario:arg_usuario,
			    precioR:arg_precio_compra

		    },
		    success:function(datos){
          datatable.ajax.reload(null, false);
			    alertify.success(datos);
        }
	    });
    })
    //fin de document ready
  });
</script>
</body>
</html>

