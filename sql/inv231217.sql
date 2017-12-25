-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 25-12-2017 a las 21:31:24
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `inv231217`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblbancos`
--

CREATE TABLE IF NOT EXISTS `tblbancos` (
  `idBanco` tinyint(2) unsigned NOT NULL,
  `banco` varchar(20) NOT NULL,
  `tipo_cuenta` varchar(10) NOT NULL,
  `num_cuenta` char(20) NOT NULL,
  PRIMARY KEY (`idBanco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblbancos`
--

INSERT INTO `tblbancos` (`idBanco`, `banco`, `tipo_cuenta`, `num_cuenta`) VALUES
(1, 'BANESCO', 'CORRIENTE', '01430215910987654321'),
(2, 'BFC', 'CORRIENTE', '12345678900987654321'),
(3, 'ACTIVO', 'CORRIENTE', '12345678901234567890'),
(4, 'BOD', 'CORRIENTE', '12345678901112131415'),
(5, 'BANPLUS', 'CORRIENTE', '09876543211234567890');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblcontrolingresos`
--

CREATE TABLE IF NOT EXISTS `tblcontrolingresos` (
  `idcontrol` int(10) unsigned NOT NULL,
  `idtblTienda` tinyint(3) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `comentario` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idcontrol`),
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
(1, 1, 3, -2, '120000.00'),
(5, 3, 11, -10, '123400.00'),
(6, 4, 2, -10, '350000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblfacturas`
--

CREATE TABLE IF NOT EXISTS `tblfacturas` (
  `idFactura` int(10) unsigned NOT NULL,
  `idtblTienda` tinyint(3) unsigned NOT NULL,
  `idOpciones` tinyint(2) unsigned NOT NULL COMMENT '1 para ventas y 0 para entregas',
  `fecha` date NOT NULL,
  `numFactura` int(10) unsigned DEFAULT NULL,
  `comentario` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idFactura`),
  KEY `fk_tblFacturas_tblTiendas_idx` (`idtblTienda`),
  KEY `tblfactuas_tblopciones` (`idOpciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblfacturas`
--

INSERT INTO `tblfacturas` (`idFactura`, `idtblTienda`, `idOpciones`, `fecha`, `numFactura`, `comentario`) VALUES
(1, 3, 1, '2017-12-24', 1, ''),
(3, 3, 1, '2017-12-25', 2, ''),
(4, 1, 1, '2017-12-25', 1, '');

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
(5, 'Transferencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblingresos`
--

CREATE TABLE IF NOT EXISTS `tblingresos` (
  `idingresos` int(10) unsigned NOT NULL,
  `idBanco` tinyint(2) unsigned NOT NULL,
  `idtipomovimiento` tinyint(2) unsigned NOT NULL,
  `idcontrol` int(10) unsigned NOT NULL,
  `montoIngreso` decimal(12,2) NOT NULL,
  PRIMARY KEY (`idingresos`),
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
  `opcion` varchar(45) NOT NULL,
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
-- Estructura de tabla para la tabla `tblpagos2`
--

CREATE TABLE IF NOT EXISTS `tblpagos2` (
  `idtblpagos` int(10) unsigned NOT NULL,
  `idFactura` int(10) unsigned NOT NULL,
  `idFormaPago` tinyint(3) unsigned NOT NULL,
  `referencia` varchar(8) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idtblpagos`),
  KEY `fk_tblpagos_tblfacturas1_idx` (`idFactura`),
  KEY `fk_tblpagos2_tblformaspago1_idx` (`idFormaPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblpagos2`
--

INSERT INTO `tblpagos2` (`idtblpagos`, `idFactura`, `idFormaPago`, `referencia`, `monto`) VALUES
(1, 1, 4, '123', '240000.00'),
(5, 3, 2, '432323', '123400.00'),
(6, 4, 5, '121212', '3500000.00');

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
(9, 'BERMUDAS DAMAS'),
(8, 'BERMUDAS HOMBRES'),
(4, 'BLUSA NIÑA'),
(7, 'BRAGA CORTA NIÑA'),
(6, 'BRAGA LARGA NIÑA'),
(10, 'PANTALÓN DAMA'),
(11, 'PANTALÓN HOMBRE'),
(1, 'PANTALON NIÑA'),
(5, 'SHORT NIÑA'),
(2, 'VESTIDO NIÑA');

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
(1, 'LA NIÑA', 'FALCON', 'LA DE LA TIENDA', '71616151414'),
(2, 'LA ADULTA', 'UNA PERSONA', 'LA DEL CC', '65543221112'),
(3, 'ADAN', 'ADAN NUÑES', 'LA CASA DE ADAN', '45456778900');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltipomovban`
--

CREATE TABLE IF NOT EXISTS `tbltipomovban` (
  `idtipomovimiento` tinyint(2) unsigned NOT NULL,
  `movimiento_bancario` varchar(45) NOT NULL,
  PRIMARY KEY (`idtipomovimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbltipomovban`
--

INSERT INTO `tbltipomovban` (`idtipomovimiento`, `movimiento_bancario`) VALUES
(1, 'EFECTIVO'),
(2, 'CHEQUES'),
(3, 'TRANSFERENCIAS'),
(4, 'DEPOSITOS'),
(5, 'PUNTOS DE VENTA');

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
  ADD CONSTRAINT `fk_tblDetalles_tblFacturas1` FOREIGN KEY (`idFactura`) REFERENCES `tblfacturas` (`idFactura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblDetalles_tblProductos1` FOREIGN KEY (`idproducto`) REFERENCES `tblproductos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblfacturas`
--
ALTER TABLE `tblfacturas`
  ADD CONSTRAINT `tblfacturas_ibfk_1` FOREIGN KEY (`idtblTienda`) REFERENCES `tbltiendas` (`idtblTienda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblfacturas_ibfk_3` FOREIGN KEY (`idOpciones`) REFERENCES `tblopciones` (`idOpciones`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblingresos`
--
ALTER TABLE `tblingresos`
  ADD CONSTRAINT `fk_tblingresos_tblbancos1` FOREIGN KEY (`idBanco`) REFERENCES `tblbancos` (`idBanco`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblingresos_tblcontrolingresos1` FOREIGN KEY (`idcontrol`) REFERENCES `tblcontrolingresos` (`idcontrol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblingresos_tbltipomovban1` FOREIGN KEY (`idtipomovimiento`) REFERENCES `tbltipomovban` (`idtipomovimiento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblpagos`
--
ALTER TABLE `tblpagos`
  ADD CONSTRAINT `tblpagos_ibfk_1` FOREIGN KEY (`idFactura`) REFERENCES `tblfacturas` (`idFactura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblpagos2`
--
ALTER TABLE `tblpagos2`
  ADD CONSTRAINT `fk_tblpagos2_tblformaspago1` FOREIGN KEY (`idFormaPago`) REFERENCES `tblformaspago` (`idFormaPago`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblpagos_tblfacturas1` FOREIGN KEY (`idFactura`) REFERENCES `tblfacturas` (`idFactura`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
