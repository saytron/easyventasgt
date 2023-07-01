<?php
error_reporting(E_ALL ^ E_NOTICE);
if (isset($_GET['num'])) {
    $num = $_GET['num'];
}
if (isset($_GET['nacimiento'])) {
    $cod = $_GET['nacimiento'];
}
if (isset($_GET['idVenta'])) {
    $idVenta = $_GET['idVenta'];
}




if (isset($_GET['eliminar'])) {
    eliminarUsuario($_GET['eliminar']);
}

if (!isset($_SESSION)) {

    session_start();
}
$pass = $_SESSION['codigo'];
$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];
if (!isset($_SESSION['codigo'])) {
    header("location: ../login.php");
} else {
    require_once('../Model/class.conexion.php');
    require_once('../Model/class.consultas.php');

?>
    <title>Ms 381</title>
  
    </head>
    <?php

    ?>

    <body>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <img src="../img/ms381.jpg" alt="" usemap="#mapa">
                    <map name="mapa" id="mapa">
                        <area class="btnDetalles" shape="circle" coords="203,259,10" href="#" onclick="recuperarRep('9022 341 1020');" alt="1119 020 1514">
                    </map>
                </div>
            </div>
        </div>



        <script>
        function recuperarRep(variable) {
            var rep = variable;
            alert(rep);
        }
    </script>
    </body>

    </html>

<?php
}

?>