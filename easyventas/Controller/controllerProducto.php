<?php

require_once('../Model/class.conexion.php');
require_once('../Model/class.producto.php');

$consult = new Producto();

/*
1 = getBuscarProducto($busqueda)
2 = getObtenerProductos()
3 = setModificarProducto($arg_codigo, $arg_descripcion, $arg_cantidad, $arg_precio,$imagen)
4 =setComprarProducto($compra)
5 = setEliminarProducto($eliminar)
6 = getProductoUbicacion($ubicacion)
7 = setModificarDetalleProducto(codigo)
*/

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (isset($_GET['ubicacion'])) {
    $ubicacion = $_GET['ubicacion'];
}
$data = "";
switch ($id) {
    case 1:
        break;
    case 2:
        $data = $consult->getObtenerProductos();
        break;
    case 3:
        break;
    case 4:
        break;
    case 5:
        break;
    case 6:
        $data = $consult->getProductoUbicacion($ubicacion);
        break;
    case 7:
        $cantidad = $_POST["cantidad"];
        $oldCantidad = $_POST["oldCantidad"];
        $oldBodega = $_POST["oldBodega"];
        $proveedor = $_POST["proveedor"];
        $ubicacion = $_POST["ubicacion"];
        $repuesto = $_POST["idrepuesto"];
        $codigoRepuesto = $_POST['codigoPr'];
        $inventario = $_POST['inventario']; //puede ser 1 o 2 
        $usuario = $_POST["usuario"];
        $precio = $_POST["precio"];
        $validar_numeros = "1234567890.";
        $actualizar_cantidad;
        ini_set('date.timezone', 'America/Guatemala');
        $fecha = date('y-m-j');
        $mensaje = null;

        if (strlen($cantidad) > 0 && strlen($proveedor) > 0 && strlen($ubicacion) > 0 && strlen($repuesto) > 0 && strlen($oldBodega) > 0) {



            for ($i = 0; $i < strlen($precio); $i++) {
                if (strpos($validar_numeros, substr($precio, $i, 1)) === false) {
                    echo "Caracteres no validos para el campo precio";
                    return false;
                }
            }
            for ($i = 0; $i < strlen($cantidad); $i++) {
                if (strpos($validar_numeros, substr($cantidad, $i, 1)) === false) {
                    echo "Caracteres no validos para el campo cantidad";
                    return false;
                }
            }

            $mensaje = $consult->setModificarDetalleProducto($fecha, $cantidad, $oldBodega, $proveedor, $ubicacion, $repuesto, $precio, $inventario, $oldCantidad);
            $datos = $consult->setRecuperarCantidadDetalleRepuesto($codigoRepuesto);
            $cantidadTotal = "";
            foreach ($datos as $filas) {
                $cantidadTotal = $filas['cantidad'];
            }
            $consult->setActualizarCantidadRepuesto($cantidadTotal, $codigoRepuesto);
        } else {


            $mensaje = "2"; //<h2>Debes llenar los campos</h2>";

        }

        $data = $mensaje;

        break;
    case 8:
        $data = $consult->getProductosInventario();
        break;
    case 9:
        $codigo = $_POST['codigopr'];
        $cantidad = $_POST['cantidadpr'];
        $data = $consult->setCuadrarInventario($codigo, $cantidad);

        break;
    case 10:
        $consult->setInventarioCero();
        $data = "1";
        break;
    case 11:
        $arg_codigo = $_POST['codigo'];
        $consult->setEliminarDetorden($arg_codigo);
        $consult->setEliminarDetenvio($arg_codigo);
        $consult->setEliminarDetalleVenta($arg_codigo);
        $consult->setEliminarDetalleProducto($arg_codigo);
        $consult->setEliminarProducto($arg_codigo);
        $data = $arg_codigo;
        break;
    case 12:
        $Datos = json_decode(file_get_contents("php://input"));
        // Si no hay datos, salir inmediatamente indicando un error 500
        if (!$Datos) {
            // https://parzibyte.me/blog/2021/01/17/php-enviar-codigo-error-500/
            http_response_code(500);
            exit;
        }

        $codProducto = $Datos->codigo;

        //$codProducto = $_POST['codigo'];


        $data = $consult->getBuscarDetalleProducto($codProducto);

       
        break;
    default:
        $data = "no hay datos que mostrar";
        break;
}

print_r($data);
