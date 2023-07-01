<?php
error_reporting(E_ALL ^ E_NOTICE);
if (!isset($_SESSION)) {

  session_start();
}
if (isset($_SESSION['codigo'])) {
  $pass = $_SESSION['codigo'];
}
if (isset($_SESSION['usuario'])) {
  $usuario = $_SESSION['usuario'];
}
if (isset($_SESSION['rol'])) {
  $rol = $_SESSION['rol'];
}

ini_set('date.timezone', 'America/Guatemala');

$mes = (int) date('m');
$meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$anio = 0;
$mes = 0;
$dia = 0;
$fecha = "'20" . $anio . "-" . $mes . "-" . $dia . "'";

if (isset($_GET['eliminar'])) {
  eliminarUsuario($_GET['eliminar']);
}



if (!isset($_SESSION['codigo'])) {
  header("location: login.php");
} else {
}

require_once('Model/class.conexion.php');
require_once('Model/class.consultas.php');
require_once('Controller/cargarDatos.php');
require_once('Controller/Eliminar.php');
include('lib/templates/header.php');
?>

</head>

<body id="page-top">
  <header>

  </header>
  <?php
  $pagina = 6;
  include('lib/templates/nav2.php');
  ?>

  <input type="hidden" id="codigoUsuario" value="<?php echo $pass; ?>">
  <input type="hidden" id="idCliente" value="">
  <input type="hidden" id="idventaFacturado" value="" disabled>
  <input type="hidden" id="idventaFact" value="" disabled>

  <div class="container-fluid" id="background-head">
    <div class="row">

      <div class="col-xs-12 col-sm-12 col-md-7">
        <!-- Aqui imprimmimos el contenido de la tabla -->
        <div class="card shadow">
          <div class="card-body bg-light">
            <div class="table-responsive">
              <table id="tabla" class="table table-sm table-hover table-striped table-bordered text-primary " style="width:100%">
                <thead>
                  <tr class="bg-primary">
                    <th>ID </th>
                    <th>DETALLE</th>
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

      <div class="col-xs-12 col-sm-12 col-md-5">
        <div class="table-responsive bg-light">
          <div class="card shadow">
            <div class="card-body bg-light">
              <div class="table-responsive">
                <table id="clientes" class="table table-sm table-hover table-striped table-bordered text-primary " style="width:100%">
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
  </div>
  </div>

  <!--Modal ver producto-->
  <!-- Modal -->
  <div class="modal fade" id="modalDetalleProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">DETALLES</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="tablaModal"></div>

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
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">eliminar</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" id="formEliminarOrden">

            <input type="hidden" name="" id="iddetalleOR" value="">

            <input type="hidden" name="" id="idproductoOR" value="">

            <input type="hidden" name="" id="idVentaOR" value="">
            <LABEL class="btn-danger">REALMENTE QUIERES ELIMINAR ESTA VENTA?</LABEL>

            <input class="form-control" type="hidden" id="precioCompraOR" value="" placeholder="Precio">
            <input class="form-control" type="hidden" name="" id="comprarOR" placeholder="Cantidad comprada" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="eliminarOrden();" data-bs-dismiss="modal">ELIMINAR PRODUCTO</button>
        </div>
      </div>
    </div>
  </div>
  <!--Modal para actualizar venta-->
  <!-- Modal -->
  <div class="modal fade" id="modalActualizarVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">COMPRAS</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" id="formActualizarVenta">

            <input type="hidden" name="" id="iddetalleC" value="">
            <input type="hidden" name="" id="idproductoC" value="">

            Precio de Compra:
            <input class="form-control" type="text" id="precioCompraC" value="" placeholder="Precio">
            <input class="form-control" type="text" name="" id="comprarC" placeholder="Cantidad comprada" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="compraProducto();" data-bs-dismiss="modal">Agregar</button>
        </div>
      </div>
    </div>
  </div>

  <?php include('lib/templates/footer.php'); ?>
  <script>
    $(document).ready(function() {
      var funcion = "listar";
      let datatable = $('#clientes').DataTable({

        "ajax": {
          "method": "POST",
          "url": "Controller/cargarCliente.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "nit"
          },
          {
            "data": "cliente"
          },
          {
            "defaultContent": `
          <a class="detalles btn btn-danger float-right btn-sm"><img width="20px" height="20px"  src="img/detalle.png"></a>
        `
          }
        ],
        "fnRowCallback": function(nRow, data, iDisplayIndex, iDisplayIndexFull) {
          if (data.cantidad == 0) {
            $(nRow).css('color', 'red')
          } else {}
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
            "sLast": "Último",
            "sNext": ">",
            "sPrevious": "<"
          },
          "sProcessing": "Procesando...",
        },
        //para usar los botones

        responsive: "true",



      });

      $('#clientes tbody').on('click', '.detalles', function() {
        let data = datatable.row($(this).parents()).data();
        obtenerIdCliente(data.id);
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      var funcion = "listar2";
      let datatable = $('#tabla').DataTable({
        "order": [
          [0, "desc"]
        ],

        "ajax": {
          "method": "POST",
          "url": "Controller/cargarIdOrden.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "idorden"
          },
          {
            "data": "facturado"
          },
          {
            "defaultContent": `
          <a class="detalles2 btn btn-danger btn-sm float-right" data-bs-toggle="modal" data-bs-target="#modalDetalleProducto"><img width="20px" height="20px"  src="img/detalle.png"></a>
          <a class="btn verFactura btn-success btn-sm float-right" alt="FACTURAR" title="FACTURAR" target="blank"><img width="20px" height="20px" src="img/pdf.png" alt=""></a>
          <a class="detalles2 btn btn-warning btn-sm float-right"><img width="20px" height="20px"  src="img/check.png"></a>

          `
          }
        ],
        "fnRowCallback": function(nRow, data, iDisplayIndex, iDisplayIndexFull) {
          if (data.estado == 0) {
            $(nRow).css('color', 'red')
          } else {}
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
            "sLast": "Último",
            "sNext": ">",
            "sPrevious": "<"
          },
          "sProcessing": "Procesando...",
        },
        //para usar los botones

        responsive: "true",



      });

      $('#tabla tbody').on('click', '.detalles2', function() {
        let data = datatable.row($(this).parents()).data();

        recuperarDatosOrden(data.usuario, data.idorden, data.estado);
      });
      $('#tabla tbody').on('click', '.verFactura', function() {
        let data = datatable.row($(this).parents()).data();

        generarPdfOrden(data.cliente, data.usuario, data.idorden, data.estado);
      });
    });
  </script>

</body>

</html>