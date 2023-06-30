<main>
<!-- Page Wrapper -->
<div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    
    <button class="btn btn-light btn-sm"><img width="100px" src="img/banner1.png"></button>

  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
   
    <?php
      if($pagina == 2){
      ?>
        <a href="verEnvio.php" class="btn btn-warning text-danger">VER ORDEN</a>

      <?php
      }else if($pagina == 3){
        ?>
          <a href="cotizacion.php" class="btn btn-warning text-danger">VER COTIZACION</a>
        <?php
      }else{}
          ?>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">


  <!-- Nav Item - Utilities Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-wrench"></i>
      <span>UTILIDADES</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">UTILIDADES:</h6>
        <?php if($pagina == 1){ ?>
      
        
        <a class="collapse-item" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">Nuevo Producto</a>
        <a class="collapse-item" data-bs-toggle="modal" data-bs-target="#modalNuevaMarca">Crear Marca</a>
        <a class="collapse-item" data-bs-toggle="modal" data-bs-target="#modalNuevoProveedor">Nuevo Proveedor</a>
        <a class="collapse-item" data-bs-toggle="modal" data-bs-target="#modalNuevaBodega">Crear Bodega</a>
        <?php } ?>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Addons
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item active">
    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
      <i class="fas fa-fw fa-folder"></i>
      <span>Paginas</span>
    </a>
    <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-bs-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">PRODUCTOS:</h6>
        <?php if($rol == 2){ ?>
        <a class="collapse-item" href="empleado.php">EMPLEADOS</a>
        <?php } ?>
        <a class="collapse-item" href="verProducto.php?pagina=1">PRODUCTOS</a>
        <a class="collapse-item" href="envios.php?pagina=2">ENVIOS</a>
        <a class="collapse-item" href="ventasUsuario.php">VENTAS</a>
        <a class="collapse-item" href="factura.php">FACTURACION</a>
        <a class="collapse-item" href="prorat.php">CUOTAS</a></a>
        <a class="collapse-item" href="cliente.php">CLIENTES</a>
        <a class="collapse-item" href="verMotos.php">MOTOS</a>
        <a class="collapse-item" href="proveedores.php">PROVEEDORES</a>
        <a class="collapse-item" href="cotizar.php">COTIZACION</a>
        <a class="collapse-item" href="verCatalogo.php">CATALOGOS</a>
      </div>
    </div>
  </li>


  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->



 <!-- Content Wrapper -->
 <div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div class="cabecera1" id="content">

  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-primary topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none bg-light rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>

    

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

      <?php
      if($pagina == 1){ ?>
        <button class="btn btn-danger btn-sm" onclick="generarVenta();">Generar Venta</button>
      <?php
      }else if($pagina == 3){
      ?>
      <button class="btn btn-danger btn-sm" onclick="generarCotizar();">Generar Cotizacion</button>

          <?php
      }else if($pagina == 2){
          ?>
          <button class="btn btn-danger  btn-sm" onclick="generar_envio();">Generar Envio</button>

      <?php
      }else{

      }
          ?>
      <div class="topbar-divider d-none d-sm-block"></div>

      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="btn btn-success mr-2" href=""><img width="25px" src="img/82202.svg" alt=""> <?php echo $usuario; ?></span>     
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
          </a>
          <a class="dropdown-item" href="#">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
          </a>
          <a class="dropdown-item" href="#">
            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
            Activity Log
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item bg-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
          <img  width="20px" src="img/cerrar2.png">
            SALIR
          </a>
        </div>
      </li>

    </ul>

  </nav>
  <!-- End of Topbar -->

  <!-- Begin Page Content -->
  <div class="container-fluid" id="cabecera1">

    

  