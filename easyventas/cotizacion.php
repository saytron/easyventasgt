<?php
error_reporting(E_ALL ^ E_NOTICE);
if (!isset($_SESSION)) {

  session_start();
  
  }
if (isset($_SESSION['codigo'])){$pass = $_SESSION['codigo'];}
if (isset($_SESSION['usuario'])){$usuario = $_SESSION['usuario'];}
if (isset($_SESSION['rol'])){$rol = $_SESSION['rol'];}

ini_set('date.timezone', 'America/Guatemala');

$mes = (int) date('m');
$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

//$fecha = "'20".$anio."-".$mes."-".$dia."'";

      if (isset($_GET['eliminar'])) {
        eliminarUsuario($_GET['eliminar']);
      }

if (!isset($_SESSION['codigo'])) {
  header("location: login.php");
}else{
  
}

require_once('Model/class.conexion.php');
  require_once('Model/class.consultas.php');
   require_once('Controller/cargarDatos.php');
   require_once('Controller/Eliminar.php');
   include ('lib/templates/header.php');
 ?>
<title>COTIZACIONES</title>
</head>
<body id="page-top">
<header>
  
</header> 
<?php
$pagina = 9;
    include ('lib/templates/nav2.php');
  ?>
 
                      <input type="hidden" id="codigoUsuario" value="<?php echo $pass; ?>">
                      <input type="hidden" id="idCliente" value="">
                   
                      <input type="hidden" id="idventaFacturado" value="" disabled>
                      <input type="hidden" id="idventaFact" value="" disabled>
    
             

  <div class="page-body">
    <div class="container-fluid">
                   <!-- Aqui imprimmimos el producto-->
      <div class="col-xs-12 col-sm-12 col-md-12">
      <!-- Aqui imprimmimos el contenido de la tabla -->
        <div class="card shadow">  
          <div class="card-body bg-light">
            <div class="table-responsive">  
              <table id="tabla" class="table table-sm table-hover table-striped table-bordered text-primary " style="width:100%">
                <thead>
                  <tr class="bg-primary ">
                    <th class="text-light">NO. </th>
                    <th class="text-light">DETALLE COTIZACION</th>
                    <th class="text-light">ACCIONES</th>
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
  </div> 
   <!--Modal ver CLIENTES-->
<!-- Modal -->
<div class="modal fade" id="modalClienteFactura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-detalle">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <div class="container-button-modal">
        <button class="btn btn-danger" alt="COTIZAR" title="COTIZAR" onclick="generarCotizacion('<?php echo $pass; ?>','2');" target="blank"><i class="material-icons">add_to_photos</i></button>

        </div>

        <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive card shadow card-principal-page pt-4">        
            <div class="content-principal-page">  
         
                <div class="table-responsive">  
                  <table id="clientes" class="table table-sm table-hover table-striped table-bordered text-primary " style="width:100%">
                    <thead>
                      <tr class="bg-primary">
                        <th class="text-light">NIT</th>
                        <th class="text-light">CLIENTE</th>
                        <th class="text-light">ACCIONES</th>
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
        <div class="modal-footer">
      </div>
    </div>
  </div>
</div> 
   <!--Modal ver producto-->
