let sumar = document.querySelector(".sumar");
let restar = document.querySelector(".restar");
let inputVenta = document.getElementById("vender");
let arg_suma = 0;
inputVenta.value = arg_suma;
sumar.onclick = async () => {
	arg_suma++;
	inputVenta.value = arg_suma;
}
restar.onclick = async () => {
	if (arg_suma >= 1) {
		arg_suma--;
		inputVenta.value = arg_suma;
	}

}

function mayus(e) {

	var tecla = e.value;
	var tecla2 = tecla.toUpperCase();

	alert(tecla2);
}
//evento para actualizar producto
function actualizar_productoE(formulario) {


	//validar tamanio de la imagen
	var verificador = document.getElementById("imagenProductoEdit").value
	if (verificador.length > 0) {
		var fileSize = $('#imagenProductoEdit')[0].files[0].size;
		var siezekiloByte = parseInt(fileSize / 1024);
		if (siezekiloByte > $('#imagenProductoEdit').attr('size')) {
			alertify.alert('Imagen muy grande!', 'El tamaño permitido no debe superar los 512 kb', function () {
				alertify.error('busca otra imagen');
			});
			return false;
		} else {
			// alertify.success("imagen validada");
		}
	}

	var datos = new FormData($("#formActualizarProducto")[0])
	var url = "Controller/actualizarProducto.php";
	$.ajax({

		type: "post",
		url: url,
		data: datos,
		contentType: false,
		processData: false,
		success: function (datos) {

			if (datos === "1") {
				$('#modalDetalleProducto').modal('hide');
				Swal.fire({
					position: 'button-end',
					icon: 'success',
					title: 'producto actualizado correctamente',
					showConfirmButton: false,
					timer: 2500
				})
			} else if (datos === "2") {
				Swal.fire({
					position: 'button-end',
					icon: 'success',
					title: 'Producto actualizado con exito',
					showConfirmButton: false,
					timer: 2500
				})
			} else if (datos === "4") {
				Swal.fire({
					position: 'button-end',
					icon: 'error',
					title: 'Debes llenar los campos',
					showConfirmButton: false,
					timer: 2500
				})
			} else {
				Swal.fire({
					position: 'button-end',
					icon: 'error',
					title: "1",
					showConfirmButton: false,
					timer: 2500
				})
			}
		}
	});
}
//evento para actualizar producto
function actualizar_productoInventario(formulario) {


	//validar tamanio de la imagen
	var verificador = document.getElementById("imagenProductoEdit").value
	if (verificador.length > 0) {
		var fileSize = $('#imagenProductoEdit')[0].files[0].size;
		var siezekiloByte = parseInt(fileSize / 1024);
		if (siezekiloByte > $('#imagenProductoEdit').attr('size')) {
			alertify.alert('Imagen muy grande!', 'El tamaño permitido no debe superar los 512 kb', function () {
				alertify.error('busca otra imagen');
			});
			return false;
		} else {
			// alertify.success("imagen validada");r
		}
	}

	var datos = new FormData($("#formActualizarProductoInventario")[0])
	var url = "Controller/actualizarProducto.php";
	$.ajax({

		type: "post",
		url: url,
		data: datos,
		contentType: false,
		processData: false,
		success: function (datos) {

			alertify.success(datos);
		}
	});
}

function enviar_marca() {
	var dMarca = document.getElementById("descripcionMarca").value
	var opc = 1;

	var url = "Controller/insertarDatos.php";
	document.getElementById("formMarca").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			descripcion: dMarca,
			opcion: opc
		},
		success: function (datos) {
			//$('#tabla').load('verProducto.php');
			alertify.success(datos);


		}
	});
}



function editar_usuario(codigo, usuario) {
	$("#codigoEdU").val(codigo);
	$("#usuarioEdU").val(usuario);
}

//evento para agregar producto

function guardar_repuesto(formulario) {

	if (formulario.codigoP.value.trim().length == 0) {
		alertify.error('Datos obligatorios para el campo codigo del producto');
		formulario.codigoP.focus();
		return false;
	}
	if (formulario.descripcionP.value.trim().length == 0) {
		alertify.error('Datos obligatorios para el campo descripcion del producto');
		formulario.descripcionP.focus();
		return false;
	}
	if (formulario.cantidadP.value.trim().length == 0) {
		alertify.error('Datos obligatorios para el campo cantidad');
		formulario.cantidadP.focus();
		return false;
	}
	if (formulario.precioP.value.trim().length == 0) {
		alertify.error('Datos obligatorios para el campo precio');
		formulario.precioP.focus();
		return false;
	}
	if (formulario.idMarcaInsert.value.trim().length == 0) {
		alertify.error('Datos obligatorios para el campo marca');
		formulario.marcaInsert.focus();
		return false;
	}
	if (formulario.idProveedorInsert.value.trim().length == 0) {
		alertify.error('Datos obligatorios para el campo proveedor');
		formulario.proveedorInsert.focus();
		return false;
	}
	if (formulario.idBodegaInsert.value.trim().length == 0) {
		alertify.error('Datos obligatorios para el campo ubicacion');
		formulario.bodegaInsert.focus();
		return false;
	}
	if (formulario.usuarioP.value.trim().length == 0) {
		alertify.error('Datos obligatorios para el campo usuario');
		formulario.usuarioP.focus();
		return false;
	}
	if (formulario.precioCP.value.trim().length == 0) {
		alertify.error('Datos obligatorios para el campo precio compra');
		formulario.precioCP.focus();
		return false;
	}
	//validar tamanio de la imagen
	var fileSize = $('#imagenProducto')[0].files[0].size;
	var siezekiloByte = parseInt(fileSize / 1024);
	if (siezekiloByte > $('#imagenProducto').attr('size')) {
		alertify.alert('Imagen muy grande!', 'El tamaño permitido no debe superar los 512 kb', function () {
			alertify.error('busca otra imagen');
		});
		return false;
	} else {
		// alertify.success("imagen validada");
	}

	var datos = new FormData($("#formProducto")[0])

	var url = "Controller/insertarRepuesto.php";
	document.getElementById("formProducto").reset();
	$("#chekProveedor").attr("src", "");
	$("#chekMarca").attr("src", "");
	$("#chekBodega").attr("src", "");

	$.ajax({
		type: "post",
		url: url,
		data: datos,
		contentType: false,
		processData: false,
		success: function (datos) {
			alertify.success(datos);
		}
	});
}

function enviar_Rol() {
	var Rol = document.getElementById("rol").value


	var url = "Controller/insertarRol.php";
	document.getElementById("formRol").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			rol: Rol
		},
		success: function (datos) {

			alertify.success(datos);


		}
	});
}

function insertar_bodega() {
	var arg_descripcionbd = document.getElementById("descripcionbd").value
	var opc = 4;

	var url = "Controller/insertarDatos.php";
	document.getElementById("formBodega").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			descripcion: arg_descripcionbd,
			opcion: opc
		},
		success: function (datos) {
			//$('#tabla').load('verProducto.php');
			alertify.success(datos);


		}
	});
}

function insertar_proveedor() {
	var arg_nit = document.getElementById("nitpr").value
	var arg_nombre = document.getElementById("nombrepr").value
	var arg_direccion = document.getElementById("direccionpr").value
	var opc = 4;

	var url = "Controller/insertarProveedor.php";
	document.getElementById("formProveedor").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			nit: arg_nit,
			nombre: arg_nombre,
			direccion: arg_direccion,
			opcion: opc
		},
		success: function (datos) {

			alertify.success(datos);


		}
	});
}

function guardar_cliente() {
	var arg_telefono = document.getElementById("telefonocl").value
	var arg_nit = document.getElementById("nitcl").value
	var arg_nombre = document.getElementById("nombrecl").value
	var arg_email = document.getElementById("emailcl").value
	var arg_direccion = document.getElementById("direccioncl").value



	var url = "Controller/insertarCliente.php";
	document.getElementById("formCliente").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			telefono: arg_telefono,
			nit: arg_nit,
			nombre: arg_nombre,
			email: arg_email,
			direccion: arg_direccion

		},
		success: function (datos) {

			alertify.success(datos);


		}
	});
}

function guardar_detalleProducto() {
	var arg_cantidad = document.getElementById("cantidaddet").value
	var arg_proveedor = document.getElementById("proveedordet").value
	var arg_ubicacion = document.getElementById("bodegadet").value
	var arg_repuesto = document.getElementById("codigodet").value
	var arg_usuario = document.getElementById("usuariodet").value
	var arg_precio_compra = document.getElementById("preciodet").value


	var url = "Controller/insertarDetalleRepuesto.php";
	document.getElementById("formDetalle").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			cantidad: arg_cantidad,
			proveedor: arg_proveedor,
			ubicacion: arg_ubicacion,
			repuesto: arg_repuesto,
			usuario: arg_usuario,
			precio: arg_precio_compra
		},
		success: function (datos) {


			alertify.success(datos);


		}
	});
}
//ingresa datos en el modal actualizar detalle producto para actualizarlos
function ActualizarDetalleProducto(codigo, bodega, idProveedor, cantidad, precio, usuario, proveedor, noBodega, codProducto) {
	$('#codigoAcDet').val(codigo);
	$('#codigoProductoDetalle').val(codProducto);
	$('#oldBodega').val(bodega);
	$('#bodegaId').val(bodega);
	$('#bodegaInsert2').val("UBICACION: " + noBodega);
	$('#proveedorId').val(idProveedor);
	$('#proveedorInsert2').val("PROVEEDOR: " + proveedor);
	$('#cantidadAcDet').val(cantidad);
	$('#oldCantidadAcDet').val(cantidad);
	$('#precioAcDet').val(precio);
	$('#usuarioAcDet').val(usuario);
	$('#bodegaName').val(noBodega);



}

