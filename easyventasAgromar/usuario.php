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
} else if (!isset($_SESSION['rol']) == 2) {
  header("location: verProducto.php");
} else {
require_once('Model/class.conexion.php');
require_once('Model/class.consultas.php');
require_once('Controller/cargarDatos.php');
require_once('Controller/Eliminar.php');
require_once('Controller/cargarUsuario.php');
include('lib/templates/header.php');


if (isset($_GET['eliminar'])) {
  eliminarUsuario($_GET['eliminar']);
}

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

  <div class="page-body">
    <div class="container-fluid card shadow mt-4 card-principal-page">

      <!-- contenido principal -->

      <div class="content-principal-page pt-4">
        <div class="container-user">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 img-user">
              <img class="img-empleado" src="img/empleado.png" alt="">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 personal-data">
              <h2 class="datos-usuario">DATOS PERSOALES</h2>
              <div class="card-user">
                <div class="card-content-1">
                  <div class="card-global-user">
                    <span class="">NOMBRE: </span>
                    <span id="nombre-user" class="nombre-user"></span>
                  </div>
                  <div class="card-global-user">
                    <span class="">DIRECCION: </span>
                    <span id="direccion-user" class="direccion-user"> </span>
                  </div>
                  <div class="card-global-user">
                    <span class="">NFECHA DE NACIMIENTO: </span>
                    <span id="fecha-user" class="fecha-user"></span>
                  </div>
                  <div class="card-global-user">
                    <span class="">CARGO: </span>
                    <span id="cargo-user" class="cargo-user"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="line"></div>
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 modify-data-user">
              <div class="card-global-form">
                <form method="post">
                  <fieldset>
                    <legend class="datos-usuario">ACTUALIZAR DATOS DE USUARIO</legend>
                    <input type="hidden" id="idEmpleadou">
                    <input class="form-control input-sm" type="text" name="" id="nombreu">
                    <input class="form-control input-sm" type="text" id="direccionu" placeholder="Direccion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <input class="form-control input-sm" type="date" id="nacimientou" placeholder="NACIMIENTO">


                  </fieldset>
                </form>

              </div>
              <div class="btns-group">
                <button type="button" class="btns btn-color-blue" onclick="Actualizar_Empleado();" data-bs-dismiss="modal">Actualizar</button>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 modify-password-user">
                <p><h2 class="datos-usuario">USUARIO(S)</h2></p>
              
              <div id="userEmpleado">

              </div>
              
              <div class="btns-group">
              <button type="button" class="btns btn-color-blue" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario" alt="Agregar Usuario" title="Agregar Usuario">NUEVO USUARIO</button>

              </div>




            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

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
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario" alt="Agregar Usuario" title="Agregar Usuario"><i class="fas fa-plus-square"></i></button>
              </p>

            </div>
            <div class="col">
              <img id="fotoLider" width="200px" src="" alt="">

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
          <h5 class="modal-title text-dark" id="exampleModalLabel">Nuevo Usuario</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" id="formUsuario">
            <input class="form-control" type="text" id="codigoU" placeholder="Codigo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            <input class="form-control" type="text" id="usuarioU" placeholder="Usuario" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            <input class="form-control" type="text" id="empleadoU" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">

            <div class="btn-group btn-lg btn-block">
              <select class="btn btn-primary btn-lg btn-block" name="region" id="rolU">
                <option class="dropdown-toggle" value="">Rol</option>
                <?php
                cargarRol();

                ?>
              </select>
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
          <h5 class="modal-title text-dark" id="exampleModalLabel">Cambiar Contraseña</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" id="formEdUsuario">
            <input class="form-control" type="hidden" id="codigoEdU" placeholder="Codigo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            <input class="form-control" type="text" id="usuarioEdU" placeholder="Usuario" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            <input class="form-control" type="text" id="passEdU" placeholder="New Password..." style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">



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
          "url": "Controller/cargarDatosUsuario.php",
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
          <button type="button" class="detalles btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetalleEmpleado" alt="Ver detalles" title="Ver detalles"><i class="fas fa-address-card"></i></button>
          <button type="button" class="actualizar btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalActualizarEmpleado" alt="Editar datos" title="Editar datos"><i class="fas fa-pencil-alt"></i></button>

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
            for (let x = 0; x <= json.length; x++) {

              document.getElementById("userEmpleado").innerHTML += `
         <div class="row">
         <div class="col text-dark"> ${json[x].n_usuario}
         </div>
         <div class="col">
         
         <input type="hidden" id="idTelefono" name="idTelefono" value="${json[x].codigo}">        
         <button type="button" class="btn btn-warning btn-md" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario" alt="cambiar contraseña" title="cambiar contraseña" onclick="editar_usuario('${json[x].codigo}','${json[x].n_usuario}');"><i class="fas fa-pencil-alt"></i></button>
        </div>
         </div>
         `;

            }

          }
        });
      });

    });
  </script>
  <script>
    cargarDatosUsuario();

    function cargarDatosUsuario() {

      var cargo = '<?php echo $rol; ?>';
      var url = "Controller/cargarDatosUsuario.php";

      $.ajax({
        type: "post",
        url: url,
        data: {

        },
        success: function(datos) {
          let json = JSON.parse(datos);

          document.getElementById("nombre-user").innerHTML = json[0].nombre;
          document.getElementById("direccion-user").innerHTML = json[0].direccion;
          document.getElementById("fecha-user").innerHTML = json[0].nacimiento;
          let rol = '';
          if (cargo === '1') {
            rol = 'VENDEDOR';
          } else if (cargo === '2') {
            rol = 'ADMINISTRADOR';
          } else if (cargo === '3') {
            rol = 'MECANICO';
          } else {
            rol = 'CONTADOR';
          }
          document.getElementById("cargo-user").innerHTML = rol;
          actualizarEmpleado(json[0].id_empleado, json[0].nombre, json[0].direccion, json[0].nacimiento);
          recuperarUsuario(json[0].id_empleado);
          /*
          $("#idEmpleadou").val = json[0].id_empleado;
          $("#nombreu").val = json[0].nombre;
          $("#direccionu").val = json[0].direccion;
          $("#nacimientou").val = json[0].nacimiento;
          */
        }
      });
    }
    function recuperarUsuario(idUsuario){
      var url = "Controller/recuperarUsuario.php";


      $.ajax({
        type: "post",
        url: url,
        data: {
          idEmpleado: idUsuario
        },
        success: function(datos) {

          document.getElementById("userEmpleado").innerHTML = "";
          var json = JSON.parse(datos);
          for (let x = 0; x <= json.length; x++) {

            document.getElementById("userEmpleado").innerHTML += `
            <div class="card-user">
            <div class="card-name-user">
            <span> ${json[x].n_usuario}</span>
            <span>
            
            <input type="hidden" id="idTelefono" name="idTelefono" value="${json[x].codigo}">        
            <button type="button" class="btns btn-color-red" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario" alt="cambiar contraseña" title="cambiar contraseña" onclick="editar_usuario('${json[x].codigo}','${json[x].n_usuario}');"><i class="fas fa-pencil-alt"></i></button>
            </span>
            </div>
            </div>
            `;

          }

        }
      });
    }


    
  </script>
</body>

</html>