<!-- Modal -->
<div class="modal fade" id="modalDetalleProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-detalle">
        <h5 class="modal-title" id="exampleModalLabel">DETALLES</h5>
        <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="tablaModal" class="table-responsive">

      </div>
   
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>       
 <!--Modal eliminar venta-->
    <!-- Modal -->
    <div class="modal fade" id="modalEliminarVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header-detalle">
            <h5 class="modal-title" id="exampleModalLabel">eliminar</h5>
            <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formEliminarVenta">

              <input type="hidden" name="" id="iddetalleC" value="">

              <input type="hidden" name="" id="idproductoC" value="">
              <input type="hidden" name="" id="idPagC" value="2">

              <input type="hidden" name="" id="idVentaC" value="">
              <span class="text-dark"></span><input class="form-control" type="hidden" id="passVentaDetalleE" name="" placeholder="Codigo" style="text-transform:uppercase;" readonly>
              <span class="text-dark"></span><input class="form-control" type="hidden" id="iddetalleventaE" name="" placeholder="Codigo" style="text-transform:uppercase;" readonly>

              <LABEL class="btn-danger">REALMENTE QUIERES ELIMINAR ESTA VENTA?</LABEL>

              <input class="form-control" type="hidden" id="precioCompraC" value="" placeholder="Precio">
              <input class="form-control" type="hidden" name="" id="comprarC" placeholder="Cantidad comprada" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary cerrar" onclick="eliminarVentaCotizar();" data-bs-dismiss="modal">ELIMINAR</button>
          </div>
        </div>
      </div>
    </div>


    <!--Modal Actualizar venta-->
    <!-- Modal -->
    <div class="modal fade" id="modalActualizarDetalleVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header-detalle">
            <h5 class="modal-title" id="exampleModalLabel">ACTUALIZAR</h5>
            <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formActualizarProducto" enctype="multipart/form-data" class="needs-validation" novalidate>
              <span class="text-dark"></span><input class="form-control" type="hidden" id="idVentaDetalle" name="" placeholder="Codigo" style="text-transform:uppercase;" readonly>
              <span class="text-dark"></span><input class="form-control" type="hidden" id="iddetalleVentaDetalle" name="" placeholder="Codigo" style="text-transform:uppercase;" readonly>
              <span class="text-dark"></span><input class="form-control" type="hidden" id="passVentaDetalle" name="" placeholder="Codigo" style="text-transform:uppercase;" readonly>
              <span class="text-dark"></span><input class="form-control" type="hidden" id="iddetalleventa" name="" placeholder="Codigo" style="text-transform:uppercase;" readonly>
              <span class="text-dark"></span><input class="form-control" type="hidden" id="cantidadProducto2" name="" placeholder="Codigo" style="text-transform:uppercase;" readonly>

              <span class="text-dark">CODIGO:</span><input class="form-control" type="text" id="codigoDetalle" name="codigoDetalle" placeholder="Codigo" style="text-transform:uppercase;" readonly>
              <div class="md-form">
                <i class="fas fa-pencil-alt prefix"></i>
                <textarea id="descripcionDetalle" name="descripcionDetalle" class="md-textarea form-control" rows="3" style="text-transform:uppercase;"></textarea>
              </div>
              <span class="text-dark">CANTIDAD2:</span> <input class="form-control" type="hidden" id="cantidadDetalleOld" name="cantidadDetalle" placeholder="cantidad">

              <span class="text-dark">CANTIDAD:</span> <input class="form-control" type="text" id="cantidadDetalle" name="cantidadDetalle" placeholder="cantidad">
              <span class="text-dark">PRECIO:</span><input class="form-control" type="text" id="precioUdetalle" name="precioUdetalle" placeholder="precio">
              <span class="text-dark">PRECIO T:</span><input class="form-control" type="text" id="precioTdetalle" name="precioTdetalle" placeholder="precio" readonly>

            </form>
          </div>
          <div class="modal-footer bg-info">
            <button type="button" class="cerrar btn btn-danger" onclick="actualizarVentaCotizar();" data-bs-dismiss="modal">Actualizar</button>
          </div>


        </div>
      </div>
    </div>

<?php include ('lib/templates/footer.php'); ?>