function actualizar_detalleProducto() {
	var arg_codigoProducto = document.getElementById("codigoProductoDetalle").value
	var arg_idrepuesto = document.getElementById("codigoAcDet").value
	var arg_oldBodega = document.getElementById("oldBodega").value
	var arg_proveedor = document.getElementById("proveedorId").value
	var arg_ubicacion = document.getElementById("bodegaId").value
	var arg_cantidad = document.getElementById("cantidadAcDet").value
	var arg_usuario = document.getElementById("usuarioAcDet").value
	var arg_precio_compra = document.getElementById("precioAcDet").value
	var arg_posision = document.getElementById("posicionAcDet").value

	document.getElementById("formActualizarDetalle").reset();
	$('#proveedorId2').val(arg_proveedor);
	var url = "Controller/actualizarDetalleRepuesto.php";


	$.ajax({
		type: "post",
		url: url,
		data: {
			cantidad: arg_cantidad,
			oldBodega: arg_oldBodega,
			proveedor: arg_proveedor,
			ubicacion: arg_ubicacion,
			idrepuesto: arg_idrepuesto,
			usuario: arg_usuario,
			precio: arg_precio_compra,
			codigoPr: arg_codigoProducto
		},
		success: function (datos) {

			if (datos === "1") {
				$('#modalDetalleProducto').modal('hide');
				Swal.fire({
					position: 'button-end',
					icon: 'success',
					title: 'datos actualizados correctamente',
					showConfirmButton: false,
					timer: 2500
				})
			} else if (datos === "2") {
				Swal.fire({
					position: 'button-end',
					icon: 'error',
					title: 'Debes llenar los campos',
					showConfirmButton: false,
					timer: 2500
				})
			} else if (datos === "3") {
				Swal.fire({
					position: 'button-end',
					icon: 'error',
					title: 'No tienes suficientes privilegios para realizar esta tarea',
					showConfirmButton: false,
					timer: 2500
				})
			} else {
				Swal.fire({
					position: 'button-end',
					icon: 'error',
					title: datos,
					showConfirmButton: false,
					timer: 2500
				})
			}

		}
	});
}

function actualizar_detalleProductoInventario() {
	var arg_codigoProducto = document.getElementById("codigoProductoDetalle").value
	var arg_idrepuesto = document.getElementById("codigoAcDet").value
	var arg_oldBodega = document.getElementById("oldBodega").value
	var arg_proveedor = document.getElementById("proveedorId").value
	var arg_ubicacion = document.getElementById("bodegaId").value
	var arg_cantidad = document.getElementById("cantidadAcDet").value
	var arg_oldCantidad = document.getElementById("oldCantidadAcDet").value
	var arg_usuario = document.getElementById("usuarioAcDet").value
	var arg_precio_compra = document.getElementById("precioAcDet").value
	var arg_posision = document.getElementById("posicionAcDet").value
	let bodega = document.getElementById("bodegaName").value
	ubicacion = bodega;

	document.getElementById("formActualizarDetalle").reset();
	$('#proveedorId2').val(arg_proveedor);
	var url = "Controller/controllerProducto.php?id=7";


	$.ajax({
		type: "post",
		url: url,
		data: {
			cantidad: arg_cantidad,
			oldCantidad: arg_oldCantidad,
			oldBodega: arg_oldBodega,
			proveedor: arg_proveedor,
			ubicacion: arg_ubicacion,
			idrepuesto: arg_idrepuesto,
			usuario: arg_usuario,
			precio: arg_precio_compra,
			codigoPr: arg_codigoProducto,
			inventario: '1'
		},
		success: function (datos) {

			datatableReload(bodega);
			if (datos === "1") {
				$('#modalDetalleProducto').modal('hide');
				Swal.fire({
					position: 'button-end',
					icon: 'success',
					title: 'datos actualizados correctamente',
					showConfirmButton: false,
					timer: 2500
				})
			} else if (datos === "2") {
				Swal.fire({
					position: 'button-end',
					icon: 'error',
					title: 'Debes llenar los campos',
					showConfirmButton: false,
					timer: 2500
				})
			} else if (datos === "3") {
				Swal.fire({
					position: 'button-end',
					icon: 'error',
					title: 'No tienes suficientes privilegios para realizar esta tarea',
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
	});
}

function actualizar_detalleProductoVerInventario() {
	var arg_codigoProducto = document.getElementById("codigoProductoDetalle").value
	var arg_idrepuesto = document.getElementById("codigoAcDet").value
	var arg_oldBodega = document.getElementById("oldBodega").value
	var arg_proveedor = document.getElementById("proveedorId").value
	var arg_ubicacion = document.getElementById("bodegaId").value
	var arg_cantidad = document.getElementById("cantidadAcDet").value
	var arg_oldCantidad = document.getElementById("oldCantidadAcDet").value
	var arg_usuario = document.getElementById("usuarioAcDet").value
	var arg_precio_compra = document.getElementById("precioAcDet").value
	var arg_posision = document.getElementById("posicionAcDet").value
	let bodega = document.getElementById("bodegaName").value
	ubicacion = bodega;

	document.getElementById("formActualizarDetalle").reset();
	$('#proveedorId2').val(arg_proveedor);
	var url = "Controller/controllerProducto.php?id=7";


	$.ajax({
		type: "post",
		url: url,
		data: {
			cantidad: arg_cantidad,
			oldCantidad: arg_oldCantidad,
			oldBodega: arg_oldBodega,
			proveedor: arg_proveedor,
			ubicacion: arg_ubicacion,
			idrepuesto: arg_idrepuesto,
			usuario: arg_usuario,
			precio: arg_precio_compra,
			codigoPr: arg_codigoProducto,
			inventario: '2'
		},
		success: function (datos) {


			if (datos === "1") {
				$('#modalDetalleProducto').modal('hide');
				Swal.fire({
					position: 'button-end',
					icon: 'success',
					title: 'datos actualizados correctamente',
					showConfirmButton: false,
					timer: 2500
				})
			} else if (datos === "2") {
				Swal.fire({
					position: 'button-end',
					icon: 'error',
					title: 'Debes llenar los campos',
					showConfirmButton: false,
					timer: 2500
				})
			} else if (datos === "3") {
				Swal.fire({
					position: 'button-end',
					icon: 'error',
					title: 'No tienes suficientes privilegios para realizar esta tarea',
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
	});
}

function maestroProducto() {
	var arg_descripcion = document.getElementById("tabdescripcion").value
	$.ajax({

		success: function (datos) {
			$("#mensaje").text(arg_descripcion);


		}
	});
}

async function enviar_login() {
	var arg_usuario = document.getElementById("usuario").value
	var arg_pass = document.getElementById("pass").value

	document.getElementById("form1").reset();
	const datos = {
		usuario: arg_usuario,
		pass: arg_pass
	};
	const datosCodificados = JSON.stringify(datos);
	const url = "Controller/validarLogin.php";
	const respuestaRaw = await fetch(url, {
		method: "POST",
		body: datosCodificados
	});

	json = await respuestaRaw.json();
	console.log(json);
	if (json == "correcto") {
		location.href = "verProducto";
	} else {
		Swal.fire({
			position: 'top-end',
			icon: 'error',
			title: json,
			showConfirmButton: false,
			timer: 1500
		})

	}

}
async function buacarCatalogo(catalogo) {
	var idCatalogo = catalogo;

	document.getElementById("form1").reset();
	const datos = {
		idCatalogo: idCatalogo
	};
	const datosCodificados = JSON.stringify(datos);
	const url = "Controller/cargarCatalogo.php";
	const respuestaRaw = await fetch(url, {
		method: "POST",
		body: datosCodificados
	});

	json = await respuestaRaw.json();
	console.log(json);
}


function iniciarInventario() {


	var url = "Controller/controllerProducto.php?id=10";


	$.ajax({
		type: "post",
		url: url,
		data: {

		},
		success: function (datos) {
			if (datos == "1") {
				alertify.success('<h2>inventario iniciado con exito!</h2>');
			} else {
				alertify.success(datos);

			}


		}
	});
}


function guardarEmpleado() {
	var arg_nombre = document.getElementById("nombre").value
	var arg_direccion = document.getElementById("direccion").value
	var arg_fecha = document.getElementById("fechaNacE").value



	var url = "Controller/insertarEmpleado.php";
	document.getElementById("nuevoEmpleado").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			nombre: arg_nombre,
			direccion: arg_direccion,
			fechaNac: arg_fecha


		},
		success: function (datos) {
			//$("#resultado").html(datos);
			$('#tabla').load('empleado.php');
			//$("#resultado").fadeIn().delay(1500).fadeOut();
			alertify.success(datos);


		}
	});
}

function actualizarEmpleado(id, nombre, direccion, nacimiento) {

	$('#idEmpleadou').val(id);
	$('#nombreu').val(nombre);
	$('#direccionu').val(direccion);
	$('#nacimientou').val(nacimiento);


}

//ingresa datos en el modal cliente para actualizarlos
function actualizarDatosCliente(id, nit, nombre, apellido, direccion) {
	$('#idCliente').val(id);
	$('#nitclan').val(nit);
	$('#nombrecla').val(nombre);
	$('#apellidocla').val(apellido);
	$('#direccioncla').val(direccion);


}

//Actualiza los clientes
function actualizar_cliente() {
	var arg_id = document.getElementById("idCliente").value
	var arg_nit = document.getElementById("nitclan").value
	var arg_nombre = document.getElementById("nombrecla").value
	var arg_email = document.getElementById("emailcla").value
	var arg_direccion = document.getElementById("direccioncla").value
	var arg_telefono = document.getElementById("telefonocla").value



	var url = "Controller/actualizarCliente.php";
	document.getElementById("formActualizarCliente").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			id: arg_id,
			nit: arg_nit,
			nombre: arg_nombre,
			email: arg_email,
			direccion: arg_direccion,
			telefono: arg_telefono

		},
		success: function (datos) {
			//$('#tabla').load('cliente.php');
			alertify.success(datos);


		}
	});
}
//Actualiza los clientes
function actualizar_clienteFel(id, nit, nombre, direccion, email) {
	var arg_id = id;
	var arg_nit = nit;
	var arg_nombre = nombre;
	var arg_apellido = "";
	var arg_direccion = direccion;
	var arg_email = email;



	var url = "Controller/actualizarCliente.php";

	$.ajax({
		type: "post",
		url: url,
		data: {
			id: arg_id,
			nit: arg_nit,
			nombre: arg_nombre,
			apellido: arg_apellido,
			direccion: arg_direccion,
			email: arg_email

		},
		success: function (datos) {
			//$('#tabla').load('cliente.php');
			console.log(datos);
			console.log(arg_id + ' ' + arg_nit + ' ' + arg_nombre + ' ' + arg_direccion);


		}
	});
}



function guardar_Usuario() {
	var arg_codigo = document.getElementById("codigoU").value
	var arg_usuario = document.getElementById("usuarioU").value
	var arg_empleado = document.getElementById("empleadoU").value
	var arg_rol = document.getElementById("rolU").value


	var url = "Controller/insertarUsuario.php";
	document.getElementById("formUsuario").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			codigo: arg_codigo,
			usuario: arg_usuario,
			empleado: arg_empleado,
			rol: arg_rol

		},
		success: function (datos) {

			alertify.success(datos);


		}
	});
}

