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
  $idventaProducto = "";
  if (isset($_POST['idventaProducto2'])) {
    $idventaProducto = $_POST['idventaProducto2'];
  } else {
    $datos4 = $consultas->recuperarVentaGenerada($pass);

    foreach ($datos4 as $filas) {
      $idventaProducto = utf8_encode($filas['filas']);
    }
  }
  $datos6 = $consultas->cargarTotalVentasDetalle($idventaProducto, $pass);
  $totalVenta = "";
  foreach ($datos6 as $filas) {
    $totalVenta = $filas['total'];
  }
  include('lib/templates/header.php');
?>
  <title>INVENTARIO</title>

  </head>

  <body>
    <header>

    </header>
    <?php
    $pagina = 13;
    include('lib/templates/nav2.php');
    ?>


    <div class="page-body">
      <div class="container-fluid card shadow mt-2 card-principal-page">
        <div class="pt-4 content-principal-page">
          <div class="card-top-title">
            <h2>INVENTARIO </h2>
          </div>
          <div class="card-top-title">

            <div id="buscarBodega" class="mb-3 input-group mt-4">

              <span class="input-group-text"><img width="20px" src="" id="chekBodega3" alt=""></span>
              <input type="text" id="bodegaInsert3" name="bodegaInsert3" class="form-control" placeholder="Bodega..." aria-label="Recipient's username" aria-describedby="basic-addon2" style="text-transform:uppercase;">
              <button class="buscarUbicacion btn btn-success">Buscar</button>
              <input id="bodegaId3" name="bodegaId3" type="hidden">
            </div>
          </div>

        </div>

        <!-- Aqui imprimmimos el producto-->
        <div class="pt-4 content-principal-page" style="width:100%">

          <div class="table-responsive" style="width:100%">
            <table id="tabla" class="table table-sm table-hover table-striped table-bordered text-primary " style="width:100%">
              <thead>
                <tr class="bg-success">
                  <th class="text-light">CODIGO</th>
                  <th class="text-light">DESCRIPCION</th>
                  <th class="text-light">CANTIDAD</th>
                  <th class="text-light">PRECIO</th>
                  <th class="text-light">UBICACION</th>
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

    <?php include('lib/templates/modalInventario.php'); ?>



  <?php } ?>



  <?php include('lib/templates/footer.php'); ?>
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
    var availableTags = <?= json_encode($ubicacion) ?>;

    $("#bodegaInsert3").autocomplete({
      appendTo: "#buscarBodega",
      source: availableTags,
      select: function(event, item) {
        var params = {
          ubicacion: item.item.value
        }
        $.get("Controller/datosBodega.php", params, function(response) {
          var json = JSON.parse(response);

          $("#idBodegaInsert3").val(json[0].id);

          var ubicacion = document.getElementById("bodegaInsert3").value
          if (ubicacion.length > 0) {
            $("#chekBodega3").attr("src", "img/check.png");
          } else {
            $("#chekBodega3").attr("src", "");
          }




        });
      }
    });
  </script>
  <script>
    var availableTags = <?= json_encode($proveedor) ?>;

    $("#proveedorInsert2").autocomplete({
      appendTo: "#modalActualizarDetalle",
      source: availableTags,
      select: function(event, item) {
        var params = {
          proveedor: item.item.value
        }
        $.get("Controller/datosProveedor.php", params, function(response) {
          var json = JSON.parse(response);

          $("#proveedorId").val(json[0].id);

          var proveedor = document.getElementById("proveedorInsert2").value
          if (proveedor.length > 0) {
            $("#chekProveedor2").attr("src", "img/check.png");
          } else {
            $("#chekProveedor2").attr("src", "");
          }




        });
      }
    });
  </script>
  <script>
    var availableTags = <?= json_encode($ubicacion) ?>;

    $("#bodegaInsert2").autocomplete({
      appendTo: "#modalActualizarDetalle",
      source: availableTags,
      select: function(event, item) {
        var params = {
          ubicacion: item.item.value
        }
        $.get("Controller/datosBodega.php", params, function(response) {
          var json = JSON.parse(response);

          $("#bodegaId").val(json[0].id);

          var ubicacion = document.getElementById("bodegaInsert2").value
          if (ubicacion.length > 0) {
            $("#chekBodega2").attr("src", "img/check.png");
          } else {
            $("#chekBodega2").attr("src", "");
          }




        });
      }
    });
  </script>

  <script>
    let ubicacion = document.getElementById("bodegaInsert3").value;
    $(document).ready(function() {
      var funcion = "listar";

      let url = "Controller/controllerProducto?id=6&ubicacion=" + ubicacion;
      let datatable = $('#tabla').DataTable({

        'destroy': true,
        "ajax": {
          "method": "POST",
          "url": url,
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
            "data": "ubicacion"
          },
          {
            "defaultContent": `
            <div class="btns-group">
          <button class="btnDetalles btns btn-color-green" data-bs-toggle="modal" data-bs-target="#modalDetalleProducto" alt="detalles" title="ver detalles" ><i class="material-icons">read_more</i></button>
          <button class="btnActualizar btns btn-color-yellow" data-bs-toggle="modal" data-bs-target="#modalActualizarProducto" alt="detalles" alt="actualizar" title="Actualizar producto"><i class='material-icons'>edit</i></button>
          </div>
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
      $('#tabla tbody').on('click', '.btnActualizar', function() {
        fila = $(this).closest("tr");
        var codigo = fila.find('td:eq(0)').text(); //capturamos el ID		            
        var descripcion = fila.find('td:eq(1)').text();
        var cantidad = fila.find('td:eq(2)').text();
        var precio = fila.find('td:eq(3)').text();
        $('#codigopr').val(codigo);
        $('#descripcionpr').val(descripcion);
        $('#cantidadpr').val(cantidad);
        $('#preciopr').val(precio);
        verImagen(codigo);
        $('#imagenProductoEdit').val("");

      });

      $('#tabla tbody').on('click', '.btnDetalles', function() {
        fila = $(this).closest("tr");
        let codigo = fila.find('td:eq(0)').text(); //capturo el ID		            
        let descripcion = fila.find('td:eq(1)').text();
        let cantidad = fila.find('td:eq(2)').text();
        let precio = fila.find('td:eq(3)').text();

        $('#codigodet').val(codigo);
        $('#precioVentaC').val(precio);

        obtener_detalleProducto(codigo, descripcion, precio, codigo, <?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>','inventario');

      });

      //evento para agregar producto
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
            $('#modalDetalleProducto').modal('hide');
            $('#comprarC').val('');
            Swal.fire({
              position: 'button-end',
              icon: 'success',
              title: datos,
              showConfirmButton: false,
              timer: 2000
            })


          }
        });
      });
      //evento para rebajar producto


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
      });
      $("#cerrar3").click(function(e) {
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
      $("#btnvenderProducto").click(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página

        $('#modalDetalleProducto').modal('hide');

      });

      $(".buscarUbicacion").click(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página


        let bodega = document.getElementById('bodegaInsert3').value;

        ubicacion = bodega;
        datatableReload(ubicacion);

      })
      //fin de document ready
    });


    //evento para boton vender producto
    $btnVender = document.querySelector("#venderProducto");
    $btnVender.onclick = async () => {

      var arg_cantidad = document.getElementById('cantidadPr').value
      var arg_Venta = document.getElementById('vender').value
      var arg_idventa = document.getElementById('idventa').value
      var arg_iddetalleproducto = document.getElementById('iddetalleP').value
      var arg_usuario = document.getElementById('usuarioventa').value
      var arg_precio = document.getElementById('precioVenta').value
      var arg_idventaProducto = document.getElementById('idventaProductos').value
      var arg_DescripcionProducto = document.getElementById('DescripcionR').value
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
        descripcion: arg_DescripcionProducto
      };
      const datosCodificados = JSON.stringify(datos);
      const url = "Controller/venderProducto.php";
      const respuestaRaw = await fetch(url, {
        method: "POST",
        body: datosCodificados
      });
      const respuesta = await respuestaRaw.json();

      if (respuesta === "1") {

        recuperarTotalVenta(arg_usuario, arg_idventaProducto);
        $('#modalDetalleProducto').modal('hide');
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
          title: 'no tienes producto para rebajar tu  existencia es: ' + arg_cantidad,
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

    /*
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
    }*/
  </script>
  </body>

  </html>