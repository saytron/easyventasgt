<?php
error_reporting(E_ALL ^ E_NOTICE);

if (!isset($_SESSION)) {

  session_start();
}

if (isset($_SESSION['codigo'])) {
  $pass = $_SESSION['codigo'];
  $usuario = $_SESSION['usuario'];
  $rol = $_SESSION['rol'];
}


if (!isset($_SESSION['codigo'])) {
  header("location: login.php");
} else {
  require_once('Model/class.conexion.php');
  require_once('Model/class.consultas.php');
  require_once('Controller/cargarDatos.php');
  include('lib/templates/header.php');

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
  if (isset($_POST['idventaProducto2']) &&  !empty($_POST['idventaProducto2'])) {
    $idventaProducto = $_POST['idventaProducto2'];
  } else {
    $datos4 = $consultas->recuperarVentaGenerada($pass);
    if (!empty($datos4)) {
      foreach ($datos4 as $filas) {

        if ($filas['filas'] == '') {
          $idventaProducto = 0;
        } else {
          $idventaProducto = $filas['filas'];
        }
      }
    }
  }
  $totalVenta = 0;
  if ($idventaProducto != 0) {
    $datos6 = $consultas->cargarTotalVentasDetalle($idventaProducto, $pass);
    foreach ($datos6 as $filas) {
      $totalVenta = $filas['total'];
    }
  }


  //titulo de la pagina
  echo "<title>PRODUCTOS</title>";
  echo "</head>";
  echo "  <body>";

  $pagina = 1;
  include('lib/templates/nav2.php');

  // Begin Page Content

?>
  <div class="page-body">
    <div class="container-fluid card shadow mt-2 card-principal-page">
      <!-- Aqui imprimmimos el producto-->
      <div class="content-principal-page">

        <div class="card card-top color-secondary">
          <div class="media static-top-widget media-body-center">
            <div class="align-self-center text-center"><i data-feather="shopping-bag"></i>
            </div>
            <div class="media-body ">
              <span class="m-0">Venta no.</span>
              <h4 class="mb-0 counter"><span id="idVentaProd"><?php echo $idventaProducto; ?></span></h4>
              <i class="icon-bg" data-feather="shopping-bag"></i>
            </div>
          </div>
        </div>
        <div class="card card-top color-primary">
          <div class="media static-top-widget media-body-center color-primary">
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
        <div class="verDetalleProducto">
          <button class="btn btn-danger" id="recuperar_detalle_venta" style="width: 200px;">VER PRODUCTO</button>

        </div>
      </div>
      <div class="content-principal-page">
        <div class="table-responsive" style="width: 100%;">



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
<?php
  include('lib/templates/modal.php');
}

echo "<footer>";

include('lib/templates/footer.php');

?>
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
  //datatables sin jquery
  document.addEventListener('DOMContentLoaded', function() {

    let datatable = new DataTable('#tabla', {
      "bProcessing": true,
      "bDeferRender": true,
      "bServerSide": true,
      "sAjaxSource": "serverside/serversideRepuesto.php",
      "columnDefs": [{
        "targets": [ 3,4 ],
              render: $.fn.dataTable.render.number( '', '.', 2, 'Q ' ),

        "defaultContent": `
          <div class="btns-group">
            <button class="btnDetalles btns btn-color-blue" data-bs-toggle="modal" data-bs-target="#modalDetalleProducto" alt="detalles" title="ver detalles" ><span class="material-symbols-outlined">read_more</span></button>
            <button class="btnActualizar btns btn-color-green" data-bs-toggle="modal" data-bs-target="#modalActualizarProducto" alt="detalles" alt="actualizar" title="Actualizar producto"><span class="material-symbols-outlined">edit</span></button>
          </div>
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
      /*
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
            */

    });
    $('#tabla tbody').on('click', '.btnActualizar', function() {
      fila = $(this).closest("tr");
      var codigo = fila.find('td:eq(0)').text(); //capturamos el ID		            
      var descripcion = fila.find('td:eq(1)').text();
      var cantidad = fila.find('td:eq(2)').text();
      var precio = fila.find('td:eq(3)').text();
      let precioSize = precio.length;
      //Le quitamos el caracter Q al precio
      let precio1 = precio.substring(2,precioSize);
      $('#codigopr').val(codigo);
      $('#descripcionpr').val(descripcion);
      $('#cantidadpr').val(cantidad);
      $('#preciopr').val(precio1);
      verImagen(codigo);
      $('#imagenProductoEdit').val("");

    });

    $('#tabla tbody').on('click', '.btnDetalles', function() {
      fila = $(this).closest("tr");
      let codigo = fila.find('td:eq(0)').text(); //capturo el ID		            
      let descripcion = fila.find('td:eq(1)').text();
      let cantidad = fila.find('td:eq(2)').text();
      let precio = fila.find('td:eq(3)').text();
      let precioSize = precio.length;
      let precio1 = precio.substring(2,precioSize);
      $('#codigodet').val(codigo);
      $('#precioVentaC').val(precio1);
      
      obtener_detalleProducto(codigo, descripcion, precio1, codigo, <?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>', 'identificador');

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

      $('#modalDetalleProducto').modal('show');

    });


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
    var arg_idventa = document.getElementById('idventaProductos').value
    var arg_usuario = document.getElementById('usuarioventa').value
    recuperarDatosVenta(arg_usuario, arg_idventa, '0');
    $('#modalDetalleVenta').modal('show');
  }

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

  async function dteDisponible() {

    const datos = {

    };
    const datosCodificados = JSON.stringify(datos);
    const url = "Controller/dteDisponible.php";
    const respuestaRaw = await fetch(url, {
      method: "POST",
      body: datosCodificados
    });

    const respuesta = await respuestaRaw.json();
    //console.log(respuesta);
    document.getElementById("dteDisponible").innerHTML = respuesta
  }
  dteDisponible();
</script>

</body>

</html>