//Actualizar Empleados
function Actualizar_Empleado() {
	var arg_id = document.getElementById("idEmpleadou").value
	var arg_nombre = document.getElementById("nombreu").value
	var arg_direccion = document.getElementById("direccionu").value
	var arg_nacimiento = document.getElementById("nacimientou").value



	var url = "Controller/actualizarEmpleado.php";


	$.ajax({
		type: "post",
		url: url,
		data: {
			id: arg_id,
			nombre: arg_nombre,
			direccion: arg_direccion,
			fecha: arg_nacimiento


		},
		success: function (datos) {

			alertify.success(datos);
			cargarDatosUsuario();


		}
	});
}

//Actualiza los Usuario
function Actualizar_Usuario() {
	var arg_codigo = document.getElementById("codigoEdU").value
	var arg_usuario = document.getElementById("usuarioEdU").value
	var arg_pass = document.getElementById("passEdU").value



	var url = "Controller/actualizarUsuario.php";
	document.getElementById("formEdUsuario").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			codigo: arg_codigo,
			usuario: arg_usuario,
			pass: arg_pass


		},
		success: function (datos) {

			alertify.success(datos);


		}
	});
}
//llenar modal para actualizar usuarios
function actualizarUsuario(nom, cod) {

	$('#codigoEdU').val(cod);
	$('#usuarioEdU').val(nom);
}
//agrega el id al modal rebajar producto
function iddetalle(codigo, cantidad, idventaproducto) {

	$('#iddetalleP').val(codigo);
	$('#cantidadPr').val(cantidad);
	$('#idventaProducto').val(idventaproducto);
}

function precioCompra(codigo2, precio) {


	$('#iddetalleC').val(codigo2);
	$('#precioCompraC').val(precio);


}

function pedir_producto(codigo2) {


	$('#idPedir').val(codigo2);


}



async function obtener_detalleProductoCotizar(Codigo, descripcion, precio, codigo_id_producto, rol, idventaProducto, pass, marca) {
	document.getElementById("precioVenta").value = precio
	document.getElementById("iddetalleC").value = codigo_id_producto
	document.getElementById("idproductoC").value = Codigo
	//document.getElementById("vender").vualue = ""
	arg_suma = 0;
	var codigo = Codigo;
	var arg_user = pass;
	var nombre = descripcion;
	var arg_precio = precio;
	var arg_rol = rol;
	var arg_idventaproducto = idventaProducto;
	var arg_marca = marca;
	document.getElementById("tituloProducto").innerHTML = nombre;
	//alert(arg_user);
	document.getElementById("idventa").value = codigo
	document.getElementById("DescripcionCot").value = nombre

	const datos = {
		codigo: codigo,
		nombre: nombre,
		precio: arg_precio
	};
	const datosCodificados = JSON.stringify(datos);
	const url = "Controller/controllerProducto.php?id=12";
	const respuestaRaw = await fetch(url, {
		method: "POST",
		body: datosCodificados
	});

	json = await respuestaRaw.json();

	document.getElementById("img-flip").innerHTML = "";
	let imagen = 0;
	for (item of json) {
		imagen = item.url_imagen;
	}

	if (imagen === '0' || imagen === "") {

		document.getElementById("img-flip").innerHTML += `
				<div class="img-no-disponible">
					
					<span class="">NO IMAGEN DISPONIBLE</span>
						
				</div>
			`;
	} else {
		document.getElementById("img-flip").innerHTML += `
				<div class="">
				<img class="img-product" src="./easyventas/${json[0].url_imagen}" loading="lazy"></img>
				</div>
				`;
	}
	document.getElementById("card-content-1").innerHTML = "";
	document.getElementById("card-content-1").innerHTML += `
		<div class="card-global">
         
            	<span class="">CODIGO</span>
          
                <span class="">${json[0].codigo}</span>
           
        </div>

		<div class="card-global">
            
            	<span class="">MARCA</span>
         
                <span class="">${arg_marca}</span>
          
        </div>

        <div class="card-global">
            	<span class="">PRECIO: </span>
        
                <span class="">Q ${arg_precio}</span>
      
        </div>
	`;
	if (arg_rol == '2') {

		document.getElementById("card-content-1").innerHTML += `
		<div class="card-global">
            
            	<span class="">PRECIO COMPRA</span>
       
                <span class="">Q ${json[0].precio_compra}</span>
         
        </div>
		<div class="card-global">
          
            	<span class="">FECHA</span>
         
                <span class="">${json[0].fecha}</span>
    
        </div>

	`;
	}
	document.getElementById("card-content-1").innerHTML += `
	
		<div class="card-global">
         
            	<span class="">EXISTENCIA TOTAL</span>
         
                <span class="">${json[0].existencia}</span>
       
        </div>
		<div class="line"></div>
	`;

	document.getElementById("card-content-2").innerHTML = "";
	for (let item of json) {
		if (typeof json !== 'undefined') {
			document.getElementById("card-content-2").innerHTML += `
	 
	 
					<div class="card-global">
				
						<span class="">PROVEEDOR</span>
				
						<span class="text-danger">${item.proveedor}</span>
				
					</div>
						<div class="card-global">
				
							<span class="">UBICACION</span>
				
					
							<span class="text-danger">${item.ubicacion}</span>
				
					</div>
				   <div class="card-global">
					
						   <span class="">CANTIDAD</span>
				
						   <span class="text-danger">${item.cantidad}</span>
					 
				   </div>
				   <div class="btns-group">
								
					   <button class="btns btn-color-red" id="venderProductoCotizar" onclick="iddetalle('${item.iddetalle}','${item.cantidad}','${arg_idventaproducto}')" data-bs-toggle="modal"  data-bs-target="#modalVenderProducto_Cotizar" alt="Vender" title="Vender"><i class="material-icons">add_shopping_cart</i></button>
				 
		
						  <button class="btns btn-color-yellow" onclick="pedir_producto('${item.iddetalle}')" data-bs-toggle="modal" data-bs-target="#modalPedirProducto" alt="Pedir" title="Pedir"><i class="material-icons">shopping_basket</i></button>
			   
					</div>
					`;


		}


	}



}

async function obtener_detalleProducto(Codigo, descripcion, precio, codigo_id_producto, rol, idventaProducto, pass, identificador) {
	document.getElementById("precioVenta").value = precio
	document.getElementById("iddetalleC").value = codigo_id_producto
	document.getElementById("idproductoC").value = Codigo
	document.getElementById("vender").value = ""
	var codigo = Codigo;
	var arg_user = pass;
	var nombre = descripcion;
	var arg_precio = precio;
	var arg_rol = rol;
	var arg_idventaproducto = idventaProducto;
	arg_suma = 0;
	

	document.getElementById("tituloProducto").innerHTML = nombre;
	//alert(arg_user);
	document.getElementById("idventa").value = codigo
	document.getElementById("DescripcionR").value = nombre
	document.getElementById("vender").vualue = ""

	const datos = {
		codigo: codigo,
		nombre: nombre,
		precio: arg_precio
	};
	const datosCodificados = JSON.stringify(datos);
	const url = "Controller/controllerProducto.php?id=12";
	const respuestaRaw = await fetch(url, {
		method: "POST",
		body: datosCodificados
	});

	json = await respuestaRaw.json();

	document.getElementById("img-flip").innerHTML = "";
	let imagen = 0;
	for (item of json) {
		imagen = item.url_imagen;
	}

	if (imagen === '0' || imagen === "") {

		document.getElementById("img-flip").innerHTML += `
				<div class="img-no-disponible">
					
					<span class="">NO IMAGEN DISPONIBLE</span>
						
				</div>
			`;
	} else {
		//img-flip tipo id y uno tipo clase

		document.getElementById("img-flip").innerHTML += `
					<div class="">
						
						<img class="img-product" src="./easyventas/${json[0].url_imagen}" loading="lazy"></img>
							
					</div>
				`;
	}

	document.getElementById("card-content-1").innerHTML = "";
	document.getElementById("card-content-1").innerHTML += `
				<div class="card-global">
            		<span class="">CODIGO</span>
                	<span class="">${json[0].codigo}</span>
            	</div>

				<div class="card-global">
            		<span  class="">MARCA</span>
                	<span id="marcaDet" name="marcaDet" class="">${json[0].marca}</span>
        		</div>

        		<div class="card-global">
            		<span class="">PRECIO: </span>
                	<span class="">Q ${arg_precio}</span>
        		</div>
			`;
	if (arg_rol == '2') {
		document.getElementById("card-content-1").innerHTML += `
					<div class="card-global">
            			<span class="">PRECIO COMPRA</span>
                		<span class="">Q ${json[0].precio_compra}</span>
        			</div>
					<div class="card-global">
            			<span class="">FECHA</span>
                		<span class="">${json[0].fecha}</span>
        			</div>

				`;
	}
	document.getElementById("card-content-1").innerHTML += `
				<div class="card-global">
            		<span class="">EXISTENCIA TOTAL</span>
                	<span class="">${parseInt(json[0].existencia)}</span>
        		</div>

	`;
	document.getElementById("card-content-2").innerHTML = "";

	for (let item of json) {

		if (arg_rol == '2' && typeof json !== 'undefined') {
			document.getElementById("card-content-2").innerHTML += `
	 
	 
			<div class="card-global">
			
				<span class="">PROVEEDOR</span>
		
				<span class="text-danger">${item.proveedor}</span>
			
			</div>
				<div class="card-global">
			
					<span class="">UBICACION</span>
			
					<span class="text-danger">${item.ubicacion}</span>
				
			</div>
		   <div class="card-global">
			
				   <span class="">CANTIDAD</span>
			
				   <span class="text-danger">${parseInt(item.cantidad)}</span>
		
		   </div>
		   
		   `;
			if (identificador == 'inventario') {
				document.getElementById("card-content-2").innerHTML += `		
			<div class="btns-group">
		  
				  
		 
				   <button class="btns btn-color-green" onclick="ActualizarDetalleProducto('${item.iddetalle}','${item.idubicacion}','${item.idProveedor}','${item.cantidad}','${item.precio_compra}','${arg_user}','${item.proveedor}','${item.ubicacion}','${item.codigo}')" data-bs-toggle="modal" data-bs-target="#modalActualizarDetalle" data-bs-dismiss="modal" alt="Modificar" title="Modificar"><i class="medium material-icons">border_color</i></button>
			  
			   
		   
 
			 </div>
			 `;

			} else {
				document.getElementById("card-content-2").innerHTML += `		
		   <div class="btns-group">
			   <button class="btns btn-color-blue" onclick="iddetalle('${item.iddetalle}','${item.cantidad}','${arg_idventaproducto}')" data-bs-toggle="modal"  data-bs-target="#modalVenderProducto" data-bs-dismiss="modal" alt="Vender" title="Vender"><i class="material-icons">add_shopping_cart</i></button>
		 
				 
				  <button  class="btns btn-color-red" onclick="precioCompra('${item.iddetalle}','${item.precio_compra}')" data-bs-toggle="modal" data-bs-target="#modalCompraProducto" data-bs-dismiss="modal" alt="Comprar" title="Comprar"><i class="larch material-icons">add</i></button>
		
				  <button class="btns btn-color-green" onclick="ActualizarDetalleProducto('${item.iddetalle}','${item.idubicacion}','${item.idProveedor}','${item.cantidad}','${item.precio_compra}','${arg_user}','${item.proveedor}','${item.ubicacion}','${item.codigo}')" data-bs-toggle="modal" data-bs-target="#modalActualizarDetalle" data-bs-dismiss="modal" alt="Modificar" title="Modificar"><i class="medium material-icons">border_color</i></button>
			 
			  
		  
				  <button  class="btns btn-color-yellow" onclick="pedir_producto('${item.iddetalle}')" data-bs-toggle="modal" data-bs-target="#modalPedirProducto" data-bs-dismiss="modal" alt="Pedir" title="Pedir"><i class="material-icons">shopping_basket</i></button>

			</div>
			`;
			}
		} else {
			document.getElementById("card-content-2").innerHTML += `
	 
	 
			<div class="card-global">
			
				<span class="">PROVEEDOR</span>
		
				<span class="text-danger">${item.proveedor}</span>
			
			</div>
				<div class="card-global">
				
					<span class="">UBICACION</span>
				
				
					<span class="text-danger">${item.ubicacion}</span>
				
			</div>
		   <div class="card-global">
			   
				   <span class="">CANTIDAD</span>
			
				   <span class="text-danger">${parseInt(item.cantidad)}</span>
			
		   </div>
		   <div class="btns-group">
						
			   <button class="btns btn-color-red" id="btnvenderProducto" onclick="iddetalle('${item.iddetalle}','${item.cantidad}','${arg_idventaproducto}')" data-bs-toggle="modal"  data-bs-target="#modalVenderProducto" alt="Vender" title="Vender"><i class="material-icons">add_shopping_cart</i></button>
			   

				  <button class="btns btn-color-yellow" onclick="pedir_producto('${item.iddetalle}')" data-bs-toggle="modal" data-bs-target="#modalPedirProducto" alt="Pedir" title="Pedir"><i class="larch material-icons">shopping_basket</i></button>
	   
			</div>
			
			`;
		}


	}


}




