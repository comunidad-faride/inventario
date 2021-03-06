-- MySQL Script generated by MySQL Workbench
-- 11/27/17 10:19:28
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema inventario
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema inventario
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `inventario` DEFAULT CHARACTER SET utf8 ;
USE `inventario` ;

-- -----------------------------------------------------
-- Table `inventario`.`tbltiendas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tbltiendas` (
  `idtblTienda` TINYINT(3) UNSIGNED NOT NULL,
  `nombreTienda` VARCHAR(50) NOT NULL,
  `Responsable` VARCHAR(50) NOT NULL,
  `direccion` VARCHAR(145) NOT NULL,
  `telefono` VARCHAR(11) CHARACTER SET 'latin2' NOT NULL,
  PRIMARY KEY (`idtblTienda`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inventario`.`tblopciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblopciones` (
  `idOpciones` TINYINT(2) UNSIGNED NOT NULL,
  `opcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idOpciones`),
  UNIQUE INDEX `opcion_UNIQUE` (`opcion` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inventario`.`tblformaspago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblformaspago` (
  `idFormaPago` TINYINT(3) UNSIGNED NOT NULL,
  `formaPago` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`idFormaPago`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inventario`.`tblfacturas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblfacturas` (
  `idFactura` INT(10) UNSIGNED NOT NULL,
  `idtblTienda` TINYINT(3) UNSIGNED NOT NULL,
  `fecha` DATE NOT NULL,
  `numFactura` INT(10) UNSIGNED NULL DEFAULT NULL,
  `idOpciones` TINYINT(2) UNSIGNED NOT NULL COMMENT '1 para ventas y 0 para entregas',
  `idFormaPago` TINYINT(3) UNSIGNED NOT NULL COMMENT 'Los valores serán los correspondientes a idFormaPago de la entidad tblformaspago',
  `comentario` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idFactura`),
  INDEX `fk_tblFacturas_tblTiendas_idx` (`idtblTienda` ASC),
  INDEX `tblfactuas_tblopciones` (`idOpciones` ASC),
  INDEX `idFormaPago` (`idFormaPago` ASC),
  CONSTRAINT `tblfacturas_ibfk_1`
    FOREIGN KEY (`idtblTienda`)
    REFERENCES `inventario`.`tbltiendas` (`idtblTienda`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `tblfacturas_ibfk_3`
    FOREIGN KEY (`idOpciones`)
    REFERENCES `inventario`.`tblopciones` (`idOpciones`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `tblfacturas_ibfk_4`
    FOREIGN KEY (`idFormaPago`)
    REFERENCES `inventario`.`tblformaspago` (`idFormaPago`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inventario`.`tblproductos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblproductos` (
  `idproducto` SMALLINT(5) UNSIGNED NOT NULL,
  `producto` VARCHAR(45) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NOT NULL,
  PRIMARY KEY (`idproducto`),
  UNIQUE INDEX `unico_nombre_producto` (`producto` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inventario`.`tbldetalles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tbldetalles` (
  `idDetalles` INT(10) UNSIGNED NOT NULL,
  `idFactura` INT(10) UNSIGNED NOT NULL,
  `idproducto` SMALLINT(5) UNSIGNED NOT NULL,
  `cantidad` TINYINT(4) NOT NULL,
  `precioUnitario` DECIMAL(10,2) UNSIGNED NOT NULL,
  PRIMARY KEY (`idDetalles`),
  INDEX `fk_tblDetalles_tblFacturas1_idx` (`idFactura` ASC),
  INDEX `fk_tblDetalles_tblProductos1_idx` (`idproducto` ASC),
  CONSTRAINT `fk_tblDetalles_tblFacturas1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `inventario`.`tblfacturas` (`idFactura`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tblDetalles_tblProductos1`
    FOREIGN KEY (`idproducto`)
    REFERENCES `inventario`.`tblproductos` (`idproducto`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inventario`.`tblpagos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblpagos` (
  `idPago` INT(10) UNSIGNED NOT NULL,
  `idFactura` INT(10) UNSIGNED NOT NULL,
  `fecha` DATE NOT NULL,
  `referencia` VARCHAR(10) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NOT NULL COMMENT 'Numero de referencia, factura, transferencia, deposito, etc',
  `monto` DECIMAL(10,2) NOT NULL,
  `confirmado` CHAR(1) NOT NULL,
  PRIMARY KEY (`idPago`),
  INDEX `fk_tblPagos_tblFacturas1_idx` (`idFactura` ASC),
  CONSTRAINT `tblpagos_ibfk_1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `inventario`.`tblfacturas` (`idFactura`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inventario`.`tblusuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblusuarios` (
  `idUsuario` TINYINT(4) NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `clave` CHAR(32) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
