 
 <main>
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <button class="btn btn-light btn-sm"><img width="50%" src="img/banner1.png"></button>
      </a>  
      <!-- Divider -->
      <hr class="sidebar-divider my-0">
        <!-- Nav Item - Dashboard -->
      <li class="nav-item">  
        <?php
        switch($pagina){
          case 1:
       
          break;
          case 2:
          ?>
            <a href="verEnvio.php" class="btn btn-warning text-danger btn-block">VER ENVIO</a>
          <?php
          break;
          case 3:
          ?>
            <a href="cotizacion.php" class="btn btn-warning text-danger btn-block">VER COTIZACION</a>
          <?php
          break;
          case 4:
          ?>
            <a href="orden.php" class="btn btn-warning text-danger btn-block">VER ORDEN</a>
          <?php
          break;
          default:
          ?>
          <hr>
          <?php
        }
        ?>
      </li>
      <?php if($pagina == 5){ ?>
        <!-- divider -->
      <hr class="sidebar-divider">
      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="far fa-file-pdf"></i>
          <span>REPORTES</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">REPORTES:</h6>
        
            <a class="collapse-item" data-toggle="modal" data-target="#modalCrearReporte" onclick="agregarUsuarioReporte(<?php echo $pass?>)">REPORTE POR FECHA</a> 
            <a class="collapse-item" target="blank" href="Controller/reporteVentas.php?codigo=<?php echo $pass?>">VER REPORTE DIARIO</a>
          </div>
        </div>
      </li>
      <?php }else{ ?>
        <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>UTILIDADES</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">UTILIDADES:</h6>
            <?php if($rol == 2 ){ ?>
            <a class="collapse-item" data-toggle="modal" data-target="#modalNuevoProducto">Nuevo Producto</a>
            <a class="collapse-item" data-toggle="modal" data-target="#modalNuevaMarca">Crear Marca</a>
            <a class="collapse-item" data-toggle="modal" data-target="#modalNuevoProveedor">Nuevo Proveedor</a>
            <a class="collapse-item" data-toggle="modal" data-target="#modalNuevaBodega">Crear Bodega</a>
            <?php } ?>
          </div>
        </div>
      </li>
      <?php } ?>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item active">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Paginas</span>
        </a>
        <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">PRODUCTOS:</h6>
            <?php if($rol == 2){ ?>
            <a class="collapse-item" href="empleado.php">EMPLEADOS</a>
            <?php } ?>
            <a class="collapse-item" href="verProducto.php?pagina=1">PRODUCTOS</a>
            <a class="collapse-item" href="ventasUsuario.php">VENTAS</a>
            <a class="collapse-item" href="envios.php?pagina=2">ENVIOS</a>
            <a class="collapse-item" href="verOrden.php?pagina=2">ORDEN DE REPARACION</a>
            <a class="collapse-item" href="factura.php">FACTURACION</a>
            <a class="collapse-item" href="prorat.php">CUOTAS</a></a>
            <a class="collapse-item" href="cliente.php">CLIENTES</a>
            <a class="collapse-item" href="verMotos.php">MOTOS</a>
            <a class="collapse-item" href="proveedores.php">PROVEEDORES</a>
            <a class="collapse-item" href="cotizar.php">COTIZACION</a>
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
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none bg-light rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>


        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Nav Item - Alerts -->
          <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="topbar-divider d-none d-sm-block"></div>
            <?php

            switch($pagina){
              case 1:
                ?>
                <button class="btn btn-danger" alt="Generar Venta" title="Generar Venta" onclick="generarVenta();"><i class="material-icons">library_add</i></button>
    
                <?php
              break;
              case 2:
                ?>
                <button class="btn btn-danger" alt="Generar Envio" title="Generar Envio" onclick="generar_envio();"><i class="material-icons">library_add</i></button>
    
                <?php
              break;
              case 3:
                ?>
                <button class="btn btn-danger" alt="Nueva Cotizacion" title="Nueva Orden" onclick="generarCotizar();"><i class="material-icons">library_add</i></i></button>
    
                <?php
              break;
              case 4:
                ?>
                <button class="btn btn-danger" alt="Generar Orden" title="Generar Orden" onclick="generar_orden();"><i class="material-icons">library_add</i></button>
    
                <?php
              break;
              case 5:

              break;
              case 6:
                ?>
                <button class="btn btn-danger" alt="Generar Orden" title="Generar Orden" onclick="generarOrden('<?php echo $pass; ?>');" target="blank"><i class="far fa-file-pdf"></i></button>
    
                <?php
              break;
              case 7:
                ?>
                <button class="btn btn-danger " alt="Generar Envio" title="Generar Envio" onclick="generarEnvio('<?php echo $pass; ?>');" target="blank"><i class="far fa-file-pdf"></i></button>
    
                <?php
              break;
              case 8:
                ?>
                <button class="btn btn-danger" alt="Generar Factura" title="Generar Factura" onclick="generarFactura('<?php echo $pass; ?>');" target="blank"><i class="far fa-file-pdf"></i></button>
      
                <?php
              break;
              case 9:
                ?>
                <button class="btn btn-danger" alt="COTIZAR" title="COTIZAR" onclick="generarCotizacion('<?php echo $pass; ?>','2');" target="blank"><i class="far fa-file-pdf"></i></button>
    
                <?php
              break;
              case 10:
                ?>
                <button  class="btn btn-danger" data-toggle="modal" data-target="#modalVenderMoto">GENERAR NOTA DE VENTA</button>
      
                <?php
              break;
              default:

            }

            ?>
            </a>
          </li>
          <div class="topbar-divider d-none d-sm-block"></div>
          <!-- Nav Item - User Information -->
          <li class="nav-item dropdown no-arrow">
        
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="btn btn-success mr-2" href=""><img width="25px" src="img/82202.svg" alt=""> <?php echo $usuario; ?></span>     
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <a class="dropdown-item" href="usuario.php">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                <span class="text-danger">Profile</span>
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
              <a class="dropdown-item bg-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                <img  width="20px" src="img/cerrar2.png">
                SALIR
              </a>
            </div>
          </li>
        </ul>
      </div>
    

  <!-- End of Topbar -->

    

  