async function obtener_detalleProductoEnvio(Codigo, descripcion, precio, codigo_id_producto, rol, idventaProducto, pass) {
	document.getElementById("precioVenta").value = precio
	document.getElementById("iddetalleC").value = codigo_id_producto
	document.getElementById("idproductoC").value = Codigo
	var codigo = Codigo;
	var arg_user = pass;
	var nombre = descripcion;
	var arg_precio = precio;
	var arg_rol = rol;
	var arg_idventaproducto = idventaProducto;
	arg_suma = 0;
	document.getElementById("tituloProductoE").innerHTML = nombre;

	//alert(arg_user);
	document.getElementById("idventa").value = codigo
	document.getElementById("DescripcionEnvio").value = nombre

	const datos = {
		codigo: codigo,
		nombre: nombre,
		precio: arg_precio
	};
	const datosCodificados = JSON.stringify(datos);
	const url = "Controller/controllerProducto.php?id=12";
	const respuestaRaw = await fetch(url, {
		method: "POST",
		body: datosCodificados
	});

	json = await respuestaRaw.json();

	document.getElementById("img-flip").innerHTML = "";
	let imagen = 0;
	for (item of json) {
		imagen = item.url_imagen;
	}

	if (imagen === '0' || imagen === "") {

		document.getElementById("img-flip").innerHTML += `
				<div class="img-no-disponible">
					
					<span class="">NO IMAGEN DISPONIBLE</span>
						
				</div>
			`;
	} else {
		document.getElementById("img-flip").innerHTML += `
				<div class="">
				<img class="img-product" src="./easyventas/${json[0].url_imagen}" loading="lazy"></img>
				</div>
				`;
	}
	document.getElementById("card-content-1").innerHTML = "";
	document.getElementById("card-content-1").innerHTML += `
		<div class="card-global">
            
            	<span class="">CODIGO</span>
           
                <span class="">${json[0].codigo}</span>
            
        </div>

        <div class="card-global">
        	
            	<span class="">PRECIO: </span>
          
                <span class="">Q ${arg_precio}</span>
           
        </div>
	`;
	if (arg_rol == '2') {

		document.getElementById("card-content-1").innerHTML += `
		<div class="card-global">
            
            	<span class="">PRECIO COMPRA</span>
        
                <span class="">Q ${json[0].precio_compra}</span>
          
        </div>
		<div class="card-global">
         
            	<span class="">FECHA</span>
          
                <span class="">${json[0].fecha}</span>
       
        </div>

	`;
	}
	document.getElementById("card-content-1").innerHTML += `
	
		<div class="card-global">
           
            	<span class="">EXISTENCIA TOTAL</span>
          
                <span class="">${json[0].existencia}</span>
        
        </div>

	`;

	document.getElementById("card-content-2").innerHTML = "";
	for (let item of json) {
		if (typeof json !== 'undifined') {
			document.getElementById("card-content-2").innerHTML += `
	 
	 
	 <div class="card-global">
	
		 <span class="">PROVEEDOR</span>
	
		 <span class="text-danger">${item.proveedor}</span>
	
 	</div>
	 	<div class="card-global">
	 	
		 	<span class="">UBICACION</span>
	 
		 	<span class="text-danger">${item.ubicacion}</span>
	 
 	</div>
	<div class="card-global">
	
			<span class="y">CANTIDAD</span>
	
			<span class="text-danger">${parseInt(item.cantidad)}</span>
	
	</div>
	<div class="btns-group">
                 
		<button class="btns btn-color-blue" id="btnvenderProducto" onclick="iddetalle('${item.iddetalle}','${item.cantidad}','${arg_idventaproducto}')" data-bs-toggle="modal"  data-bs-target="#modalVenderProductoEnvio" alt="Vender" title="Vender"><i class="material-icons">add_shopping_cart</i></button>
  
	   
   
   		<button class="btns btn-color-yellow" onclick="pedir_producto('${item.iddetalle}')" data-bs-toggle="modal" data-bs-target="#modalPedirProducto" alt="Pedir" title="Pedir"><i class="material-icons">shopping_basket</i></button>

 	</div>
	 `;
		}

	}



}

function obtener_detalleMoto(idMoto) {
	$('#idMotoV').val(idMoto);
	//alertify.success("moto seleccionada");


}

function obtenerNotaVenta(chasis) {
	$arg_chasis = chasis


}

function actualizar_producto(codigo, descripcion, cantidad, precio) {

	$('#codigopr').val(codigo);
	$('#descripcionpr').val(descripcion);
	$('#cantidadpr').val(cantidad);
	$('#preciopr').val(precio);

}

function actualizar_pedido(codigo) {

	$('#codigoPedido').val(codigo);

}

function actualizar_Moto(idmoto, linea, color, chasis, motor, modelo, precio) {

	$('#idMotoA').val(idmoto);
	$('#lineaA').val(linea);
	$('#colorA').val(color);
	$('#chasisA').val(chasis);
	$('#motorA').val(motor);
	$('#modeloA').val(modelo);
	$('#precioA').val(precio);



}

//Actualiza los productos
function ActualizarPedido(proveedor) {

	var arg_codigo = document.getElementById("codigoPedido").value

	var arg_nit = proveedor;


	var url = "Controller/actualizarPedido.php";
	document.getElementById("formQuitar").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {

			codigo: arg_codigo

		},
		success: function (datos) {

			alertify.success(datos);
			$(location).attr('href', 'pedidos?proveedor=' + arg_nit);
		}
	});
}

//realiza pedido pone en cero el campo pedir de detalle_producto
function realizarPedido(proveedor) {


	var arg_nit = proveedor;


	var url = "Controller/realizarPedido.php";
	document.getElementById("formQuitar").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			nit: arg_nit
		},
		success: function (datos) {

			alertify.success(datos);
			$(location).attr('href', 'pedidos.php?proveedor=' + arg_nit);

		}
	});
}

//obtine factruas
function obtenerFacturas() {


	var url = "Controller/cargarIdFactura.php";

	$.ajax({
		type: "post",
		url: url,
		data: {
			id: arg_id,
			codigo: arg_codigo,
			descripcion: arg_descripcion,
			cantidad: arg_cantidad,
			precio: arg_precio

		},
		success: function (datos) {
			//$('#tabla').load('verProducto.php');
			alertify.success(datos);

		}
	});
}

function obtenerNotaVenta(chasis) {
	arg_chasis = "'" + chasis + "'";
	window.open("Controller/generarNotaVenta.php?chasis=" + arg_chasis, 'blank');

}

//Actualiza las motos
function ActualizarMoto() {
	var arg_id = document.getElementById("idMotoA").value
	var arg_linea = document.getElementById("lineaA").value
	var arg_color = document.getElementById("colorA").value
	var arg_chasis = document.getElementById("chasisA").value
	var arg_motor = document.getElementById("motorA").value
	var arg_modelo = document.getElementById("modeloA").value
	var arg_precio = document.getElementById("precioA").value



	var url = "Controller/actualizarMoto.php";
	document.getElementById("formActualizarMoto").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			idMoto: arg_id,
			linea: arg_linea,
			color: arg_color,
			chasis: arg_chasis,
			motor: arg_motor,
			modelo: arg_modelo,
			precio: arg_precio

		},
		success: function (datos) {
			//$('#tabla').load('verMotos.php');
			alertify.success(datos);

		}
	});
}

