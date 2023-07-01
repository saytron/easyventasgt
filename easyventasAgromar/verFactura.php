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
if (!isset($_SESSION['codigo'])) {
  header("location: login.php");
} else {



  require_once('Model/class.conexion.php');
  require_once('Model/class.consultas.php');
  require_once('Controller/cargarDatos.php');
  require_once('Controller/Eliminar.php');
  include('lib/templates/header.php');
  $consultas = new consultas();
  $datos = $consultas->cargarCliente();
  $cliente = array();
  $com = '';
  foreach ($datos as $filas) {
    $com = utf8_encode($filas['nit'] . ' ' . $filas['nombre']);
    array_push($cliente, $com);
  }
  ini_set('date.timezone', 'America/Guatemala');

  $mes = (int) date('m');
  $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

  //$fecha = "'20".$anio."-".$mes."-".$dia."'";

  if (isset($_GET['eliminar'])) {
    eliminarUsuario($_GET['eliminar']);
  }







?>
  <title>ver Facturas</title>
  </head>

  <body>
    <header>

    </header>
    <!-- spinner -->
    <div id="spinner" class="spinn-container">
      <div class="carga">

      </div>
    </div>
    <!-- fin del spinner -->
    <?php
    $pagina = 8;
    include('lib/templates/nav2.php');
    ?>

    <input type="hidden" id="codigoUsuario" value="<?php echo $pass; ?>">



    <input type="hidden" id="idventaFact" value="" disabled>


    <div class="page-body">
      <div class="container-fluid card shadow mt-4 card-principal-page">
        <div class="content-principal-page">
          <div class="table-responsive mt-4">
            <table id="tabla" class="table table-sm table-hover table-striped table-bordered text-primary " style="width:100%">
              <thead>
                <tr class="bg-primary">
                  <th class="text-light">ID</th>
                  <th class="text-light">DETALLE</th>
                  <th class="text-light">NO. DTE</th>
                  <th class="text-light">FECHA</th>
                  <th class="text-light">ESTADO</th>
                  <th class="text-light">ACCIONES</th>
                </tr>
              </thead>

              <tfoot>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <input type="hidden" id="idventaFacturado" value="er" disabled>
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
          </div>
        </div>
      </div>
    </div>
    
    <!--Modal PARA buscar nit de FACTURA-->
    <!-- Modal -->
    <div class="modal fade" id="modalClienteFactura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header-detalle">
            <h5 class="modal-title" id="exampleModalLabel">DTE: DATOS DEL CLIENTE</h5>
            <div class="container-button-modal">

            </div>

            <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card bg-light">
              <div class="input-group mb-4">
                <span class="input-group-text bg-primary" style="width:60px;"><span class="material-symbols-outlined">
                    database
                  </span></span>
                <input class="form-control" type="text" name="buscarClienteBd" id="buscarClienteBd" placeholder="Buscar Cliente Existente">

              </div>
              <div class="input-group mb-4">
              <select class="btn btn-info input-group-text" name="region" width="100px" id="abono">
                  <option class="dropdown-toggle" value="1">NIT</option>
                  <option class="dropdown-toggle" value="0">CUI</option>

                </select>
                <input class="form-control" type="text" name="nitFel" id="nitFel" placeholder="Igresa el nit para buscar en SAT">
                <button class="btn btn-danger buscarNit"><span class="material-symbols-outlined">
                    search
                  </span></button>
              </div>

              <div class="input-group ">
                <span class="input-group-text bg-primary" style="width:110px;">NIT</span>
                <input class="form-control" type="text" name="taxCode" id="taxCode" readonly>
              </div>
              <div class="input-group">
                <span class="input-group-text bg-primary" style="width:110px;">NOMBRE</span>
                <input class="form-control" type="text" name="taxName" id="taxName" required>
              </div>
              <div class="input-group">
                <span class="input-group-text bg-primary" style="width:110px;">DIRECCION</span>
                <input class="form-control" type="text" name="taxAddress" id="taxAddress" required>
              </div>
              <div class="input-group">
                <span class="input-group-text bg-primary" style="width:110px;">EMAIL</span>
                <input class="form-control" type="email" name="email" id="email" placeholder="Email (opcional)">
              </div>
              <input type="hidden" id="idCliente" value="">
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-success" id="felCf">CF</button>
            <button class="generarFactura btn btn-danger mr-4" alt="Generar Factura" title="Generar Factura" target="blank" data-bs-dismiss="modal">GENERAR FACTURA</button>

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

  <?php
}
include('lib/templates/footer.php'); ?>

  <script>
    var availableTags = <?= json_encode($cliente) ?>;

    $("#buscarClienteBd").autocomplete({
      appendTo: "#modalClienteFactura",
      source: availableTags,
      select: function(event, item) {
        var params = {
          cliente: item.item.value
        }
        $.get("Controller/datosCliente.php", params, function(response) {
          var json = JSON.parse(response);


          if (json.length > 0) {
            document.getElementById("taxCode").value = json[0].nit;
            document.getElementById("taxName").value = json[0].nombre;
            document.getElementById("taxAddress").value = json[0].direccion;
            document.getElementById("email").value = json[0].email;
            document.getElementById("idCliente").value = json[0].id_cliente;


          } else {

          }

        });
      }
    });
  </script>

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
          <div class="btns-grooup">
          <button class="detalles btns btn-color-red"><span class="material-symbols-outlined">