<script>
$(document).ready(function
  (){
    var funcion = "listar";
    let datatable = $('#clientes').DataTable
    ({
      
      "ajax":{
        "method":"POST",
        "url":"Controller/cargarCliente.php",
        "dataSrc":""
      },
      "columns":[
        {"data":"nit"},
        {"data":"cliente"},
        {"defaultContent":`
          <div class="btns-group">
          <button class="detalles btns btn-color-red"><span class="material-symbols-outlined">
check
</span></button>
        </div>
          `}
        ],
      "fnRowCallback": function( nRow, data, iDisplayIndex, iDisplayIndexFull ) {
                if ( data.cantidad == 0 )
                {
                    $(nRow).css('color', 'red')
                }
                else
                {
                }
            },
      select: true,
      language: {
                "lengthMenu": "Mostrar _MENU_ reg",
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
           
       
	        
    });
   
    $('#clientes tbody').on('click','.detalles', function(){
      let data = datatable.row($(this).parents()).data();
      obtenerIdCliente(data.id);
      alertify.success("Cliente seleccionado");
    });
  });
</script>
<script>
$(document).ready(function
  (){
    var funcion = "listar2";
    let datatable = $('#tabla').DataTable
    ({
      "order": [[ 0, "desc" ]],
      
      "ajax":{
        "method":"POST",
        "url":"Controller/cargarIdCotizar.php",
        "dataSrc":""
      },
      "columns":[
        {"data":"idventa"},
        {"data":"facturado"},
        {"defaultContent":`
          <div class="btns-group">
          <button class="btns btn-color-red detalles3" data-bs-toggle="modal" data-bs-target="#modalDetalleProducto"><i class="material-icons">read_more</i></button>
          <button class="btns verFactura btn-color-green" alt="FACTURAR" title="FACTURAR" target="blank"><i class="material-icons"><span class="material-icons-outlined">
picture_as_pdf
</span></i></button>
          <button class="detalles2 btns btn-color-yellow"><i class="material-icons">done</i></button>
          </div>
          `}
        ],
      "fnRowCallback": function( nRow, data, iDisplayIndex, iDisplayIndexFull ) {
                if ( data.estado == 2 )
                {
                    $(nRow).css('color', 'red')
                }
                else
                {
                }
            },
      select: true,
      language: {
                "lengthMenu": "Mostrar _MENU_ reg",
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
           
       
	        
    });


    $('#tabla tbody').on('click','.detalles2', function(){
      let data = datatable.row($(this).parents()).data();
     if(data.estado == 2){
      recuperarDatosVentaEnvio(data.usuario,data.idventa,data.estado);
      $('#modalClienteFactura').modal('toggle');
     }else{
      

       alertify.error("Esta cotizacion ya ha sido atendida");
     }
      
    });
    $('#tabla tbody').on('click','.detalles3', function(){
      let data = datatable.row($(this).parents()).data();
    
      recuperarDatosVentaEnvio(data.usuario,data.idventa,data.estado);
     
      
    });
    $('#tabla tbody').on('click','.verFactura', function(){
      let data = datatable.row($(this).parents()).data();
    
      generarPdfCotizar(data.cliente,data.usuario,data.idventa,data.estado);
    });
  });
  var btnCantidadDetalle = document.querySelector('#cantidadDetalle');
      btnCantidadDetalle.onchange = async () => {

        let cantidad = document.getElementById('cantidadDetalle').value
        let precioU = document.getElementById('precioUdetalle').value
        let precioT = cantidad * precioU
        document.getElementById('precioTdetalle').value = precioT
      }
      var btnPrecioDetalle = document.querySelector('#precioUdetalle');
      btnPrecioDetalle.onchange = async () => {

        let cantidad = document.getElementById('cantidadDetalle').value
        let precioU = document.getElementById('precioUdetalle').value
        let precioT = cantidad * precioU
        document.getElementById('precioTdetalle').value = precioT
      }

      btnRecuperarVenta2 = document.querySelector('#recuperar_detalle_venta2');
      btnRecuperarVenta2.onclick = async () => {
        var arg_idventa = document.getElementById('idventaProductoCot').value
        var arg_usuario = document.getElementById('usuarioP').value
        recuperarDatosVenta(arg_usuario, arg_idventa, '0');
        $('#modalDetalleVenta2').modal('show');
      }
</script>
 
</body>
</html>