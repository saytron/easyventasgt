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
} else {


  $pagina = 0;
  include('lib/templates/header.php');
  include('lib/templates/nav2.php');
?>
  <title>CUOTAS</title>
  </head>

  <body>

    <!-- Begin Page Content -->



    <div class="page-body">
      <div class="container-fluid card shadow mt-4 card-principal-page">
        <div class="content-principal-page pt-4">

          <div class="row mb-2">
            <!-- Aqui imprimmimos el producto-->

            <aside>
            
                <legend>
                  <h1 class="text-dark">CREDITO HONDA</h1>
                </legend>

                <div class="mb-3 input-group">
                  <span class="input-group-text"><i class="material-icons">person</i></span>
                  <input class="form-control" name="cliente" type="text" id="cliente" value="" placeholder="Nombre del Cliente" />
                </div>
                <div class="mb-3 input-group">
                  <span class="input-group-text"><i class="material-icons">local_offer</i></span>
                  <input class="form-control" name="producto" type="text" id="producto" value="" placeholder="Producto a Cotizar" />
                </div>

                <div class="mb-3 input-group">
                  <span class="input-group-text"><i class="material-icons">attach_money</i></span>
                  <input class="form-control" name="monto" type="number" id="monto" value="" placeholder="monto" required>
                </div>
                <div class="mb-3 input-group">
                  <span class="input-group-text"><i class="material-icons">attach_money</i></span>
                  <input class="form-control" name="abono" type="number" id="abono" value="" placeholder="abono" required>
                </div>
                <div class="mb-3 input-group">
                  <span class="input-group-text"><i class="material-icons">date_range</i></span>
                  <input class="form-control" name="meses" type="number" id="meses" value="" placeholder="meses" required>
                </div>
                <div class="mb-3 btns-group">
                  <button class="btns btn-color-blue" onclick="generarCuotas();">Generar Cuotas</button>
                </div>
              
            </aside>

          </div>
        </div>

      </div>

    </div>


  <?php
}
include('lib/templates/footer.php'); ?>
  <script>



  </script>
  </body>

  </html>