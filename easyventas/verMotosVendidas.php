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
include ('lib/templates/header.php');

if (isset($_GET['eliminar'])) {
  eliminarUsuario($_GET['eliminar']);
}


if (isset($_POST['idventaProducto2'])){$idventaProducto2 = $_POST['idventaProducto2'];}



 ?>
 <title>Motos vendidas</title>
</head>
<body>
  <header>
  
  </header> 
  <?php
  $pagina = 0;
    include ('lib/templates/nav2.php');
  ?>
  <div class="page-body">
    <div class="container-fluid card shadow mt-4 card-principal-page">
       
          <div class="content-principal-page pt-4">
            <!-- Aqui imprimmimos el contenido de la tabla -->
            <div class="table-responsive">  
                   
              <table id="tablaMotos" class="table table-sm table-responsive table-hover table-striped table-bordered text-primary" style="width:100%">
                <thead>
                  <tr class="bg-primary text-primary">
                    <th class="text-light">LINEA</th>
                    <th class="text-light">CHASIS</th>
                    <th class="text-light">CLIENTE</th>
                    <th class="text-light">MODELO</th>
                    <th class="text-light">FECHA</th>
                    <th class="text-light">PRECIO</th>
                    <th class="text-light">NOTA DE VENTA</th>
                    <th class="text-light">PLACAS</th>
                  </tr>
                </thead>
                    
                <tfoot>
                </tfoot>
              </table>                  
   
          </div>
        </div>
      </div>
    </div>
  <!--Modal ver estado de placas-->
<!-- Modal -->
<div class="modal fade" id="modalEstadoPlacas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h4 class="modal-title bg-success text-light" id="exampleModalLabel">ESTADO DE PLACAS</h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formEstado" class="form form-group" >
      <input type="hidden" id="iddetMoto" value="">
        <h2><span  class="text-danger" id="estadoPlacas"></span></h2>
        <hr>
        <span class="text-dark" id="mensajeP">CAMBIAR ESTADO</span>
        <select class="btn btn-primary btn-lg btn-block" name="region" id="estadoP"> 
           <option class="dropdown-toggle" value="">SELECCIONAR</option>
           <option class="dropdown-toggle" value="2">EN PROCESO</option>
           <option class="dropdown-toggle" value="3">ENVIADO</option>
           <option class="dropdown-toggle" value="4">RECIBIDO</option>
           <option class="dropdown-toggle" value="5">ENTREGADO</option>

      </select>
            
             
          
        </form>

      </div>
      
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" id="verEstadoPlacas" data-bs-dismiss="modal">Cambiar Estado</button>
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
    let datatable = $('#tablaMotos').DataTable
    ({
      
      "ajax":{
        "method":"POST",
        "url":"Controller/cargarMotoVendida.php",
        "dataSrc":""
      },
      "columns":[
        {"data":"linea"},
        {"data":"chasis"},
        {"data":"cliente"},
        {"data":"modelo"},
        {"data":"fecha"},
        {"data":"precio"},
        {"defaultContent":`
          <div class="btns-grouop">
          <button class="pdfmotos btns btn-color-red" alt="Generar nota de venta" title="Generar nota de venta"><i class="material-icons">picture_as_pdf</i></button>
          </div>
          `},
          {"defaultContent":`
            <div class="btns-grouop">
          <button id="estadoMotos" class="estadoMotos btns btn-color-green" data-bs-toggle="modal" data-bs-target="#modalEstadoPlacas" alt="estado de placas" title="estado de placas"><i class="material-icons">read_more</i></button> 
          </div>
            `}
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

    $('#tablaMotos tbody').on('click','.pdfmotos', function(){
      let data = datatable.row($(this).parents()).data();
      obtenerNotaVenta(data.chasis);
    });
    
    $('#tablaMotos tbody').on('click','.estadoMotos', function(){
      let data = datatable.row($(this).parents()).data();
      let estado = data.estadoPlacas;
      $('#iddetMoto').val(data.iddetMoto);
      if(estado == 2){
        $('#estadoPlacas').text( `FACTURACION EN PROCESO` );
        $("#estadoP").css("display", "block");
        $("#verEstadoPlacas").css("display", "block");
        $("#mensajeP").css("display", "block");
      }else if(estado == 3){
        $('#estadoPlacas').text(`PAPELERIA ENVIADA A PLACAS`);
        $("#estadoP").css("display", "block");
        $("#verEstadoPlacas").css("display", "block");
        $("#mensajeP").css("display", "block");
      }else if(estado == 4){
        $('#estadoPlacas').text(`PLACAS RECIBIDAS`);
        $("#estadoP").css("display", "block");
        $("#verEstadoPlacas").css("display", "block");
        $("#mensajeP").css("display", "block");
      }else if(estado == 5){
        $('#estadoPlacas').text(`PLACAS ENTREGADAS`);
        $("#estadoP").css("display", "none");
        $("#verEstadoPlacas").css("display", "none"); 
        $("#mensajeP").css("display", "none");
      }else{
        
        $('#estadoPlacas').text( `SIN ACCION` );
        $("#estadoP").css("display", "block");
        $("#verEstadoPlacas").css("display", "block");
        $("#mensajeP").css("display", "block");
      }
      
    });
    $("#verEstadoPlacas").click(function(e){  
      e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    
	
	    var arg_estado = document.getElementById("estadoP").value
      var arg_detMoto = document.getElementById("iddetMoto").value
	    
	    var url= "Controller/estadoPlacas.php";
	    document.getElementById("formEstado").reset();

	    $.ajax({
		    type: "post",
		    url: url,
		    data:{
			
			    estadoPlacas:arg_estado,
          iddetalleMoto: arg_detMoto
			   
		    },
		    success:function(datos){
			    datatable.ajax.reload(null, false);
			    $('#comprarC').val('');
			      alertify.success(datos);


		    }
	    });
    });
    
    //fin de document ready
  });
</script>
</body>
</html>

