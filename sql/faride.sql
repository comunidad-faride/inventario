-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 18-11-2017 a las 11:44:36
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblcontrol`
--

CREATE TABLE IF NOT EXISTS `tblcontrol` (
  `idControl` int(10) unsigned NOT NULL DEFAULT '0',
  `idControlFisico` int(10) unsigned NOT NULL,
  `idproducto` smallint(5) unsigned NOT NULL,
  `cantidad` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`idControl`),
  KEY `fk_tblControl_tblControlFisico1_idx` (`idControlFisico`),
  KEY `fk_tblControl_tblProductos1_idx` (`idproducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblcontrolfisico`
--

CREATE TABLE IF NOT EXISTS `tblcontrolfisico` (
  `idControlFisico` int(10) unsigned NOT NULL DEFAULT '0',
  `idtblTienda` tinyint(3) unsigned NOT NULL,
  `fecha` date DEFAULT NULL,
  `idTipoControl` tinyint(6) unsigned NOT NULL,
  PRIMARY KEY (`idControlFisico`),
  KEY `fk_tblControlFisico_tblTiendas1_idx` (`idtblTienda`),
  KEY `idTipoControl` (`idTipoControl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbldetalles`
--

CREATE TABLE IF NOT EXISTS `tbldetalles` (
  `idDetalles` int(10) unsigned NOT NULL,
  `idFactura` int(10) unsigned NOT NULL,
  `idproducto` smallint(5) unsigned NOT NULL,
  `cantidad` tinyint(4) NOT NULL,
  `precioUnitario` decimal(10,2) unsigned NOT NULL,
  PRIMARY KEY (`idDetalles`),
  KEY `fk_tblDetalles_tblFacturas1_idx` (`idFactura`),
  KEY `fk_tblDetalles_tblProductos1_idx` (`idproducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbldetalles`
--

INSERT INTO `tbldetalles` (`idDetalles`, `idFactura`, `idproducto`, `cantidad`, `precioUnitario`) VALUES
(1, 1, 1, -12, '123.00'),
(2, 1, 1, -123, '321.00'),
(3, 1, 1, -128, '13243.00'),
(4, 1, 1, -32, '12.00'),
(5, 1, 1, -128, '4524.00'),
(6, 1, 1, -128, '645.00'),
(7, 1, 1, -76, '64.00'),
(8, 1, 1, -64, '54.00'),
(9, 1, 1, -65, '54.00'),
(10, 1, 1, -64, '54.00'),
(11, 2, 1, -11, '123.00'),
(12, 2, 1, -12, '321.00'),
(13, 2, 1, -13, '13243.00'),
(14, 2, 1, -14, '12.00'),
(15, 2, 1, -15, '4524.00'),
(16, 2, 1, -16, '645.00'),
(17, 2, 1, -17, '64.00'),
(18, 2, 1, -18, '54.00'),
(19, 2, 1, -19, '54.00'),
(20, 2, 1, -20, '54.00'),
(21, 3, 1, -128, '54.00'),
(22, 3, 1, -128, '45.00'),
(23, 3, 1, -128, '13.00'),
(24, 4, 1, -5, '6543.00'),
(25, 4, 1, -128, '534.00'),
(26, 5, 1, -100, '5000.00'),
(27, 6, 1, 40, '100.00'),
(28, 6, 1, 40, '5000.00'),
(29, 7, 3, 10, '134500.00'),
(30, 7, 1, 20, '15000.00'),
(31, 8, 1, 15, '25000.00'),
(32, 8, 3, 20, '17200.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblfacturas`
--

