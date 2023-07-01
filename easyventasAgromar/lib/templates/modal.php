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
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-light">
        <h5 class="modal-title" id="exampleModalLabel">NUEVO PRODUCTO</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formProducto" enctype="multipart/form-data" class="needs-validation" novalidate>
          <div class="mb-2">
            <input class="form-control" type="text" id="codigoP" name="codigoP" placeholder="Codigo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
          </div>
          <div class="md-form mb-3">
            <i class="fas fa-pencil-alt prefix"></i>
            <textarea id="descripcionP" name="descripcionP" class="md-textarea form-control" rows="1" placeholder="DESCRIPCION" style="text-transform:uppercase;"></textarea>
          </div>
          <div class="mb-3">
            <input class="form-control" type="number" id="cantidadP" name="cantidadP" value="" placeholder="CANTIDAD">
          </div>
          <div class="mb-3">
            <input class="form-control" type="number" id="precioP" name="precioP" value="" placeholder="PRECIO AL PUBLICO">
          </div>

          <div class="mb-3 input-group">
            <input type="text" id="marcaInsert" name="marcaInsert" class="form-control" placeholder="Marca..." aria-label="Recipient's username" aria-describedby="basic-addon2" style="text-transform:uppercase;">
            <span class="input-group-text"><img width="20px" src="" id="chekMarca" alt=""></span>
            <input id="idMarcaInsert" name="idMarcaInsert" type="hidden">
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text" style="width: 40%;">TIPO DE PRODUCTO</span>
            <select class="btn btn-primary" name="region" id="tipoProducto" style="width: 60%;">
              <option class="dropdown-toggle" value="B">BIEN</option>
              <option class="dropdown-toggle" value="S">SERVICIO</option>
            </select>

          </div>

          <div class="mb-3 input-group">
            <input type="text" id="proveedorInsert" name="proveedorInsert" class="form-control" placeholder="Proveedor..." aria-label="Recipient's username" aria-describedby="basic-addon2" style="text-transform:uppercase;">
            <span class="input-group-text"><img width="20px" src="" id="chekProveedor" alt=""></span>
            <input id="idProveedorInsert" name="idProveedorInsert" type="hidden">
          </div>

          <div class="mb-3 input-group">
            <input type="text" id="bodegaInsert" name="bodegaInsert" class="form-control" placeholder="Bodega..." aria-label="Recipient's username" aria-describedby="basic-addon2" style="text-transform:uppercase;">
            <span class="input-group-text"><img width="20px" src="" id="chekBodega" alt=""></span>
            <input id="idBodegaInsert" name="idBodegaInsert" type="hidden">
          </div>
          <div class="mb-3">
            <input class="form-control input-sm" type="number" id="precioCP" name="precioCP" placeholder="Precio de Compra">
            <input class="form-control input-sm" type="hidden" id="usuarioP" name="usuarioP" value="<?php echo $pass; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
          </div>
          <div class="mb-2">
            <input type="file" id="imagenProducto" name="imagenProducto" class="form-control" size="512" placeholder="Imagen">
          </div>
          <div class="modal-footer bg-info">
            <button type="button" class="btn btn-danger" id="cerrar" onclick="return guardar_repuesto(this.form);">Agregar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- modal para detalle producto -->


<!-- Modal -->
<div class="modal fade" id="modalDetalleProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header modal-header-detalle ">
        <h5 class="" id="exampleModalLabel"><label for="" name="tituloProducto" id="tituloProducto"></label></h5>
        <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body  ">

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
      <div class="modal-footer modal-footer-detalle">
        <?php if ($rol == 2) { ?>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoDetalle" data-bs-dismiss="modal" alt="Agregar Detalle" title="Agregar Detalle"><i class="material-icons">queue</i></button>
        <?php } ?>
        <button type="button" id="cerrar2" class="btn btn-danger" data-bs-dismiss="modal" alt="cancelar" title="cancelar"><i class="material-icons">cancel</i></button>
      </div>
    </div>
  </div>
