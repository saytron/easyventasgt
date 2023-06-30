<?php
	
	class Consultas{
		public function insertarMarca($arg_descripcionMarca){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into marca (descripcion) values(:descripcion)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':descripcion',$arg_descripcionMarca);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}

		public function insertarCatalogo($arg_tipo, $argDescripcion){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into catalogo (descripcion, type) values(:descripcion, :type)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':descripcion',$argDescripcion);
			$statement->bindParam(':type',$arg_tipo);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}

		public function cargarMarca(){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from marca";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarDetalleProducto($codigo){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from detalle_repuesto where repuesto_codigo = '$codigo'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function cargarCliente(){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from cliente";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function buscarClienteId($id){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from cliente where id_cliente = $id ";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function buscarClienteNombre($nombre){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from cliente where nombre = '$nombre' ";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		
		public function buscarClienteMax(){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select max(id_cliente) as id_cliente from cliente";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}


		public function buscarCliente($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from cliente where nombre like '%".$busqueda."%' or nit like '%".$busqueda."%' or apellidos like '%".$busqueda."%'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function buscarClienteNit($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from cliente where nit = '$busqueda'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function cargarVentaFactura($pass,$inicio,$registros){
			$rows = null;
			
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from venta where facturado IN(0,1) and usuario = $pass order by idventa desc LIMIT $inicio, $registros";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarVentaCotizar($pass,$inicio,$registros){
			$rows = null;
			
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from venta where facturado IN(2,3) and usuario = $pass order by idventa desc LIMIT $inicio, $registros";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function cargarVentaEnvio($pass,$inicio,$registros){
			$rows = null;
			
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from envio where usuario = $pass order by idventa desc LIMIT $inicio, $registros";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		
		public function cargarVentaOrden($pass,$inicio,$registros){
			$rows = null;
			
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from orden where usuario = $pass order by idorden desc LIMIT $inicio, $registros";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}


		public function cargarNotaVenta($chasis){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT m.linea, m.chasis, m.motor, m.modelo, c.nit, c.direccion, d.fecha, f.descripcion as marca, m.precio, m.color, CONCAT(c.nombre,' ',c.apellidos) as comprador, e.nombre as vendedor, r.descripcion as telefono FROM moto m, cliente c, empleado e, usuario u, detalle_moto d, marca f, telefono_cliente r where m.id_moto = d.moto_id_moto and m.marca_id_marca = f.id_marca and c.id_cliente = d.cliente_id_cliente1 and e.id_empleado = u.empleado_id_empleado and u.codigo = d.usuario_codigo and c.id_cliente = r.cliente_id_cliente and m.chasis = $chasis ";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function insertarProducto($arg_codigo, $arg_descripcion, $arg_cantidad, $arg_precio, $arg_marca,$imagen,$tipo){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into repuesto (codigo, descripcion, cantidad, precio, url_imagen, marca_id_marca,type) values(:codigo, :descripcion, :cantidad, :precio, :url_imagen, :marca, :type)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':codigo',$arg_codigo);
			$statement->bindParam(':descripcion',$arg_descripcion);
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':precio',$arg_precio);
			$statement->bindParam(':url_imagen',$imagen);
			$statement->bindParam(':marca',$arg_marca);
			$statement->bindParam(':type',$tipo);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}

		public function insertarMotos($linea, $color, $chasis, $motor, $arg_modelo, $precio, $marca){
			$model = new Conexion();
			$vendido = 0;
			$conexion = $model->get_connection();
			$sql = "insert into moto (linea, color, chasis, motor, modelo, precio, vendido, marca_id_marca) values(:linea, :color, :chasis, :motor, :modelo, :precio, :vendido, :marca)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':linea',$linea);
			$statement->bindParam(':color',$color);
			$statement->bindParam(':chasis',$chasis);
			$statement->bindParam(':motor',$motor);
			$statement->bindParam(':modelo',$arg_modelo);
			$statement->bindParam(':precio',$precio);
			$statement->bindParam(':vendido',$vendido);
			$statement->bindParam(':marca',$marca);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}

		public function insertarCliente($arg_nit, $arg_nombre, $arg_email, $arg_direccion){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into cliente (nit, nombre, direccion, email) values(:nit, :nombre, :direccion, :email)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':nit',$arg_nit);
			$statement->bindParam(':nombre',$arg_nombre);
			$statement->bindParam(':direccion',$arg_direccion);
			$statement->bindParam(':email',$arg_email);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}
		
		public function insertarClienteFel($arg_nit, $arg_nombre, $arg_direccion){
			$modelo = new Conexion();
			$arg_apellidos = ".";
			$conexion = $modelo->get_connection();
			$sql = "insert into cliente (nit, nombre, apellidos, direccion) values(:nit, :nombre, :apellidos :direccion)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':nit',$arg_nit);
			$statement->bindParam(':nombre',$arg_nombre);
          	$statement->bindParam(':apellidos',$direccion);
			$statement->bindParam(':direccion',$arg_direccion);
			if (!$statement) {
				return "2";
			}else{
				$statement->execute();
				return "$arg_direccion";
			}

		}
		public function insertarTelefonoCliente($telefono, $idcliente){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into telefono_cliente (descripcion, cliente_id_cliente) values(:descripcion, :idcliente)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':descripcion',$telefono);
			$statement->bindParam(':idcliente',$idcliente);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>".$idcliente;
			}

		}

		public function insertarDetalleProducto($arg_fecha,$arg_cantidad, $arg_proveedor, $arg_ubicacion, $arg_repuesto, $arg_usuario,$arg_precio){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into detalle_repuesto (fecha, cantidad, proveedor_nit, ubicacion_id_ubicacion, precio_compra, repuesto_codigo, usuario_codigo) values(:fecha, :cantidad, :proveedor, :ubicacion, :precio, :idrepuesto, :usuario)";

			
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':fecha',$arg_fecha);
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':proveedor',$arg_proveedor);
			$statement->bindParam(':ubicacion',$arg_ubicacion);
			$statement->bindParam(':precio',$arg_precio);
			$statement->bindParam(':idrepuesto',$arg_repuesto);
			$statement->bindParam(':usuario',$arg_usuario);
			
			if (!$statement) {
				return "Error al crear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}

		public function insertarDetalleMoto($arg_fecha,$arg_idMoto, $arg_idCliente,$arg_usuario){
			$modelo = new Conexion();
			$facturado = 0;
			$estadoPlacas = 0;
			$conexion = $modelo->get_connection();
			$sql = "insert into detalle_moto (fecha, facturado, estadoPlacas, cliente_id_cliente1, moto_id_moto, usuario_codigo) values(:fecha, :facturado, :estadoPlacas, :idCliente, :idMoto, :usuario)";

			
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':fecha',$arg_fecha);
			$statement->bindParam(':facturado',$facturado);
			$statement->bindParam(':estadoPlacas',$estadoPlacas);
			$statement->bindParam(':idCliente',$arg_idCliente);
			$statement->bindParam(':idMoto',$arg_idMoto);
			$statement->bindParam(':usuario',$arg_usuario);
			
			if (!$statement) {
				return "Error al crear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>".$arg_usuario;
			}

		}

		public function actualizarDetalleProducto($arg_cantidad, $oldBodega, $arg_proveedor, $arg_ubicacion, $arg_repuesto, $arg_usuario,$arg_precio){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_repuesto set cantidad = :cantidad, proveedor_nit = :proveedor, ubicacion_id_ubicacion = :ubicacion, precio_compra = :precio where iddetalle_repuesto = :idrepuesto and ubicacion_id_ubicacion = :oldBodega";

			
			$statement = $conexion->prepare($sql);
			
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':oldBodega',$oldBodega);
			$statement->bindParam(':proveedor',$arg_proveedor);
			$statement->bindParam(':ubicacion',$arg_ubicacion);
			$statement->bindParam(':precio',$arg_precio);
			$statement->bindParam(':idrepuesto',$arg_repuesto);
			
			
			if (!$statement) {
				return "0"; // "Error al crear el registro";
			}else{
				$statement->execute();
				return "1"; // "<h2>datos actualizados correctamente</h2>";
			}

		}

		public function actualizarProductoDetalle($compra, $iddetalle, $precio, $descripcion){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_venta set cantidad = :cantidad, descripcion = :descripcion, precio_venta = :precio where iddetalle_venta = :iddetalle";

			
			$statement = $conexion->prepare($sql);
			
			$statement->bindParam(':cantidad',$compra);
			$statement->bindParam(':descripcion',$descripcion);
			$statement->bindParam(':precio',$precio);
			$statement->bindParam(':iddetalle',$iddetalle);
			
			
			
			if (!$statement) {
				return "0"; // "Error al crear el registro";
			}else{
				$statement->execute();
				return "1"; // "<h2>datos actualizados correctamente</h2>";
			}

		}

		public function actualizarEnvioDetalle($compra, $iddetalle, $precio, $descripcion){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detenvio set cantidad = :cantidad, descripcion = :descripcion, precio_venta = :precio where iddetEnvio = :iddetalle";

			
			$statement = $conexion->prepare($sql);
			
			$statement->bindParam(':cantidad',$compra);
			$statement->bindParam(':descripcion',$descripcion);
			$statement->bindParam(':precio',$precio);
			$statement->bindParam(':iddetalle',$iddetalle);
			
			
			
			if (!$statement) {
				return "0"; // "Error al crear el registro";
			}else{
				$statement->execute();
				return "1"; // "<h2>datos actualizados correctamente</h2>";
			}

		}
		
		public function cargarProducto(){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select r.codigo as codigo, r.descripcion as descripcion, r.cantidad, r.precio, m.descripcion as marca  from repuesto r, marca m where r.marca_id_marca = m.id_marca";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function cargarPedido($nit){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select r.codigo as codigo, r.descripcion as descripcion, r.precio, m.descripcion as marca, d.pedir  from repuesto r, marca m, detalle_repuesto d where r.marca_id_marca = m.id_marca and d.repuesto_codigo = r.codigo and d.pedir > 0 and d.proveedor_nit = '$nit'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function estadoPlacas($estadoPlacas,$id){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_moto set estadoPlacas = :estado where iddetalle_moto = :id";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':id',$id);
			$statement->bindParam(':estado',$estadoPlacas);
			
			if(!$statement){
				return "Error al modificar cliente";
			}else{
				$statement->execute();
				return "cliente actualizado correctamente";
			}	
		}

		public function cargarMoto($inicio, $registros){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select r.id_moto, r.linea, r.color, r.chasis, r.motor, r.modelo, r.precio, m.descripcion as marca from moto r, marca m where r.marca_id_marca = m.id_marca and r.vendido = 0 LIMIT $inicio,$registros";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function cargarMotoVendida($usuario){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select r.id_moto, r.linea, r.color, r.chasis, r.motor, r.modelo, r.precio, m.descripcion as marca, concat(c.nombre,' ',c.apellidos) as cliente from cliente c, moto r, marca m, detalle_moto d where r.marca_id_marca = m.id_marca and c.id_cliente =d.cliente_id_cliente1 and r.id_moto = d.moto_id_moto and r.vendido = 1 and d.usuario_codigo = $usuario ORDER BY id_moto desc";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarClientes($inicio, $registros){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select id_cliente, nit, nombre, apellidos, direccion from cliente LIMIT $inicio,$registros";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function cargarClientesFactura($idcliente){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select c.id_cliente, c.nit, c.nombre, c.apellidos, c.direccion, c.email, t.descripcion as telefono from cliente c, telefono_cliente t where c.id_cliente = t.cliente_id_cliente and c.id_cliente = $idcliente";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function totalClientes(){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select COUNT(nit) as filas from cliente";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$consulta[] = $result;
			}
			return $consulta;
		}
 

		public function cargarTotalVentas($cod,$fecha){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select COUNT(cantidad) as filas from detalle_venta where usuario_codigo = '$cod'";
			$statement = $conexion->prepare($sql);
		
			
			if(!$statement){
				return "Error cargar total";
			}else{
				$statement->execute();
				while($result = $statement->fetch()){
					$consulta[] = $result;
				}
				return $consulta;
			}	
		}
		public function cargarTotalVentasEnvio($cod,$fecha){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select COUNT(cantidad) as filas from detenvio where usuario_codigo = $cod";
			$statement = $conexion->prepare($sql);
		
			
			if(!$statement){
				return "Error cargar total";
			}else{
				$statement->execute();
				while($result = $statement->fetch()){
					$consulta[] = $result;
				}
				return $consulta;
			}	
		}
		public function cargarTotalVentasOrden($cod,$fecha){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select COUNT(cantidad) as filas from detorden where usuario_codigo = $cod";
			$statement = $conexion->prepare($sql);
		
			
			if(!$statement){
				return "Error cargar total";
			}else{
				$statement->execute();
				while($result = $statement->fetch()){
					$consulta[] = $result;
				}
				return $consulta;
			}	
		}
		public function cargarVentasMes($pass){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select d.fecha as fecha, sum(d.precio_venta) as total  from repuesto r, detalle_venta d, detalle_repuesto a, venta v WHERE
			r.codigo = a.repuesto_codigo and d.detalle_repuesto_iddetalle_repuesto = a.iddetalle_repuesto AND r.codigo = d.repuesto_codigo AND d.venta_idventa = v.idventa AND d.usuario_codigo = '$pass' and month(d.fecha) = MONTH(NOW()) AND year(d.fecha) = YEAR(NOW()) AND v.facturado = 0 GROUP BY d.fecha";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarTotalVendidoMes($pass){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select sum(d.precio_venta) totalMes  from repuesto r, detalle_venta d, detalle_repuesto a, venta v WHERE
			r.codigo = a.repuesto_codigo and d.detalle_repuesto_iddetalle_repuesto = a.iddetalle_repuesto AND r.codigo = d.repuesto_codigo AND d.venta_idventa = v.idventa AND d.usuario_codigo = '$pass' and month(d.fecha) = MONTH(NOW()) AND year(d.fecha) = YEAR(NOW()) AND v.facturado = 0";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarVentaDiaria($cod,$fecha){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select d.iddetalle_venta as id, a.iddetalle_repuesto, r.codigo, r.descripcion, d.cantidad, d.precio_venta, d.descripcion as detalleProducto, r.precio as precio_publico from repuesto r, detalle_venta d, detalle_repuesto a, venta v WHERE
r.codigo = a.repuesto_codigo and d.detalle_repuesto_iddetalle_repuesto = a.iddetalle_repuesto AND r.codigo = d.repuesto_codigo AND d.venta_idventa = v.idventa AND d.usuario_codigo = '$cod' and d.fecha = '$fecha' AND v.facturado = 0 ORDER BY d.fecha asc";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function cargarVentasFacturar($cod,$id){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select d.iddetalle_venta as id, a.iddetalle_repuesto, r.codigo, r.descripcion, r.cantidad as cantidad_repuesto, d.cantidad, d.descripcion as detalleProducto, d.precio_venta, d.fecha, r.precio as precio_publico, d.usuario_codigo, d.venta_idventa as idventa from repuesto r, detalle_venta d, detalle_repuesto a WHERE
r.codigo = a.repuesto_codigo and d.detalle_repuesto_iddetalle_repuesto = a.iddetalle_repuesto AND r.codigo = d.repuesto_codigo AND d.usuario_codigo = '$cod' and d.venta_idventa = $id";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarVentasEnvios($cod,$id){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select d.iddetenvio as id, a.iddetalle_repuesto, r.codigo, r.descripcion, d.cantidad, d.descripcion as descripcion2, d.fecha, d.precio_venta, d.facturado as estado, r.precio as precio_publico from repuesto r, detenvio d, detalle_repuesto a WHERE
			r.codigo = a.repuesto_codigo and d.detalle_repuesto_iddetalle_repuesto = a.iddetalle_repuesto AND r.codigo = d.repuesto_codigo AND d.usuario_codigo = $cod and d.envio_idventa = $id and facturado = 1";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarVentasAbonos($cod,$id){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select d.iddetenvio as id, a.iddetalle_repuesto, r.codigo, r.descripcion, d.cantidad, d.fecha, d.precio_venta, d.facturado as estado, r.precio as precio_publico from repuesto r, detenvio d, detalle_repuesto a WHERE
			r.codigo = a.repuesto_codigo and d.detalle_repuesto_iddetalle_repuesto = a.iddetalle_repuesto AND r.codigo = d.repuesto_codigo AND d.usuario_codigo = $cod and d.envio_idventa = $id";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarVentasOrden($cod,$id){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select d.iddetalle as id, a.iddetalle_repuesto, r.codigo, r.descripcion, d.cantidad, d.fecha, d.precio_venta, r.precio as precio_publico from repuesto r, detorden d, detalle_repuesto a WHERE
			r.codigo = a.repuesto_codigo and d.detalle_repuesto_iddetalle_repuesto = a.iddetalle_repuesto AND r.codigo = d.repuesto_codigo AND d.usuario_codigo = $cod and d.orden_idorden = $id and d.tipo = 1";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarVentasOrdenReparacion($cod,$id){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select d.iddetalle as id, a.iddetalle_repuesto, r.codigo, r.descripcion, d.cantidad, d.fecha, d.precio_venta, r.precio as precio_publico from repuesto r, detorden d, detalle_repuesto a WHERE
			r.codigo = a.repuesto_codigo and d.detalle_repuesto_iddetalle_repuesto = a.iddetalle_repuesto AND r.codigo = d.repuesto_codigo AND d.usuario_codigo = $cod and d.orden_idorden = $id and d.tipo = 0";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function cargarTotalVentasFacturar($cod,$id,$anio,$mes){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT sum(precio_venta) as total FROM detalle_venta where usuario_codigo = '$cod' and venta_idventa = $id";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarJsonFel($id, $pass){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select d.cantidad as qty, d.type, d.precio_venta as price, CONCAT(r.codigo,' ', d.descripcion) as description, d.without_iva, d.discount, d.is_discount_percentage, d.taxes from repuesto r, detalle_venta d, detalle_repuesto a WHERE
			r.codigo = a.repuesto_codigo and d.detalle_repuesto_iddetalle_repuesto = a.iddetalle_repuesto AND r.codigo = d.repuesto_codigo AND d.usuario_codigo = '$pass' and d.venta_idventa = $id";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			$data = $statement->fetchAll(PDO::FETCH_ASSOC);
			return $data;
		}
		public function cargarTotalVentasDetalle($id,$cod){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT sum(precio_venta) as total FROM detalle_venta where usuario_codigo = '$cod' and venta_idventa = $id";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarTotalVentasDetalleEnvio($id,$cod){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT sum(precio_venta) as total FROM detenvio where usuario_codigo = '$cod' and envio_idventa = $id";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarTotalPrecioEnvios($cod,$id,$anio,$mes){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT sum(precio_venta) as total FROM detenvio where usuario_codigo = $cod and envio_idventa = $id and facturado = 1";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarTotalPrecioOrden($cod,$id,$anio,$mes){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT sum(precio_venta) as total FROM detorden WHERE usuario_codigo = $cod and orden_idorden = $id and tipo = 1";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarTotalPrecioOrdenGlobal($cod,$id,$anio,$mes){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT sum(precio_venta) as total FROM detorden WHERE usuario_codigo = $cod and orden_idorden = $id";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function cargarTotalPrecioOrdenReparacion($cod,$id,$anio,$mes){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT sum(precio_venta) as total FROM detorden WHERE usuario_codigo = $cod and orden_idorden = $id and tipo = 0";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		

		public function actualizarVentasFactura($arg_id,$arg_idCliente){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update venta set facturado = 1, cliente_nit = $arg_idCliente where idventa = $arg_id";
			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al modificar venta";
			}else{
				$statement->execute();
				return "Campo Actualizado correctamente";
			}	

		}
      public function actualizarVentaFelAnulada($arg_id){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update venta set estado_dte = 1 where idventa = $arg_id";
			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al modificar venta";
			}else{
				$statement->execute();
				return "Campo Actualizado correctamente";
			}	

		}
      public function actualizarVentasFel($arg_id,$arg_idCliente,$uuid,$certifier,$taxCode,$invoiceUrl,$satSerie,$satNo,$authorization,$certificationDate){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update venta set facturado = 1, cliente_nit = $arg_idCliente, uuid = '$uuid', certifier = '$certifier', tax_code = '$taxCode', invoice_url = '$invoiceUrl', sat_serie = '$satSerie', sat_no = '$satNo', sat_authorization = '$authorization', certification_date = '$certificationDate' where idventa = $arg_id";
			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al modificar venta";
			}else{
				$statement->execute();
				return $arg_id.' '.$arg_idCliente.' '.$uuid.' '.$certifier.' '.$taxCode.' '.$invoiceUrl.' '.$satSerie.' '.$satNo.' '.$authorization.' '.$certificationDate;
			}	

		}
		public function actualizarVentasCotizar($arg_id,$arg_idCliente){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update venta set facturado = 3, cliente_nit = $arg_idCliente where idventa = $arg_id";
			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al modificar venta";
			}else{
				$statement->execute();
				return "Campo Actualizado correctamente";
			}	

		}
		public function actualizarVentasCotizarFacturar($arg_id,$arg_idCliente){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update venta set facturado = 1, cliente_nit = $arg_idCliente where idventa = $arg_id";
			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al modificar venta";
			}else{
				$statement->execute();
				return "Campo Actualizado correctamente";
			}	

		}
		public function actualizarVentasEnvios($arg_id,$arg_idCliente){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update envio set facturado = 1, cliente_nit = $arg_idCliente where idventa = $arg_id";
			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al modificar venta";
			}else{
				$statement->execute();
				return "Campo Actualizado correctamente";
			}	

		}
		public function actualizarTelefonoCliente($arg_id,$arg_telefonoCliente){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update telefono_cliente set descripcion = '$arg_telefonoCliente' where cliente_id_cliente = $arg_id";
			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al modificar venta";
			}else{
				$statement->execute();
				return "Campo Actualizado correctamente";
			}	

		}
		public function actualizarVentasOrden($arg_id,$arg_idCliente){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update orden set facturado = 1, cliente_nit = $arg_idCliente where idorden = $arg_id";
			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al modificar venta";
			}else{
				$statement->execute();
				return "Campo Actualizado correctamente";
			}	

		}

		public function totalVendido($cod,$fecha){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT sum(d.precio_venta) as total FROM detalle_venta d, venta v where d.fecha = '$fecha' and d.venta_idventa = v.idventa and v.facturado = 0 and usuario_codigo = '$cod'";
			$statement = $conexion->prepare($sql);
			
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function totalVendidoMes($cod,$anio,$mes){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT sum(d.precio_venta) as total FROM detalle_venta d, venta v where v.idventa = d.venta_idventa and v.facturado IN(0,1) and year(d.fecha) = '$anio' and month(d.fecha) = '$mes' and usuario_codigo = $cod";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		
		public function totalVendidoDiario($fecha,$cod){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT sum(d.precio_venta) as totales FROM detalle_venta d, venta v where v.idventa = d.venta_idventa and v.facturado = 0 and d.fecha = $fecha  and d.usuario_codigo = $cod";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function buscarProducto($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select r.codigo as codigo, r.descripcion as descripcion, r.cantidad, r.precio, m.descripcion as marca  from repuesto r, marca m where r.marca_id_marca = m.id_marca and r.codigo like '%".$busqueda."%' or r.marca_id_marca = m.id_marca and r.descripcion like '%".$busqueda."%' or r.marca_id_marca = m.id_marca and m.descripcion like '%".$busqueda."%'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function buscarCatalogo($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "SELECT r.codigo, r.descripcion,r.cantidad as cant, m.descripcion as marca, r.precio, c.descripcion as catalogo, d.cantidad from repuesto r, marca m, catalogo c, detalle_catalogo d where d.repuesto_codigo = r.codigo AND r.marca_id_marca = m.id_marca AND d.catalogo_idcatalogo = c.idcatalogo and c.idcatalogo = $busqueda";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function buscarTotProducto($busqueda){
			$rows2 = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select r.codigo as codigo, r.descripcion as descripcion, r.cantidad as existencia, r.precio, m.descripcion as marca, r.type  from repuesto r, marca m where r.marca_id_marca = m.id_marca and r.codigo = '".$busqueda."'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows2[] = $result;
			}
			return $rows2;
		}

		public function buscarProveedor($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select *from proveedor where nit like '%".$busqueda."%' or nombre like '%".$busqueda."%'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function buscarMoto($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select m.id_moto, m.linea, m.color, m.chasis, m.motor, m.modelo, m.precio, d.descripcion as marca  from moto m, marca d where m.marca_id_marca = d.id_marca and m.chasis like '%".$busqueda."%' and m.vendido = 0 or m.marca_id_marca = d.id_marca and m.motor like '%".$busqueda."%'  and m.vendido = 0 or m.marca_id_marca = d.id_marca and m.modelo like '%".$busqueda."%'  and m.vendido = 0";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function buscarMotoVendida($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select m.id_moto as codigo, m.linea, m.color, m.chasis, m.motor, m.modelo, m.precio, d.descripcion as marca  from moto m, marca d where m.marca_id_marca = d.id_marca and m.chasis like '%".$busqueda."%' and m.vendido = 1 or m.marca_id_marca = d.id_marca and m.motor like '%".$busqueda."%'  and m.vendido = 1 or m.marca_id_marca = d.id_marca and m.modelo like '%".$busqueda."%'  and m.vendido = 1";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		//para validar que no hayan productos repetidos
		public function buscarProductoValidado($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select codigo from repuesto where codigo like '%".$busqueda."%'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		//para validar que no hayan motocicletas repetidas
		public function buscarMotoValidada($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select chasis from moto where chasis like '%".$busqueda."%'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		//Actualizar productos
		public function actualizarProducto($arg_codigo, $arg_descripcion, $arg_cantidad, $arg_precio,$imagen){
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

		//Actualizar pedido
		public function actualizarPedido($arg_codigo){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_repuesto set pedir = 0 where repuesto_codigo = :codigo";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':codigo',$arg_codigo);
			
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "producto eliminado ";
			}	

		}
		//realiza pedido
		public function realizarPedido($arg_pedido){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_repuesto set pedir = 0 where proveedor_nit = :nit";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':nit',$arg_pedido);
			
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "pedido realizado ";
			}	

		}

				//Actualizar moto
				public function actualizarMotocicleta($idMoto,$linea,$color,$chasis,$motor,$strmodel,$precio){
					$modelo = new Conexion();
		
					$conexion = $modelo->get_connection();
					$sql = "update moto set linea = :linea, color = :color, chasis = :chasis, motor = :motor, modelo = :modelo, precio = :precio where id_moto = :idmoto";
					$statement = $conexion->prepare($sql);
					$statement->bindParam(':idmoto',$idMoto);
					$statement->bindParam(':linea',$linea);
					$statement->bindParam(':color',$color);
					$statement->bindParam(':chasis',$chasis);
					$statement->bindParam(':motor',$motor);
					$statement->bindParam(':modelo',$strmodel);
					$statement->bindParam(':precio',$precio);
					
					if(!$statement){
						return "Error al modificar moto";
					}else{
						$statement->execute();
						return "moto actualizada correctamente";
					}	
		
				}
		//Actualizar Moto
		public function actualizarMoto($idMoto){
			$modelo = new Conexion();
			$vendido = 1;
			$conexion = $modelo->get_connection();
			$sql = "update moto set vendido = :vendido where id_moto = :id_moto";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':vendido',$vendido);
			$statement->bindParam(':id_moto',$idMoto);
			
			if(!$statement){
				return "Error al modificar Moto";
			}else{
				$statement->execute();
				return "moto actualizada correctamente";
			}	

		}

		//Actualizar cliente
		public function actualizarCliente($arg_id,$arg_nit,$arg_nombre,$arg_email,$arg_direccion){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update cliente set nit = :nit, nombre = :nombre, direccion = :direccion, email = :email where id_cliente = :id";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':id',$arg_id);
			$statement->bindParam(':nit',$arg_nit);
			$statement->bindParam(':nombre',$arg_nombre);
			$statement->bindParam(':direccion',$arg_direccion);
			$statement->bindParam(':email',$arg_email);
			
			if(!$statement){
				return "Error al modificar cliente";
			}else{
				$statement->execute();
				return "cliente actualizado correctamente";
			}	

		}

		//Actualizar productos le suma a cantidad cuando se crea el detalle por primera vez
		public function actualizarCantidad($arg_repuesto,$arg_cantidad,$precio){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update repuesto set cantidad = (cantidad + :cantidad), precio = :precio where codigo = :id";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':precio',$precio);
			$statement->bindParam(':id',$arg_repuesto);
			
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "Producto Actualizado correctamente";
			}	

		}
		public function actualizarCantidadEnvio($arg_repuesto,$arg_cantidad){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update repuesto set cantidad = (cantidad + :cantidad) where codigo = :id";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':id',$arg_repuesto);
			
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "Producto Actualizado correctamente";
			}	

		}
		public function actualizarCantidad2($arg_repuesto,$arg_cantidad){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update repuesto set cantidad = (cantidad + :cantidad) where codigo = :id";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':id',$arg_repuesto);
			
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "Producto Actualizado correctamente";
			}	

		}

		
		//Rebajar productos cuando se realiza una venta
		public function rebajarProducto($arg_venta,$arg_idventa){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update repuesto set cantidad = (cantidad - :cantidad) where codigo = :id";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':cantidad',$arg_venta);
			$statement->bindParam(':id',$arg_idventa);
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "Producto Actualizado correctamente";
			}	

		}
		//pedir producto 
		public function pedirProducto($pedir,$iddetalle){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_repuesto set pedir = :cantidad where iddetalle_repuesto = :id";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':cantidad',$pedir);
			$statement->bindParam(':id',$iddetalle);
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "TU PEDIDO HA SIDO AGREGADO";
			}	

		}
		//Recupera la cantidad de producto en repuesto para luego ser validada
		public function recuperarCantidad($arg_iddetalle){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "select cantidad from repuesto where codigo = '$arg_iddetalle'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;

		}
		//Recupera la cantidad de producto en detalle_repuesto para luego ser validada
		public function recuperarCantidadDetalleRepuesto($repuesto){
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
		public function cargarCorrelativoInterno($idVenta){
			$modelo = new Conexion();
			$rows = null;
			$conexion = $modelo->get_connection();
			$sql = "select *from facturafel where venta_idventa = $idVenta";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;

		}
		
		//Rebajar detalle de productos cuando se realiza una venta
		public function rebajarDetalle($arg_venta,$arg_iddetalle){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_repuesto set cantidad = (cantidad - :cantidad) where iddetalle_repuesto = :id";

			$statement = $conexion->prepare($sql);
			$statement->bindParam(':cantidad',$arg_venta);
			$statement->bindParam(':id',$arg_iddetalle);
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "Producto Actualizado correctamente";
			}	

		}
		//Agrega detalle de productos cuando se modifica una venta
		public function agregarDetalle($arg_venta,$arg_iddetalle){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_repuesto set cantidad = (cantidad + :cantidad) where iddetalle_repuesto = :id";

			$statement = $conexion->prepare($sql);
			$statement->bindParam(':cantidad',$arg_venta);
			$statement->bindParam(':id',$arg_iddetalle);
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "Producto Actualizado correctamente";
			}	

		}
				//actualizar cantidad en repuesto luego de una actualizacion en el detalleRepuesto
		public function actualizarCantidadRepuesto($cantidadTotal,$repuesto){
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

		//Agregar productos cuando se realiza una compra
		public function agregarCompraProducto2($arg_id,$arg_cantidad,$arg_precio, $fecha){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_repuesto set fecha = :fecha, cantidad = (cantidad + :cantidad), precio_compra = :precio where iddetalle_repuesto = :id";

			$statement = $conexion->prepare($sql);
			$statement->bindParam(':fecha',$fecha);
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':precio',$arg_precio);
			$statement->bindParam(':id',$arg_id);
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "compra realizada correctamente";
			}	

		}
		//Agregar productos cuando se realiza una compra
		public function agregarCompraProducto($arg_id,$arg_cantidad,$arg_precio){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update detalle_repuesto set cantidad = (cantidad + :cantidad), precio_compra = :precio where iddetalle_repuesto = :id";

			$statement = $conexion->prepare($sql);
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':precio',$arg_precio);
			$statement->bindParam(':id',$arg_id);
			if(!$statement){
				return "Error al modificar producto";
			}else{
				$statement->execute();
				return "compra realizada correctamente";
			}	

		}


		public function guardarDetalleVenta($arg_fecha, $arg_cantidad, $arg_precio, $arg_iddetalle, $arg_usuario,$idventa,$idventaProducto,$descripcion,$type){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into detalle_venta (fecha, cantidad, descripcion, precio_venta, detalle_repuesto_iddetalle_repuesto,
				usuario_codigo, venta_idventa, repuesto_codigo, type) values(:fecha, :cantidad, :descripcion, :precio, :detalle_repuesto, :usuario, :idventa, :codigo, :type)";

			$statement = $conexion->prepare($sql);
			$statement->bindParam(':fecha',$arg_fecha);
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':descripcion',$descripcion);
			$statement->bindParam(':precio',$arg_precio);
			$statement->bindParam(':detalle_repuesto',$arg_iddetalle);
			$statement->bindParam(':usuario',$arg_usuario);
			$statement->bindParam(':idventa',$idventaProducto);
			$statement->bindParam(':codigo',$idventa);
			$statement->bindParam(':type',$type);
			if (!$statement) {
				return "0";
			}else{
				$statement->execute();
				return "1";
			}

		}
		public function guardarIdFactura($arg_id){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into facturafel (venta_idventa) values(:venta)";

			$statement = $conexion->prepare($sql);
			$statement->bindParam(':venta',$arg_id);
			if (!$statement) {
				return "0";
			}else{
				$statement->execute();
				return "1";
			}

		}
		public function guardarDetalleOrden($arg_fecha, $arg_cantidad, $arg_precio, $arg_iddetalle, $arg_usuario,$idventa,$idventaProducto,$mObra){
			$modelo = new Conexion();
			$idVentas = "'".$idventa."'";
			$conexion = $modelo->get_connection();
			$sql = "insert into detorden (fecha, cantidad, precio_venta, detalle_repuesto_iddetalle_repuesto,
				usuario_codigo, tipo, repuesto_codigo, orden_idorden) values(:fecha, :cantidad, :precio, :detalle_repuesto, :usuario, :tipo, :codigo, :idventa)";

			$statement = $conexion->prepare($sql);
			$statement->bindParam(':fecha',$arg_fecha);
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':precio',$arg_precio);
			$statement->bindParam(':detalle_repuesto',$arg_iddetalle);
			$statement->bindParam(':usuario',$arg_usuario);
			$statement->bindParam(':tipo',$mObra);
			$statement->bindParam(':codigo',$idventa);
			$statement->bindParam(':idventa',$idventaProducto);
			
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "";
			}

		}

		public function guardarDetalleCotizacion($arg_fecha, $arg_cantidad, $arg_precio, $arg_iddetalle, $arg_usuario,$idventa,$idventaProducto,$descripcion){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into detalle_venta (fecha, cantidad, descripcion, precio_venta, detalle_repuesto_iddetalle_repuesto,
				usuario_codigo, venta_idventa, repuesto_codigo) values(:fecha, :cantidad, :descripcion, :precio, :detalle_repuesto, :usuario, :idventa, :codigo)";

			$statement = $conexion->prepare($sql);
			$statement->bindParam(':fecha',$arg_fecha);
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':descripcion',$descripcion);
			$statement->bindParam(':precio',$arg_precio);
			$statement->bindParam(':detalle_repuesto',$arg_iddetalle);
			$statement->bindParam(':usuario',$arg_usuario);
			$statement->bindParam(':idventa',$idventaProducto);
			$statement->bindParam(':codigo',$idventa);
			if (!$statement) {
				return "0"; // "Error al carear el registro";
			}else{
				$statement->execute();
				return "1"; //producto rebajado con exito
			}

		}


		public function guardarDetalleEnvios($arg_fecha, $arg_cantidad, $arg_precio, $arg_iddetalle, $arg_usuario,$idventa,$idventaProducto,$abono,$descripcion){
			$modelo = new Conexion();
			$idVentas = "'".$idventa."'";
			$conexion = $modelo->get_connection();
			$sql = "insert into detenvio (fecha, cantidad, descripcion, precio_venta, detalle_repuesto_iddetalle_repuesto,
				usuario_codigo, facturado, repuesto_codigo, envio_idventa) values(:fecha, :cantidad, :descripcion, :precio, :detalle_repuesto, :usuario, :facturado, :codigo, :idventa)";

			$statement = $conexion->prepare($sql);
			$statement->bindParam(':fecha',$arg_fecha);
			$statement->bindParam(':cantidad',$arg_cantidad);
			$statement->bindParam(':descripcion',$descripcion);
			$statement->bindParam(':precio',$arg_precio);
			$statement->bindParam(':detalle_repuesto',$arg_iddetalle);
			$statement->bindParam(':usuario',$arg_usuario);
			$statement->bindParam(':facturado',$abono);
			$statement->bindParam(':codigo',$idventa);
			$statement->bindParam(':idventa',$idventaProducto);
			
			if (!$statement) {
				return "0"; // "Error al carear el registro";
			}else{
				$statement->execute();
				return "1"; //producto guardado con exito
			}

		}



		public function buscarDetalleProducto($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select d.iddetalle_repuesto as iddetalle, d.fecha, d.cantidad, r.cantidad as existencia, r.url_imagen, d.precio_compra, d.ubicacion_id_ubicacion as idubicacion, u.descripcion as ubicacion, p.nombre as proveedor, p.nit as idProveedor, r.codigo, m.descripcion as marca FROM repuesto r, marca m, detalle_repuesto d, ubicacion u, proveedor p WHERE d.ubicacion_id_ubicacion = u.id_ubicacion and d.proveedor_nit = p.nit and r.codigo = d.repuesto_codigo and m.id_marca = r.marca_id_marca and r.codigo = '$busqueda'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function buscarProductoId($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * FROM repuesto WHERE codigo = '$busqueda'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function buscarTelefonoCliente($busqueda){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select d.descripcion, r.direccion FROM cliente r, telefono_cliente d WHERE d.cliente_id_cliente = r.id_cliente and r.id_cliente = '$busqueda'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}


		public function totalProducto(){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select COUNT(codigo) as filas from repuesto";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$consulta[] = $result;
			}
			return $consulta;
		}

		public function totalMoto(){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select COUNT(id_moto) as filas from moto";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$consulta[] = $result;
			}
			return $consulta;
		}

		public function validarLogin($arg_pass){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select codigo, n_usuario as usuario, rol_idrol as rol, pass from usuario where n_usuario = ?";
			$statement = $conexion->prepare($sql);
			$statement->execute(array($arg_pass));
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}
		public function insertarEmpleado($arg_nombre, $arg_direccion, $arg_nacimiento){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into empleado (nombre, direccion, nacimiento) values(:nombre, :direccion, :nacimiento)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':nombre',$arg_nombre);
			$statement->bindParam(':direccion',$arg_direccion);
			$statement->bindParam(':nacimiento',$arg_nacimiento);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}

		public function insertarRol($rol){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into rol (descripcion) values(:descripcion)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':descripcion',$rol);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}

		public function insertarBodega($descripcion){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into ubicacion (descripcion) values(:descripcion)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':descripcion',$descripcion);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}

		public function insertarProveedor($arg_nit,$arg_nombre,$arg_direccion){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into proveedor (nit, nombre, direccion) values(:nit, :nombre, :direccion)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':nit',$arg_nit);
			$statement->bindParam(':nombre',$arg_nombre);
			$statement->bindParam(':direccion',$arg_direccion);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}

		public function cargarRol(){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from rol";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function cargarProveedor(){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from proveedor";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function cargarUbicacion(){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from ubicacion";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}


		public function cargarEmpleado($empleado){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from empleado where nombre like '%".$empleado."%' or direccion like '%".$empleado."%'";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function buscarEmpleado($inicio,$registro){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select * from empleado LIMIT $inicio,$registro";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$rows[] = $result;
			}
			return $rows;
		}

		public function totalEmpleados(){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select COUNT(nombre) as filas from empleado";
			$statement = $conexion->prepare($sql);
			$statement->execute();
			while($result = $statement->fetch()){
				$consulta[] = $result;
			}
			return $consulta;
		}

		public function buscarUsuario($busqueda){
					$rows = null;
					$modelo = new Conexion();
					$conexion = $modelo->get_connection();
					$sql = "select a.codigo as codigo, a.n_usuario as nombre, b.descripcion as descripcion from usuario a, rol b where a.rol_idrol = b.idrol and a.empleado_id_empleado = '$busqueda'";
					$statement = $conexion->prepare($sql);
					$statement->execute();
					while($result = $statement->fetch()){
						$rows[] = $result;
					}
					return $rows;
				}

				public function cargarUsuario($busqueda){
					$rows = null;
					$modelo = new Conexion();
					$conexion = $modelo->get_connection();
					$sql = "select *from usuario where codigo = '$busqueda'";
					$statement = $conexion->prepare($sql);
					$statement->execute();
					while($result = $statement->fetch()){
						$rows[] = $result;
					}
					return $rows;
				}
				public function cargarProductoCatalogo(){
					$rows = null;
					$modelo = new Conexion();
					$conexion = $modelo->get_connection();
					$sql = "SELECT r.codigo, concat(r.descripcion,' marca ',m.descripcion) as producto FROM repuesto r, marca m where m.id_marca = r.marca_id_marca";
					$statement = $conexion->prepare($sql);
					$statement->execute();
					while($result = $statement->fetch()){
						$rows[] = $result;
					}
					return $rows;
				}

		public function insertarUsuario($arg_codigo, $arg_usuario, $arg_empleado, $arg_rol,$pass){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into usuario (codigo, n_usuario, rol_idrol, empleado_id_empleado, pass) values(:codigo, :nombre, :rol, :empleado, :pass)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':codigo',$arg_codigo);
			$statement->bindParam(':nombre',$arg_usuario);
			$statement->bindParam(':rol',$arg_rol);
			$statement->bindParam(':empleado',$arg_empleado);
			$statement->bindParam(':pass',$pass);
			
			
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}

		public function agregarProductoCatalogo($codigo, $catalogo, $cantidad){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "insert into detalle_catalogo (cantidad, catalogo_idcatalogo, repuesto_codigo) values(:cantidad, :catalogo, :repuesto_codigo)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':cantidad',$cantidad);
			$statement->bindParam(':catalogo',$catalogo);
			$statement->bindParam(':repuesto_codigo',$codigo);

			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}