check
</span></button>
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
        alertify.success("Cliente seleccionado");
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
          "url": "Controller/cargarIdFactura.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "idventa"
          },
          {
            "data": "facturado"
          },
          {
            "data": "sat_no"
          },
          {
            "data": "fecha"
          },
          {
            "data": "estadodte"
          },
          {
            "defaultContent": `
          <div class="btns-group">
		  <button class="detalles2 btns btn-color-yellow" alt="CERTIFICAR" title="CERTIFICAR"><i class="material-icons">done</i></button>
          <button class="detalles3 btns btn-color-green"><i class="material-icons" alt="VER PRODUCTOS" title="VER PRODUCTOS">read_more</i></button>
          <button class="btns verFactura btn-color-blue" alt="VER FACTURA" title="VER FACTURA" target="blank"><i class="material-icons"><span class="material-icons-outlined">picture_as_pdf
</span></i></button>
          
          <button class="btns anularDte btn-color-red" alt="ANULAR DTE" title="ANULAR DTE" target="blank"><span class="material-symbols-outlined">delete_forever</span></button>
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
        if (data.estado == 0) {
          recuperarDatosVenta(data.usuario, data.idventa, data.estado);
          $('#modalClienteFactura').modal('toggle');
        } else {
          Swal.fire(
            'DTE Facturado!',
            'Esta factura ya ha sido atendida.',
            'error'
          )
        }

      });
      $('#tabla tbody').on('click', '.detalles3', function() {
        let data = datatable.row($(this).parents()).data();
        if (data.estado == 1) {
          Swal.fire(
            'Facturado!',
            'El dte ya no se puede modificar.',
            'error'
          )

        } else {

          $('#modalDetalleVenta').modal('toggle');
          recuperarDatosVenta(data.usuario, data.idventa, data.estado);
        }



      });
      $(".generarFactura").click(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        let taxCode = document.getElementById("taxCode").value
        let taxName = document.getElementById("taxName").value
        let taxAddress = document.getElementById("taxAddress").value
        if(taxCode == '' || taxName == '' || taxAddress == ''){
          Swal.fire(
            'Cambos vacios!',
            'La factura no fue creada por que los campos estaban vacios',
            'error'
          )
        }else{
          spinner();
        generarFactura('<?php echo $pass; ?>');
        }
        
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

      $('#tabla tbody').on('click', '.anularDte', function() {
        let data = datatable.row($(this).parents()).data();
        let estadoDte = data.estado_dte;
        if (estadoDte == 1) {
          Swal.fire(
            'DTE Anulado!',
            'el dte ya fue anulado.',
            'error'
          )
        } else {
          Swal.fire({
            title: 'Estas seguro? ingresa la razon',
            text: "Ingresa la razon!",
            html: '<input class="form-control" type="text" id="reazonAnular">',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'sí, estoy seguro!'
          }).then((result) => {
            let anulado = document.getElementById('reazonAnular').value
            if (result.isConfirmed && anulado != "") {
              anularFacturaFel(data.idventa, anulado);
              Swal.fire(
                'Anulado!',
                'el dte ha sido anulado.',
                'success'
              )
            } else {
              Swal.fire(
                'Sin acciones!',
                'no ingresaste la razon, vuelve a intentarlo.',
                'error'
              )
            }
          })
        }

      });

      $('#tabla tbody').on('click', '.verFactura', function() {
        let data = datatable.row($(this).parents()).data();
        document.getElementById('idventaFacturado').value = 1;
        generarPdfFactura(data.cliente, data.usuario, data.idventa, data.estado);
      });
    });

    btnNit = document.querySelector(".buscarNit");
    btnNit.onclick = async () => {
      arg_nitFel = document.getElementById("nitFel").value
      spinner();
      const datos = {
        nitFel: arg_nitFel
      };
      const datosCodificados = JSON.stringify(datos);
      const url = "Controller/buscarNitSat.php?nit=" + arg_nitFel;
      const respuestaRaw = await fetch(url, {
        method: "POST",
        body: datosCodificados
      });
      const respuesta = await respuestaRaw.json();

      if (respuesta == "") {
        alertify.alert('NIT INVALIDO', 'Agrega un nit correcto!');
        spinnerHidden();

      } else {
        console.log(respuesta);
        arg_nit = respuesta[0].tax_code;
        arg_name = respuesta[0].tax_name;
        arg_address = 'CIUDAD';
        buscar_cliente(arg_nit, arg_name, arg_address);
      }


    }

    async function buscar_cliente(nit, name, address) {
      let arg_nit = nit;
      const datos = {
        nitCliente: arg_nit
      };
      const datosCodificados = JSON.stringify(datos);
      const url = "Controller/buscarCliente.php";
      const respuestaRaw = await fetch(url, {
        method: "POST",
        body: datosCodificados
      });
      const respuesta = await respuestaRaw.json();
      if (respuesta == null) {
        //let nombre = name.replace(/[^a-zA-Z 0-9.]+/g, ' ');
        document.getElementById("taxCode").value = nit;
        document.getElementById("taxName").value = name;
        document.getElementById("taxAddress").value = address;
        guardar_clienteFel(nit, name, address);

      } else {
        document.getElementById("idCliente").value = respuesta[0].id_cliente;
        document.getElementById("taxCode").value = respuesta[0].nit;
        if (respuesta[0].id_cliente >= 208) {
          document.getElementById("taxName").value = respuesta[0].nombre;
        } else {
          document.getElementById("taxName").value = respuesta[0].nombre + ' ' + respuesta[0].apellidos;
        }

        document.getElementById("taxAddress").value = respuesta[0].direccion;
        document.getElementById("email").value = respuesta[0].email;

      }
      spinnerHidden();

    }

    function guardar_clienteFel(nit, nombre, direccion) {
      let arg_email = document.getElementById("email").value
      let arg_nit = nit;
      let arg_nombre = nombre;
      let arg_direccion = direccion;
      var url = "Controller/guardarClienteFel.php";

      $.ajax({
        type: "post",
        url: url,
        data: {
          nit: arg_nit,
          nombre: arg_nombre,
          direccion: arg_direccion,
          email: arg_email

        },
        success: function(datos) {

          alertify.success(datos);
          document.getElementById("idCliente").value = datos;

        }
      });

    }

    //recuperamos los datos de la venta para poder anular el dte
    async function anularFacturaFel(id_venta, anulado) {

      const datos = {
        idVenta: id_venta,
        razon: anulado
      };
      const datosCodificados = JSON.stringify(datos);
      const url = "Controller/anularDte.php";
      const respuestaRaw = await fetch(url, {
        method: "POST",
        body: datosCodificados
      });
      const respuesta = await respuestaRaw.json();
      console.log(respuesta);

    }

    let felCf = document.getElementById('felCf');
    felCf.onclick = async () => {
      document.getElementById("taxCode").value = 'CF';
      document.getElementById("taxName").value = 'CLIENTES VARIOS';
      document.getElementById("taxAddress").value = 'CIUDAD';
    }
  </script>
  <script>
    //ocultamos el spinner despues de que la pagina ha cargado completamente
    spinnerHidden();

    function spinnerHidden() {
      const spinner = document.querySelector('#spinner');
      spinner.style.display = 'none';
    }

    function spinner() {
      const spinner = document.querySelector('#spinner');
      spinner.style.display = 'block';
    }
  </script>
  </body>

  </html>