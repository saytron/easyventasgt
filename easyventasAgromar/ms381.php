<?php
error_reporting(E_ALL ^ E_NOTICE);
if (!isset($_SESSION)) {

  session_start();
}
if (isset($_SESSION['codigo'])){$pass = $_SESSION['codigo'];}
if (isset($_SESSION['usuario'])){$usuario = $_SESSION['usuario'];}
if (isset($_SESSION['rol'])){$rol = $_SESSION['rol'];}
if (isset($_GET['eliminar'])) {
  eliminarUsuario($_GET['eliminar']);
}


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
  <title>MS 381</title>
  <style>
    map:hover .a {
      background: red;
    }
  </style>
  </head>

  <body>
    <?php
    $pagina = 1;
    include('lib/templates/nav2.php');
    ?>

    <!-- Begin Page Content -->


    <div class="page-body">
      <div class="container-fluid card shadow mt-4  card-principal-page">
        <!-- Aqui imprimmimos el producto-->
        <div class="row">
          <div class="col mt-3">
            <button class="btn btn-primary" onclick="ocultarImagen('carter');">carter</button>
            <button class="btn btn-secondary" onclick="ocultarImagen('cilindro');">cilindro</button>
            <button class="btn btn-success" onclick="ocultarImagen('silenciador');">silenciador</button>
            <button class="btn btn-danger" onclick="ocultarImagen('bomba');">bomba de aceite</button>
            <button class="btn btn-warning" onclick="ocultarImagen('embrague');">embrague</button>
          </div>
        </div>
        <div class="row justify-content-center">


          <div class="col-auto">

            <img width="596" src="./img/stihl/ms381/ms381.jpg" loading="lazy" alt="" id="carter" usemap="#mapa">
            <map class="a" name="mapa" id="mapa">
              <area class="a" shape="circle" coords="218,88,10" href="#" onclick="recuperarRep('1119 020 2122',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="1">
              <area class="a" shape="circle" coords="547,267,10" href="#" onclick="recuperarRep('1119 020 2122',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="1">
              <area class="a" shape="circle" coords="153,226,10" href="#" onclick="recuperarRep('9371 470 2610',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="2">
              <area class="a" shape="circle" coords="46,230,10" href="#" onclick="recuperarRep('0000 988 5211',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="3">
              <area class="a" shape="circle" coords="524,351,10" href="#" onclick="recuperarRep('1118 162 5200',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="4">
              <area class="a" shape="circle" coords="551,300,10" href="#" onclick="recuperarRep('1117 162 5225',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="5">
              <area class="a" shape="circle" coords="570,312,10" href="#" onclick="recuperarRep('1128 640 9100',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="6">
              <area class="a" shape="circle" coords="338,223,10" href="#" onclick="recuperarRep('1118 028 7400',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="7">
              <area class="a" shape="circle" coords="456,403,10" href="#" onclick="recuperarRep('9022 341 1010',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="8">
              <area class="a" shape="circle" coords="495,406,10" href="#" onclick="recuperarRep('9456 621 4330',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="9">
              <area class="a" shape="circle" coords="281,302,10" href="#" onclick="recuperarRep('9503 003 0440',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="10">
              <area class="a" shape="circle" coords="174,241,10" href="#" onclick="recuperarRep('9503 003 0341',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="11">
              <area class="a" shape="circle" coords="544,351,10" href="#" onclick="recuperarRep('1138 664 2400',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="12">
              <area class="a" shape="circle" coords="518,421,10" href="#" onclick="recuperarRep('9640 003 1880',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="13">
              <area class="a" shape="circle" coords="98,101,10" href="#" onclick="recuperarRep('9640 003 1340',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="14">
              <area class="a" shape="circle" coords="365,198,10" href="#" onclick="recuperarRep('1106 647 9404',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="15">
              <area class="a" shape="circle" coords="393,171,10" href="#" onclick="recuperarRep('1106 640 3801',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="16">
              <area class="a" shape="circle" coords="307,320,10" href="#" onclick="recuperarRep('1119 029 0500',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="17">
              <area class="a" shape="circle" coords="229,273,10" href="#" onclick="recuperarRep('1119 030 0400',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="18">
              <area class="a" shape="circle" coords="204,259,10" href="#" onclick="recuperarRep('1120 036 8500',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="19">
              <area class="a" shape="circle" coords="97,34,10" href="#" onclick="recuperarRep('0000 350 0537',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="20">
              <area class="a" shape="circle" coords="126,52,10" href="#" onclick="recuperarRep('9645 948 2470',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="21">

            </map>
          </div>
          <div class="col-auto">
            <img width="596" src="./img/stihl/ms381/cilindroms381.png" loading="lazy" alt="" id="cilindro" usemap="#mapa2">
            <map class="a" name="mapa" id="mapa2">
              <area class="a" shape="circle" coords="240,25,10" href="#" onclick="recuperarRep('1119 020 1204',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="1">
              <area class="a" shape="circle" coords="236,415,10" href="#" onclick="recuperarRep('1119 030 2003',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="2">
              <area class="a" shape="circle" coords="237,323,10" href="#" onclick="recuperarRep('1115 034 3010',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="3">
              <area class="a" shape="circle" coords="386,399,10" href="#" onclick="recuperarRep('1122 034 1500',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="4">
              <area class="a" shape="circle" coords="208,386,10" href="#" onclick="recuperarRep('9463 650 1200',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="5">
              <area class="a" shape="circle" coords="417,420,10" href="#" onclick="recuperarRep('9463 650 1200',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="5">
              <area class="a" shape="circle" coords="267,475,10" href="#" onclick="recuperarRep('9512 003 3140',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="6">
              <area class="a" shape="circle" coords="465,86,10" href="#" onclick="recuperarRep('1124 020 9401',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="7">
              <area class="a" shape="circle" coords="189,270,10" href="#" onclick="recuperarRep('1119 029 2302',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="8">
              <area class="a" shape="circle" coords="395,270,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="9">
              <area class="a" shape="circle" coords="428,139,10" href="#" onclick="recuperarRep('9022 341 1010',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="10">
              <area class="a" shape="circle" coords="127,35,10" href="#" onclick="recuperarRep('0000 400 7000',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="11">
              <area class="a" shape="circle" coords="151,35,10" href="#" onclick="recuperarRep('1110 400 7005',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="12">
              <area class="a" shape="circle" coords="138,161,10" href="#" onclick="recuperarRep('1119 140 2500',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="13">
              <area class="a" shape="circle" coords="172,138,10" href="#" onclick="recuperarRep('9771 021 2578',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="14">
              <area class="a" shape="circle" coords="98,177,10" href="#" onclick="recuperarRep('1119 141 1800',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="15">
              <area class="a" shape="circle" coords="209,272,10" href="#" onclick="recuperarRep('1119 007 1050',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="16">
              <area class="a" shape="circle" coords="233,270,10" href="#" onclick="recuperarRep('1119 007 1051',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="17">
             
            </map>
          </div>
          <div class="col-auto">
            <img width="596" src="./img/stihl/ms381/silenciadorms381.png" loading="lazy" alt="" id="silenciador" usemap="#mapa3">
            <map class="a" name="mapa" id="mapa3">
              <area class="a" shape="circle" coords="150,53,10" href="#" onclick="recuperarRep('1119 140 0602',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="1">
              <area class="a" shape="circle" coords="289,28,10" href="#" onclick="recuperarRep('1119 145 0803',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="1">
              <area class="a" shape="circle" coords="150,326,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="2">
              <area class="a" shape="circle" coords="46,230,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="3">
              <area class="a" shape="circle" coords="524,351,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="4">
              <area class="a" shape="circle" coords="473,198,10" href="#" onclick="recuperarRep('9022 341 1010',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="5">
              <area class="a" shape="circle" coords="232,41,10" href="#" onclick="recuperarRep('9022 341 1010',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="6">
              <area class="a" shape="circle" coords="350,19,10" href="#" onclick="recuperarRep('9022 341 0910',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="7">
              <area class="a" shape="circle" coords="72,398,10" href="#" onclick="recuperarRep('1125 149 0601',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="8">
             
            </map>
          </div>
          <div class="col-auto">
            <img width="675" src="./img/stihl/ms381/bombams381.png" loading="lazy" alt="" id="bomba" usemap="#mapa4">
            <map class="a" name="mapa" id="mapa4">
              <area class="a" shape="circle" coords="313,227,10" href="#" onclick="recuperarRep('1117 649 1100',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="1">
              <area class="a" shape="circle" coords="512,255,10" href="#" onclick="recuperarRep('1117 640 3001',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="1">
              <area class="a" shape="circle" coords="540,270,10" href="#" onclick="recuperarRep('9643 950 1160',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="2">
              <area class="a" shape="circle" coords="569,288,10" href="#" onclick="recuperarRep('0000 958 0406',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="3">
              <area class="a" shape="circle" coords="653,340,10" href="#" onclick="recuperarRep('1119 640 7100',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="4">
              <area class="a" shape="circle" coords="377,420,10" href="#" onclick="recuperarRep('0000 958 0701',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="5">
              <area class="a" shape="circle" coords="339,309,10" href="#" onclick="recuperarRep('0000 958 0701',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="5">
              <area class="a" shape="circle" coords="309,323,10" href="#" onclick="recuperarRep('0000 997 1010',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="6">
              <area class="a" shape="circle" coords="273,346,10" href="#" onclick="recuperarRep('1117 647 0601',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="7">
              <area class="a" shape="circle" coords="238,366,10" href="#" onclick="recuperarRep('0000 988 6220',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="8">
              <area class="a" shape="circle" coords="376,395,10" href="#" onclick="recuperarRep('9646 945 0490',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="9">
              <area class="a" shape="circle" coords="375,449,10" href="#" onclick="recuperarRep('0000 997 1200',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="10">
              <area class="a" shape="circle" coords="374,490,10" href="#" onclick="recuperarRep('1117 647 4801',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="11">
              <area class="a" shape="circle" coords="477,235,10" href="#" onclick="recuperarRep('9646 945 0230',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="12">
              <area class="a" shape="circle" coords="479,204,10" href="#" onclick="recuperarRep('9486 648 0100',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="13">
              <area class="a" shape="circle" coords="370,195,10" href="#" onclick="recuperarRep('1117 647 9800',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="14">
              <area class="a" shape="circle" coords="377,530,10" href="#" onclick="recuperarRep('0000 989 0401',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="15">
              <area class="a" shape="circle" coords="542,343,10" href="#" onclick="recuperarRep('9022 313 0740',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="16">
              <area class="a" shape="circle" coords="529,137,10" href="#" onclick="recuperarRep('1119 640 3200',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="17">
              <area class="a" shape="circle" coords="90,484,10" href="#" onclick="recuperarRep('1119 007 1050',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="18">
              <area class="a" shape="circle" coords="92,519,10" href="#" onclick="recuperarRep('1119 007 1051',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="19">
            
            </map>
          </div>
          <div class="col-auto">
            <img width="652" src="./img/stihl/ms381/embrague381.png" loading="lazy" alt="" id="embrague" usemap="#mapa5">
            <map class="a" name="mapa" id="mapa5">
              <area class="a" shape="circle" coords="240,25,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="1">
              <area class="a" shape="circle" coords="236,415,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="1">
              <area class="a" shape="circle" coords="237,323,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="2">
              <area class="a" shape="circle" coords="46,230,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="3">
              <area class="a" shape="circle" coords="524,351,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="4">
              <area class="a" shape="circle" coords="551,300,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="5">
              <area class="a" shape="circle" coords="570,312,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="6">
              <area class="a" shape="circle" coords="338,223,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="7">
              <area class="a" shape="circle" coords="456,403,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="8">
              <area class="a" shape="circle" coords="495,406,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="9">
              <area class="a" shape="circle" coords="281,302,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="10">
              <area class="a" shape="circle" coords="174,241,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="11">
              <area class="a" shape="circle" coords="544,351,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="12">
              <area class="a" shape="circle" coords="518,421,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="13">
              <area class="a" shape="circle" coords="98,101,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="14">
              <area class="a" shape="circle" coords="365,198,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="15">
              <area class="a" shape="circle" coords="393,171,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="16">
              <area class="a" shape="circle" coords="307,320,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="17">
              <area class="a" shape="circle" coords="229,273,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="18">
              <area class="a" shape="circle" coords="204,259,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="19">
              <area class="a" shape="circle" coords="97,34,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="20">
              <area class="a" shape="circle" coords="126,52,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="21">

            </map>
          </div>
          <!--
          <div class="col-auto">
            <img width="100%" src="./img/stihl/ms381/silenciadorms381.png" loading="lazy" alt="" id="silenciador" usemap="#mapa3">
            <map class="a" name="mapa" id="mapa3">
              <area class="a" shape="circle" coords="240,25,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="1">
              <area class="a" shape="circle" coords="236,415,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="1">
              <area class="a" shape="circle" coords="237,323,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="2">
              <area class="a" shape="circle" coords="46,230,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="3">
              <area class="a" shape="circle" coords="524,351,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="4">
              <area class="a" shape="circle" coords="551,300,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="5">
              <area class="a" shape="circle" coords="570,312,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="6">
              <area class="a" shape="circle" coords="338,223,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="7">
              <area class="a" shape="circle" coords="456,403,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="8">
              <area class="a" shape="circle" coords="495,406,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="9">
              <area class="a" shape="circle" coords="281,302,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="10">
              <area class="a" shape="circle" coords="174,241,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="11">
              <area class="a" shape="circle" coords="544,351,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="12">
              <area class="a" shape="circle" coords="518,421,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="13">
              <area class="a" shape="circle" coords="98,101,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="14">
              <area class="a" shape="circle" coords="365,198,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="15">
              <area class="a" shape="circle" coords="393,171,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="16">
              <area class="a" shape="circle" coords="307,320,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="17">
              <area class="a" shape="circle" coords="229,273,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="18">
              <area class="a" shape="circle" coords="204,259,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="19">
              <area class="a" shape="circle" coords="97,34,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="20">
              <area class="a" shape="circle" coords="126,52,10" href="#" onclick="recuperarRep('',<?php echo $rol; ?>, <?php echo $idventaProducto; ?>, '<?php echo $pass; ?>');" alt="21">

            </map>
          </div>
         -->
        </div>
      </div>
    </div>
    <?php include('lib/templates/modal.php'); ?>



  <?php } ?>



  <?php include('lib/templates/footer.php'); ?>

  <script>
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
          title: 'no tienes producto para rebajar existencia ' + arg_cantidad,
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


    function ocultarImagen(id) {
      if (id === "0") {
        document.getElementById('cilindro').style.display = "none";
        document.getElementById('silenciador').style.display = "none";
        document.getElementById('bomba').style.display = "none";
        document.getElementById('embrague').style.display = "none";
      } else {
        var x = document.getElementById(id);
        if (id === "carter") {
          x.style.display = "block";
          document.getElementById('cilindro').style.display = "none";
          document.getElementById('silenciador').style.display = "none";
          document.getElementById('bomba').style.display = "none";
          document.getElementById('embrague').style.display = "none";
        }
        if(id === "cilindro"){
          x.style.display = "block";
          document.getElementById('carter').style.display = "none";
          document.getElementById('silenciador').style.display = "none";
          document.getElementById('bomba').style.display = "none";
          document.getElementById('embrague').style.display = "none";
        }
        if(id === "silenciador"){
          x.style.display = "block";
          document.getElementById('carter').style.display = "none";
          document.getElementById('cilindro').style.display = "none";
          document.getElementById('bomba').style.display = "none";
          document.getElementById('embrague').style.display = "none";
        }
        if(id === "bomba"){
          x.style.display = "block";
          document.getElementById('carter').style.display = "none";
          document.getElementById('cilindro').style.display = "none";
          document.getElementById('silenciador').style.display = "none";
          document.getElementById('embrague').style.display = "none";
        }
        if(id === "embrague"){
          x.style.display = "block";
          document.getElementById('carter').style.display = "none";
          document.getElementById('cilindro').style.display = "none";
          document.getElementById('silenciador').style.display = "none";
          document.getElementById('bomba').style.display = "none";
        }
      }

      
    }
    ocultarImagen('0');
  </script>


  </body>

  </html>