function venderProducto_envio() {
	var arg_idventa = document.getElementById("idventa").value
	var arg_idventaProducto = document.getElementById("idventaProducto").value
	var arg_iddetalleproducto = document.getElementById("iddetalleP").value
	var arg_cantidad = document.getElementById("cantidadPr").value
	var arg_usuario = document.getElementById("usuarioventa").value
	var arg_precio = document.getElementById("precioVenta").value
	var arg_abono = document.getElementById("abono").value
	var arg_Venta = document.getElementById("vender").value
	var arg_descuento = "";
	if (document.getElementById('descuento1').checked) {
		arg_descuento = 0.05;
	}
	if (document.getElementById('descuento2').checked) {
		arg_descuento = 0.07;
	}
	if (document.getElementById('descuento3').checked) {
		arg_descuento = 0.10;
	}
	if (document.getElementById('descuento4').checked) {
		arg_descuento = 0.125;
	}
	if (document.getElementById('descuento5').checked) {
		arg_descuento = 0.15;
	}
	alert(arg_descuento);
	//var url= "Controller/venderProductoEnvio.php";
	//document.getElementById("formVender").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			descuento: arg_descuento,
			existencia: arg_cantidad,
			idventa: arg_idventa,
			venta: arg_Venta,
			iddetalle: arg_iddetalleproducto,
			usuario: arg_usuario,
			idventaProducto: arg_idventaProducto,
			abono: arg_abono,
			precio: arg_precio
		},
		success: function (datos) {
			//$('#tabla').load('verProducto.php');


			$('#idventaProducto').val(arg_idventaProducto);
			$('#usuarios').html('');
			$('#modalDetalleProductoEnvio').modal('hide');
			if (datos === "") {
				Swal.fire({
					position: 'button-end',
					icon: 'success',
					title: 'Producto rebajado con exito' + datos,
					showConfirmButton: false,
					timer: 2500
				})

			} else {


				Swal.fire({
					position: 'button-end',
					icon: 'error',
					title: datos,
					showConfirmButton: false,
					timer: 2500
				})
			}



		}
	});
}

function pedirProducto() {

	var arg_iddetalle = document.getElementById("idPedir").value
	var arg_pedir = document.getElementById("pedir").value
	var url = "Controller/pedirProducto.php";
	document.getElementById("formPedir").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {

			iddetalle: arg_iddetalle,
			pedir: arg_pedir
		},
		success: function (datos) {


			Swal.fire({
				position: 'button-end',
				icon: 'success',
				title: 'Has agregado ' + arg_pedir + ' unidades al pedido',
				showConfirmButton: false,
				timer: 2500
			})

		}
	});
}


function venderMoto() {
	var arg_idMoto = document.getElementById("idMotoV").value
	var arg_idCliente = document.getElementById("idClienteMoto").value

	var url = "Controller/venderMoto.php";
	document.getElementById("formVender").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			idMoto: arg_idMoto,
			idCliente: arg_idCliente

		},
		success: function (datos) {
			//$('#tabla').load('verMoto.php');
			$('#clientes').html('');

			alertify.success(datos);


		}
	});
}


function agregarUsuarioReporte(usuario) {

	$('#usuarioR').val(usuario);


}

function eliminarProducto(arg_codigo) {
	var arg_codigo = arg_codigo;
	var url = "Controller/controllerProducto.php?id=11";
	$.ajax({
		type: "post",
		url: url,
		data: {
			codigo: arg_codigo
		},
		success: function (datos) {
			return datos;
		}
	});
}
async function actualizarVenta (){
	let idproducto = document.getElementById('codigoDetalle').value
	let descripcionDetalle = document.getElementById('descripcionDetalle').value 
	let compra = document.getElementById('cantidadDetalle').value //cantidad a vender 
	let precioU = document.getElementById('precioUdetalle').value
	let precio = document.getElementById('precioTdetalle').value
	let iddetalle = document.getElementById('idVentaDetalle').value
	let arg_idventa = document.getElementById('iddetalleventa').value
	let arg_usuario = document.getElementById('passVentaDetalle').value
	let compraOld = document.getElementById('cantidadDetalleOld').value
	let iddetalleVentaDetalle = document.getElementById('iddetalleVentaDetalle').value
	let cantidad_producto = document.getElementById('cantidadProducto2').value
	const datos = {
		idproducto: idproducto,
		descripcionDetalle:descripcionDetalle,
		compra: compra,
		precioU: precioU,
		precio: precio,
		iddetalle: iddetalle,
		compraOld: compraOld,
		iddetalleVenta: iddetalleVentaDetalle,
		existencia: cantidad_producto
	};
	const datosCodificados = JSON.stringify(datos);
	const url = "Controller/actualizarVentaDetalle.php";
	const respuestaRaw = await fetch(url, {
		method: "POST",
		body: datosCodificados
	});

	respuesta = await respuestaRaw.json();
	if (respuesta === "1") {
		recuperarTotalVenta(arg_usuario, arg_idventa);
		recuperarDatosVenta(arg_usuario, arg_idventa, '0');
		//document.getElementById("totalVenta").innerHTML = "ok";
		Swal.fire({
		  position: 'button-end',
		  icon: 'success',
		  title: 'venta modificada con exito',
		  showConfirmButton: false,
		  timer: 2500
		})
	  } else if (respuesta === "2") {
		Swal.fire({
		  position: 'button-end',
		  icon: 'error',
		  title: 'No tienes suficiente producto',
		  showConfirmButton: false,
		  timer: 2500
		})
	  }else if (respuesta === "3") {
		Swal.fire({
		  position: 'button-end',
		  icon: 'error',
		  title: 'la venta debe ser mayor a 0',
		  showConfirmButton: false,
		  timer: 2500
		})
	  }else{}
	
	
	
}
async function actualizarVentaCotizar (){
	let idproducto = document.getElementById('codigoDetalle').value
	let descripcionDetalle = document.getElementById('descripcionDetalle').value 
	let compra = document.getElementById('cantidadDetalle').value //cantidad a vender 
	let precioU = document.getElementById('precioUdetalle').value
	let precio = document.getElementById('precioTdetalle').value
	let iddetalle = document.getElementById('idVentaDetalle').value
	let arg_idventa = document.getElementById('iddetalleventa').value
	let arg_usuario = document.getElementById('passVentaDetalle').value
	let compraOld = document.getElementById('cantidadDetalleOld').value
	let iddetalleVentaDetalle = document.getElementById('iddetalleVentaDetalle').value
	let cantidad_producto = document.getElementById('cantidadProducto2').value
	const datos = {
		idproducto: idproducto,
		descripcionDetalle:descripcionDetalle,
		compra: compra,
		precioU: precioU,
		precio: precio,
		iddetalle: iddetalle,
		compraOld: compraOld,
		iddetalleVenta: iddetalleVentaDetalle,
		existencia: cantidad_producto
	};
	const datosCodificados = JSON.stringify(datos);
	const url = "Controller/actualizarVentaCotizar.php";
	const respuestaRaw = await fetch(url, {
		method: "POST",
		body: datosCodificados
	});

	respuesta = await respuestaRaw.json();
	if (respuesta === "1") {
		recuperarTotalVenta(arg_usuario, arg_idventa);
		recuperarDatosVenta(arg_usuario, arg_idventa, '0');
		//document.getElementById("totalVenta").innerHTML = "ok";
		Swal.fire({
		  position: 'button-end',
		  icon: 'success',
		  title: 'venta modificada con exito',
		  showConfirmButton: false,
		  timer: 2500
		})
	  } else if (respuesta === "2") {
		Swal.fire({
		  position: 'button-end',
		  icon: 'error',
		  title: 'No tienes suficiente producto',
		  showConfirmButton: false,
		  timer: 2500
		})
	  }else if (respuesta === "3") {
		Swal.fire({
		  position: 'button-end',
		  icon: 'error',
		  title: 'la venta debe ser mayor a 0',
		  showConfirmButton: false,
		  timer: 2500
		})
	  }else{}
	
	
	
}

async function actualizarDetalleEnvio (){
	let idproducto = document.getElementById('codigoDetalle').value
	let descripcionDetalle = document.getElementById('descripcionDetalle').value 
	let compra = document.getElementById('cantidadDetalle').value
	let precioU = document.getElementById('precioUdetalle').value
	let precio = document.getElementById('precioTdetalle').value
	let iddetalle = document.getElementById('idVentaDetalle').value
	let arg_idventa = document.getElementById('iddetalleventa').value
	let arg_usuario = document.getElementById('passVentaDetalle').value
	let compraOld = document.getElementById('cantidadDetalleOld').value
	let iddetalleVentaDetalle = document.getElementById('iddetalleVentaDetalle').value
	const datos = {
		idproducto: idproducto,
		descripcionDetalle:descripcionDetalle,
		compra: compra,
		precioU: precioU,
		precio: precio,
		iddetalle: iddetalle,
		compraOld: compraOld,
		iddetalleVenta: iddetalleVentaDetalle
	};
	const datosCodificados = JSON.stringify(datos);
	const url = "Controller/actualizarEnvioDetalle.php";
	const respuestaRaw = await fetch(url, {
		method: "POST",
		body: datosCodificados
	});

	respuesta = await respuestaRaw.json();
	if (respuesta === "1") {
		recuperarTotalVentaEnvio(arg_usuario, arg_idventa);
		recuperarDatosEnvio(arg_usuario, arg_idventa, '0');
		//document.getElementById("totalVenta").innerHTML = "ok";
		Swal.fire({
		  position: 'button-end',
		  icon: 'success',
		  title: 'venta modificada con exito',
		  showConfirmButton: false,
		  timer: 2500
		})
	  } else if (respuesta === "2") {
		Swal.fire({
		  position: 'button-end',
		  icon: 'error',
		  title: 'ubo un error en la bd',
		  showConfirmButton: false,
		  timer: 2500
		})
	  }else{}
	
	
}

