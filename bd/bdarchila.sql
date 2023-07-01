-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Servidor: db5010543805.hosting-data.io
-- Tiempo de generación: 01-07-2023 a las 02:49:36
-- Versión del servidor: 10.5.19-MariaDB-1:10.5.19+maria~deb11-log
-- Versión de PHP: 7.0.33-0+deb9u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbs8926263`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellidos` varchar(45) DEFAULT '',
  `direccion` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nit`, `nombre`, `apellidos`, `direccion`) VALUES
(230, '34635963', 'HENRY GEOVANNI MOLINA VERNALES', '', 'CIUDAD'),
(231, '760243K', 'BALEU SOCIEDAD ANONIMA', '', 'CIUDAD'),
(232, '3239063', 'HANS PETER, DROEGE LUETZOW', '', 'CIUDAD'),
(233, 'CF', 'CLIENTES VARIOS', NULL, 'CIUDAD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_inventario`
--

CREATE TABLE `detalle_inventario` (
  `iddetalle_venta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_venta` float(11,2) DEFAULT NULL,
  `detalle_repuesto_iddetalle_repuesto` int(11) NOT NULL,
  `usuario_codigo` varchar(20) NOT NULL,
  `facturado` int(11) DEFAULT NULL,
  `repuesto_codigo` varchar(45) NOT NULL,
  `inventario_idinventario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_moto`
--

CREATE TABLE `detalle_moto` (
  `iddetalle_moto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `facturado` int(11) DEFAULT NULL,
  `estadoPlacas` int(11) DEFAULT NULL,
  `cliente_id_cliente1` int(11) NOT NULL,
  `moto_id_moto` int(11) NOT NULL,
  `usuario_codigo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_repuesto`
--

CREATE TABLE `detalle_repuesto` (
  `iddetalle_repuesto` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `pedir` int(11) DEFAULT NULL,
  `proveedor_nit` varchar(20) NOT NULL,
  `ubicacion_id_ubicacion` int(11) NOT NULL,
  `precio_compra` float(11,2) DEFAULT NULL,
  `inventario` int(11) DEFAULT 0,
  `cantidad_inventario` float(11,2) DEFAULT 0.00,
  `repuesto_codigo` varchar(45) NOT NULL,
  `usuario_codigo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_repuesto`
--

INSERT INTO `detalle_repuesto` (`iddetalle_repuesto`, `fecha`, `cantidad`, `pedir`, `proveedor_nit`, `ubicacion_id_ubicacion`, `precio_compra`, `inventario`, `cantidad_inventario`, `repuesto_codigo`, `usuario_codigo`) VALUES
(4395, '2022-10-20', 9995, NULL, 'cf', 153, 1680.00, 0, 0.00, 'M001', '57830948DEON');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `precio_venta` float(11,2) DEFAULT NULL,
  `detalle_repuesto_iddetalle_repuesto` int(11) NOT NULL,
  `usuario_codigo` varchar(20) NOT NULL,
  `facturado` int(11) DEFAULT NULL,
  `venta_idventa` int(11) NOT NULL,
  `repuesto_codigo` varchar(45) NOT NULL,
  `type` varchar(9) NOT NULL DEFAULT 'B',
  `without_iva` int(9) NOT NULL DEFAULT 0,
  `discount` int(9) NOT NULL DEFAULT 0,
  `is_discount_percentage` int(9) NOT NULL DEFAULT 0,
  `taxes` varchar(200) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`iddetalle_venta`, `fecha`, `cantidad`, `descripcion`, `precio_venta`, `detalle_repuesto_iddetalle_repuesto`, `usuario_codigo`, `facturado`, `venta_idventa`, `repuesto_codigo`, `type`, `without_iva`, `discount`, `is_discount_percentage`, `taxes`) VALUES
(1, '2022-10-20 00:00:00', 1, 'MANO DE OBRA POR REPARACION DE BOMBA PARA AGUA ELECTRICA', 50.00, 4395, '57830948DEON', NULL, 1, 'M001', 'S', 0, 0, 0, ''),
(3, '2022-12-04 00:00:00', 1, 'MANO DE OBRA POR INSTALACION DE BOMBA DE AGUA SUMERGIBLE', 1680.00, 4395, '57830948DEON', NULL, 2, 'M001', 'S', 0, 0, 0, ''),
(4, '2022-12-12 00:00:00', 1, 'MANO DE OBRA POR INSTALACIÓN DE CALENTADOR ELÉCTRICO 220V', 450.00, 4395, '57830948DEON', NULL, 3, 'M001', 'S', 0, 0, 0, ''),
(5, '2022-12-23 00:00:00', 1, 'MANO DE OBRA POR INSTALACION DE SISTEMA HIDRONEUMATICO', 550.00, 4395, '57830948DEON', NULL, 4, 'M001', 'S', 0, 0, 0, ''),
(6, '2022-12-27 00:00:00', 1, 'MANO DE OBRA POR REPARACION DE BOMBA DE AGUA', 50.00, 4395, '57830948DEON', NULL, 5, 'M001', 'S', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detenvio`
--

CREATE TABLE `detenvio` (
  `iddetEnvio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` varchar(300) NOT NULL,
  `precio_venta` float(11,2) DEFAULT NULL,
  `detalle_repuesto_iddetalle_repuesto` int(11) NOT NULL,
  `usuario_codigo` varchar(20) NOT NULL,
  `facturado` int(11) DEFAULT NULL,
  `repuesto_codigo` varchar(45) NOT NULL,
  `envio_idventa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detorden`
--

CREATE TABLE `detorden` (
  `iddetalle` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_venta` float(11,2) DEFAULT NULL,
  `detalle_repuesto_iddetalle_repuesto` int(11) NOT NULL,
  `usuario_codigo` varchar(20) NOT NULL,
  `tipo` int(11) DEFAULT NULL,
  `repuesto_codigo` varchar(45) NOT NULL,
  `orden_idorden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `nacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `nombre`, `direccion`, `nacimiento`) VALUES
(2, 'PEDRO SANTOS ARCHILA SANCHEZ', 'RIO DULCE', '1989-10-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `idventa` int(11) NOT NULL,
  `facturado` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `usuario` varchar(20) DEFAULT NULL,
  `cliente_nit` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `envio`
--

INSERT INTO `envio` (`idventa`, `facturado`, `fecha`, `usuario`, `cliente_nit`) VALUES
(394, 0, '2022-11-10 20:52:33', '57830948DEON', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `idinventario` int(11) NOT NULL,
  `inventariado` int(11) DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  `cliente_nit` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `descripcion`) VALUES
(215, 'SERVICIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moto`
--

CREATE TABLE `moto` (
  `id_moto` int(11) NOT NULL,
  `linea` varchar(45) NOT NULL,
  `color` varchar(80) NOT NULL,
  `chasis` varchar(45) NOT NULL,
  `motor` varchar(45) NOT NULL,
  `modelo` varchar(45) NOT NULL,
  `precio` varchar(45) DEFAULT NULL,
  `vendido` int(9) DEFAULT NULL,
  `marca_id_marca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `idorden` int(11) NOT NULL,
  `facturado` int(11) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `cliente_nit` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `nit` varchar(20) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`nit`, `nombre`, `direccion`) VALUES
('cf', 'SERVICIO', 'TIENDA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repuesto`
--

CREATE TABLE `repuesto` (
  `codigo` varchar(45) NOT NULL,
  `descripcion` varchar(65) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` float(12,2) DEFAULT NULL,
  `url_imagen` varchar(200) DEFAULT NULL,
  `marca_id_marca` int(11) NOT NULL,
  `type` varchar(11) DEFAULT 'B'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `repuesto`
--

INSERT INTO `repuesto` (`codigo`, `descripcion`, `cantidad`, `precio`, `url_imagen`, `marca_id_marca`, `type`) VALUES
('M001', 'MANO DE OBRA POR REPARACION', 9995, 300.00, '../img/productos/44f77914de8003aa701ad26642185810.webp', 215, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `descripcion`) VALUES
(1, 'VENTAS'),
(2, 'ADMINISTRADOR'),
(3, 'MECANICO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefono_cliente`
--

CREATE TABLE `telefono_cliente` (
  `id_telefono` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `cliente_id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `telefono_cliente`
--

INSERT INTO `telefono_cliente` (`id_telefono`, `descripcion`, `cliente_id_cliente`) VALUES
(1, '0', 230),
(2, '0', 231),
(3, '0', 232),
(4, '0', 233);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefono_proveedor`
--

CREATE TABLE `telefono_proveedor` (
  `id_tel_prov` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `proveedor_nit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id_ubicacion` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id_ubicacion`, `descripcion`) VALUES
(153, 'SERVICIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `codigo` varchar(20) NOT NULL,
  `n_usuario` varchar(45) NOT NULL,
  `empleado_id_empleado` int(11) NOT NULL,
  `rol_idrol` int(11) NOT NULL,
  `pass` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`codigo`, `n_usuario`, `empleado_id_empleado`, `rol_idrol`, `pass`) VALUES
('57830948DEON', 'PEDRO', 2, 2, '$2y$12$CHbp7gSI8FjZwiZTcno/R.kl6bhleJ6IsDKIRgekhm.t34Yl82Nu2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `facturado` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `usuario` varchar(20) DEFAULT NULL,
  `cliente_nit` varchar(40) DEFAULT NULL,
  `uuid` varchar(200) DEFAULT NULL,
  `certifier` varchar(100) DEFAULT NULL,
  `tax_code` varchar(100) DEFAULT NULL,
  `invoice_url` varchar(200) DEFAULT NULL,
  `sat_serie` varchar(100) DEFAULT NULL,
  `sat_no` varchar(100) DEFAULT NULL,
  `sat_authorization` varchar(200) DEFAULT NULL,
  `certification_date` varchar(200) DEFAULT NULL,
  `estado_dte` int(9) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `facturado`, `fecha`, `usuario`, `cliente_nit`, `uuid`, `certifier`, `tax_code`, `invoice_url`, `sat_serie`, `sat_no`, `sat_authorization`, `certification_date`, `estado_dte`) VALUES
(1, 1, '2022-10-20 22:32:49', '57830948DEON', '230', '3EC11526-B538-4E55-A764-84F97F9129E8', 'CONTAP, S.A.', '98978802', '', '60673599', '2613988884', '60673599-9BCE-4E14-9F85-92416A4E7E57', '2022-10-20 20:35:05', 0),
(2, 1, '2022-12-04 17:41:41', '57830948DEON', '231', '227CCCA2-B55B-42EE-B237-574753ACA8F0', 'CONTAP, S.A.', '98978802', '', 'EAF990E4', '329731473', 'EAF990E4-13A7-4D91-94CC-8F171795A06A', '2022-12-04 16:53:13', 0),
(3, 0, '2022-12-12 10:31:58', '57830948DEON', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, 1, '2022-12-23 20:44:47', '57830948DEON', '232', 'FDE2C799-F638-4B86-9D8B-099A105EA26A', 'CONTAP, S.A.', '98978802', '', 'C0055610', '3288350845', 'C0055610-C400-407D-A6FB-5D2FF6980BF3', '2022-12-23 19:47:15', 0),
(5, 1, '2022-12-27 09:46:26', '57830948DEON', '233', '10F46937-E549-45F2-944C-660E94555315', 'CONTAP, S.A.', '98978802', '', '42BEC94A', '594035503', '42BEC94A-2368-432F-9220-8B82DC6AD1EF', '2022-12-27 08:50:08', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `detalle_inventario`
--
ALTER TABLE `detalle_inventario`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `fk_detalle_venta_detalle_repuesto1_idx` (`detalle_repuesto_iddetalle_repuesto`),
  ADD KEY `fk_detalle_venta_usuario1_idx` (`usuario_codigo`),
  ADD KEY `fk_detalle_venta_repuesto1_idx` (`repuesto_codigo`),
  ADD KEY `fk_detalle_inventario_inventario1_idx` (`inventario_idinventario`);

--
-- Indices de la tabla `detalle_moto`
--
ALTER TABLE `detalle_moto`
  ADD PRIMARY KEY (`iddetalle_moto`),
  ADD KEY `fk_detalle_moto_cliente2_idx` (`cliente_id_cliente1`),
  ADD KEY `fk_detalle_moto_moto1_idx` (`moto_id_moto`),
  ADD KEY `fk_detalle_moto_usuario1_idx` (`usuario_codigo`);

--
-- Indices de la tabla `detalle_repuesto`
--
ALTER TABLE `detalle_repuesto`
  ADD PRIMARY KEY (`iddetalle_repuesto`),
  ADD KEY `fk_detalle_repuesto_proveedor1_idx` (`proveedor_nit`),
  ADD KEY `fk_detalle_repuesto_ubicacion1_idx` (`ubicacion_id_ubicacion`),
  ADD KEY `fk_detalle_repuesto_repuesto1_idx` (`repuesto_codigo`),
  ADD KEY `fk_detalle_repuesto_usuario1_idx` (`usuario_codigo`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `fk_detalle_venta_detalle_repuesto1_idx` (`detalle_repuesto_iddetalle_repuesto`),
  ADD KEY `fk_detalle_venta_usuario1_idx` (`usuario_codigo`),
  ADD KEY `fk_detalle_venta_venta1_idx` (`venta_idventa`),
  ADD KEY `fk_detalle_venta_repuesto1_idx` (`repuesto_codigo`);

--
-- Indices de la tabla `detenvio`
--
ALTER TABLE `detenvio`
  ADD PRIMARY KEY (`iddetEnvio`),
  ADD KEY `fk_detalle_venta_detalle_repuesto1_idx` (`detalle_repuesto_iddetalle_repuesto`),
  ADD KEY `fk_detalle_venta_usuario1_idx` (`usuario_codigo`),
  ADD KEY `fk_detalle_venta_repuesto1_idx` (`repuesto_codigo`),
  ADD KEY `fk_detEnvio_envio1_idx` (`envio_idventa`);

--
-- Indices de la tabla `detorden`
--
ALTER TABLE `detorden`
  ADD PRIMARY KEY (`iddetalle`),
  ADD KEY `fk_detalle_venta_detalle_repuesto1_idx` (`detalle_repuesto_iddetalle_repuesto`),
  ADD KEY `fk_detalle_venta_usuario1_idx` (`usuario_codigo`),
  ADD KEY `fk_detalle_venta_repuesto1_idx` (`repuesto_codigo`),
  ADD KEY `fk_detalle_venta_copy1_orden1_idx` (`orden_idorden`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`idventa`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`idinventario`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `moto`
--
ALTER TABLE `moto`
  ADD PRIMARY KEY (`id_moto`),
  ADD KEY `fk_moto_marca1_idx` (`marca_id_marca`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`idorden`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`nit`);

--
-- Indices de la tabla `repuesto`
--
ALTER TABLE `repuesto`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_repuesto_marca1_idx` (`marca_id_marca`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `telefono_cliente`
--
ALTER TABLE `telefono_cliente`
  ADD PRIMARY KEY (`id_telefono`),
  ADD KEY `fk_telefono_cliente_cliente1_idx` (`cliente_id_cliente`);

--
-- Indices de la tabla `telefono_proveedor`
--
ALTER TABLE `telefono_proveedor`
  ADD PRIMARY KEY (`id_tel_prov`),
  ADD KEY `fk_telefono_proveedor_proveedor_idx` (`proveedor_nit`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id_ubicacion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_usuario_empleado1_idx` (`empleado_id_empleado`),
  ADD KEY `fk_usuario_rol1_idx` (`rol_idrol`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT de la tabla `detalle_inventario`
--
ALTER TABLE `detalle_inventario`
  MODIFY `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_moto`
--
ALTER TABLE `detalle_moto`
  MODIFY `iddetalle_moto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_repuesto`
--
ALTER TABLE `detalle_repuesto`
  MODIFY `iddetalle_repuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4396;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detenvio`
--
ALTER TABLE `detenvio`
  MODIFY `iddetEnvio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detorden`
--
ALTER TABLE `detorden`
  MODIFY `iddetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=395;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `idinventario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT de la tabla `moto`
--
ALTER TABLE `moto`
  MODIFY `id_moto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `idorden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `telefono_cliente`
--
ALTER TABLE `telefono_cliente`
  MODIFY `id_telefono` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `telefono_proveedor`
--
ALTER TABLE `telefono_proveedor`
  MODIFY `id_tel_prov` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_inventario`
--
ALTER TABLE `detalle_inventario`
  ADD CONSTRAINT `fk_detalle_inventario_inventario1` FOREIGN KEY (`inventario_idinventario`) REFERENCES `inventario` (`idinventario`),
  ADD CONSTRAINT `fk_detalle_venta_detalle_repuesto10` FOREIGN KEY (`detalle_repuesto_iddetalle_repuesto`) REFERENCES `detalle_repuesto` (`iddetalle_repuesto`),
  ADD CONSTRAINT `fk_detalle_venta_repuesto10` FOREIGN KEY (`repuesto_codigo`) REFERENCES `repuesto` (`codigo`),
  ADD CONSTRAINT `fk_detalle_venta_usuario10` FOREIGN KEY (`usuario_codigo`) REFERENCES `usuario` (`codigo`);

--
-- Filtros para la tabla `detalle_moto`
--
ALTER TABLE `detalle_moto`
  ADD CONSTRAINT `fk_detalle_moto_cliente2` FOREIGN KEY (`cliente_id_cliente1`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_detalle_moto_moto1` FOREIGN KEY (`moto_id_moto`) REFERENCES `moto` (`id_moto`),
  ADD CONSTRAINT `fk_detalle_moto_usuario1` FOREIGN KEY (`usuario_codigo`) REFERENCES `usuario` (`codigo`);

--
-- Filtros para la tabla `detalle_repuesto`
--
ALTER TABLE `detalle_repuesto`
  ADD CONSTRAINT `fk_detalle_repuesto_proveedor1` FOREIGN KEY (`proveedor_nit`) REFERENCES `proveedor` (`nit`),
  ADD CONSTRAINT `fk_detalle_repuesto_repuesto1` FOREIGN KEY (`repuesto_codigo`) REFERENCES `repuesto` (`codigo`),
  ADD CONSTRAINT `fk_detalle_repuesto_ubicacion1` FOREIGN KEY (`ubicacion_id_ubicacion`) REFERENCES `ubicacion` (`id_ubicacion`),
  ADD CONSTRAINT `fk_detalle_repuesto_usuario1` FOREIGN KEY (`usuario_codigo`) REFERENCES `usuario` (`codigo`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_detalle_venta_detalle_repuesto1` FOREIGN KEY (`detalle_repuesto_iddetalle_repuesto`) REFERENCES `detalle_repuesto` (`iddetalle_repuesto`),
  ADD CONSTRAINT `fk_detalle_venta_repuesto1` FOREIGN KEY (`repuesto_codigo`) REFERENCES `repuesto` (`codigo`),
  ADD CONSTRAINT `fk_detalle_venta_usuario1` FOREIGN KEY (`usuario_codigo`) REFERENCES `usuario` (`codigo`),
  ADD CONSTRAINT `fk_detalle_venta_venta1` FOREIGN KEY (`venta_idventa`) REFERENCES `venta` (`idventa`);

--
-- Filtros para la tabla `detenvio`
--
ALTER TABLE `detenvio`
  ADD CONSTRAINT `fk_detEnvio_envio1` FOREIGN KEY (`envio_idventa`) REFERENCES `envio` (`idventa`),
  ADD CONSTRAINT `fk_detalle_venta_detalle_repuesto11` FOREIGN KEY (`detalle_repuesto_iddetalle_repuesto`) REFERENCES `detalle_repuesto` (`iddetalle_repuesto`),
  ADD CONSTRAINT `fk_detalle_venta_repuesto11` FOREIGN KEY (`repuesto_codigo`) REFERENCES `repuesto` (`codigo`),
  ADD CONSTRAINT `fk_detalle_venta_usuario11` FOREIGN KEY (`usuario_codigo`) REFERENCES `usuario` (`codigo`);

--
-- Filtros para la tabla `detorden`
--
ALTER TABLE `detorden`
  ADD CONSTRAINT `fk_detalle_venta_copy1_orden1` FOREIGN KEY (`orden_idorden`) REFERENCES `orden` (`idorden`),
  ADD CONSTRAINT `fk_detalle_venta_detalle_repuesto12` FOREIGN KEY (`detalle_repuesto_iddetalle_repuesto`) REFERENCES `detalle_repuesto` (`iddetalle_repuesto`),
  ADD CONSTRAINT `fk_detalle_venta_repuesto12` FOREIGN KEY (`repuesto_codigo`) REFERENCES `repuesto` (`codigo`),
  ADD CONSTRAINT `fk_detalle_venta_usuario12` FOREIGN KEY (`usuario_codigo`) REFERENCES `usuario` (`codigo`);

--
-- Filtros para la tabla `moto`
--
ALTER TABLE `moto`
  ADD CONSTRAINT `fk_moto_marca1` FOREIGN KEY (`marca_id_marca`) REFERENCES `marca` (`id_marca`);

--
-- Filtros para la tabla `repuesto`
--
ALTER TABLE `repuesto`
  ADD CONSTRAINT `fk_repuesto_marca1` FOREIGN KEY (`marca_id_marca`) REFERENCES `marca` (`id_marca`);

--
-- Filtros para la tabla `telefono_cliente`
--
ALTER TABLE `telefono_cliente`
  ADD CONSTRAINT `fk_telefono_cliente_cliente1` FOREIGN KEY (`cliente_id_cliente`) REFERENCES `cliente` (`id_cliente`);

--
-- Filtros para la tabla `telefono_proveedor`
--
ALTER TABLE `telefono_proveedor`
  ADD CONSTRAINT `fk_telefono_proveedor_proveedor` FOREIGN KEY (`proveedor_nit`) REFERENCES `proveedor` (`nit`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_empleado1` FOREIGN KEY (`empleado_id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `fk_usuario_rol1` FOREIGN KEY (`rol_idrol`) REFERENCES `rol` (`idrol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
