<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
  <!-- Page Header Start-->
  <div class="page-header menu-horizontal">
    <div class="header-wrapper">
      <form class="form-inline search-full col" action="#" method="get">
        <div class="form-group w-100">
          <div class="Typeahead Typeahead--twitterUsers">
            <div class="u-posRelative">
              <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Buscar .." name="q" title="" autofocus>
              <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
            </div>
            <div class="Typeahead-menu"></div>
          </div>
        </div>
      </form>
      <div class="header-logo-wrapper col-auto p-0">
        <div class="toggle-sidebar text-light"><span class="material-symbols-outlined">
            density_medium
          </span></div>
      </div>
      <div class="left-header col horizontal-wrapper ps-0 content-primary">
        <!-- contenido izquierdo del nav -->

      </div>
      <div class="nav-right col-8 pull-right right-header p-0">
        <ul class="nav-menus">
          <li class="language-nav">

            <?php
            switch ($pagina) {
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
                <button class="btn btn-danger" alt="Nueva Cotizacion" title="Nueva Cotizacion" onclick="generarCotizar();"><i class="material-icons">library_add</i></i></button>

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
                //contenido de la pagina verEnvio.php
              ?>

              <?php
                break;
              case 8:
              ?>

              <?php
                break;
              case 9:
              ?>

              <?php
                break;
              case 10:

              ?>
                <button class="btn btn-danger" alt="Insertar Moto" title="Insertar Moto" data-bs-toggle="modal" data-bs-target="#modalNuevaMoto"><i class="material-icons">library_add</i></button>

              <?php
                break;
              case 11:

              ?>
                <button class="btn btn-success" onclick="realizarPedido('<?php echo $nitProveedor; ?>');">limpiar tabla</button>

              <?php
                break;
              case 12:

              ?>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente"><i class="material-icons">library_add</i></button>

              <?php
                break;
              case 13:
              ?>
                <button class="btn btn-danger" alt="Iniciar inventario a 0" title="Iniciar inventario a 0" data-bs-toggle="modal" data-bs-target="#modalIniciarInventario"><span class="material-symbols-outlined">
                    upgrade
                  </span></button>

              <?php
                break;
              case 14:
              ?>


            <?php
                break;
                case 15:

                  ?>
                    <button class="btn btn-danger" alt="CREAR CATALOGO" title="CREAR CATALOGO" target="blank" data-bs-toggle="modal" data-bs-target="#modalCrearCatalogo"><i class="material-icons">library_add</i></button>
    
    
                <?php
                    break;
                  default:
                }
                ?>


          </li>


          <li class="onhover-dropdown content-primary">
            <div class="media profile-media "><?php if (empty($foto)) {
                                                echo '<span class="material-symbols-outlined">
                                                                                                    person
                                                                                                    </span>';
                                              } else {
                                                echo '<img class="b-r-10" width="40px" height="40px" src="Controller/' . $foto . '" alt="">';
                                              } ?>
              <div class="onhover-dropdown"><span><?php echo $usuario; ?></span>
              </div>
            </div>
            <ul class="profile-dropdown onhover-show-div">
              <li><a href="usuario.php"><i data-feather="user"></i><span>Cuenta </span></a></li>
              <li><a href="#"><i data-feather="mail"></i><span>Mensajes</span></a></li>
              <li><a href="#"><i data-feather="file-text"></i><span>Mi Agenda</span></a></li>
              <li><a href="#"><i data-feather="settings"></i><span>Configuración</span></a></li>
              <li><a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><span class="material-symbols-outlined">
                    logout
                  </span><span> salir</span></a>
              </li>
            </ul>
          </li>
        </ul>
      </div>

      <script class="result-template" type="text/x-handlebars-template">
        <div class="ProfileCard u-cf">                        
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName">{{name}}</div>
            </div>
            </div>
          </script>
      <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
    </div>
  </div>



  <!-- Page Header Ends -->


  <!-- Page Body Start-->
  <div class="page-body-wrapper">
    <!-- Page Sidebar Start-->
    <div class="sidebar-wrapper sidebar-left">
      <div>
        <div class="logo-wrapper"><a href="index"><img width="90px" class="img-fluid for-light" src="img/banner1.png" alt=""></a>
          <div class="back-btn"><i class="fa fa-angle-left"></i>
          </div>
          <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
          </div>
        </div>
        <div class="logo-icon-wrapper"><a href="index"><img class="img-fluid" src="lib/assets/images/logo/logo-icon.png" alt=""></a>
        </div>
        <nav class="sidebar-main">
          <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
          <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
              <li class="back-btn"><a href="index"><img class="img-fluid" src="lib/assets/images/logo/logo-icon.png" alt=""></a>
                <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
              </li>
              <li class="sidebar-list">

                <label class="badge badge-danger">4</label><a class="sidebar-link sidebar-title" href="#"><i data-feather="link"></i><span>Enlaces</span></a>
                <ul class="sidebar-submenu">
                  <li><a href="http://bizagi.sopesatotal.com/Prod_Sopesa1/" target="blank">BIZAGI</a></li>
                  <li><a href="http://emanager.crediopciones.com:8880/" target="blank">CREDIOPCIONES</a></li>
                  <li><a href="https://placas.sopesatotal.com/login" target="blank">PLACAS HONDA</a></li>
                  <li><a href="https://pos.zu.gt/" target="blank">ZU</a></li>

                </ul>


              </li>
              <li class="sidebar-main-title">
                <div>
                  <!-- muestra un boton en la parte superiro del sidebar -->
                  <?php
                  switch ($pagina) {
                    case 1:

                      break;
                    case 2:
                  ?>
                      <a href="verEnvio" class="btn btn-secondary btn-md text-light">VER ENVIOS GENERADOS</a>
                    <?php
                      break;
                    case 3:
                    ?>
                      <a href="cotizacion" class="btn btn-secondary btn-md text-light">VER COTIZACIONES</a>
                    <?php
                      break;
                    case 4:
                    ?>
                      <a href="orden" class="btn btn-secondary btn-md text-light ">VER ORDENES</a>
                    <?php
                    case 10:
                    ?>

                      <a class="btn btn-secondary btn-md text-light" href="verMotosVendidas">VER MOTOS VENDIDAS</a>

                    <?php
                      break;
                    default:
                    ?>
                      <hr>
                  <?php
                  }

                  ?>
                </div>
              </li>


              <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="index"><i data-feather="home"> </i><span>Dashboard</span></a></li>



              <li class="sidebar-list">

                <?php if ($pagina == 5) { ?>
                  <label class="badge badge-danger">2</label><a class="sidebar-link sidebar-title" href="#"><i data-feather="trending-up"></i><span>Reportes </span></a>
                  <ul class="sidebar-submenu">
                    <li><a class="collapse-item text-dark" data-bs-toggle="modal" data-bs-target="#modalCrearReporte" onclick="agregarUsuarioReporte(<?php echo $pass ?>)">REPORTE POR FECHA</a> </li>
                    <li><a class="collapse-item text-dark" href="Controller/totalVendidoMes" target="blank">REPORTE MENSUAL</a> </li>

                  </ul>
                <?php } else { ?>


                  <?php if ($rol == 2) {
                    if ($pagina == 13 || $pagina == 1 || $pagina == 14) {


                  ?>

                      <label class="badge badge-danger">8</label><a class="sidebar-link sidebar-title" href="#"><i data-feather="settings"></i><span>Settings </span></a>
                      <ul class="sidebar-submenu">
                        <li><a data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">NUEVO PRODUCTO</a></li>
                        <li><a data-bs-toggle="modal" data-bs-target="#modalNuevaMarca">CREAR MARCA</a></li>
                        <li><a data-bs-toggle="modal" data-bs-target="#modalNuevoProveedor">NUEVO PROVEEDOR</a></li>
                        <li><a data-bs-toggle="modal" data-bs-target="#modalNuevaBodega">CREAR BODEGA</a></li>
                        <li><a href="eliminarProducto">ELIMINAR PRODUCTO</a></li>
                        <li><a href="empleado">EMPLEADOS</a></li>
                        <li><a href="inventario">INVENTARIO</a></li>
                        <li><a href="verInventario">VER INVENTARIO</a></li>
                      </ul>
                    <?php
                    }
                  } else { ?>
                    <label class="badge badge-danger">0</label><a class="sidebar-link sidebar-title" href="#"><i data-feather="user"></i><span>Registros </span></a>
                    <ul class="sidebar-submenu">
                    </ul>
                <?php
                  }
                } ?>

              </li>


              <li class="sidebar-list">

                <label class="badge badge-danger">3</label><a class="sidebar-link sidebar-title" href="#"><i data-feather="shopping-bag"></i><span>Productos</span></a>
                <ul class="sidebar-submenu">


                  <li><a href="verProducto">PRODUCTOS</a></li>
                  <li><a href="ventasUsuario">VENTAS</a></li>
                  <li><a href="verFactura">FACTURACION</a></li>

                </ul>
              </li>

              <li class="sidebar-list">
                <label class="badge badge-danger">6</label><a class="sidebar-link sidebar-title" href="#"><i data-feather="zap"></i><span>Herramientas</span></a>
                <ul class="sidebar-submenu">
                  <li><a href="envios">ENVIOS</a></li>
                  <li><a href="prorat">CUOTAS</a></a></li>
                  <li><a href="cliente">CLIENTES</a></li>
                  <li><a href="verMotos">MOTOS</a></li>
                  <li><a href="proveedores">PROVEEDORES</a></li>
                  <li><a href="cotizar">COTIZACION</a></li>
                  <li><a href="verCatalogo">CATALOGOS</a></li>
                </ul>
              </li>

              <li class="sidebar-main-title">
                <div>

                  <p></p>
                </div>
              </li>
            </ul>
          </div>
          <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
      </div>
    </div>
    <!-- Page Sidebar Ends-->