function actualizar_detalle_venta(iddetalle, idproducto, precio, compra, idventa,precioU,descripcionDetalle,pass,idDetalleVenta,cantidad_producto) {
	document.getElementById('codigoDetalle').value = idproducto
	document.getElementById('descripcionDetalle').value = descripcionDetalle
	document.getElementById('cantidadDetalle').value = compra
	document.getElementById('cantidadDetalleOld').value = compra
	document.getElementById('precioUdetalle').value = precio / compra
	document.getElementById('precioTdetalle').value = precio
	document.getElementById('idVentaDetalle').value = idventa
	document.getElementById('iddetalleVentaDetalle').value = iddetalle
	document.getElementById('passVentaDetalle').value = pass
	document.getElementById('iddetalleventa').value = idDetalleVenta
	document.getElementById('cantidadProducto2').value = cantidad_producto
	

}


function eliminar_venta(iddetalle, idproducto, precio, compra, idventa,pass,idDetalleVenta) {

	$('#iddetalleC').val(iddetalle);
	$('#precioCompraC').val(precio);
	$('#comprarC').val(compra);
	$('#idproductoC').val(idproducto);
	$('#idVentaC').val(idventa);
	$('#idPagC').val('1');
	document.getElementById('passVentaDetalleE').value = pass
	document.getElementById('iddetalleventaE').value = idDetalleVenta

}

function eliminar_envio(iddetalle, idproducto, precio, compra, idventa) {

	$('#iddetalleE').val(iddetalle);
	$('#precioCompraE').val(precio);
	$('#comprarE').val(compra);
	$('#idproductoE').val(idproducto);
	$('#idVentaE').val(idventa);

}

function eliminar_ordenes(iddetalle, idproducto, precio, compra, idventa) {

	$('#iddetalleOR').val(iddetalle);
	$('#precioCompraOR').val(precio);
	$('#comprarOR').val(compra);
	$('#idproductoOR').val(idproducto);
	$('#idVentaOR').val(idventa);

}

function eliminarVenta() {
	var arg_pagina = document.getElementById("idPagC").value
	var arg_iddetalleproducto = document.getElementById("iddetalleC").value
	var arg_precio = document.getElementById("precioCompraC").value
	var arg_cantidad = document.getElementById("comprarC").value
	var arg_idproducto = document.getElementById("idproductoC").value
	var arg_idventa = document.getElementById("idVentaC").value
	var arg_idventa2  = document.getElementById("iddetalleventaE").value
	let arg_usuario = document.getElementById('passVentaDetalleE').value
	var url = "Controller/eliminarVenta.php"; //funciona para ventas y cotizaciones
	document.getElementById("formEliminarVenta").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {

			iddetalle: arg_iddetalleproducto,
			precio: arg_precio,
			cantidad: arg_cantidad,
			idproducto: arg_idproducto,
			idventa: arg_idventa,
			pagina: arg_pagina
		},
		success: function (datos) {
			recuperarDatosVenta(arg_usuario, arg_idventa2, '0');
			recuperarTotalVenta(arg_usuario, arg_idventa2);
			alertify.success(datos);


		}
	});
}

function eliminarVentaCotizar() {
	var arg_pagina = document.getElementById("idPagC").value
	var arg_iddetalleproducto = document.getElementById("iddetalleC").value
	var arg_precio = document.getElementById("precioCompraC").value
	var arg_cantidad = document.getElementById("comprarC").value
	var arg_idproducto = document.getElementById("idproductoC").value
	var arg_idventa = document.getElementById("idVentaC").value
	var arg_idventa2  = document.getElementById("iddetalleventaE").value
	let arg_usuario = document.getElementById('passVentaDetalleE').value
	var url = "Controller/eliminarVentaCotizar.php"; //funciona para ventas y cotizaciones
	document.getElementById("formEliminarVenta").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {

			iddetalle: arg_iddetalleproducto,
			precio: arg_precio,
			cantidad: arg_cantidad,
			idproducto: arg_idproducto,
			idventa: arg_idventa,
			pagina: arg_pagina
		},
		success: function (datos) {
			recuperarDatosVenta(arg_usuario, arg_idventa2, '0');
			recuperarTotalVenta(arg_usuario, arg_idventa2);
			alertify.success(datos);


		}
	});
}

function eliminarEnvio() {

	var arg_iddetalleproducto = document.getElementById("iddetalleE").value
	var arg_precio = document.getElementById("precioCompraE").value
	var arg_cantidad = document.getElementById("comprarE").value
	var arg_idproducto = document.getElementById("idproductoE").value
	var arg_idventa = document.getElementById("idVentaE").value
	var url = "Controller/eliminarEnvio.php";
	document.getElementById("formEliminarVenta").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {

			iddetalle: arg_iddetalleproducto,
			precio: arg_precio,
			cantidad: arg_cantidad,
			idproducto: arg_idproducto,
			idventa: arg_idventa
		},
		success: function (datos) {
			//$('#tabla').load('ventasUsuario.php');
			alertify.success(datos);


		}
	});
}

function eliminarOrden() {

	var arg_iddetalleproducto = document.getElementById("iddetalleOR").value
	var arg_precio = document.getElementById("precioCompraOR").value
	var arg_cantidad = document.getElementById("comprarOR").value
	var arg_idproducto = document.getElementById("idproductoOR").value
	var arg_idventa = document.getElementById("idVentaOR").value
	var url = "Controller/eliminarOrden.php";
	document.getElementById("formEliminarOrden").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {

			iddetalle: arg_iddetalleproducto,
			precio: arg_precio,
			cantidad: arg_cantidad,
			idproducto: arg_idproducto,
			idventa: arg_idventa
		},
		success: function (datos) {
			//$('#tabla').load('ventasUsuario.php');
			alertify.success(datos);


		}
	});
}

function agregarTelefonoCliente() {

	var arg_idTelefono = document.getElementById("idTelefono").value
	var arg_telefono = document.getElementById("telefono").value

	var url = "Controller/insertarTelefono.php";
	document.getElementById("formTelefono").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {

			idTelefono: arg_idTelefono,
			telefono: arg_telefono
		},
		success: function (datos) {
			$('#tabla').load('cliente.php');
			alertify.success(datos);


		}
	});
}

function generarVenta() {

	var url = "Controller/generarVenta.php";
	var accion = 1;

	$.ajax({
		type: "post",
		url: url,
		data: {
			accion: accion

		},
		success: function (datos) {
			document.getElementById("idventaProductos").value = datos;
			document.getElementById("idVentaProd").innerHTML = datos;
			document.getElementById("totalVenta").innerHTML = "";

			Swal.fire({
				position: 'button-end',
				icon: 'success',
				title: "Venta Generada",
				showConfirmButton: false,
				timer: 2000
			})

		}
	});
}

function generarCotizar() {

	var url = "Controller/generarVentaCotizar.php";
	var accion = 2;

	$.ajax({
		type: "post",
		url: url,
		data: {
			accion: accion

		},
		success: function (datos) {
			$('#idventaProductoCot').val(datos);
			$('#idventaProducto2').val(datos);
			document.getElementById("idVentaProdCot").innerHTML = datos;
			document.getElementById("totalVentaCot").innerHTML = "";


			Swal.fire({
				position: 'button-end',
				icon: 'success',
				title: "Envio Generado",
				showConfirmButton: false,
				timer: 2000
			})


		}
	});
}

function generar_envio() {

	var url = "Controller/generarEnvio.php";


	$.ajax({
		type: "post",
		url: url,
		data: {


		},
		success: function (datos) {
			$('#idventaProductoE').val(datos);
			$('#idventaProducto2').val(datos);
			document.getElementById("idVentaProd").innerHTML = datos;
			document.getElementById("totalVenta").innerHTML = "";


			Swal.fire({
				position: 'button-end',
				icon: 'success',
				title: "Envio Generado",
				showConfirmButton: false,
				timer: 2000
			})



		}
	});
}

function generar_orden() {

	var url = "Controller/generarOrden.php";


	$.ajax({
		type: "post",
		url: url,
		data: {


		},
		success: function (datos) {
			$('#idventaProducto').val(datos);
			$('#idventaProducto2').val(datos);

			alertify.success("<h3>Orden generada</h3>");



		}
	});
}

function recuperarVenta() {


	var idventagenerada = document.getElementById("idventaProducto").value
	var btnvenderProducto = document.getElementById("btnvenderProducto");

	if (idventagenerada == 1) {
		btnvenderProducto.disabled = true;
	}




	var url = "Controller/recuperarVenta.php";


	$.ajax({
		type: "post",
		url: url,
		data: {


		},
		success: function (datos) {
			$('#idventaProducto').val(datos);

		}
	});
}

function recuperarVentaEnvio() {


	var idventagenerada = document.getElementById("idventaProducto").value
	var btnvenderProducto = document.getElementById("btnvenderProducto");

	if (idventagenerada == 1) {
		btnvenderProducto.disabled = true;
	}




	var url = "Controller/recuperarVentaEnvio.php";


	$.ajax({
		type: "post",
		url: url,
		data: {


		},
		success: function (datos) {
			$('#idventaProducto').val(datos);

		}
	});
}


function recuperarDatosVenta(usuario, idventa, facturado) {
	var arg_idventa = idventa;
	var arg_usuario = usuario;
	var arg_facturado = facturado;
	$('#idventaFact').val(arg_idventa);
	$('#idventaFacturado').val(arg_facturado);

	var url = "Controller/ventaFactura.php";


	$.ajax({
		type: "post",
		url: url,
		data: {

			idventa: arg_idventa,
			cod: arg_usuario
		},
		success: function (datos) {

			$("#tablaModal").html(datos);
			//alertify.success(arg_usuario);



		}
	});
}


function recuperarDatosVentaEnvio(usuario, idventa, facturado) {
	var arg_idventa = idventa;
	var arg_usuario = usuario;
	var arg_facturado = facturado;
	$('#idventaFact').val(arg_idventa);
	$('#idventaFacturado').val(arg_facturado);

	var url = "Controller/ventaFactura.php";


	$.ajax({
		type: "post",
		url: url,
		data: {

			idventa: arg_idventa,
			cod: arg_usuario
		},
		success: function (datos) {

			$("#tablaModal").html(datos);
			//alertify.success(arg_usuario);



		}
	});
}

function recuperarDatosEnvio(usuario, idventa, facturado) {
	var arg_idventa = idventa;
	var arg_usuario = usuario;
	var arg_facturado = facturado;
	$('#idventaFact').val(arg_idventa);
	$('#idventaFacturado').val(arg_facturado);

	var url = "Controller/ventaEnvio.php";


	$.ajax({
		type: "post",
		url: url,
		data: {

			idventa: arg_idventa,
			cod: arg_usuario
		},
		success: function (datos) {

			$("#tablaModal").html(datos);
			//alertify.success(arg_usuario);



		}
	});
}

