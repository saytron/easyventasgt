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


 ?>
 <title>MOTOS</title>
</head>
<body >
<header>
  
</header> 
<?php
$pagina = 10;
    include ('lib/templates/nav2.php');
  ?>
 
  
  
<div class="page-body">
  <div class="container-fluid card shadow mt-4 card-principal-page">
             
   
      <!-- Aqui imprimmimos el contenido de la tabla -->
   
          <div class="card mt-4 content-principal-page">
            <div class="table-responsive">  
              <table id="tabla" class="table table-sm table-hover table-striped table-bordered table-responsive" style="width:100%;color:#000000;">
                <thead>
                  <tr class="bg-primary">
                    <th class="text-light">LINEA</th>
                    <th class="text-light">CHASIS</th>
                    <th class="text-light">MOTOR</th>
                    <th class="text-light">MODELO</th>
                    <th class="text-light">PRECIO</th>
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
  <!--Modal ver CLIENTES-->
<!-- Modal -->
<div class="modal fade" id="modalClienteFactura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-detalle">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <div class="container-button-modal">
        <button  class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalVenderMoto">GENERAR NOTA DE VENTA</button>

        </div>
        <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive ">        
            <div class="card shadow  card-principal-page">  
              <div class="content-principal-page">
                <div class="table-responsive mt-4">  
                  <table id="clientes" class="table table-sm table-hover table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr class="bg-primary">
                        <th>NIT</th>
                        <th>CLIENTE</th>
                        <th>ACCIONES</th>
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
        <div class="modal-footer">
      </div>
    </div>
  </div>
</div> 

<!-- modal para nueva moto-->

<!-- Modal -->
<div class="modal fade" id="modalNuevaMoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-detalle">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Moto</h5>
        <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formInsertarMoto">
            <table class="tcolor table table-hover">
            <tr>
                <td><label for="linea">LINEA</label></td>
                <td><input class="form-control" type="text" id="linea" placeholder="Linea" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
            </tr>
            <tr>
                <td><label for="color">COLOR</label></td>
                <td><textarea class="md-textarea form-control" rows="1" id="color" placeholder="Color" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea></td>
            </tr>
            <tr>
                <td><label for="chasis">CHASIS</label></td>
                <td><textarea class="md-textarea form-control" rows="1" id="chasis" placeholder="NO. chasis" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea></td>
            </tr>
            <tr>
                <td><label for="motor">MOTOR</label></td>
                <td><textarea class="md-textarea form-control" rows="1" id="motor" value="" placeholder="No. motor" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea></td>
            </tr>
            <tr>
                <td> <label for="modelo">MODELO</label></td>
                <td><input class="form-control" type="text" id="modelo" value="" placeholder="Modelo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
            </tr>
            <tr>
                <td><label for="precio">PRECIO</label></td>
                <td><input class="form-control" type="text" id="precio" value="" placeholder="Precio" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
            </tr>
            <tr>
                <td><label for="marca">MARCA</label></td>
                <td><select class="btn btn-primary btn-lg btn-block" name="region" id="marcaM"> 
                    <option class="dropdown-toggle" value="">Marca</option>
                    <?php
                        cargarMarca();
                    ?>
                    </select></td>
            </tr>
            </table> 
           

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="guardar_moto();" data-bs-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div>   
<!-- modal para actualizar moto-->

<!-- Modal -->
<div class="modal fade" id="modalActualizarMoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-detalle">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar Moto</h5>
        <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formActualizarMoto">
            
            <table class="tcolor table table-hover">
            <tr>
                
                <td><input class="form-control" type="hidden" id="idMotoA" placeholder="Linea" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
            </tr>
            <tr>
                <td><label for="lineaA">LINEA</label></td>
                <td><input class="form-control" type="text" id="lineaA" placeholder="Linea" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
            </tr>
            <tr>
                <td><label for="colorA">COLOR</label></td>
                <td><textarea class="md-textarea form-control" rows="1" id="colorA" placeholder="Color" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea></td>
            </tr>
            <tr>
                <td><label for="chasisA">CHASIS</label></td>
                <td><textarea class="md-textarea form-control" rows="1" id="chasisA" placeholder="NO. chasis" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea></td>
            </tr>
            <tr>
                <td><label for="motorA">MOTOR</label></td>
                <td><textarea class="md-textarea form-control" rows="1" id="motorA" value="" placeholder="No. motor" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea></td>
            </tr>
            <tr>
                <td> <label for="modeloA">MODELO</label></td>
                <td><input class="form-control" type="text" id="modeloA" value="" placeholder="Modelo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
            </tr>
            <tr>
                <td><label for="precioA">PRECIO</label></td>
                <td><input class="form-control" type="text" id="precioA" value="" placeholder="Precio" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
            </tr>
            
            </table> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="cerrar3" onclick="ActualizarMoto();" data-bs-dismiss="modal">ACTUALIZAR</button>
      </div>
    </div>
  </div>
</div>   


<!--Modal para vender moto -->
<!-- Modal -->
<div class="modal fade" id="modalVenderMoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md text-light" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="exampleModalLabel">VENDER MOTOCICLETA</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light text-dark">
        <form method="post" id="formVender">
            <input type="hidden" name="" id="idMotoV" value="">
            CHASIS:
            <span id="chasisMoto"></span>
             <input type="hidden" name="" id="idventaProducto" value="">
             <br>
             CLIENTE: <span id="clienteMoto"></span>

             <input type="text" name="" id="idClienteMoto" value="">
            
          
        </form>

      </div>
      <div class="modal-footer bg-success">
        <button type="button" class="btn btn-primary" onclick="venderMoto();" data-bs-dismiss="modal">VENDER</button>
      </div>
    </div>
  </div>
</div> 

<?php } ?>
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
          <button class="detalles btns btn-color-red"><i class="material-icons">done</i></button>
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
      alertify.success("cliente seleccionado");
      document.getElementById("clienteMoto").innerHTML = data.cliente;
      document.getElementById("idClienteMoto").value = data.id;
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
        "url":"Controller/cargarMoto.php",
        "dataSrc":""
      },
      "columns":[
        {"data":"linea"},
        {"data":"chasis"},
        {"data":"motor"},
        {"data":"modelo"},
        {"data":"precio"},
        {"defaultContent":`
          <div class="btns-group">
          <button class="detalles3 btns btn-color-red" data-bs-toggle="modal" data-bs-target="#modalDetalleProducto"><i class="material-icons">read_more</i></button>
          <button class="detalles2 btns btn-color-yellow"><i class="material-icons">done</i></button>
          </div>
          `}
        ],
      
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
    
      obtener_detalleMoto(data.id_moto);
      $("#chasisMoto").val(data.chasis);
      document.getElementById("chasisMoto").innerHTML = data.chasis;
      $('#modalClienteFactura').modal('toggle');
      
    });
    $('#tabla tbody').on('click','.detalles3', function(){
      let data = datatable.row($(this).parents()).data();
    
      actualizar_Moto(data.id_moto,data.linea,data.color,data.chasis,data.motor,data.modelo,data.precio);
      $('#modalActualizarMoto').modal('toggle');
    
    });

    $("#cerrar3").click(function(e){
      e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     


	    var url= "";

	    $.ajax({
		    type: "post",
		    url: url,
		    data:{
			   
		    },
		    success:function(datos){
          datatable.ajax.reload(null, false);
        }
	    });
    })

  });

  
  </script>
 
</body>
</html>

