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
if (isset($_POST['idventaProducto2'])) {
  $idventaProducto2 = $_POST['idventaProducto2'];
}

if (isset($_GET['num'])) {
  $num = $_GET['num'];
}


if (isset($_GET['eliminar'])) {
  eliminarUsuario($_GET['eliminar']);
}



if (!isset($_SESSION['codigo'])) {
  header("location: login.php");
} else {


  require_once('Model/class.conexion.php');
  require_once('Model/class.consultas.php');
  require_once('Controller/cargarDatos.php');
  require_once('Controller/Eliminar.php');
  include('lib/templates/header.php');
  $consultas = new consultas();
  $datos = $consultas->cargarMarca();
  $marca = array();
  foreach ($datos as $filas) {
    $com = utf8_encode($filas['descripcion']);
    array_push($marca, $com);
  }
  $datos2 = $consultas->cargarProveedor();
  $proveedor = array();
  foreach ($datos2 as $filas) {
    $com = utf8_encode($filas['nombre']);
    array_push($proveedor, $com);
  }

  $datos3 = $consultas->cargarUbicacion();
  $ubicacion = array();
  foreach ($datos3 as $filas) {
    $com = utf8_encode($filas['descripcion']);
    array_push($ubicacion, $com);
  }
  $idventaProducto = 0;
  if (isset($_POST['idventaProducto2'])) {
    $idventaProducto = $_POST['idventaProducto2'];
  } else {
    $datos4 = $consultas->recuperarVentaGenerada2($pass);
    foreach ($datos4 as $filas) {
      if ($filas['filas'] != NULL) {
        $idventaProducto = $filas['filas'];
      }
    }
  }

  $datos6 = $consultas->cargarTotalVentasDetalle($idventaProducto, $pass);
  $totalVenta = 0;
  foreach ($datos6 as $filas) {
    $totalVenta = $filas['total'];
  }
?>
  <title>COTIZACION</title>
  </head>

  <body>
    <header>

    </header>
    <?php
    $pagina = 3;
    include('lib/templates/nav2.php');
    ?>

    <div class="page-body">
      <div class="container-fluid card shadow mt-2 card-principal-page">
        <div class="content-principal-page">

          <div class="card-top bg-secondary">
            <div class="media static-top-widget media-body-center">
              <div class="align-self-center text-center"><i data-feather="shopping-bag"></i>
              </div>
              <div class="media-body ">
                <span class="m-0">Cotización no.</span>
                <h4 class="mb-0 counter"><span id="idVentaProdCot"><?php echo $idventaProducto; ?></span></h4><i class="icon-bg" data-feather="shopping-bag"></i>
              </div>
            </div>
          </div>
          <div class="card-top bg-primary">
            <div class="media static-top-widget media-body-center">
              <div class="align-self-center text-center">
                <span class="iconify" data-width="32px" data-height="32px" data-icon="fa6-solid:q"></span>
              </div>
              <div class="media-body"><span class="m-0">Total.</span>
                <h4 class="mb-0 mr-2 counter"><span id="totalVentaCot" class="totalVenta"><?php echo $totalVenta; ?></span></h4><i class="icon-bg" data-feather="shopping-cart"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="content-principal-page">
          <div class="verDetalleProducto">
            <button class="btn btn-danger" id="recuperar_detalle_venta2" style="width: 200px;">VER PRODUCTO</button>

          </div>
        </div>
        <!-- Aqui imprimmimos el producto-->

        <div class="content-principal-page">
          <div class="table-responsive" style="width: 100%;">

            <table id="tabla" class="table table-sm table-hover table-striped table-bordered text-primary " style="width:100%">
              <thead>
                <tr class="bg-success">
                  <th class="text-light">CODIGO</th>
                  <th class="text-light">DESCRIPCION</th>
                  <th class="text-light">CANTIDAD</th>
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
    <div class="modal fade" id="modalDetalleProductoCotizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header-detalle ">
            <h5 class="" id="exampleModalLabel"><label for="" name="tituloProducto" id="tituloProducto"></label></h5>
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
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoDetalleCotizar">Agregar Detalle</button>
            <?php } ?>
            <button type="button" id="cerrar2" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal para nuevo detalle -->

    <!-- Modal -->
    <div class="modal fade" id="modalNuevoDetalleCotizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <input type="text" name="" id="posisiondet" value="<?php echo $num; ?>">
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
          <div class="modal-header bg-success text-light">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO DETALLE</h5>
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
          <div class="modal-footer bg-info">
            <button type="button" class="btn btn-danger" onclick="actualizar_detalleProducto();" data-bs-dismiss="modal">ACTUALIZAR</button>
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
          <div class="modal-footer bg-info">
            <button type="button" class="btn btn-danger" onclick="insertar_proveedor();" data-bs-dismiss="modal">Agregar</button>
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
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formBodega">
              <input class="form-control" type="text" name="descripcionbd" id="descripcionbd" placeholder="Ingresa la bodega" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



            </form>

          </div>
          <div class="modal-footer bg-info">
            <button type="button" class="btn btn-danger" onclick="insertar_bodega();" data-bs-dismiss="modal">Agregar</button>
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
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formMarca">
              <input class="form-control" type="text" name="descripcionMarca" id="descripcionMarca" placeholder="Ingresa la Marca" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



            </form>

          </div>
          <div class="modal-footer bg-info">
            <button type="button" class="btn btn-danger" onclick="enviar_marca();" data-bs-dismiss="modal">Agregar</button>
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
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formProducto">
              <input class="form-control" type="text" id="codigoP" placeholder="Codigo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <input class="form-control" type="text" id="descripcionP" placeholder="Descripcion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <input class="form-control" type="text" id="cantidadP" value="" placeholder="CANTIDAD">
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
            <button type="button" class="btn btn-danger" id="guardar_repuesto" data-bs-dismiss="modal">Agregar</button>
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
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?php if ($rol == 2) { ?>
            <div class="modal-body">

              <form method="post" id="formAcpr">
                <input class="form-control" type="hidden" id="idpr" placeholder="">
                CODIGO:<input class="form-control" type="text" id="codigopr" placeholder="Codigo" style="text-transform:uppercase;" disabled>
                DESCRIPCION:<input class="form-control" type="text" id="descripcionpr" placeholder="descripcion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                CANTIDAD:<input class="form-control" type="text" id="cantidadpr" placeholder="cantidad">
                PRECIO:<input class="form-control" type="text" id="preciopr" placeholder="precio">



              </form>
            </div>
            <div class="modal-footer bg-info">
              <button type="button" class="btn btn-danger" id="ActualizarProducto" data-bs-dismiss="modal">Actualizar</button>
            </div>
          <?php } else {
          ?>
            <p class="text-dagner">
              <center>
                <h3>No tienes privilegios para modificar</h3>
              </center>
            </p>
          <?php
          } ?>
        </div>
      </div>
    </div>

    <!--Modal para vender producto -->
    <!-- Modal -->
    <div class="modal fade" id="modalVenderProducto_Cotizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-light text-center">
            <h5 class="modal-title" id="exampleModalLabel">REBAJAR PRODUCTO</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body card-vender" style="background-color: #f2f1f1 ;">
            <form method="post" id="formVender">
              <input type="hidden" name="" id="paginaCotizar" value="3">
              <input type="hidden" name="" id="idventa" value="">
              <input type="hidden" name="" id="idventaProductoCot" value="<?php echo $idventaProducto; ?>">
              <input type="hidden" name="" id="iddetalleP" value="">
              <input type="hidden" name="" id="cantidadPr" value="">
              <input type="hidden" name="" id="usuarioventa" value="<?php echo $pass; ?>">
              <div class="md-form">
                <i class="fas fa-pencil-alt prefix"></i>
                <textarea id="DescripcionCot" name="DescripcionCot" class="md-textarea form-control" rows="3"></textarea>
              </div>
              Precio:
              <div class="input-group">
                <span class="input-group-text bg-secondary"><i class="fas fa-cart-plus"></i></span>
                <input class="form-control" type="text" id="precioVenta" value="" placeholder="Precio">


              </div>
              <div class="input-group">
                <span class="input-group-text bg-secondary"><i class="fas fa-cart-plus"></i></span>

                <input class="form-control" type="number" name="vender" id="vender" placeholder="Cantidad a Vender" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
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
            <button type="button" class="btn btn-danger" id="venderProductoCotizar" data-bs-dismiss="modal">Agregar</button>
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
            <button type="button" class="btn btn-danger" id="comprarProducto" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>

    <!--Modal ver producto-->
    <!-- Modal -->
    <div class="modal fade" id="modalDetalleVenta2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

            <a href="verFactura" class="btn btn-primary">IR A FACTURACION</a>
            <button class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>

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
  <?php } ?>

  <footer>
    <?php include('lib/templates/footer.php'); ?>
  </footer>
  <script>
    $(document).ready(function() {
      var funcion = "listar";
      let datatable = $('#tabla').DataTable({

        "ajax": {
          "method": "POST",
          "url": "Controller/cargarProducto.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "precio"
          },
          {
            "defaultContent": `
          <a class="detalles btn btn-danger btn-sm" alt="detalles" title="ver detalles" ><i class="material-icons">read_more</i></a>          
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
      $('#tabla tbody').on('click', '.actualizar', function() {
        let data = datatable.row($(this).parents()).data();
        $('#codigopr').val(data.codigo);
        $('#descripcionpr').val(data.descripcion);
        $('#cantidadpr').val(data.cantidad);
        $('#preciopr').val(data.precio);

      });


      $('#tabla tbody').on('click', '.detalles', function() {
        let data = datatable.row($(this).parents()).data();
        document.getElementById("tituloProducto").innerHTML = data.descripcion;
        $('#codigodet').val(data.codigo);
        $('#precioVentaC').val(data.precio);
        document.getElementById("vender").vualue = ""
        obtener_detalleProductoCotizar(data.codigo, data.descripcion, data.precio, data.codigo, <?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>', data.marca);
        $('#modalDetalleProductoCotizar').modal('show');
      });
      //evento para rebajar producto
      $("#comprarProducto").click(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página


        var arg_iddetalleproducto = document.getElementById("iddetalleC").value
        var arg_precio = document.getElementById("precioCompraC").value
        var arg_cantidad = document.getElementById("comprarC").value
        var arg_idproducto = document.getElementById("idproductoC").value
        var url = "Controller/compras.php";
        document.getElementById("formComprar").reset();

        $.ajax({
          type: "post",
          url: url,
          data: {

            iddetalle: arg_iddetalleproducto,
            precio: arg_precio,
            cantidad: arg_cantidad,
            idproducto: arg_idproducto
          },
          success: function(datos) {
            datatable.ajax.reload(null, false);
            $('#comprarC').val('');
            alertify.success(datos);


          }
        });
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

      btnRecuperarVenta2 = document.querySelector('#recuperar_detalle_venta2');
      btnRecuperarVenta2.onclick = async () => {
        var arg_idventa = document.getElementById('idventaProductoCot').value
        var arg_usuario = document.getElementById('usuarioP').value
        recuperarDatosVenta(arg_usuario, arg_idventa, '0');
        $('#modalDetalleVenta2').modal('show');
      }
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
      //evento para agregar producto
      $("#guardar_repuesto").click(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        var arg_codigo = document.getElementById("codigoP").value
        var arg_descripcion = document.getElementById("descripcionP").value
        var arg_cantidad = document.getElementById("cantidadP").value
        var arg_precio = document.getElementById("precioP").value
        var arg_marca = document.getElementById("marcaP").value

        var arg_proveedor = document.getElementById("proveedorP").value
        var arg_ubicacion = document.getElementById("bodegaP").value
        var arg_usuario = document.getElementById("usuarioP").value
        var arg_precio_compra = document.getElementById("precioCP").value



        var url = "Controller/insertarRepuesto.php";
        document.getElementById("formProducto").reset();

        $.ajax({
          type: "post",
          url: url,
          data: {
            codigo: arg_codigo,
            descripcion: arg_descripcion,
            cantidad: arg_cantidad,
            precio: arg_precio,
            marca: arg_marca,

            proveedor: arg_proveedor,
            ubicacion: arg_ubicacion,
            usuario: arg_usuario,
            precioR: arg_precio_compra

          },
          success: function(datos) {
            datatable.ajax.reload(null, false);
            alertify.success(datos);
          }
        });
      })
      //fin de document ready
    });

    //rebajar producto 
    $btnVenderCotizar = document.querySelector("#venderProductoCotizar");
    $btnVenderCotizar.onclick = async () => {
      var arg_pagina = document.getElementById("paginaCotizar").value
      var arg_cantidad = document.getElementById("cantidadPr").value
      var arg_Venta = document.getElementById("vender").value
      var arg_idventa = document.getElementById("idventa").value
      var arg_iddetalleproducto = document.getElementById("iddetalleP").value
      var arg_usuario = document.getElementById("usuarioventa").value
      var arg_precio = document.getElementById("precioVenta").value
      var arg_idventaProducto = document.getElementById("idventaProductoCot").value
      var arg_DescripcionProducto = document.getElementById('DescripcionCot').value
      var arg_descuento = "";
      if (document.getElementById('descuento1').checked) {
        arg_descuento = 0.05;
      }
      if (document.getElementById('descuento2').checked) {
        arg_descuento = 0.07;
      }
      if (document.getElementById('descuento3').checked) {
        arg_descuento = 0.10;
      }
      if (document.getElementById('descuento4').checked) {
        arg_descuento = 0.125;
      }
      if (document.getElementById('descuento5').checked) {
        arg_descuento = 0.15;
      }

      const datos = {
        descuento: arg_descuento,
        existencia: arg_cantidad,
        idventa: arg_idventa,
        venta: arg_Venta,
        iddetalle: arg_iddetalleproducto,
        usuario: arg_usuario,
        idventaProducto: arg_idventaProducto,
        descripcion: arg_DescripcionProducto,
        precio: arg_precio,
        pagina: arg_pagina
      };
      const datosCodificados = JSON.stringify(datos);
      const url = "Controller/cotizarProducto.php";
      const respuestaRaw = await fetch(url, {
        method: "POST",
        body: datosCodificados
      });
      const respuesta = await respuestaRaw.json();

      if (respuesta === "1") {
        var IdVenta = document.getElementById("idventaProductoCot");
        IdVenta.value = arg_idventaProducto;
        var nombreVenta = document.getElementById("vender");
        nombreVenta.value = "";

        recuperarTotalVentaCotizar(arg_usuario, arg_idventaProducto);
        $('#modalDetalleProductoCotizar').modal('hide');
        Swal.fire({
          position: 'button-end',
          icon: 'success',
          title: 'producto rebajado con exito',
          showConfirmButton: false,
          timer: 2500
        })
      } else if (respuesta === "2") {
        Swal.fire({
          position: 'button-end',
          icon: 'error',
          title: 'Debes generar una cotizacion',
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
      } else if (respuesta === "3") {
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

  </html>