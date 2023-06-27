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
  
if (isset($_GET['eliminar'])) {
  eliminarUsuario($_GET['eliminar']);
}

?>
<title>CLIENTES</title>
  </head>

  <body id="page-top">
    <header>

    </header>
    <?php
    $pagina = 12;
    include('lib/templates/nav2.php');
    ?>

    <div class="page-body">
      <div class="container-fluid card shadow mt-4 card-principal-page">
        <!-- Aqui imprimmimos el contenido de la tabla -->



        <!-- Aqui imprimmimos los datos del cliente-->

        <div class="content-principal-page mt-3">
          <div class="table-responsive">
            <table id="tabla" class="table table-sm table-responsive table-hover table-striped table-bordered text-primary " style="width:100%">
              <thead>
                <tr class="bg-primary">
                  <th class="text-light">NIT</th>
                  <th class="text-light">CLIENTE</th>
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

    <!--Modal ver informacion de CLIENTES-->
    <!-- Modal -->
    <div class="modal fade" id="modalTelefonoCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg text-dark" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header-detalle">
            <h5 class="modal-title" id="exampleModalLabel"><span class="">INFORMACION DEL CLIENTE</span>
            </h5>

            <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-dark">
            <div class="table-responsive">
              <div class="card shadow">
                <div class="card-body">
                  <div id="detalles" class="card-repuesto">
                    <div class="row">
                      <div id="img-flip" class="col-md-5 img-flip">

                      </div>
                      <div id="card-content-1" class="col-md-7 card-content-1">


                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
    <!-- modal para nuevo Cliente -->

    <!-- Modal -->
    <div class="modal fade" id="modalNuevoCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Cliente</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formCliente">
              <input class="form-control" type="text" id="nitcl" placeholder="Nit" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <input class="form-control" type="text" id="nombrecl" placeholder="Nombre Completo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <input class="form-control" type="text" id="direccioncl" value="" placeholder="direccion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <input class="form-control" type="text" id="telefonocl" value="" placeholder="TELEFONO">
              <input class="form-control" type="email" id="emailcl" placeholder="Correo Electronico">


            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="guardar_cliente();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal para actualizar CLIENTE -->

    <!-- Modal -->
    <div class="modal fade" id="modalActualizarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header-detalle">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Cliente</h5>
            <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="form-container-client">
            <div class="login-container">
              <form method="post" id="formActualizarCliente">
                <input class="input" type="hidden" id="idCliente">
                <p>
                  <label for="nit">NIT</label>
                  <input class="input" type="text" id="nitclan" placeholder="Nit" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                </p>
                <p>
                  <LABEL>NOMBRES</LABEL>
                  <input class="input" type="text" id="nombrecla" placeholder="Nombre" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

                </p>
                <p>
                  <LABEL>EMAIL</LABEL>
                  <input class="input" type="email" id="emailcla" placeholder="Email" >

                </p>
                <p>
                  <LABEL>DIRECCION</LABEL>
                  <input class="input" type="text" id="direccioncla" value="" placeholder="direccion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

                </p>
                <p>
                  <LABEL>TELEFONO</LABEL>
                  <input class="input" type="text" id="telefonocla" value="" placeholder="Telefono" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

                </p>

              </form>
            </div>

          </div>
          <div class="modal-footer btns-group">
            <button type="button" class="btns btn-color-blue" onclick="actualizar_cliente();" data-bs-dismiss="modal">Actualizar</button>
          </div>
        </div>
      </div>
    </div>

    <!--Modal para agregar telefono a cliente -->
    <!-- Modal -->
    <div class="modal fade" id="modalNuevoTelefono" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">AGREGAR TELEFONO</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formTelefono">


              <input type="hidden" name="" id="idTelefono" value="">
              <LABEl>NO. TELEFONO</LABEl>
              <input class="form-control" type="text" id="telefono" value="" placeholder="telefono">

            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="agregarTelefonoCliente();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>


    <?php include('lib/templates/footer.php'); ?>
    <script>
      $(document).ready(function() {
        var funcion = "listar";
        let datatable = $('#tabla').DataTable({

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
              "data": "direccion"
            },
            {
              "defaultContent": `
          <div class="btns-group">
          <button class="detalles btns btn-color-red" data-bs-toggle="modal" data-bs-target="#modalTelefonoCliente"><i class="material-icons">info</i></button>

          <button class="actualizar btns btn-color-blue" data-bs-toggle="modal" data-bs-target="#modalActualizarCliente"><i class="material-icons">edit</i></button>
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
        $('#tabla tbody').on('click', '.actualizar', function() {
          let data = datatable.row($(this).parents()).data();
          $('#idCliente').val(data.id);
          $('#nitclan').val(data.nit);
          if(data.apellido != ''){
            $('#nombrecla').val(data.cliente);
          }else{
            $('#nombrecla').val(data.nombre);
          }
          
          $('#emailcla').val(data.email);
          $('#direccioncla').val(data.direccion);
          $('#telefonocla').val(data.telefono);


        });

        $('#tabla tbody').on('click', '.detalles', function() {
          let data = datatable.row($(this).parents()).data();
          obtenerIdCliente(data.id);
        });
       
        //fin de document ready
      });
    </script>

  </body>

  </html>
<?php } ?>