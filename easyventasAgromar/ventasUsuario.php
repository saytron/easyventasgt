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
} else {

  require_once('Model/class.conexion.php');
  require_once('Model/class.consultas.php');
  require_once('Controller/cargarDatos.php');
  require_once('Controller/Eliminar.php');
  include('lib/templates/header.php');

ini_set('date.timezone', 'America/Guatemala');

$mes = (int) date('m');
$meses = array("", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
if (isset($anio) && isset($dia)) {
  $fecha = "'20" . $anio . "-" . $mes . "-" . $dia . "'";
};
if (isset($_GET['eliminar'])) {
  eliminarUsuario($_GET['eliminar']);
}



  $arg_codigoUsuario = "'" . $pass . "'";
  ini_set('date.timezone', 'America/Guatemala');
  $anio = date('y');
  $mes = date('m');
  $dia = date('j');
  $fecha = "'20" . $anio . "-" . $mes . "-" . $dia . "'";

  $consultas = new consultas();
  $datos = $consultas->totalVendidoDiario($fecha, $arg_codigoUsuario);
  $com = 0;
  $diario = array();
  foreach ($datos as $filas) {
    $com = $filas['totales'];
    array_push($diario, $com);
  }
  $datos2 = $consultas->totalVendidoMes($arg_codigoUsuario, '20' . $anio, $mes);
  $mensual = array();
  $comision = 0;
  foreach ($datos2 as $filas) {
    $com = $filas['total'];
    $comision = round(($filas['total'] * 0.01), 2);
    array_push($mensual, $com);
  }

?>

  <title id="title">VENTAS</title>
  </head>

  <body>

    <header>

    </header>
    <?php
    $pagina = 5;
    include('lib/templates/nav2.php');
    ?>
    <input type="hidden" id="codigoUsuario" value="<?php echo $pass; ?>">

    <div class="page-body ">
      <div class="container-fluid card shadow mt-4 card-principal-page">
        <!-- Aqui imprimmimos el producto-->
        <div class="content-principal-page">
          <div class="card-top bg-secondary">
            <div class="media static-top-widget media-body-center">
              <div class="align-self-center text-center"><i data-feather="shopping-cart"></i></div>
              <div class="media-body"><span class="m-0">Diario.</span>
                <h4 class="mb-0 mr-2 counter"><?php echo 'Q' . $diario[0]; ?></h4><i class="icon-bg" data-feather="shopping-cart"></i>
              </div>
            </div>
          </div>
          <div class="card-top bg-primary">
            <div class="media static-top-widget media-body-center">
              <div class="align-self-center text-center"><i data-feather="shopping-cart"></i></div>
              <div class="media-body"><span class="m-0">Mensual.</span>
                <h4 class="mb-0 mr-2 counter"><?php echo 'Q' . $mensual[0]; ?></h4><i class="icon-bg" data-feather="shopping-cart"></i>
              </div>
            </div>
          </div>
          <div class="card-top bg-success">
            <div class="media static-top-widget media-body-center">
              <div class="align-self-center text-center"><i data-feather="activity"></i></div>
              <div class="media-body"><span class="m-0">Comision.</span>
                <h4 class="mb-0 mr-2 counter"><?php echo 'Q' . $comision; ?></h4><i class="icon-bg" data-feather="activity"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="content-principal-page">



          <div class="table-responsive" style="width:100%">
            <table id="tabla" class="table table-sm table-hover table-striped table-bordered text-primary " style="width:100%">
              <thead>
                <tr class="bg-primary">
                  <th class="text-light">CANT.</th>
                  <th class="text-light">CODIGO</th>
                  <th class="text-light">DESCRIPCION</th>
                  <th class="text-light">P_UNIT</th>
                  <th class="text-light">TOTAL</th>
                  <th class="text-light">ACCIONES</th>
                </tr>
              </thead>

              <tfoot>
              </tfoot>
            </table>

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
              <form method="post" id="formEliminarVenta">

                <input type="text" name="" id="iddetalleC" value="">

                <input type="text" name="" id="idProductoC" value="">

                <input type="text" name="" id="idVentaC" value="">
                <LABEL class="btn-danger">REALMENTE QUIERES ELIMINAR ESTA VENTA?</LABEL>

                <input class="form-control" type="text" id="precioCompraC" value="" placeholder="Precio">
                <input class="form-control" type="text" name="" id="comprarC" placeholder="Cantidad comprada" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



              </form>

            </div>
            <div class="modal-footer">
              <button id="eliminarVenta" type="button" class="btn btn-primary" data-bs-dismiss="modal">ELIMINAR</button>
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

                <input type="hidden" name="" id="idVentaC">


                <input class="form-control" type="hidden" id="precioCompraC" value="" placeholder="Precio">
                <label for="">Agregar</label>
                <input class="form-control" type="text" name="" id="comprarC" placeholder="Cantidad comprada" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                <label for="">Quitar</label>
                <input class="form-control" type="text" name="" id="comprarC" placeholder="Cantidad comprada" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

              </form>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="compraProducto();" data-bs-dismiss="modal">Agregar</button>
            </div>
          </div>
        </div>
      </div>

      <!--Modal para generar reporte-->
      <!-- Modal -->
      <div class="modal fade" id="modalCrearReporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Reporte</h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="Controller/reporteVentaDiaria.php" target="blank" method="GET">

                <input type="hidden" name="usuarioR" id="usuarioR" value="">
                <div class="mb-3">
                  <input type="date" id="fechaReporte" name="fechaReporte" class="form-control" placeholder="Fecha..." aria-label="Recipient's username" aria-describedby="basic-addon2" style="text-transform:uppercase;">
                </div>


                <input type="submit" class="btn btn-danger btn-block" value="GENERAR REPORTE">

              </form>
            </div>
          </div>
        </div>
      </div>


      <?php include('lib/templates/footer.php'); ?>
      <script type="text/javascript">
        //recuperarTotalVendido();
      </script>
      

      <script>
        $(document).ready(function() {
          var funcion = "listar";
          let datatable = $('#tabla').DataTable({

            "ajax": {
              "method": "POST",
              "url": "Controller/cargarVenta.php",
              "dataSrc": ""
            },
            "columns": [{
                "data": "cantidad"
              },
              {
                "data": "codigo"
              },
              {
                "data": "descripcion"
              },
              {
                "data": "precio_publico"
              },
              {
                "data": "total_venta"
              },
              {
                "defaultContent": `<button class="eliminar btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminarVenta"><i class="fas fa-trash-alt"></i></button>

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
              "lengthMenu": "Mostrar _MENU_ registros",
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
            dom: 'Bfrtilp',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success'
              },
              {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger'
              },
              {
                extend: 'print',
                text: '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
              },
            ]

          });
          $('#tabla tbody').on('click', '.eliminar', function() {
            let data = datatable.row($(this).parents()).data();
            $('#iddetalleC').val(data.id);
            $('#idProductoC').val(data.codigo);
            $('#idVentaC').val(data.idventa);
            $('#precioCompraC').val(data.precio_publico);
            $('#comprarC').val(data.cantidad);

          });
          //evento para rebajar producto
          $("#eliminarVenta").click(function(e) {
            e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
            var arg_iddetalleproducto = document.getElementById("iddetalleC").value
            var arg_precio = document.getElementById("precioCompraC").value
            var arg_cantidad = document.getElementById("comprarC").value
            var arg_idproducto = document.getElementById("idProductoC").value
            var arg_idventa = document.getElementById("idVentaC").value
            var url = "Controller/eliminarVenta.php";
            document.getElementById("formEliminarVenta").reset();

            $.ajax({
              type: "post",
              url: url,
              data: {

                iddetalle: arg_iddetalleproducto,
                precio: arg_precio,
                cantidad: arg_cantidad,
                idproducto: arg_idproducto,
                idventa: arg_idventa
              },
              success: function(datos) {
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

<?php } ?>