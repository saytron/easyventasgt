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




if (!isset($_SESSION['codigo'])) {
  header("location: login.php");
} else if (isset($_SESSION['rol']) != 2) {
  header("location: verProducto.php");
} else {
  require_once('Model/class.conexion.php');
  require_once('Model/class.consultas.php');
  require_once('Controller/cargarDatos.php');
  require_once('Controller/Eliminar.php');
  require_once('Controller/cargarUsuario.php');
  include('lib/templates/header.php');


?>
  <title>Empleado</title>
  </head>

  <body>
    <?php
    $pagina = 0;
    include('lib/templates/nav2.php');
    ?>

    <?php

    if (isset($_GET['eliminar'])) {
      eliminarUsuario($_GET['eliminar']);
    }
    ?>
    <?php
    if ($rol != 2) {
      echo '<h1>No tienes permiso para ver o modificar en este lugar</h1>';
    } else {
    ?>

      <div class="page-body">
        <div class="container-fluid card shadow mt-4 card-principal-page">

          <!-- contenido principal -->

          <div class="content-principal-page pt-4">
            <div class="table-responsive">
              <table id="tabla" class="table table-sm table-hover table-striped table-bordered text-primary " style="width:100%">
                <thead>
                  <tr class="bg-primary">
                    <th class="text-light text-center">NOMBRE</th>
                    <th class="text-light text-center">DIRECCION</th>
                    <th class="text-light">FECHA DE NACIMIENTO</th>
                    <th><button type="button" class="detalles btn btn-danger btn-sm float-right" data-bs-toggle="modal" data-bs-target="#modalNuevo" alt="Agregar Empleado" title="Agregar Empleado"><i class="fas fa-plus-circle"></i></button></th>
                  </tr>
                </thead>
                <tfoot>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>


    <?php } ?>

    <!-- modal para ver detalle -->

    <!-- Modal -->
    <div class="modal fade" id="modalDetalleEmpleado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><span></span> <span class="text-primary text-center" id="nombreLider"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col">
                <div class="row">
                  <div class="col"><span class="text-danger">NOMBRE: </span></div>
                  <div class="col"><span class="text-primary" id="nombreD"></span></div>
                </div>
                <div class="row">
                  <div class="col"><span class="text-danger">DIRECCION: </span></div>
                  <div class="col"><span class="text-primary" id="direccionD"></span></div>
                </div>
                <div class="row">
                  <div class="col"><span class="text-danger">NACIMIENTO: </span></div>
                  <div class="col"><span class="text-primary" id="nacimientoD"></span></div>
                </div>

                <div class="row bg-secondary" style="height:5px"></div>
                <p></p>
                <p><span class="text-danger">USUARIO(S): </span><span id="userEmpleado"></span>
                  <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario" alt="Agregar Usuario" title="Agregar Usuario"><i class="fas fa-plus-square"></i></button>
                </p>

              </div>
              <div class="col">
                <img id="fotoLider" width="200px" src="img/empleado.png" alt="">

              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal para registros nuevos -->

    <!-- Modal -->
    <div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Empleado</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="nuevoEmpleado" enctype="multipart/form-data" class="needs-validation" novalidate>
              <div class="mb-3 input-group">
                <span class="input-group-text"><i class="far fa-user"></i></span>
                <input class="form-control" type="text" id="nombre" placeholder="Nombre" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>
              <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                <input class="form-control" type="text" id="direccion" placeholder="Direccion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>
              <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-calendar-week"></i></span>
                <input class="form-control" type="date" id="fechaNacE" value="">
              </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="guardarEmpleado();" data-bs-dismiss="modal">Agregar</button>
          </div>
          </form>
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
              <input class="form-control input-sm" type="date" id="nacimientou" placeholder="NACIMIENTO">



            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="Actualizar_Empleado();" data-bs-dismiss="modal">Actualizar</button>
          </div>
        </div>
      </div>
    </div>

    <!--Modal para insertar Rol -->
    <!-- Modal -->
    <div class="modal fade" id="modalNuevoRol" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Rol</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formRol">
              <input class="form-control" type="text" name="rol" id="rol" placeholder="Rol">



            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="enviar_Rol();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>


    <!-- modal para nuevo usuario -->

    <!-- Modal -->
    <div class="modal fade" id="modalNuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formUsuario">
              <div class="input-group">
                <span class="input-group-text"><span class="material-symbols-outlined">
                    person
                  </span></span>
                <input class="form-control" type="text" id="usuarioU" placeholder="USER" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

              </div>
              <div class="input-group">
              <span class="input-group-text"><span class="material-symbols-outlined">
                    key
                  </span></span>
                <input class="form-control" type="text" id="codigoU" placeholder="PASSWORD" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>
              <div class="input-group">
              <div class="btn-group btn-lg btn-block">
                <select class="btn btn-primary btn-lg btn-block" name="region" id="rolU">
                  <option class="dropdown-toggle" value="">Rol</option>
                  <?php
                  cargarRol();

                  ?>
                </select>
              </div>
                <input class="form-control" type="hidden" id="empleadoU" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>

              


            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="guardar_Usuario();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal para actualizar usuario -->

    <!-- Modal -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Usuario</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="formEdUsuario">
              <input class="form-control" type="hidden" id="codigoEdU" placeholder="Codigo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <input class="form-control" type="text" id="usuarioEdU" placeholder="Usuario" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <input class="form-control" type="text" id="passEdU" placeholder="Password..." style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="Actualizar_Usuario();" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>

  <?php
}
include('lib/templates/footer.php'); ?>


  <script>
    $(document).ready(function() {
      var funcion = "listar";
      let datatable = $('#tabla').DataTable({
        "ajax": {
          "method": "POST",
          "url": "Controller/cargarEmpleado.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "nombre"
          },
          {
            "data": "direccion"
          },
          {
            "data": "nacimiento"
          },
          {
            "defaultContent": `
          <div class="btns-group">
          <button type="button" class="detalles btns btn-color-blue" data-bs-toggle="modal" data-bs-target="#modalDetalleEmpleado" alt="Ver detalles" title="Ver detalles"><i class="fas fa-address-card"></i></button>
          <button type="button" class="actualizar btns btn-color-yellow" data-bs-toggle="modal" data-bs-target="#modalActualizarEmpleado" alt="Editar datos" title="Editar datos"><i class="fas fa-pencil-alt"></i></button>
          </div>
          `
          }
        ],

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
            text: '<i class="fas fa-file-excel"></i>',
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
        ],
        //ocultamos las columnas sector y comunidad 


      });
      $('#tabla tbody').on('click', '.actualizar', function() {
        let data = datatable.row($(this).parents()).data();
        $("#idEmpleadou").val(data.id_empleado);
        $("#nombreu").val(data.nombre);
        $("#direccionu").val(data.direccion);
        $("#nacimientou").val(data.nacimiento);

      });
      $('#tabla tbody').on('click', '.detalles', function() {
        let data = datatable.row($(this).parents()).data();
        $('#empleadoU').val(data.id_empleado);
        document.getElementById("nombreD").innerHTML = data.nombre;
        document.getElementById("direccionD").innerHTML = data.direccion;
        let fecha = data.nacimiento;
        let fecha_corta = fecha.substring(0, 10);
        fecha = fecha_corta.split('-').reverse().join('/');
        document.getElementById("nacimientoD").innerHTML = fecha;

        //$("#fotoLider").attr("src",'Controller/'+data.url_imagen);

        // $('#cuiUsuarioTel').val(data.cui); //insertamos el cui al input para poder guardar el telefono del usuario
        // $('#cuiUsuarioTelE').val(data.cui); //insertamos el cui al input para poder eliminar el telefono del usuario
        var url = "Controller/recuperarUsuario.php";


        $.ajax({
          type: "post",
          url: url,
          data: {
            idEmpleado: data.id_empleado
          },
          success: function(datos) {

            document.getElementById("userEmpleado").innerHTML = "";
            var json = JSON.parse(datos);
            for (let datos of json) {

              document.getElementById("userEmpleado").innerHTML += `
         <div class="row">
         <div class="col"> ${datos.n_usuario}
         </div>
         <div class="col">
         
         <input type="hidden" id="idTelefono" name="idTelefono" value="${datos.codigo}">        
         <button type="button" class="btn btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario" alt="Editar usuario" title="Editar usuario" onclick="editar_usuario('${datos.codigo}','${datos.n_usuario}');"><i class="fas fa-pencil-alt"></i></button>
        </div>
         </div>
         `;

            }

          }
        });
      });

    });
  </script>
  </body>

  </html>