function recuperarDatosOrden(usuario, idventa, facturado) {
	var arg_idventa = idventa;
	var arg_usuario = usuario;
	var arg_facturado = facturado;
	$('#idventaFact').val(arg_idventa);
	$('#idventaFacturado').val(arg_facturado);

	var url = "Controller/ventaOrden.php";


	$.ajax({
		type: "post",
		url: url,
		data: {

			idventa: arg_idventa,
			cod: arg_usuario
		},
		success: function (datos) {

			$("#tablaModal").html(datos);
			alertify.success(arg_usuario);



		}
	});
}

function finalizarVenta() {

	alertify.success("<h3>Venta Finalizada</h3>");


}

async function generarFactura(codigo) {

	var arg_facturado = document.getElementById("idventaFacturado").value
	var arg_idFactura = document.getElementById("idventaFact").value
	var arg_idCliente = document.getElementById("idCliente").value
	var arg_CodUser = codigo;

	let nit = document.getElementById("taxCode").value
	let nombre = document.getElementById("taxName").value
	let direccion = document.getElementById("taxAddress").value
	let email = document.getElementById("email").value

	if (nit == 'CF') {
		//si el campo nit es cf lo mandamos a guardar pero antes pasa por un flitro para saber si el nombre ya existe o no en la bd
		arg_idCliente = guardar_clienteFel2(nit, nombre, direccion, email);
		//arg_idCliente = document.getElementById("idCliente").value
	} else {
		//si el nit existe entonces solo lo actualizamos
		actualizar_clienteFel(arg_idCliente, nit, nombre, direccion, email);
	}


	//console.log(arg_idCliente);
	const datos = {
		nit: nit,
		nombre: nombre,
		direccion: direccion,
		idfactura: arg_idFactura
	};
	const datosCodificados = JSON.stringify(datos);
	const url = "Controller/certificarFel.php";
	const respuestaRaw = await fetch(url, {
		method: "POST",
		body: datosCodificados
	});
	const respuesta = await respuestaRaw.json();
	let uuid = "1";
	let certifier = "1";
	let taxCode = "1";
	let invoiceUrl = "1";
	let satSerie = "1";
	let satNo = "1";
	let satAuthorization = "1";
	let certificationDate = "1";
	console.log(email);
	window.open("Controller/generarFactura.php?nit=" + nit + "&nombreCliente=" + nombre + "&idfactura=" + arg_idFactura + "&idcliente=" + arg_idCliente + "&cod=" + arg_CodUser + "&facturado=" + arg_facturado + "&estado=0" + "&uuid=" + uuid + "&certifier=" + certifier + "&taxCode=" + taxCode + "&invoceUrl=" + invoiceUrl + "&satSerie=" + satSerie + "&satNo=" + satNo + "&satAuthorization=" + satAuthorization + "&certificationDate=" + certificationDate + "&email=" + email, "Diseño Web", "width=900, height=600");
	// spinnerHidden();  

	window.location.href = "verFactura.php";

}

function guardar_clienteFel2(nit, nombre, direccion, email) {
	var result;
	let arg_nit = nit;
	let arg_nombre = nombre;
	let arg_direccion = direccion;
	let arg_email = email;
	var url = "Controller/guardarClienteFel.php";

	$.ajax({
		type: "post",
		url: url,
		data: {
			nit: arg_nit,
			nombre: arg_nombre,
			direccion: arg_direccion,
			email: arg_email

		},
		success: function (datos) {
			let data = parseInt(datos);
			console.log(data);

			//document.getElementById("idCliente").value = data;
			result = data;

		}
	});
	return result;
}

function generarCotizacion(codigo, facturado) {
	var arg_facturado = facturado;
	var arg_idFactura = document.getElementById("idventaFact").value
	var arg_idCliente = document.getElementById("idCliente").value
	var arg_CodUser = codigo;

	//var url= "Controller/generarFactura.php";
	window.open("Controller/generarCotizacion.php?idfactura=" + arg_idFactura + "&idcliente=" + arg_idCliente + "&cod=" + arg_CodUser + "&facturado=" + arg_facturado + "&estado=0", "Diseño Web", "width=900, height=600");

	$.ajax({
		type: "post",
		url: url,
		data: {


		},
		success: function (datos) {
			//$('#idventaProducto').val(datos);
			alertify.success("<h3>Venta Generada</h3>");



		}
	});
}

function generarEnvio(codigo) {
	var arg_facturado = document.getElementById("idventaFacturado").value
	var arg_idFactura = document.getElementById("idventaFact").value
	var arg_idCliente = document.getElementById("idCliente").value
	var arg_CodUser = codigo;


	//var url= "Controller/generarFactura.php";
	window.open("Controller/gEnvio.php?idfactura=" + arg_idFactura + "&idcliente=" + arg_idCliente + "&cod=" + arg_CodUser + "&facturado=" + arg_facturado + "&estado=0", "Diseño Web", "width=900, height=600");

	$.ajax({
		type: "post",
		url: url,
		data: {


		},
		success: function (datos) {
			//$('#idventaProducto').val(datos);
			alertify.success("<h3>Venta Generada</h3>");



		}
	});
}

function generarOrden(codigo) {
	var arg_facturado = document.getElementById("idventaFacturado").value
	var arg_idFactura = document.getElementById("idventaFact").value
	var arg_idCliente = document.getElementById("idCliente").value
	var arg_CodUser = codigo;


	//var url= "Controller/generarPdfOrden.php";
	window.open("Controller/generarPdfOrden.php?idfactura=" + arg_idFactura + "&idcliente=" + arg_idCliente + "&cod=" + arg_CodUser + "&facturado=" + arg_facturado + "&estado=0", "Diseño Web", "width=900, height=600");

	$.ajax({
		type: "post",
		url: url,
		data: {


		},
		success: function (datos) {
			//$('#idventaProducto').val(datos);
			alertify.success("<h3>Venta Generada</h3>");



		}
	});
}

function generarPdfFactura(idcliente, pass, idfactura, facturado) {
	var arg_facturado = facturado;
	var arg_idFactura = idfactura;
	var arg_idCliente = idcliente;
	var arg_CodUser = pass;

	//var url= "Controller/generarFactura.php";
	window.open("Controller/generarFactura.php?idfactura=" + arg_idFactura + "&idcliente=" + arg_idCliente + "&cod=" + arg_CodUser + "&facturado=" + arg_facturado + "&estado=1", "Diseño Web", "width=900, height=600");

	$url = '';
	$.ajax({
		type: "post",
		url: url,
		data: {


		},
		success: function (datos) {
			//$('#idventaProducto').val(datos);
			alertify.success("<h3>Venta Generada</h3>");



		}
	});
}

function generarEnvioPdf(cliente, factura) {

	//alert(factura+" hola");
	var ancho = 1000;
	var alto = 800;
	//calcular posicion x,y para centrar la ventana
	var x = parseInt((window.screen.width / 2) - (ancho / 2));
	var y = parseInt((window.screen.height / 2) - (alto / 2));
	//window.open('factura/guardarFactura.php?cl='+cliente+'&f='+factura);
	$url = 'factura/generaEnvio.php?cl=' + cliente + '&f=' + factura;
	if (cliente === null || factura === null) {
		alertify.error('<h2>Falta facturar</h2>');
	} else {
		window.open($url, "factura", "left=" + x + ",top" + y + ",height=" + alto + ",width=" + ancho + ",scrollbar=si,location=no,resizable=si,menubar=no");

	}
}

function generarPdfCotizar(idcliente, pass, idfactura, facturado) {
	var arg_facturado = facturado;
	var arg_idFactura = idfactura;
	var arg_idCliente = idcliente;
	var arg_CodUser = pass;

	//var url= "Controller/generarFactura.php";
	window.open("Controller/generarCotizacion.php?idfactura=" + arg_idFactura + "&idcliente=" + arg_idCliente + "&cod=" + arg_CodUser + "&facturado=" + arg_facturado + "&estado=1", "Diseño Web", "width=900, height=600");

	$.ajax({
		type: "post",
		url: url,
		data: {


		},
		success: function (datos) {
			//$('#idventaProducto').val(datos);
			alertify.success("<h3>Venta Generada</h3>");



		}
	});
}

function generarPdfCotizarFacturar(idcliente, pass, idfactura, facturado) {
	var arg_facturado = facturado;
	var arg_idFactura = idfactura;
	var arg_idCliente = idcliente;
	var arg_CodUser = pass;

	//var url= "Controller/generarFactura.php";
	window.open("Controller/generarFacturaCotizacion.php?idfactura=" + arg_idFactura + "&idcliente=" + arg_idCliente + "&cod=" + arg_CodUser + "&facturado=" + arg_facturado, "Diseño Web", "width=900, height=600");

	$.ajax({
		type: "post",
		url: url,
		data: {


		},
		success: function (datos) {
			//$('#idventaProducto').val(datos);
			alertify.success("<h3>Venta Generada</h3>");



		}
	});
}

function generarPdfEnvio(idcliente, pass, idfactura, facturado) {
	var arg_facturado = facturado;
	var arg_idFactura = idfactura;
	var arg_idCliente = idcliente;
	var arg_CodUser = pass;

	//var url= "Controller/generarFactura.php";
	window.open("Controller/gEnvio.php?idfactura=" + arg_idFactura + "&idcliente=" + arg_idCliente + "&cod=" + arg_CodUser + "&facturado=" + arg_facturado + "&estado=1", "Diseño Web", "width=900, height=600");

	$.ajax({
		type: "post",
		url: url,
		data: {


		},
		success: function (datos) {
			//$('#idventaProducto').val(datos);
			alertify.success("<h3>Venta Generada</h3>");



		}
	});
}

