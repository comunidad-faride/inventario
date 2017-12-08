-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-11-2017 a las 21:30:30
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `invent`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblbancos`
--

CREATE TABLE IF NOT EXISTS `tblbancos` (
  `idBanco` tinyint(2) unsigned NOT NULL,
  `banco` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idBanco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblcontrolingresos`
--

CREATE TABLE IF NOT EXISTS `tblcontrolingresos` (
  `idcontrol` int(10) unsigned NOT NULL,
  `idtblTienda` tinyint(3) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `comentario` varchar(150) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idcontrol`,`idtblTienda`),
  KEY `fk_tblcontrolingresos_tbltiendas1_idx` (`idtblTienda`)
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
(1, 1, 3, 20, '430000.00'),
(2, 1, 4, 10, '350000.00'),
(3, 1, 1, 25, '350000.00'),
(4, 1, 5, 20, '280000.00'),
(5, 2, 1, -5, '350000.00'),
(6, 2, 3, -10, '430000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblfacturas`
--

CREATE TABLE IF NOT EXISTS `tblfacturas` (
  `idFactura` int(10) unsigned NOT NULL,
  `idtblTienda` tinyint(3) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `numFactura` int(10) unsigned DEFAULT NULL,
  `idOpciones` tinyint(2) unsigned NOT NULL COMMENT '1 para ventas y 0 para entregas',
  `idFormaPago` tinyint(3) unsigned NOT NULL COMMENT 'Los valores serÃ¡n los correspondientes a idFormaPago de la entidad tblformaspago',
  `comentario` varchar(45) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idFactura`),
  KEY `fk_tblFacturas_tblTiendas_idx` (`idtblTienda`),
  KEY `tblfactuas_tblopciones` (`idOpciones`),
  KEY `idFormaPago` (`idFormaPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblfacturas`
--

INSERT INTO `tblfacturas` (`idFactura`, `idtblTienda`, `fecha`, `numFactura`, `idOpciones`, `idFormaPago`, `comentario`) VALUES
(1, 1, '2017-11-28', 1, 0, 1, ''),
(2, 1, '2017-11-28', 1, 1, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblformaspago`
--

CREATE TABLE IF NOT EXISTS `tblformaspago` (
  `idFormaPago` tinyint(3) unsigned NOT NULL,
  `formaPago` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idFormaPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblformaspago`
--

INSERT INTO `tblformaspago` (`idFormaPago`, `formaPago`) VALUES
(1, 'Efectivo'),
(2, 'Debito'),
(3, 'Tarjeta Credito'),
(4, 'Credito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblingresos`
--

CREATE TABLE IF NOT EXISTS `tblingresos` (
  `idingresos` int(10) unsigned NOT NULL,
  `idBanco` tinyint(2) unsigned NOT NULL,
  `idtipomovimiento` tinyint(2) unsigned NOT NULL,
  `idcontrol` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idingresos`,`idBanco`,`idtipomovimiento`),
  KEY `fk_tblingresos_tblbancos1_idx` (`idBanco`),
  KEY `fk_tblingresos_tbltipomovban1_idx` (`idtipomovimiento`),
  KEY `fk_tblingresos_tblcontrolingresos1_idx` (`idcontrol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblopciones`
--

CREATE TABLE IF NOT EXISTS `tblopciones` (
  `idOpciones` tinyint(2) unsigned NOT NULL,
  `opcion` varchar(45) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idOpciones`),
  UNIQUE KEY `opcion_UNIQUE` (`opcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblopciones`
--

INSERT INTO `tblopciones` (`idOpciones`, `opcion`) VALUES
(0, 'Entregas'),
(2, 'Inventario Inicial'),
(1, 'Ventas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblpagos`
--

CREATE TABLE IF NOT EXISTS `tblpagos` (
  `idPago` int(10) unsigned NOT NULL,
  `idFactura` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `referencia` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL COMMENT 'Numero de referencia, factura, transferencia, deposito, etc',
  `monto` decimal(10,2) NOT NULL,
  `confirmado` char(1) NOT NULL,
  PRIMARY KEY (`idPago`),
  KEY `fk_tblPagos_tblFacturas1_idx` (`idFactura`)
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
(3, 'BERMUDA NIÑA'),
(4, 'BLUSA NIÑA'),
(7, 'BRAGA CORTA NIÑA'),
(6, 'BRAGA LARGA NIÑA'),
(1, 'PANTALON NIÑA'),
(5, 'SHORT NIÑA'),
(2, 'VESTIDO NIÑA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltiendas`
--

CREATE TABLE IF NOT EXISTS `tbltiendas` (
  `idtblTienda` tinyint(3) unsigned NOT NULL,
  `nombreTienda` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `Responsable` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `direccion` varchar(145) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `telefono` varchar(11) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idtblTienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbltiendas`
--

INSERT INTO `tbltiendas` (`idtblTienda`, `nombreTienda`, `Responsable`, `direccion`, `telefono`) VALUES
(1, 'LA NIÑA', 'FALCON', 'LA DE LA TIENDA', '71616151414');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltipomovban`
--

CREATE TABLE IF NOT EXISTS `tbltipomovban` (
  `idtipomovimiento` tinyint(2) unsigned NOT NULL,
  `movimiento_bancario` varchar(45) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipomovimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblusuarios`
--

CREATE TABLE IF NOT EXISTS `tblusuarios` (
  `idUsuario` tinyint(4) NOT NULL,
  `usuario` varchar(45) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `clave` char(32) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblusuarios`
--

INSERT INTO `tblusuarios` (`idUsuario`, `usuario`, `clave`) VALUES
(0, 'jose', 'd93591bdf7860e1e4ee2fca799911215'),
(1, 'luis', '81dc9bdb52d04dc20036dbd8313ed055'),
(2, 'delgadoerrade', '1a53bbc9e9a2c9953f1259c8b7e6e2ea');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tblcontrolingresos`
--
ALTER TABLE `tblcontrolingresos`
  ADD CONSTRAINT `fk_tblcontrolingresos_tbltiendas1` FOREIGN KEY (`idtblTienda`) REFERENCES `tbltiendas` (`idtblTienda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbldetalles`
--
ALTER TABLE `tbldetalles`
  ADD CONSTRAINT `fk_tblDetalles_tblFacturas1` FOREIGN KEY (`idFactura`) REFERENCES `inventario`.`tblfacturas` (`idFactura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblDetalles_tblProductos1` FOREIGN KEY (`idproducto`) REFERENCES `inventario`.`tblproductos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblfacturas`
--
ALTER TABLE `tblfacturas`
  ADD CONSTRAINT `tblfacturas_ibfk_1` FOREIGN KEY (`idtblTienda`) REFERENCES `inventario`.`tbltiendas` (`idtblTienda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblfacturas_ibfk_3` FOREIGN KEY (`idOpciones`) REFERENCES `inventario`.`tblopciones` (`idOpciones`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblfacturas_ibfk_4` FOREIGN KEY (`idFormaPago`) REFERENCES `inventario`.`tblformaspago` (`idFormaPago`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblingresos`
--
ALTER TABLE `tblingresos`
  ADD CONSTRAINT `fk_tblingresos_tblbancos1` FOREIGN KEY (`idBanco`) REFERENCES `tblbancos` (`idBanco`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblingresos_tbltipomovban1` FOREIGN KEY (`idtipomovimiento`) REFERENCES `tbltipomovban` (`idtipomovimiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblingresos_tblcontrolingresos1` FOREIGN KEY (`idcontrol`) REFERENCES `tblcontrolingresos` (`idcontrol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblpagos`
--
ALTER TABLE `tblpagos`
  ADD CONSTRAINT `tblpagos_ibfk_1` FOREIGN KEY (`idFactura`) REFERENCES `inventario`.`tblfacturas` (`idFactura`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
