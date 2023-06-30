<?php
class Producto
{



    public function getBuscarProducto($busqueda){
        $rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select r.codigo as codigo, r.descripcion as descripcion, r.cantidad, r.precio, m.descripcion as marca  from repuesto r, marca m where r.marca_id_marca = m.id_marca and r.codigo like '%".$busqueda."%' or r.marca_id_marca = m.id_marca and r.descripcion like '%".$busqueda."%' or r.marca_id_marca = m.id_marca and m.descripcion like '%".$busqueda."%'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
         
			return json_encode($rows, JSON_UNESCAPED_UNICODE);
       
    }
    public function getBuscarDetalleProducto($busqueda){
        $rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select d.iddetalle_repuesto as iddetalle, d.fecha, d.cantidad, r.cantidad as existencia, r.url_imagen, d.precio_compra, d.ubicacion_id_ubicacion as idubicacion, u.descripcion as ubicacion, p.nombre as proveedor, p.nit as idProveedor, r.codigo, m.descripcion as marca FROM repuesto r, marca m, detalle_repuesto d, ubicacion u, proveedor p WHERE d.ubicacion_id_ubicacion = u.id_ubicacion and d.proveedor_nit = p.nit and r.codigo = d.repuesto_codigo and m.id_marca = r.marca_id_marca and r.codigo = '$busqueda'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
         
			return json_encode($rows, JSON_UNESCAPED_UNICODE);
       
    }
    public function getProductosInventario(){
        $rows = null;
        $modelo = new Conexion();
        $conexion = $modelo->get_connection();
        $sql = "select r.codigo as codigo, r.descripcion as descripcion, r.cantidad, d.cantidad_inventario, r.precio from repuesto r, marca m, ubicacion u, detalle_repuesto d where r.marca_id_marca = m.id_marca AND r.codigo = d.repuesto_codigo AND u.id_ubicacion = d.ubicacion_id_ubicacion and d.cantidad != d.cantidad_inventario and d.inventario = 1 ";
        $statement = $conexion->prepare($sql);
        $statement->execute();
        while($result = $statement->fetch()){
            $rows[] = $result;
        }
     
        return json_encode($rows, JSON_UNESCAPED_UNICODE);
   
    }
    public function getObtenerProductos(){
        $rows = null;
        $modelo = new Conexion();
        $conexion = $modelo->get_connection();
        $sql = "select r.codigo as codigo, r.descripcion as descripcion, r.cantidad, r.precio, m.descripcion as marca  from repuesto r, marca m where r.marca_id_marca = m.id_marca";
        $statement = $conexion->prepare($sql);
        $statement->execute();
        while($result = $statement->fetch()){
            $rows[] = $result;
        }
     
        return json_encode($rows, JSON_UNESCAPED_UNICODE);
   
    }
    public function setModificarProducto($arg_codigo, $arg_descripcion, $arg_cantidad, $arg_precio,$imagen){
        $modelo = new Conexion();

        $conexion = $modelo->get_connection();
        $sql = "update repuesto set descripcion = :descripcion, cantidad = :cantidad, precio = :precio, url_imagen = :url_imagen where codigo = :codigo";
        $statement = $conexion->prepare($sql);
        $statement->bindParam(':codigo',$arg_codigo);
        $statement->bindParam(':descripcion',$arg_descripcion);
        $statement->bindParam(':cantidad',$arg_cantidad);
        $statement->bindParam(':precio',$arg_precio);
        $statement->bindParam(':url_imagen',$imagen);
        
        if(!$statement){
            return "Error al modificar producto";
        }else{
            $statement->execute();
            return "Producto actualizado correctamente";
        }	
    }
    public function setComprarProducto($compra){
        
    }
    //primer paso para eliminar un producto definitivamente
    public function setEliminarDetalleVenta($arg_codigo){
        $modelo = new Conexion();

        $conexion = $modelo->get_connection();
        $sql = "delete from detalle_venta where repuesto_codigo = :codigo";
        $statement = $conexion->prepare($sql);
        $statement->bindParam(':codigo',$arg_codigo);
        
        if(!$statement){
            return "Error al modificar producto";
        }else{
            $statement->execute();
            return "Producto actualizado correctamente";
        }	
    }
     //segundo paso para eliminar un producto definitivamente
     public function setEliminarDetenvio($arg_codigo){
        $modelo = new Conexion();

        $conexion = $modelo->get_connection();
        $sql = "delete from detenvio where repuesto_codigo = :codigo";
        $statement = $conexion->prepare($sql);
        $statement->bindParam(':codigo',$arg_codigo);
        
        if(!$statement){
            return "Error al modificar producto";
        }else{
            $statement->execute();
            return "Producto actualizado correctamente";
        }	
    }
     //tercer paso para eliminar un producto definitivamente
     public function setEliminarDetorden($arg_codigo){
        $modelo = new Conexion();

        $conexion = $modelo->get_connection();
        $sql = "delete from detorden where repuesto_codigo = :codigo";
        $statement = $conexion->prepare($sql);
        $statement->bindParam(':codigo',$arg_codigo);
        
        if(!$statement){
            return "Error al modificar producto";
        }else{
            $statement->execute();
            return "Producto actualizado correctamente";
        }	
    }
    //cuarto paso para eliminar un producto definitivamente
    public function setEliminarDetalleProducto($arg_codigo){
        $modelo = new Conexion();

        $conexion = $modelo->get_connection();
        $sql = "delete from detalle_repuesto where repuesto_codigo = :codigo";
        $statement = $conexion->prepare($sql);
        $statement->bindParam(':codigo',$arg_codigo);
        
        if(!$statement){
            return "Error al modificar producto";
        }else{
            $statement->execute();
            return "Producto actualizado correctamente";
        }	
    }
    //quinto paso para eliminar un producto definitivamente
    public function setEliminarProducto($arg_codigo){
        $modelo = new Conexion();

        $conexion = $modelo->get_connection();
        $sql = "delete from repuesto where codigo = :codigo";
        $statement = $conexion->prepare($sql);
        $statement->bindParam(':codigo',$arg_codigo);
        
        if(!$statement){
            return "Error al modificar producto";
        }else{
            $statement->execute();
            return "Producto actualizado correctamente";
        }	
    }
  
