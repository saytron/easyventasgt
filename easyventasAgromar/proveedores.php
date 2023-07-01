<?php
error_reporting(E_ALL ^ E_NOTICE);
if (!isset($_SESSION)) {

  session_start();
}
if (isset($_SESSION['codigo'])){$pass = $_SESSION['codigo'];}
if (isset($_SESSION['usuario'])){$usuario = $_SESSION['usuario'];}
if (isset($_SESSION['rol'])){$rol = $_SESSION['rol'];}

if (isset($_GET['idVenta'])){$idVenta = $_GET['idVenta'];}


if (isset($_GET['eliminar'])) {
  eliminarUsuario($_GET['eliminar']);
}



if (isset($_POST['idventaProducto2'])){$idventaProducto2 = $_POST['idventaProducto2'];}


if (!isset($_SESSION['codigo'])) {
  header("location: login.php");
} else {


  require_once('Model/class.conexion.php');
  require_once('Model/class.consultas.php');
  require_once('Controller/cargarDatos.php');
  require_once('Controller/Eliminar.php');
  include('lib/templates/header.php');
?>
  <title>PROVEEDORES</title>
  </head>

  <body>
    <header>

    </header>
    <?php
    $pagina = 0;
    include('lib/templates/nav2.php');
    ?>



    <div class="page-body">
      <div class="container-fluid card shadow mt-2 card-principal-page">
        <!-- Aqui imprimmimos el producto-->



        <div class="content-principal-page mt-4">

          <div class="table-responsive" style="width: 100%;">
            <table id="proveedores" class="table table-sm table-hover table-striped table-bordered table-condensed" style="width:100%">
              <thead>
                <tr class="bg-primary">
                  <th class="text-light">NIT</th>
                  <th class="text-light">PROVEEDOR</th>
                  <th class="text-light">DIRECCION</th>
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

    <!-- modal para nuevo detalle -->

    <!-- Modal -->
    <div class="modal fade" id="modalNuevoDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Detalle</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
            <button type="button" class="btn btn-primary" onclick="guardar_detalleProducto();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal para actualizar detalle -->

    <!-- Modal -->
    <div class="modal fade" id="modalActualizarDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Detalle</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="actualizar_detalleProducto();" data-bs-dismiss="modal">ACTUALIZAR</button>
          </div>
        </div>
      </div>
    </div>


    <!-- modal para edicion de registros -->

    <!-- Modal -->
    <div class="modal fade" id="modalActualizarEmpleado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modificar Empleado</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formActualizarEmpleado">
              <input type="hidden" id="idEmpleadou">
              <input class="form-control input-sm" type="text" name="" id="nombreu">
              <input class="form-control input-sm" type="text" id="direccionu" placeholder="Direccion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <input class="form-control input-sm" type="text" id="nacimientou" placeholder="NACIMIENTO">



            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="Actualizar_Empleado();" data-bs-dismiss="modal">Actualizar</button>
          </div>
        </div>
      </div>
    </div>

    <!--Modal para insertar proveedor -->
    <!-- Modal -->
    <div class="modal fade" id="modalNuevoProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Proveedor</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="insertar_proveedor();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>


    <!--Modal para insertar bodega -->
    <!-- Modal -->
    <div class="modal fade" id="modalNuevaBodega" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nueva Ubicacion</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formBodega">
              <input class="form-control" type="text" name="descripcionbd" id="descripcionbd" placeholder="Ingresa la bodega" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="insertar_bodega();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>

    <!--Modal para crear marca -->
    <!-- Modal -->
    <div class="modal fade" id="modalNuevaMarca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nueva Marca</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formMarca">
              <input class="form-control" type="text" name="descripcionMarca" id="descripcionMarca" placeholder="Ingresa la Marca" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="enviar_marca();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal para nuevo Producto -->

    <!-- Modal -->
    <div class="modal fade" id="modalNuevoProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Producto</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formProducto">
              <input class="form-control" type="text" id="codigoP" placeholder="Codigo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <input class="form-control" type="text" id="descripcionP" placeholder="Descripcion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <input class="form-control" type="text" id="cantidadP" value="" placeholder="Cantidad">
              <input class="form-control" type="text" id="precioP" value="" placeholder="Precio">

              <div class="btn-group btn-lg btn-block">
                <select class="btn btn-primary btn-lg btn-block" name="region" id="marcaP">
                  <option class="dropdown-toggle" value="">Marca</option>
                  <?php
                  cargarMarca();

                  ?>
                </select>
              </div>
              <select class="btn btn-primary btn-lg btn-block" name="region" id="proveedorP">
                <option class="dropdown-toggle" value="">proveedor</option>
                <?php
                cargarProveedor();
                ?>
              </select>
              <select class="btn btn-primary btn-lg btn-block" name="region" id="bodegaP">
                <option class="dropdown-toggle" value="">bodega</option>
                <?php
                cargarUbicacion();

                ?>
              </select>
              <input class="form-control input-sm" type="text" id="precioCP" placeholder="Precio de Compra" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <input class="form-control input-sm" type="hidden" id="usuarioP" value="<?php echo $pass; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="guardar_repuesto();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal para actualizar producto -->

    <!-- Modal -->
    <div class="modal fade" id="modalActualizarProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Producto</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formAcpr">
              <input class="form-control" type="hidden" id="idpr" placeholder="">
              CODIGO:<input class="form-control" type="text" id="codigopr" placeholder="Codigo" style="text-transform:uppercase;" disabled>
              DESCRIPCION:<input class="form-control" type="text" id="descripcionpr" placeholder="descripcion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              CANTIDAD:<input class="form-control" type="text" id="cantidadpr" placeholder="cantidad">
              PRECIO:<input class="form-control" type="text" id="preciopr" placeholder="precio">



            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="ActualizarProducto();" data-bs-dismiss="modal">Actualizar</button>
          </div>
        </div>
      </div>
    </div>

    <!--Modal para vender producto -->
    <!-- Modal -->
    <div class="modal fade" id="modalVenderProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">vender</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
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

              <input class="form-control" type="number" name="vender" id="vender" placeholder="Cantidad a Vender" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <p>
                <label class="form-check-label" for="">descuentos</label>
                <br>
                <input type="radio" id="descuento" name="descuento" value="0.05">
                <label class="form-check-label" for="descuento">5%</label>
                <br>
                <input type="radio" id="descuento" name="descuento" value="0.07">
                <label class="form-check-label" for="descuento">7%</label>
                <br>
                <input type="radio" id="descuento" name="descuento" value="0.10">
                <label class="form-check-label" for="descuento">10%</label>
                <br>
                <input type="radio" id="descuento" name="descuento" value="0.15">
                <label for="descuento">15%</label>
              </p>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="venderProducto();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>

    <!--Modal para pedir producto -->
    <!-- Modal -->
    <div class="modal fade" id="modalPedirProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">PEDIR PRODUCTO</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formPedir">
              <input type="text" name="" id="idproducto" value="">

              <input class="form-control" type="number" name="pedir" id="pedir" placeholder="Cantidad a Pedir" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="pedirProducto();" data-bs-dismiss="modal">Agregar</button>
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
            <h5 class="modal-title" id="exampleModalLabel">COMPRAS</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formComprar">

              <input type="hidden" name="" id="iddetalleC" value="">
              <input type="hidden" name="" id="idproductoC" value="">

              Precio de Compra:
              <input class="form-control" type="text" id="precioCompraC" value="" placeholder="Precio">
              <input class="form-control" type="number" name="" id="comprarC" placeholder="Cantidad comprada" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="compraProducto();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>

  <footer>
    <?php include('lib/templates/footer.php'); ?>
  </footer>

  <script>
    $(document).ready(function() {
      var funcion = "listar";
      let datatable = $('#proveedores').DataTable({
        "bProcessing": true,
        "bDeferRender": true,
        "bServerSide": true,
        "sAjaxSource": "serverside/serversideProveedor.php",
        "columnDefs": [{
          "targets": -1,

          "defaultContent": `
          <a class="detalles btn btn-success btn-sm" alt="detalles" title="ver detalles" ><i class="material-icons">read_more</i></a>
          
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
      $('#proveedores tbody').on('click', '.detalles', function() {
        fila = $(this).closest("tr");
        let codigo = fila.find('td:eq(0)').text(); //capturo el ID		            
        window.location.href = "./pedidos.php?proveedor=" + codigo;


      });
    });
  </script>
  </body>

  </html>