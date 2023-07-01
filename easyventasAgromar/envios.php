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


if (isset($_GET['eliminar'])) {
  eliminarUsuario($_GET['eliminar']);
}


if (isset($_POST['idEnvioProducto2'])) {
  $idventaProducto2 = $_POST['idEnvioProducto2'];
}

if (!isset($_SESSION['codigo'])) {
  header("location: login.php");
} else {


  require_once('Model/class.conexion.php');
  require_once('Model/class.consultas.php');
  require_once('Controller/cargarDatos.php');
  require_once('Controller/Eliminar.php');
  include('lib/templates/header.php');
  $consultas = new Consultas();
  $inicio = null;
  $registros = null;
  $datos = $consultas->cargarProducto($inicio, $registros);


  if (isset($_GET['eliminar'])) {
    eliminarUsuario($_GET['eliminar']);
  }

  $consultas = new consultas();

  $datos = $consultas->cargarMarca();
  if (!empty($datos)) {
    $marca = array();
    foreach ($datos as $filas) {
      $com = utf8_encode($filas['descripcion']);
      array_push($marca, $com);
    }
  }

  $datos2 = $consultas->cargarProveedor();
  if (!empty($datos2)) {
    $proveedor = array();
    foreach ($datos2 as $filas) {
      $com = utf8_encode($filas['nombre']);
      array_push($proveedor, $com);
    }
  }
  $datos3 = $consultas->cargarUbicacion();
  if (!empty($datos3)) {
    $ubicacion = array();
    foreach ($datos3 as $filas) {
      $com = utf8_encode($filas['descripcion']);
      array_push($ubicacion, $com);
    }
  }
  $idventaProducto = 0;
  if (isset($_POST['idventaProducto2'])) {
    $idventaProducto = $_POST['idventaProducto2'];
  } else {
    $datos4 = $consultas->recuperarEnvioGenerado($pass);

    foreach ($datos4 as $filas) {
      $idventaProducto = $filas['filas'];
    }
  }
  $totalVenta = 0;
  if ($idventaProducto != 0) {
    $datos6 = $consultas->cargarTotalVentasDetalleEnvio($idventaProducto, $pass);
    if (!empty($datos6)) {

      foreach ($datos6 as $filas) {
        $totalVenta = $filas['total'];
      }
    }
  }
?>
  <title>ENVIOS</title>
  </head>

  <body>

    <?php
    $pagina = 2;
    include('lib/templates/nav2.php');

    ?>

    <div class="page-body">
      <div class="container-fluid card shadow mt-2 card-principal-page">
        <!-- Aqui imprimmimos el producto-->
        <div class="content-principal-page">

          <div class="card card-top bg-secondary">
            <div class="media static-top-widget media-body-center">
              <div class="align-self-center text-center"><i data-feather="shopping-bag"></i>
              </div>
              <div class="media-body ">
                <span class="m-0">Envio no.</span>
                <h4 class="mb-0 counter"><span id="idVentaProd"><?php echo $idventaProducto; ?></span></h4>
                <i class="icon-bg" data-feather="shopping-bag"></i>
              </div>
            </div>
          </div>
          <div class="card card-top bg-primary">
            <div class="media static-top-widget media-body-center">
              <div class="align-self-center text-center">
                <span class="iconify" data-width="32px" data-height="32px" data-icon="fa6-solid:q"></span>
              </div>
              <div class="media-body"><span class="m-0">Total.</span>
                <h4 class="mb-0 mr-2 counter"><span id="totalVenta" class="totalVenta"><?php echo $totalVenta; ?></span></h4><i class="icon-bg" data-feather="shopping-cart"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="content-principal-page">
          <div class="table-responsive" style="width: 100%;">
            <div class="verDetalleProducto">
              <button class="btns btn-color-red float-right" id="recuperar_detalle_venta" style="width: 200px;">VER PRODUCTO</button>
            </div>
            <table id="tabla" class="table table-hover table-striped text-primary" style="width:100%">
              <thead>
                <tr class="table-repuesto">
                  <th class="text-light">COD.</th>
                  <th class="text-light">DESCRIPCION</th>
                  <th class="text-light">CANT.</th>
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



    <!-- modal para detalle producto -->

    <!-- Modal -->
    <div class="modal fade" id="modalDetalleProductoEnvio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header-detalle">
            <h5 class="modal-title" id="exampleModalLabel"><span id="tituloProductoE"></span></h5>
            <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="detalles" class="card-repuesto">
              <div class="row">
                <div id="img-flip" class="col-md-5 img-flip">

                </div>
                <div id="card-content-1" class="col-md-7 card-content-1">

                </div>

                <div class="line">

                </div>

                <div id="card-content-2" class="card-content-2">

                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <?php if ($rol == 2) { ?>
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoDetalle">Agregar Detalle</button>
            <?php } ?>
            <button type="button" id="cerrar2" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal para vender producto -->
    <!-- Modal -->
    <div class="modal fade" id="modalVenderProductoEnvio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-light text-center">
            <h5 class="modal-title" id="exampleModalLabel">REBAJAR PRODUCTO ENVIOS</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body card-vender" style="background-color: #f2f1f1 ;">
            <form method="post" id="formVenderEnvio">
              <input type="hidden" name="" id="idventa" value="">
              <input type="hidden" name="" id="idventaProductoE" value="<?php echo $idventaProducto; ?>">
              <input type="hidden" name="" id="iddetalleP" value="">
              <input type="hidden" name="" id="cantidadPr" value="">
              <input type="hidden" name="" id="usuarioventa" value="<?php echo $pass; ?>">
              <div class="md-form">
                <i class="fas fa-pencil-alt prefix"></i>
                <textarea id="DescripcionEnvio" name="DescripcionEnvio" class="md-textarea form-control" rows="2"></textarea>
              </div>
              Precio:
              <div class="input-group">
                <span class="input-group-text bg-secondary"><i class="fab fa-quora"></i></span>
                <input class="form-control" type="number" id="precioVenta" value="" placeholder="Precio">
              </div>

              <div class="input-group">
                <span class="input-group-text bg-secondary"><i class="fas fa-cart-plus"></i></span>
                <input class="form-control" type="number" name="vender" id="vender" placeholder="Cantidad a Vender" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

              </div>
              <div class="input-group">
                <select class="btn btn-info form-control" name="region" id="abono">
                  <option class="dropdown-toggle" value="1">PRODUCTO</option>
                  <option class="dropdown-toggle" value="0">ABONO</option>

                </select>
              </div>
              <div class="selector-group">
                <span class="restar bg-danger"><span class="iconify" data-icon="ant-design:line-outlined" data-width="32"></span></span>
                <span class="sumar bg-primary"><span class="iconify" data-icon="ant-design:plus-outlined" data-width="32"></span></span>
              </div>

              <label class="form-check-label" for="">descuentos</label>
              <div class="col radio_container">
                <div class="m-checkbox-inline">
                  <div class="radio radiio-theme">
                    <input id="descuento1" name="descuento" type="radio">
                    <label for="descuento1">5%</label>
                  </div>
                  <div class="radio radiio-theme">
                    <input id="descuento2" name="descuento" type="radio">
                    <label for="descuento2">7%</label>
                  </div>
                  <div class="radio radiio-theme">
                    <input id="descuento3" name="descuento" type="radio">
                    <label for="descuento3">10%</label>
                  </div>
                  <div class="radio radiio-theme">
                    <input id="descuento4" name="descuento" type="radio">
                    <label for="descuento4">12.5%</label>
                  </div>
                  <div class="radio radiio-theme">
                    <input id="descuento5" name="descuento" type="radio">
                    <label for="descuento5">15%</label>
                  </div>
                </div>
              </div>
            </form>

          </div>
          <div class="modal-footer bg-info">
            <button type="button" id="btnVenderProductoEnvio" class="cerrar btn btn-danger" data-bs-dismiss="modal">Rebajar</button>
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
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
            <button type="button" class="btn btn-danger" onclick="pedirProducto();" data-bs-dismiss="modal">PEDIR</button>
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
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formComprar" class="form form-group">

              <input type="hidden" name="" id="iddetalleC" value="">
              <input type="hidden" name="" id="idproductoC" value="">

              <span class="text-primary">Precio de Compra:</span>
              <div class="input-group-prepend">
                <span class="input-group-text">Q</span>
                <input class="form-control" type="text" id="precioCompraC" value="" placeholder="Precio">
              </div>
              <input class="form-control" type="number" name="" id="comprarC" placeholder="Cantidad comprada" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



            </form>

          </div>
          <div class="modal-footer bg-info">
            <button type="button" class="btn btn-danger" onclick="compraProducto();" data-bs-dismiss="modal">Agregar</button>
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
            <div id="tablaModal" class="table-responsive"></div>

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

              <input type="hidden" name="" id="iddetalleE" value="">

              <input type="hidden" name="" id="idproductoE" value="">

              <input type="hidden" name="" id="idVentaE" value="">
              <LABEL class="btn-danger">REALMENTE QUIERES ELIMINAR ESTA VENTA?</LABEL>

              <input class="form-control" type="hidden" id="precioCompraE" value="" placeholder="Precio">
              <input class="form-control" type="hidden" name="" id="comprarE" placeholder="Cantidad comprada" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="eliminarEnvio();" data-bs-dismiss="modal">ELIMINAR</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal Actualizar venta-->
    <!-- Modal -->
    <div class="modal fade" id="modalActualizarDetalleEnvio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <button type="button" class="cerrar btn btn-danger" onclick="actualizarDetalleEnvio();" data-bs-dismiss="modal">Actualizar</button>
          </div>


        </div>
      </div>
    </div>

  <?php } ?>

  <footer>
    <?php include('lib/templates/footer.php'); ?>
  </footer>
  <script>
    var availableTags = <?= json_encode($marca) ?>;

    $("#marcaInsert").autocomplete({
      appendTo: "#modalNuevoProducto",
      source: availableTags,
      select: function(event, item) {
        var params = {
          equipo: item.item.value
        }
        $.get("Controller/datosMarca.php", params, function(response) {
          var json = JSON.parse(response);

          $("#idMarcaInsert").val(json[0].id);

          var marca = document.getElementById("marcaInsert").value
          if (marca.length > 0) {
            $("#chekMarca").attr("src", "img/check.png");
          } else {
            $("#chekMarca").attr("src", "");
          }




        });
      }
    });
  </script>

  <script>
    var availableTags = <?= json_encode($proveedor) ?>;

    $("#proveedorInsert").autocomplete({
      appendTo: "#modalNuevoProducto",
      source: availableTags,
      select: function(event, item) {
        var params = {
          proveedor: item.item.value
        }
        $.get("Controller/datosProveedor.php", params, function(response) {
          var json = JSON.parse(response);

          $("#idProveedorInsert").val(json[0].id);

          var proveedor = document.getElementById("proveedorInsert").value
          if (proveedor.length > 0) {
            $("#chekProveedor").attr("src", "img/check.png");
          } else {
            $("#chekProveedor").attr("src", "");
          }




        });
      }
    });
  </script>

  <script>
    var availableTags = <?= json_encode($ubicacion) ?>;

    $("#bodegaInsert").autocomplete({
      appendTo: "#modalNuevoProducto",
      source: availableTags,
      select: function(event, item) {
        var params = {
          ubicacion: item.item.value
        }
        $.get("Controller/datosBodega.php", params, function(response) {
          var json = JSON.parse(response);

          $("#idBodegaInsert").val(json[0].id);

          var ubicacion = document.getElementById("bodegaInsert").value
          if (ubicacion.length > 0) {
            $("#chekBodega").attr("src", "img/check.png");
          } else {
            $("#chekBodega").attr("src", "");
          }




        });
      }
    });
  </script>

  <script>
    $(document).ready(function() {
      var funcion = "listar";
      let datatable = $('#tabla').DataTable({

        "bProcessing": true,
        "bDeferRender": true,
        "bServerSide": true,
        "sAjaxSource": "serverside/serversideRepuesto.php",
        "columnDefs": [{
          "targets": -1,
          "defaultContent": `<a class="detalles btn btn-success btn-sm" alt="detalles" title="ver detalles" ><i class="material-icons">read_more</i></a>
          `
        }],

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

        /* responsive: "true",
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
         ]*/

      });
      $('#tabla tbody').on('click', '.actualizar', function() {
        fila = $(this).closest("tr");
        var codigo = fila.find('td:eq(0)').text(); //capturo el ID		            
        var descripcion = fila.find('td:eq(1)').text();
        var cantidad = fila.find('td:eq(2)').text();
        var precio = fila.find('td:eq(3)').text();
        $('#codigopr').val(codigo);
        $('#descripcionpr').val(descripcion);
        $('#cantidadpr').val(cantidad);
        $('#preciopr').val(precio);

      });

      $('#tabla tbody').on('click', '.detalles', function() {
        fila = $(this).closest("tr");
        let codigo = fila.find('td:eq(0)').text(); //capturo el ID		            
        let descripcion = fila.find('td:eq(1)').text();
        let cantidad = fila.find('td:eq(2)').text();
        let precio = fila.find('td:eq(3)').text();
        $('#codigodet').val(codigo);
        $('#precioVentaC').val(precio);
        obtener_detalleProductoEnvio(codigo, descripcion, precio, codigo, <?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');
        $('#modalDetalleProductoEnvio').modal('show');
      });
      $('#tabla tbody').on('click', '.detalles3', function() {
        let data = datatable.row($(this).parents()).data();

        recuperarDatosEnvio(data.usuario, data.idventa, data.estado);



      });
      //evento para rebajar producto
      $("#comprarProducto").click(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página


        var arg_iddetalleproducto = document.getElementById("iddetalleC").value
        var arg_precio = document.getElementById("precioCompraC").value
        var arg_cantidad = document.getElementById("comprarC").value
        var arg_idproducto = document.getElementById("idproductoC").value
        var arg_precioVenta = document.getElementById("precioVentaC").value
        var url = "Controller/compras.php";
        document.getElementById("formComprar").reset();

        $.ajax({
          type: "post",
          url: url,
          data: {

            iddetalle: arg_iddetalleproducto,
            precio: arg_precio,
            cantidad: arg_cantidad,
            idproducto: arg_idproducto,
            precioVenta: arg_precioVenta
          },
          success: function(datos) {
            datatable.ajax.reload(null, false);
            $('#comprarC').val('');
            alertify.success(datos);


          }
        });
      });

      //evento para actualizar producto
      $("#ActualizarProducto").click(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        var arg_id = document.getElementById("idpr").value
        var arg_codigo = document.getElementById("codigopr").value
        var arg_descripcion = document.getElementById("descripcionpr").value
        var arg_cantidad = document.getElementById("cantidadpr").value
        var arg_precio = document.getElementById("preciopr").value
        var url = "Controller/actualizarProducto.php";
        document.getElementById("formAcpr").reset();
        $.ajax({
          type: "post",
          url: url,
          data: {
            id: arg_id,
            codigo: arg_codigo,
            descripcion: arg_descripcion,
            cantidad: arg_cantidad,
            precio: arg_precio
          },
          success: function(datos) {
            datatable.ajax.reload(null, false);
            alertify.success(datos);
          }
        });
      });

      $(".cerrar").click(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página



        var url = "";

        $.ajax({
          type: "post",
          url: url,
          data: {

          },
          success: function(datos) {
            datatable.ajax.reload(null, false);
          }
        });
      });

      $("#cerrar2").click(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página



        var url = "";

        $.ajax({
          type: "post",
          url: url,
          data: {

          },
          success: function(datos) {
            datatable.ajax.reload(null, false);
          }
        });
      })
      //fin de document ready
    });

    //metodos para detalle venta
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
    btnRecuperarVenta = document.querySelector('#recuperar_detalle_venta');
    btnRecuperarVenta.onclick = async () => {
      var arg_idventa = document.getElementById('idventaProductoE').value
      var arg_usuario = document.getElementById('usuarioventa').value
      recuperarDatosEnvio(arg_usuario, arg_idventa, '0');
      $('#modalDetalleProducto').modal('show');
    }
    //rebajar productos
    $btnVenderE = document.querySelector("#btnVenderProductoEnvio");
    $btnVenderE.onclick = async () => {
      var arg_cantidad = document.getElementById("cantidadPr").value
      var arg_Venta = document.getElementById("vender").value
      var arg_idventa = document.getElementById("idventa").value
      var arg_iddetalleproducto = document.getElementById("iddetalleP").value
      var arg_usuario = document.getElementById("usuarioventa").value
      var arg_precio = document.getElementById("precioVenta").value
      var arg_idventaProducto = document.getElementById("idventaProductoE").value
      var arg_DescripcionProducto = document.getElementById('DescripcionEnvio').value
      var arg_abono = document.getElementById("abono").value

      var arg_descuento = "";
      if (document.getElementById('descuento1').checked) {
        arg_descuento = 0.05;
        document.getElementById('descuento1').checked = false;
      }
      if (document.getElementById('descuento2').checked) {
        arg_descuento = 0.07;
        document.getElementById('descuento2').checked = false;
      }
      if (document.getElementById('descuento3').checked) {
        arg_descuento = 0.10;
        document.getElementById('descuento3').checked = false;
      }
      if (document.getElementById('descuento4').checked) {
        arg_descuento = 0.125;
        document.getElementById('descuento4').checked = false;
      }
      if (document.getElementById('descuento5').checked) {
        arg_descuento = 0.15;
        document.getElementById('descuento5').checked = false;
      }

      const datos = {
        descuento: arg_descuento,
        existencia: arg_cantidad,
        idventa: arg_idventa,
        venta: arg_Venta,
        iddetalle: arg_iddetalleproducto,
        usuario: arg_usuario,
        idventaProducto: arg_idventaProducto,
        precio: arg_precio,
        descripcion: arg_DescripcionProducto,
        abono: arg_abono
      };
      const datosCodificados = JSON.stringify(datos);
      const url = "Controller/venderProductoEnvio.php";
      const respuestaRaw = await fetch(url, {
        method: "POST",
        body: datosCodificados
      });
      const respuesta = await respuestaRaw.json();

      if (respuesta === "1") {
        var nombreVenta = document.getElementById("vender");
        nombreVenta.value = "";
        document.getElementById("abono").selectedIndex = 0;
        $('#idventaProducto').val(arg_idventaProducto);
        recuperarTotalVentaEnvio(arg_usuario, arg_idventaProducto);
        $('#modalDetalleProductoEnvio').modal('hide');
        Swal.fire({
          position: 'button-end',
          icon: 'success',
          title: 'producto con exito',
          showConfirmButton: false,
          timer: 2500
        })
      } else if (respuesta === "2") {
        Swal.fire({
          position: 'button-end',
          icon: 'error',
          title: 'no tienes producto para rebajar existencia ' + arg_cantidad,
          showConfirmButton: false,
          timer: 2500
        })
      } else if (respuesta === "3") {
        Swal.fire({
          position: 'button-end',
          icon: 'error',
          title: 'Debes generar una venta',
          showConfirmButton: false,
          timer: 2500
        })
      } else if (respuesta === "4") {
        Swal.fire({
          position: 'button-end',
          icon: 'error',
          title: 'Debes colocar una cantidad a vender',
          showConfirmButton: false,
          timer: 2500
        })
      } else if (respuesta === "5") {
        Swal.fire({
          position: 'button-end',
          icon: 'error',
          title: 'Hubo un error al ingresar la venta',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          position: 'button-end',
          icon: 'error',
          title: 'Hubo un error en la bd',
          showConfirmButton: false,
          timer: 2500
        })
      }
    }
  </script>
  </body>

  </body>

  </html>