//Actualizar usuarios
		public function actualizarUsuarios($arg_user, $arg_cod, $pass){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update usuario set n_usuario = :nombre, pass = :pass where codigo = :codigo";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':nombre',$arg_user);
			$statement->bindParam(':pass',$pass);
			$statement->bindParam(':codigo',$arg_cod);
			if(!$statement){
				return "Error al modificar usuario";
			}else{
				$statement->execute();
				return "Usuario Actualizado correctamente";
			}	

		}
		
		//Actualiza los empleados
		public function actualizarEmpleados($arg_id, $arg_nombre, $arg_direccion, $arg_fecha){
			$modelo = new Conexion();

			$conexion = $modelo->get_connection();
			$sql = "update empleado set nombre = :nombre, direccion = :direccion, nacimiento = :nacimiento where id_empleado = :id";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':nombre',$arg_nombre);
			$statement->bindParam(':direccion',$arg_direccion);
			$statement->bindParam(':nacimiento',$arg_fecha);
			$statement->bindParam(':id',$arg_id);
			if(!$statement){
				return "Error al modificar Empleado";
			}else{
				$statement->execute();
				return "Empleado Actualizado correctamente";
			}	

		}

		public function eliminarVenta($arg_Eliminar){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "delete from detalle_venta where iddetalle_venta = $arg_Eliminar";
			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al eliminar venta";
			}else{
				$statement->execute();
				return "venta eliminada correctamente";
			}	
		}
		public function eliminarEnvio($arg_Eliminar){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "delete from detenvio where iddetEnvio = $arg_Eliminar";
			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al eliminar venta";
			}else{
				$statement->execute();
				return "venta eliminada correctamente";
			}	
		}
		public function eliminarOrden($arg_Eliminar){
			$rows = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "delete from detorden where iddetalle = $arg_Eliminar";
			$statement = $conexion->prepare($sql);
			if(!$statement){
				return "Error al eliminar venta";
			}else{
				$statement->execute();
				return "producto eliminado correctamente";
			}	
		}



		public function eliminarUsuarios($arg_Eliminar){
					$rows = null;
					$modelo = new Conexion();
					$conexion = $modelo->get_connection();
					$sql = "delete from usuario where codigo = :codigo";
					$statement = $conexion->prepare($sql);
					$statement->bindParam(':codigo',$arg_eliminar);
					if(!$statement){
						return "Error al eliminar usuario";
					}else{
						$statement->execute();
						return "Usuario eliminado correctamente";
					}	
				}

			//insertamos datos en la tabla venta
			public function generarVenta($pass){
			$modelo = new Conexion();
			$num = 0;
			$conexion = $modelo->get_connection();
			$sql = "insert into venta (facturado, usuario) values(:facturado, :usuario)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':facturado',$num);
			$statement->bindParam(':usuario',$pass);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}
		//insertamos datos en la tabla venta
		public function generarCotizacion($pass){
			$modelo = new Conexion();
			$num = 2;
			$conexion = $modelo->get_connection();
			$sql = "insert into venta (facturado, usuario) values(:facturado, :usuario)";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':facturado',$num);
			$statement->bindParam(':usuario',$pass);
			if (!$statement) {
				return "Error al carear el registro";
			}else{
				$statement->execute();
				return "<h2>Registro creado correctamente</h2>";
			}

		}


		public function recuperarVentaGenerada($user){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select MAX(idventa) as filas, MAX(facturado) as facturado from venta where facturado = 0 and usuario = :usuario";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':usuario',$user);
			$statement->execute();
			while($result = $statement->fetch()){
				$consulta[] = $result;
			}
			return $consulta;
		}
		public function recuperarVentaGenerada2($user){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select MAX(idventa) as filas, MAX(facturado) as facturado from venta where facturado = 2 and usuario = :usuario";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':usuario',$user);
			$statement->execute();
			while($result = $statement->fetch()){
				$consulta[] = $result;
			}
			return $consulta;
		}
		public function recuperarVentaGeneradaOrden($user){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select MAX(idorden) as filas, MAX(facturado) as facturado from orden where usuario = :usuario";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':usuario',$user);
			$statement->execute();
			while($result = $statement->fetch()){
				$consulta[] = $result;
			}
			return $consulta;
		}

			//insertamos datos en la tabla venta
			public function generarEnvio($pass){
				$modelo = new Conexion();
				$num = 0;
				$conexion = $modelo->get_connection();
				$sql = "insert into envio (facturado, usuario) values(:facturado, :usuario)";
				$statement = $conexion->prepare($sql);
				$statement->bindParam(':facturado',$num);
				$statement->bindParam(':usuario',$pass);
				if (!$statement) {
					return "Error al carear el registro";
				}else{
					$statement->execute();
					return "<h2>Registro creado correctamente</h2>";
				}
	
			}
			//generamos la orden
			public function generarOrden($pass){
				$modelo = new Conexion();
				$num = 0;
				$conexion = $modelo->get_connection();
				$sql = "insert into orden (facturado, usuario) values(:facturado, :usuario)";
				$statement = $conexion->prepare($sql);
				$statement->bindParam(':facturado',$num);
				$statement->bindParam(':usuario',$pass);
				if (!$statement) {
					return "Error al carear el registro";
				}else{
					$statement->execute();
					return "<h2>Registro creado correctamente</h2>";
				}
	
			}
			public function recuperarEnvioGenerado($user){
				$consulta = null;
				$modelo = new Conexion();
				$conexion = $modelo->get_connection();
				$sql = "select MAX(idventa) as filas, MAX(facturado) as facturado from envio where usuario = :usuario";
				$statement = $conexion->prepare($sql);
				$statement->bindParam(':usuario',$user);
				$statement->execute();
				while($result = $statement->fetch()){
					$consulta[] = $result;
				}
				return $consulta;
			}
			public function recuperarOrdenGenerada($user){
				$consulta = null;
				$modelo = new Conexion();
				$conexion = $modelo->get_connection();
				$sql = "select MAX(idorden) as filas, MAX(facturado) as facturado from orden where usuario = :usuario";
				$statement = $conexion->prepare($sql);
				$statement->bindParam(':usuario',$user);
				$statement->execute();
				while($result = $statement->fetch()){
					$consulta[] = $result;
				}
				return $consulta;
			}
		public function recuperarVentaFacturada($idventa){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select facturado from venta where idventa = :idventa";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':idventa',$idventa);
			$statement->execute();
			while($result = $statement->fetch()){
				$consulta[] = $result;
			}
			return $consulta;
		}
      	public function recuperarVentasFel($idVenta){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select *from venta where idventa = :idventa";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':idventa',$idVenta);
			$statement->execute();
			while($result = $statement->fetch()){
				$consulta[] = $result;
			}
			return $consulta;
		}
		public function recuperarEnvioFacturado($idventa){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select facturado from envio where idventa = :idventa";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':idventa',$idventa);
			$statement->execute();
			while($result = $statement->fetch()){
				$consulta[] = $result;
			}
			return $consulta;
		}
		public function recuperarOrdenFacturado($idventa){
			$consulta = null;
			$modelo = new Conexion();
			$conexion = $modelo->get_connection();
			$sql = "select facturado from orden where idorden = :idventa";
			$statement = $conexion->prepare($sql);
			$statement->bindParam(':idventa',$idventa);
			$statement->execute();
			while($result = $statement->fetch()){
				$consulta[] = $result;
			}
			return $consulta;
		}
	
	}//fin de la clase

		

?>