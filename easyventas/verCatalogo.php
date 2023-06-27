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
if (!isset($_SESSION['codigo'])) {
    header("location: login.php");
} else {



    require_once('Model/class.conexion.php');
    require_once('Model/class.consultas.php');
    require_once('Controller/cargarDatos.php');
    require_once('Controller/Eliminar.php');
    include('lib/templates/header.php');
    $consultas = new consultas();
    $datos = $consultas->cargarProductoCatalogo();
    $producto = array();
    $com = '';
    foreach ($datos as $filas) {
        $com = utf8_encode($filas['codigo'] . ' ' . $filas['producto']);
        array_push($producto, $com);
    }
?>
    <title>ver Facturas</title>
    </head>

    <body>
        <header>

        </header>

        </div>

        <?php
        $pagina = 15;
        include('lib/templates/nav2.php');
        ?>

        <input type="hidden" id="codigoUsuario" value="<?php echo $pass; ?>">


        <input type="hidden" id="idventaFacturado" value="" disabled>
        <input type="hidden" id="idventaFact" value="" disabled>


        <div class="page-body">
            <div class="container-fluid card shadow mt-4 card-principal-page">
                <div class="content-principal-page">
                    <div class="table-responsive mt-4">
                        <table id="tabla" class="table table-sm table-hover table-striped table-bordered text-primary " style="width:100%">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="text-light">ID</th>
                                    <th class="text-light">DETALLE</th>

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


        <!--Modal ver producto-->
        <!-- Modal -->
        <div class="modal fade" id="modalDetalleProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-detalle">
                        <h5 class="modal-title" id="exampleModalLabel"><span id="tituloCatalogo"></span></h5>
                        <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive mt-4">
                            <input type="hidden" id="idCatalogo">
                            <input type="hidden" id="precioTotal">
                            <input type="hidden" id="tituloCatalogos">
                            <table class="table table-sm table-hover table-striped table-bordered text-primary " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>CANTIDAD</th>
                                        <th>CODIGO</th>
                                        <th>DESCRIPCION</th>
                                        <th>MARCA</th>
                                        <th>PRECIO</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaCatalogo">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td>TOTAL</td>
                                        <td><span id="totalCatalogo"></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <input type="hidden" id="idProducto">
                        <input type="hidden" id="id_Catalogo">
                        <div class="input-group">
                            <input class="form-control" type="text" id="cargarProducto" placeholder="AGREGAR PRODUCTO A CATALOGO">
                            <span class="input-group-text bg-success">
                                <button class="btn btn-success agregarItemCatalogo" title="Agregar a catalogo" ><span class="material-symbols-outlined">
                                        add_task
                                    </span></button>
                            </span>

                        </div>

                    </div>
                    <div class="modal-footer">


                        <button class="btn btn-primary" onclick="generarPdfCatalogo();"><span class="material-symbols-outlined">
                                picture_as_pdf
                            </span></button>
                        <button class="btn btn-danger" data-bs-dismiss="modal"><span class="material-symbols-outlined">
                                close
                            </span></button>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal para crear catalogo-->
        <!-- Modal -->
        <div class="modal fade" id="modalCrearCatalogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CREAR CATALOGO DE PRODUCTOS</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-text bg-primary">DESCRIPCION</span>
                            <input class="form-control" type="text" id="descripcionCatalogo" placeholder="Descripcion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                        <div class="input-group">
                            <select class="form-select" name="tiopoCatalogo" id="tipoCatalogo">
                                <option value="0">COMBO</option>
                                <option value="1">LISTADO DE PRODUCTOS</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary cerrar" onclick="crearCatalogo();" data-bs-dismiss="modal">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal para agregar cantidad a catalogo-->
        <!-- Modal -->
        <div class="modal fade" id="modalCantidadItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CREAR CATALOGO DE PRODUCTOS</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="codigoItem">
                        <input type="hidden" id="catalogoItem">
                        <div class="input-group">
                            <span class="input-group-text bg-primary">CANTIDAD</span>
                            <input class="form-control" type="text" id="cantidadItem" placeholder="CANTIDAD">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="agregarItemCatalogo();" data-bs-dismiss="modal">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

    <?php
}