</div>

<!-- modal para nuevo detalle -->

<!-- Modal -->
<div class="modal fade" id="modalNuevoDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Detalle</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formDetalle">
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
        <button type="button" id="cerrar" class="btn btn-primary" onclick="guardar_detalleProducto();" data-bs-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div>
<!-- modal para actualizar detalle -->

<!-- Modal -->
<div class="modal fade" id="modalActualizarDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-light">
        <h5 class="modal-title" id="exampleModalLabel">ACTUALIZAR DETALLE</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" id="formActualizarDetalle">
          <input type="hidden" id="codigoProductoDetalle">
          <input type="hidden" name="" id="posicionAcDet" value="<?php echo $num; ?>">
          <input class="form-control input-sm" type="hidden" id="codigoAcDet" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
          <input type="hidden" id="oldBodega" class="form-control" value="">
          <div class="mb-3 input-group">
            <input type="text" id="proveedorInsert2" name="proveedorInsert2" class="form-control" placeholder="Proveedor..." aria-label="Recipient's username" aria-describedby="basic-addon2" style="text-transform:uppercase;">
            <span class="input-group-text"><img width="20px" src="" id="chekProveedor2" alt=""></span>
            <input id="proveedorId" name="proveedorId" type="hidden">
          </div>

          <div class="mb-3 input-group">
            <input type="text" id="bodegaInsert2" name="bodegaInsert2" class="form-control" placeholder="Bodega..." aria-label="Recipient's username" aria-describedby="basic-addon2" style="text-transform:uppercase;">
            <span class="input-group-text"><img width="20px" src="" id="chekBodega2" alt=""></span>
            <input id="bodegaId" name="bodegaId" type="hidden">
          </div>

          <span class="text-dark">Cantidad</span>
          <input class="form-control input-sm" type="text" id="cantidadAcDet" placeholder="Cantidad" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

          <span class="text-dark">Precio de compra</span>
          <input class="form-control input-sm" type="text" id="precioAcDet" placeholder="Precio de Compra" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
          <input class="form-control input-sm" type="hidden" id="usuarioAcDet" value="<?php echo $pass; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">


      </div>
      <div class="modal-footer bg-info">
        <button type="button" id="cerrar2" class="cerrar btn btn-danger" onclick="actualizar_detalleProducto();" data-bs-dismiss="modal">ACTUALIZAR</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- modal para actualizar producto -->