CREATE TABLE IF NOT EXISTS `tblfacturas` (
  `idFactura` int(10) unsigned NOT NULL,
  `idtblTienda` tinyint(3) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `numFactura` int(10) unsigned DEFAULT NULL,
  `opcion` char(1) NOT NULL COMMENT 'V para ventas y E para entregas',
  `formaPago` tinyint(4) NOT NULL COMMENT 'Los valores serán los correspondientes a idFormaPago de la entidad tblformaspago',
  `comentario` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idFactura`),
  KEY `fk_tblFacturas_tblTiendas_idx` (`idtblTienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblfacturas`
--

INSERT INTO `tblfacturas` (`idFactura`, `idtblTienda`, `fecha`, `numFactura`, `opcion`, `formaPago`, `comentario`) VALUES
(1, 1, '2017-11-01', 176, 'V', 0, ''),
(2, 1, '2017-11-02', 177, 'V', 0, ''),
(3, 1, '2017-11-03', 178, 'V', 0, ''),
(4, 4, '2017-11-04', 1, 'V', 0, ''),
(5, 4, '2017-11-04', 1, 'V', 0, ''),
(6, 3, '2017-11-04', 1, 'E', 0, ''),
(7, 3, '2017-11-15', 2, 'E', 0, ''),
(8, 1, '2017-11-15', 1, 'E', 0, ''),
(9, 4, '2017-11-15', 2, 'V', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblformaspago`
--

CREATE TABLE IF NOT EXISTS `tblformaspago` (
  `idFormaPago` tinyint(3) unsigned NOT NULL,
  `formaPago` varchar(20) NOT NULL,
  PRIMARY KEY (`idFormaPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblformaspago`
--

INSERT INTO `tblformaspago` (`idFormaPago`, `formaPago`) VALUES
(1, 'Efectivo'),
(2, 'Debito'),
(3, 'Tarjeta Credito'),
(4, 'Credito'),
(5, 'Trueque');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblmovimientos`
--

CREATE TABLE IF NOT EXISTS `tblmovimientos` (
  `idMovimientos` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `idOtrasAcciones` tinyint(3) unsigned NOT NULL,
  `tiendaOrigen` tinyint(4) DEFAULT NULL,
  `tiendaDestino` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idMovimientos`),
  KEY `fk_tblMovimientos_tblOtrasAcciones1_idx` (`idOtrasAcciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblotrasacciones`
--

CREATE TABLE IF NOT EXISTS `tblotrasacciones` (
  `idOtrasAcciones` tinyint(3) unsigned NOT NULL COMMENT 'Otras acciones: \n1. Cambio de mercancía de una tienda a otra\n2. Devolución de mercancía.\n3. Reducción por pérdida/sustracción/robo\n4. Cualquier otra acción que se presente.',
  `accion` varchar(45) NOT NULL,
  PRIMARY KEY (`idOtrasAcciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblpagos`
--

CREATE TABLE IF NOT EXISTS `tblpagos` (
  `idPago` int(10) unsigned NOT NULL,
  `idFactura` int(10) unsigned NOT NULL,
  `idFormaPago` tinyint(3) unsigned NOT NULL,
  `fecha` varchar(45) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `confirmado` char(1) NOT NULL,
  PRIMARY KEY (`idPago`),
  KEY `fk_tblPagos_tblFacturas1_idx` (`idFactura`),
  KEY `fk_tblPagos_tblFormasPago1_idx` (`idFormaPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblpiezas`
--

CREATE TABLE IF NOT EXISTS `tblpiezas` (
  `idPiezas` int(10) unsigned NOT NULL,
  `idproducto` smallint(5) unsigned NOT NULL,
  `cantidad` smallint(6) NOT NULL,
  `tblMovimientos_idMovimientos` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idPiezas`),
  KEY `fk_tblPiezas_tblProductos1_idx` (`idproducto`),
  KEY `fk_tblPiezas_tblMovimientos1_idx` (`tblMovimientos_idMovimientos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblproductos`
--

CREATE TABLE IF NOT EXISTS `tblproductos` (
  `idproducto` smallint(5) unsigned NOT NULL,
  `producto` varchar(45) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idproducto`),
  UNIQUE KEY `unico_nombre_producto` (`producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblproductos`
--

INSERT INTO `tblproductos` (`idproducto`, `producto`) VALUES
(1, 'camisa chemisse'),
(4, 'Pantalones bermudas hombres'),
(3, 'viejo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltiendas`
--

CREATE TABLE IF NOT EXISTS `tbltiendas` (
  `idtblTienda` tinyint(3) unsigned NOT NULL,
  `nombreTienda` varchar(50) NOT NULL,
  `Responsable` varchar(50) NOT NULL,
  `direccion` varchar(145) NOT NULL,
  `telefono` varchar(11) CHARACTER SET latin2 NOT NULL,
  PRIMARY KEY (`idtblTienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbltiendas`
--

INSERT INTO `tbltiendas` (`idtblTienda`, `nombreTienda`, `Responsable`, `direccion`, `telefono`) VALUES
(1, 'primera', 'no se', 'la que es', '08987987'),
(2, 'Segunda Tienda', 'no se', 'la de la tienda', '09876655332'),
(3, 'Tercera', 'Tampoco se', 'La de esta tienda', '84747464645'),
(4, 'Cuarta tienda', 'Carajo no se', 'Otra vez la misma pregunta', '85875757664'),
(5, 'Otra mÃ¡s', 'El gue', 'la de la casa', '98876543222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltipocontrol`
--

CREATE TABLE IF NOT EXISTS `tbltipocontrol` (
  `idTipoControl` tinyint(3) unsigned NOT NULL,
  `tipoControl` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idTipoControl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblusuarios`
--

CREATE TABLE IF NOT EXISTS `tblusuarios` (
  `idUsuario` tinyint(4) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `clave` char(32) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblusuarios`
--

INSERT INTO `tblusuarios` (`idUsuario`, `usuario`, `clave`) VALUES
(1, 'delgadoerrade', '1a53bbc9e9a2c9953f1259c8b7e6e2ea'),
(2, 'jose.delgado', 'a0b8fc06561a8b42cff1d81b9bcc5f4a'),
(3, 'luisillo', 'f48433f1728c426de987fa3b8e886505');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tblcontrol`
--
ALTER TABLE `tblcontrol`
  ADD CONSTRAINT `fk_tblControl_tblControlFisico1` FOREIGN KEY (`idControlFisico`) REFERENCES `tblcontrolfisico` (`idControlFisico`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblControl_tblProductos1` FOREIGN KEY (`idproducto`) REFERENCES `tblproductos` (`idproducto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblcontrolfisico`
--
ALTER TABLE `tblcontrolfisico`
  ADD CONSTRAINT `fk_tblControlFisico_tblTiendas1` FOREIGN KEY (`idtblTienda`) REFERENCES `tbltiendas` (`idtblTienda`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tblcontrolfisico_ibfk_1` FOREIGN KEY (`idTipoControl`) REFERENCES `tbltipocontrol` (`idTipoControl`);

--
-- Filtros para la tabla `tbldetalles`
--
ALTER TABLE `tbldetalles`
  ADD CONSTRAINT `fk_tblDetalles_tblFacturas1` FOREIGN KEY (`idFactura`) REFERENCES `tblfacturas` (`idFactura`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblDetalles_tblProductos1` FOREIGN KEY (`idproducto`) REFERENCES `tblproductos` (`idproducto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblfacturas`
--
ALTER TABLE `tblfacturas`
  ADD CONSTRAINT `tblfacturas_ibfk_1` FOREIGN KEY (`idtblTienda`) REFERENCES `tbltiendas` (`idtblTienda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblfacturas_ibfk_2` FOREIGN KEY (`idFactura`) REFERENCES `tbldetalles` (`idDetalles`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblmovimientos`
--
ALTER TABLE `tblmovimientos`
  ADD CONSTRAINT `fk_tblMovimientos_tblOtrasAcciones1` FOREIGN KEY (`idOtrasAcciones`) REFERENCES `tblotrasacciones` (`idOtrasAcciones`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblpagos`
--
ALTER TABLE `tblpagos`
  ADD CONSTRAINT `fk_tblPagos_tblFacturas1` FOREIGN KEY (`idFactura`) REFERENCES `tblfacturas` (`idFactura`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblPagos_tblFormasPago1` FOREIGN KEY (`idFormaPago`) REFERENCES `tblformaspago` (`idFormaPago`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblpiezas`
--
ALTER TABLE `tblpiezas`
  ADD CONSTRAINT `fk_tblPiezas_tblMovimientos1` FOREIGN KEY (`tblMovimientos_idMovimientos`) REFERENCES `tblmovimientos` (`idMovimientos`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblPiezas_tblProductos1` FOREIGN KEY (`idproducto`) REFERENCES `tblproductos` (`idproducto`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