include('lib/templates/footer.php'); ?>

    <script>
        var availableTags = <?= json_encode($producto) ?>;

        $("#cargarProducto").autocomplete({
            appendTo: "#modalDetalleProducto",
            source: availableTags,
            select: function(event, item) {
                var params = {
                    idProducto: item.item.value
                }
                $.get("Controller/buscarProductoCatalogo.php", params, function(response) {
                    var json = JSON.parse(response);
                    $("#idProducto").val(json[0].codigo);

                    if (json.length > 0) {
                        document.getElementById("idProducto").value = json[0].codigo;


                    } else {

                    }

                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var funcion = "listar";
            let datatable = $('#clientes').DataTable({

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
                        "defaultContent": `
          <div class="btns-grooup">
          <button class="detalles btns btn-color-red"><span class="material-symbols-outlined">
check
</span></button>
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
                    "lengthMenu": "Mostrar _MENU_ reg",
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



            });

            $('#clientes tbody').on('click', '.detalles', function() {
                let data = datatable.row($(this).parents()).data();
                obtenerIdCliente(data.id);
                alertify.success("Cliente seleccionado");
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var funcion = "listar2";
            let datatable = $('#tabla').DataTable({
                "order": [
                    [0, "desc"]
                ],

                "ajax": {
                    "method": "POST",
                    "url": "Controller/cargarCatalogo.php",
                    "dataSrc": ""
                },
                "columns": [{
                        "data": "idcatalogo"
                    },
                    {
                        "data": "descripcion"
                    },

                    {
                        "defaultContent": `
          <div class="btns-group">
          <button class="detalles3 btns btn-color-green"><i class="material-icons" alt="VER PRODUCTOS" title="VER PRODUCTOS">read_more</i></button>
          
          `
                    }
                ],
                "fnRowCallback": function(nRow, data, iDisplayIndex, iDisplayIndexFull) {
                    if (data.estado == 0) {
                        $(nRow).css('color', 'red')
                    } else {}
                },
                select: true,
                language: {
                    "lengthMenu": "Mostrar _MENU_ reg",
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



            });

            $('#tabla tbody').on('click', '.detalles2', function() {
                let data = datatable.row($(this).parents()).data();
                if (data.estado == 0) {
                    recuperarDatosVenta(data.usuario, data.idventa, data.estado);
                    $('#modalClienteFactura').modal('toggle');
                } else {
                    Swal.fire(
                        'DTE Facturado!',
                        'Esta factura ya ha sido atendida.',
                        'error'
                    )
                }

            });
            $('#tabla tbody').on('click', '.detalles3', function() {
                let data = datatable.row($(this).parents()).data();
                let idCatalogo = data.idcatalogo;
                let tipo = data.type;
                document.getElementById('id_Catalogo').value = data.idcatalogo;
                document.getElementById('cargarProducto').value = '';
                document.getElementById('idProducto').value = '';
                $('#modalDetalleProducto').modal('toggle');
                recuperarDatosCatalogo(idCatalogo, tipo);


            });
            $(".cerrar").click(function(e) {
                e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página


                console.log(idCatalogo);

                var url = "";

                $.ajax({
                    type: "post",
                    url: url,
                    data: {

                    },
                    success: function(datos) {
                        datatable.ajax.reload(null, false);




                    }
                });
            });

        });

        btnAgregar = document.querySelector(".agregarItemCatalogo");
        btnAgregar.onclick = async () => {
            var idProducto = document.getElementById("idProducto").value
            var itemCatalogo = document.getElementById('id_Catalogo').value
            if (idProducto == '') {

                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'CAMPO VACIO!',
                    showConfirmButton: false,
                    timer: 1500
                })
               
            } else {
                $('#modalDetalleProducto').modal('hide');
                document.getElementById('catalogoItem').value = itemCatalogo;
                document.getElementById('codigoItem').value = idProducto;
                $('#modalCantidadItem').modal('toggle');
            }
        }
        async function recuperarDatosCatalogo(catalogo, tipo) {
            var tipo = tipo;
            const datos = {
                idcatalogo: catalogo,

            };
            const datosCodificados = JSON.stringify(datos);
            const url = "Controller/buscarCatalogo.php";
            const respuestaRaw = await fetch(url, {
                method: "POST",
                body: datosCodificados
            });
            const respuesta = await respuestaRaw.json();
            var total = 0;
            var precio = 0;
            if (respuesta == null) {
                document.getElementById("tablaCatalogo").innerHTML = "";
                document.getElementById("totalCatalogo").innerHTML = 'Q ' + total;
            } else {

                document.getElementById("tituloCatalogo").innerHTML = respuesta[0].catalogo;
                document.getElementById("tituloCatalogos").value = respuesta[0].catalogo;
                document.getElementById("tablaCatalogo").innerHTML = "";


                for (let item of respuesta) {
                    total = total + (item.cantidad * item.precio);
                    precio = item.cantidad * item.precio;
                    document.getElementById("tablaCatalogo").innerHTML += `
            
            <tr>
            <td>${item.cantidad}</td>
            <td>${item.codigo}</td>
            <td>${item.descripcion}</td>
            <td>${item.marca}</td>
            <td>${item.precio}</td>
            <td>${precio}</td>
            </tr>
            
         
            `;
                }

                document.getElementById("totalCatalogo").innerHTML = 'Q ' + total;
                document.getElementById("precioTotal").value = total
                document.getElementById("idCatalogo").value = catalogo
            }
        }
        async function generarPdfCatalogo() {
            var arg_idCatalogo = document.getElementById("idCatalogo").value
            var arg_totalCatalogo = document.getElementById("precioTotal").value
            var tituloCatalogo = document.getElementById("tituloCatalogos").value



            //var url= "Controller/generarFactura.php";
            window.open("Controller/generarCatalogo.php?idCatalogo=" + arg_idCatalogo + "&totalCatalogo=" + arg_totalCatalogo + "&tituloCatalogo=" + tituloCatalogo, "catalogo", "width=900, height=600");

        }

        async function crearCatalogo() {
            var tipoCatalogo = document.getElementById('tipoCatalogo').value;
            var descripcionCatalogo = document.getElementById('descripcionCatalogo').value;

            const datos = {
                tipo: tipoCatalogo,
                descripcion: descripcionCatalogo
            };
            const datosCodificados = JSON.stringify(datos);
            const url = "Controller/crearCatalogo.php";
            const respuestaRaw = await fetch(url, {
                method: "POST",
                body: datosCodificados
            });

            json = await respuestaRaw.json();

            alertify(json);

        }

        async function agregarItemCatalogo() {
            var arg_idProducto = document.getElementById('codigoItem').value
            var arg_cantidad = document.getElementById('cantidadItem').value
            var arg_catalogo = document.getElementById('catalogoItem').value
            const datos = {
                idProducto: arg_idProducto,
                cantidad: arg_cantidad,
                catalogo: arg_catalogo
            };

            const datosCodificados = JSON.stringify(datos);
            const url = "Controller/agregarProductoCatalogo.php";
            const respuestaRaw = await fetch(url, {
                method: "POST",
                body: datosCodificados
            });

            json = await respuestaRaw.json();


            Swal.fire({
                position: 'center',
                icon: 'success',
                title: json,
                showConfirmButton: false,
                timer: 1500
            })
            document.getElementById('cargarProducto').value = '';
            document.getElementById('idProducto').value = '';
            document.getElementById('cantidadItem').value = '';
            $('#modalDetalleProducto').modal('toggle');

            recuperarDatosCatalogo(arg_catalogo, 0);



        }
    </script>
    </body>

    </html>