    //para inventarios
    public function getProductoUbicacion($ubicacion){
        $rows = null;
        $modelo = new Conexion();
        $conexion = $modelo->get_connection();
        $sql = "select r.codigo as codigo, r.descripcion as descripcion, r.cantidad, r.precio, u.descripcion as ubicacion from repuesto r, marca m, ubicacion u, detalle_repuesto d where r.marca_id_marca = m.id_marca AND r.codigo = d.repuesto_codigo AND u.id_ubicacion = d.ubicacion_id_ubicacion AND d.inventario = 0 AND u.descripcion = '$ubicacion'";
        $statement = $conexion->prepare($sql);
        $statement->execute();
        while($result = $statement->fetch()){
            $rows[] = $result;
        }
     
        return json_encode($rows, JSON_UNESCAPED_UNICODE);
        
    }

    //modificar detalle producto
    public function setModificarDetalleProducto($fecha, $arg_cantidad, $oldBodega, $arg_proveedor, $arg_ubicacion, $arg_repuesto, $arg_precio, $inventario, $oldCantidad){
        $modelo = new Conexion();
       
        $conexion = $modelo->get_connection();
        $sql = "update detalle_repuesto set fecha = :fecha, cantidad = :cantidad, proveedor_nit = :proveedor, ubicacion_id_ubicacion = :ubicacion, precio_compra = :precio, inventario = :inventario, cantidad_inventario = :oldCantidad where iddetalle_repuesto = :idrepuesto and ubicacion_id_ubicacion = :oldBodega";

        
        $statement = $conexion->prepare($sql);
        $statement->bindParam(':fecha',$fecha);
        $statement->bindParam(':cantidad',$arg_cantidad);
        $statement->bindParam(':oldBodega',$oldBodega);
        $statement->bindParam(':proveedor',$arg_proveedor);
        $statement->bindParam(':ubicacion',$arg_ubicacion);
        $statement->bindParam(':precio',$arg_precio);
        $statement->bindParam(':idrepuesto',$arg_repuesto);
        $statement->bindParam(':inventario',$inventario);
        $statement->bindParam(':oldCantidad',$oldCantidad);
        
        
        if (!$statement) {
            return "0"; // "Error al crear el registro";
        }else{
            $statement->execute();
            return "1"; // "<h2>datos actualizados correctamente</h2>";
        }

    }
    //Recupera la cantidad de producto en detalle_repuesto para luego ser validada
		public function setRecuperarCantidadDetalleRepuesto($repuesto){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "select sum(cantidad) as cantidad from detalle_repuesto where repuesto_codigo = '$repuesto'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;

		}
        			//actualizar cantidad en repuesto luego de una actualizacion en el detalleRepuesto
		public function setActualizarCantidadRepuesto($cantidadTotal,$repuesto){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update repuesto set cantidad = :cantidad where codigo = :id";

			$statement = $conexion->prepare($sql);
			$statement->bindParam(':cantidad',$cantidadTotal);
			$statement->bindParam(':id',$repuesto);
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "Producto Actualizado correctamente";
			}	

		}

        public function setInventarioCero(){
            $modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_repuesto set inventario = 0, cantidad_inventario = NULL";

			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "Producto Actualizado correctamente";
			}	
        }
        public function setCuadrarInventario($codigo, $cantidad){
            $modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_repuesto set cantidad_inventario = :cantidad where codigo = :id";

			$statement = $conexion->prepare($sql);
			$statement->bindParam(':cantidad',$cantidad);
			$statement->bindParam(':id',$codigo);
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "Producto Actualizado correctamente";
			}	

        }
    
}