function generarCuotas() {
	var arg_cliente = document.getElementById("cliente").value
	var arg_producto = document.getElementById("producto").value
	var arg_monto = document.getElementById("monto").value
	var arg_abono = document.getElementById("abono").value
	var arg_meses = document.getElementById("meses").value

	if (arg_monto.length == 0) {
		alertify.error('<h3>Datos obligatorios para el campo monto</h3>');

		return false;
	}
	if (arg_abono.length == 0) {
		alertify.error('<h3>Datos obligatorios para el campo abono</h3>');

		return false;
	}
	if (arg_meses.length == 0) {
		alertify.error('<h3>Datos obligatorios para el campo meses</h3>');

		return false;
	}


	window.open("Controller/cargarProrat.php?cliente=" + arg_cliente + "&producto=" + arg_producto + "&monto=" + arg_monto + "&abono=" + arg_abono + "&meses=" + arg_meses, "Diseño Web", "width=900, height=600");

}

function obtenerIdCliente(codigo) {
	var arg_idCliente = codigo;

	$('#idCliente').val(arg_idCliente);
	//var url= "Controller/generarFactura.php";
	$.ajax({
		url: 'Controller/cargarDetalleCliente.php',
		type: 'POST',
		dataType: 'html',
		data: {
			idCliente: arg_idCliente
		},
		success: function (datos) {
			document.getElementById("img-flip").innerHTML = "";
			let json = JSON.parse(datos);
			document.getElementById("img-flip").innerHTML += `
		<div class="img p-2">
			
			<img width="175px" src="img/cliente.png"> 
				
		</div>
		`;
			document.getElementById("card-content-1").innerHTML = "";
			let clienteFinal = '';
			if (json[0].apellidos == '') {
				clienteFinal = json[0].cliente;
			} else {
				clienteFinal = json[0].nombre;
			}
			document.getElementById("card-content-1").innerHTML += `
	<div class="card-global">
            
            	<span class="">NOMBRE</span>
           
                <span class="">${clienteFinal}</span>
            
        </div>

        <div class="card-global">
        	
            	<span class="">NIT: </span>
          
                <span class=""> ${json[0].nit}</span>
           
        </div>
		<div class="card-global">
        	
            	<span class="">DIRECCION: </span>
          
                <span class=""> ${json[0].direccion}</span>
           
        </div>
		<div class="card-global">
        	
            	<span class="">EMAIL: </span>
          
                <span class=""> ${json[0].email}</span>
           
        </div>
		<div class="card-global">
        	
            	<span class="">TELEFONO: </span>
          
                <span class="text-danger"> ${json[0].telefono}</span>
           
        </div>

	`;

		}
	});

}


//scripts para mtocicletas

function guardar_moto() {
	var arg_linea = document.getElementById("linea").value
	var arg_color = document.getElementById("color").value
	var arg_chasis = document.getElementById("chasis").value
	var arg_motor = document.getElementById("motor").value
	var arg_modelo = document.getElementById("modelo").value
	var arg_precio = document.getElementById("precio").value
	var arg_marca = document.getElementById("marcaM").value


	var url = "Controller/insertarMoto.php";
	document.getElementById("formInsertarMoto").reset();

	$.ajax({
		type: "post",
		url: url,
		data: {
			linea: arg_linea,
			color: arg_color,
			chasis: arg_chasis,
			motor: arg_motor,
			modelo: arg_modelo,
			precio: arg_precio,
			marca: arg_marca

		},
		success: function (datos) {
			//$('#tabla').load('verMotos.php');
			alertify.success(datos);


		}
	});
}

function paginador(pagina, busqueda) {
	var arg_pagina = pagina + 1;
	var arg_busqueda = busqueda;


	var url = "Controller/cargarProducto.php";

	$.ajax({
		type: "post",
		url: url,
		data: {
			num: arg_pagina,
			busqueda: arg_busqueda
		},
		success: function (datos) {

			alertify.success(arg_busqueda);


		}
	});
}

function verImagen(pass) {

	arg_pass = pass;

	var url = "Controller/cargarImagen.php";

	$.ajax({
		type: "post",
		url: url,
		data: {
			pass: arg_pass
		},
		success: function (datos) {

			var json = JSON.parse(datos);
			$('#imagenProductoE').val(json[0].url_imagen);


		}
	});
}


function recuperarBodega(cui) {

	var arg_tel = cui;
	var url = "Controller/recuperarBodega.php";


	$.ajax({
		type: "post",
		url: url,
		data: {
			cuiUsuario: arg_tel
		},
		success: function (datos) {

			document.getElementById("telefonoLider").innerHTML = "";
			var json = JSON.parse(datos);
			for (let item of datos) {
				document.getElementById("telefonoLider").innerHTML += `
	 <div class="row">
	 <div class="col"> ${item.telefono}
	 </div>
	 <div class="col">
	 
	 <input type="hidden" id="idTelefono" name="idTelefono" value="${item.id_telefono}">
		  <button type="button" id="eliminarTelefono" name="eliminarTelefono" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#modalEliminarTelefono" alt="Eliminar Telefono" title="Eliminar Telefono" onclick="eliminar_telefono(${item.id_telefono});"><i class="fa fa-trash-o"></i></button>
		 
		  <button type="button" class="btn btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#modalEditarTelefono" alt="Editar Telefono" title="Editar Telefono" onclick="editar_telefono(${item.id_telefono},${item.telefono},${item.cui});"><i class="fa fa-pencil"></i></button>
		 </div>
		  </div>
	 `;

			}

		}
	});
}




function chartMes() {
	var ctx = document.getElementById('ventasMes')
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			datasets: [{
				label: 'Ventas en Quetzales',
				lineTension: 0.3,
				backgroundColor: "rgba(78, 115, 223, 0.05)",
				borderColor: "rgba(78, 115, 223, 1)",
				pointRadius: 3,
				pointBackgroundColor: "rgba(78, 115, 223, 1)",
				pointBorderColor: "rgba(78, 115, 223, 1)",
				pointHoverRadius: 3,
				pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
				pointHoverBorderColor: "rgba(78, 115, 223, 1)",
				pointHitRadius: 10,
				pointBorderWidth: 2,
			}]
		},
		options: {
			responsive: true,
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}

				}]
			}
		}
	})

	let url = 'Controller/cargarVentasAnio.php'
	fetch(url)
		.then(response => response.json())
		.then(datos => mostrar(datos))
		.catch(error => console.log(error))


	const mostrar = (ventas) => {
		ventas.forEach(element => {
			myChart.data['labels'].push(element.fecha)
			myChart.data['datasets'][0].data.push(element.venta)
			myChart.update()
		});

	}


}



function recuperarTotalVenta(arg_pass, arg_idVenta) {

	$.ajax({
		url: 'Controller/recuperarTotalVenta.php?id=1',
		type: 'POST',
		dataType: 'html',
		data: {
			pass: arg_pass,
			idVenta: arg_idVenta
		},
		success: function (datos) {
			//document.getElementById("totalVenta").innerHTML = "";

			var json = JSON.parse(datos);

			document.getElementById("totalVenta").innerHTML = json[0].total;

		}

	});

}

function recuperarTotalVentaEnvio(arg_pass, arg_idVenta) {

	$.ajax({
		url: 'Controller/recuperarTotalVenta.php?id=2',
		type: 'POST',
		dataType: 'html',
		data: {
			pass: arg_pass,
			idVenta: arg_idVenta
		},
		success: function (datos) {
			//document.getElementById("totalVenta").innerHTML = "";

			var json = JSON.parse(datos);

			document.getElementById("totalVenta").innerHTML = json[0].total;

		}

	});

}

function recuperarTotalVentaCotizar(arg_pass, arg_idVenta) {

	$.ajax({
		url: 'Controller/recuperarTotalVenta.php?id=1',
		type: 'POST',
		dataType: 'html',
		data: {
			pass: arg_pass,
			idVenta: arg_idVenta
		},
		success: function (datos) {
			//document.getElementById("totalVenta").innerHTML = "";

			var json = JSON.parse(datos);

			document.getElementById("totalVentaCot").innerHTML = json[0].total;

		}

	});

}


async function recuperarRep(variable, rolE, idventaE, passE) {
	var rep = variable;
	var rol = rolE;
	var idventaProducto = idventaE;
	var pass = passE;
	const datos = {
		codigo: rep
	};
	const datosCodificados = JSON.stringify(datos);
	const url = "Controller/cargarProductoId.php";
	const respuestaRaw = await fetch(url, {
		method: "POST",
		body: datosCodificados
	});

	json = await respuestaRaw.json();

	if (json === null) {
		alertify.alert('codigo', rep);
	} else {
		obtener_detalleProducto(json[0].codigo, json[0].descripcion, json[0].precio, json[0].codigo, rol, idventaProducto, pass);
		$('#modalDetalleProducto').modal('show');
	}

}



//funcion para llamar datatables y pintar de nuevo sus tatos
function datatableReload(tubicacion) {
	let url = "Controller/controllerProducto?id=6&ubicacion=" + tubicacion;
	let datatable = $('#tabla').DataTable({

		'destroy': true,
		"ajax": {
			"method": "POST",
			"url": url,
			"dataSrc": ""
		},
		"columns": [{
			"data": "codigo"
		},
		{
			"data": "descripcion"
		},
		{
			"data": "cantidad"
		},
		{
			"data": "precio"
		},
		{
			"data": "ubicacion"
		},
		{
			"defaultContent": `
		  <div class="btns-group">
		<button class="btnDetalles btns btn-color-green" data-bs-toggle="modal" data-bs-target="#modalDetalleProducto" alt="detalles" title="ver detalles" ><i class="material-icons">read_more</i></button>
		<button class="btnActualizar btns btn-color-yellow" data-bs-toggle="modal" data-bs-target="#modalActualizarProducto" alt="detalles" alt="actualizar" title="Actualizar producto"><i class='material-icons'>edit</i></button>
		</div>
		`
		}
		],
		"fnRowCallback": function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
			if (data.cantidad == 0) {
				$(nRow).css('color', 'red')
			} else { }
		},
		select: true,
		language: {
			"lengthMenu": "Mostrar _MENU_ registros",
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
		dom: 'Bfrtilp',
		buttons: [{
			extend: 'excelHtml5',
			text: '<i class="fas fa-file-excel"></i> ',
			titleAttr: 'Exportar a Excel',
			className: 'btn btn-success'
		},
		{
			extend: 'pdfHtml5',
			text: '<i class="fas fa-file-pdf"></i> ',
			titleAttr: 'Exportar a PDF',
			className: 'btn btn-danger'
		},
		{
			extend: 'print',
			text: '<i class="fa fa-print"></i> ',
			titleAttr: 'Imprimir',
			className: 'btn btn-info'
		},
		]

	});
}