<!-- Modal -->
<div class="modal fade" id="modalActualizarProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-light">
        <h5 class="modal-title" id="exampleModalLabel">ACTUALIZAR PRODUCTO</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php if ($rol == 2) { ?>
        <div class="modal-body">

          <form method="post" id="formActualizarProducto" enctype="multipart/form-data" class="needs-validation" novalidate>

            <span class="text-dark">CODIGO:</span><input class="form-control" type="text" id="codigopr" name="codigopr" placeholder="Codigo" style="text-transform:uppercase;" readonly>
            <div class="md-form">
              <i class="fas fa-pencil-alt prefix"></i>
              <textarea id="descripcionpr" name="descripcionpr" class="md-textarea form-control" rows="3" style="text-transform:uppercase;"></textarea>
            </div>
            <span class="text-dark">CANTIDAD:</span> <input class="form-control" type="text" id="cantidadpr" name="cantidadpr" placeholder="cantidad" readonly>
            <span class="text-dark">PRECIO:</span><input class="form-control" type="text" id="preciopr" name="preciopr" placeholder="precio">


            <div class="mb-1">
              <input type="hidden" id="imagenProductoE" name="imagenProductoE" class="form-control" size="512" placeholder="Imagen">

            </div>
            <div class="mb-1">
              <span class="form-control">Cambiar Imagen</span>
              <input type="file" id="imagenProductoEdit" name="imagenProductoEdit" class="form-control" size="512" placeholder="Imagen">

            </div>
        </div>
        <div class="modal-footer bg-info">
          <button type="button" class="cerrar btn btn-danger" onclick="return actualizar_productoE(this.form);" data-bs-dismiss="modal">Actualizar</button>
        </div>
        </form>
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
<div class="modal fade" id="modalVenderProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-detalle">
        <h5 class="modal-title" id="exampleModalLabel">REBAJAR PRODUCTO VENTA</h5>
        <button type="button" class="btn-close-modal close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body card-vender" style="background-color: #f2f1f1 ;">
        <form method="post" id="formVender">
          <input type="hidden" name="" id="idventa" value="">
          <input type="hidden" name="" id="idventaProductos" value="<?php echo $idventaProducto; ?>">
          <input type="hidden" name="" id="iddetalleP" value="">
          <input type="hidden" name="" id="cantidadPr" value="">
          <input type="hidden" name="" id="usuarioventa" value="<?php echo $pass; ?>">
          <div class="md-form">
            <i class="fas fa-pencil-alt prefix"></i>
            <textarea id="DescripcionR" name="DescripcionR" class="md-textarea form-control" rows="3"></textarea>
          </div>
          Precio:
          <div class="input-group">
            <span class="input-group-text bg-secondary"><i class="fab fa-quora"></i></span>
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
      <div class="modal-footer bg-light">
        <button type="button" class="cerrar btn btn-danger" id="venderProducto" data-bs-dismiss="modal">REBAJAR PRODUCTO</button>
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
      <div class="modal-header bg-success text-light">
        <h5 class="modal-title" id="exampleModalLabel">COMPRAS</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formComprar" class="form form-group">

          <input type="hidden" name="" id="iddetalleC" value="">
          <input type="hidden" name="" id="idproductoC" value="">

          <span class="text-primary">Precio de Compra:</span>
          <div class="input-group">
            <span class="input-group-text">Q</span>
            <input class="form-control" type="text" id="precioCompraC" value="" placeholder="Precio">
          </div>
          <span class="text-primary">Precio de Venta:</span>
          <div class="input-group">
            <span class="input-group-text">Q</span>
            <input class="form-control" type="text" id="precioVentaC" value="" placeholder="Precio">
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

<div id="modalArticulo" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Articulo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="descripcion" class="col-form-label">Descripción:</label>
            <input id="descripcion" type="text" class="form-control" autofocus>
          </div>
          <div class="mb-3">
            <label for="precio" class="col-form-label">Precio</label>
            <input id="precio" type="number" class="form-control">
          </div>
          <div class="mb-3">
            <label for="stock" class="col-form-label">Stock</label>
            <input id="stock" type="number" class="form-control">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="cerrar btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--Modal ver producto-->
<!-- Modal -->
<div class="modal fade" id="modalDetalleVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <input type="hidden" name="" id="idPagC" value="1">

          <input type="hidden" name="" id="idVentaC" value="">
          <span class="text-dark"></span><input class="form-control" type="hidden" id="passVentaDetalleE" name="" placeholder="Codigo" style="text-transform:uppercase;" readonly>
        <span class="text-dark"></span><input class="form-control" type="hidden" id="iddetalleventaE" name="" placeholder="Codigo" style="text-transform:uppercase;" readonly>

          <LABEL class="btn-danger">REALMENTE QUIERES ELIMINAR ESTA VENTA?</LABEL>

          <input class="form-control" type="hidden" id="precioCompraC" value="" placeholder="Precio">
          <input class="form-control" type="hidden" name="" id="comprarC" placeholder="Cantidad comprada" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary cerrar" onclick="eliminarVenta();" data-bs-dismiss="modal">ELIMINAR</button>
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
        <button type="button" class="cerrar btn btn-danger" onclick="actualizarVenta();" data-bs-dismiss="modal">Actualizar</button>
      </div>


    </div>
  </div>
</div>