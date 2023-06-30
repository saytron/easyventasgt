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
  $idventaProducto = 0;
  if (isset($_POST['idventaProducto2'])) {
    $idventaProducto = $_POST['idventaProducto2'];
  } else {
    $datos4 = $consultas->recuperarVentaGenerada($pass);

    foreach ($datos4 as $filas) {
      $idventaProducto = $filas['filas'];
    }
  }
  if($idventaProducto != NULL){
    $datos6 = $consultas->cargarTotalVentasDetalle($idventaProducto, $pass);
    $totalVenta = "";
    foreach ($datos6 as $filas) {
      $totalVenta = $filas['total'];
    }
  }

  include('lib/templates/header.php');
?>
  <title>PRODUCTOS</title>

  </head>

  <body>
   
    <?php
    $pagina = 1;
    include('lib/templates/nav2.php');
    ?>

    <!-- Begin Page Content -->


    <div class="page-body">
      <div class="container-fluid card shadow mt-2 card-principal-page">
        <!-- Aqui imprimmimos el producto-->
       
        <div class="content-principal-page mt-2">
          <div class="table-responsive">
           
            <table id="tabla" class="table table-sm table-hover table-striped table-condensed display datatables" style="width:100%">
              <thead>
                <tr class="bg-primary">
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
  



  <?php } ?>



  <?php include('lib/templates/footer.php'); ?>
 
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

          "defaultContent": `
          <div class="btns-group">
          <button class="btnEliminar cerrar btns btn-color-red" alt="Eliminar" title="Eliminar producto"><span class="material-symbols-outlined">
delete
</span></button>

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

      $('#tabla tbody').on('click', '.btnEliminar', function() {
        let rol = "<?php echo $rol ?>";
        fila = $(this).closest("tr");
        let codigo = fila.find('td:eq(0)').text(); //capturo el ID	
        if(rol === '2'){
          Swal.fire({
          title: 'Estas seguro?',
          text: "No podras revertir este cambio!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'si, borrar este producto!'
            }).then((result) => {
              if (result.isConfirmed) {
                eliminarProducto(codigo);
                datatable.ajax.reload(null, false);
                Swal.fire(
                  'Borrado!',
                  'Este producto ha sido borrado con exito.',
                  'success'
                )
              }
            })
        }	else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'No tienes permiso para eliminar esto!',
            footer: '<h3 class="text-center text-primary">pide permiso a un administrador</h3>'
          })
        }            
       
      
      });

     
      $(".cerrar").click(function(e){
      e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     


	    var url= "";

	    $.ajax({
		    type: "post",
		    url: url,
		    data:{
			   
		    },
		    success:function(datos){
          datatable.ajax.reload(null, false);
        }
	    });
    });
     
      //fin de document ready
    });

  </script>
   
  </body>

  </html>