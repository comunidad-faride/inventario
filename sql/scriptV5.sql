-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema inventario
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema inventario
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `inventario` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `inventario` ;

-- -----------------------------------------------------
-- Table `inventario`.`tblTiendas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblTiendas` (
  `idtblTienda` TINYINT UNSIGNED NOT NULL,
  `nombreTienda` VARCHAR(50) NOT NULL,
  `Responsable` VARCHAR(50) NOT NULL,
  `direccion` VARCHAR(145) NOT NULL,
  `telefono` VARCHAR(11) CHARACTER SET 'latin2' COLLATE 'latin2_general_ci' NOT NULL,
  PRIMARY KEY (`idtblTienda`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventario`.`tblProductos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblProductos` (
  `idproducto` SMALLINT UNSIGNED NOT NULL,
  `producto` VARCHAR(45) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NOT NULL,
  PRIMARY KEY (`idproducto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventario`.`tblFormasPago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblFormasPago` (
  `idFormaPago` TINYINT UNSIGNED NOT NULL,
  `formaPago` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`idFormaPago`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventario`.`tblOpciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblOpciones` (
  `idOpciones` TINYINT(2) UNSIGNED NOT NULL,
  `opcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idOpciones`),
  UNIQUE INDEX `opcion_UNIQUE` (`opcion` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventario`.`tblFacturas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblFacturas` (
  `idFactura` INT UNSIGNED NOT NULL,
  `idtblTienda` TINYINT UNSIGNED NOT NULL,
  `idOpciones` TINYINT(2) UNSIGNED NOT NULL,
  `idFormaPago` TINYINT UNSIGNED NOT NULL,
  `fecha` DATE NOT NULL,
  `numFactura` INT UNSIGNED NULL,
  `comentario` VARCHAR(45) NULL,
  PRIMARY KEY (`idFactura`),
  INDEX `fk_tblFacturas_tblTiendas_idx` (`idtblTienda` ASC),
  INDEX `fk_tblFacturas_tblFormasPago1_idx` (`idFormaPago` ASC),
  INDEX `fk_tblFacturas_tblOpciones1_idx` (`idOpciones` ASC),
  CONSTRAINT `fk_tblFacturas_tblTiendas`
    FOREIGN KEY (`idtblTienda`)
    REFERENCES `inventario`.`tblTiendas` (`idtblTienda`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tblFacturas_tblFormasPago1`
    FOREIGN KEY (`idFormaPago`)
    REFERENCES `inventario`.`tblFormasPago` (`idFormaPago`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tblFacturas_tblOpciones1`
    FOREIGN KEY (`idOpciones`)
    REFERENCES `inventario`.`tblOpciones` (`idOpciones`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventario`.`tblDetalles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblDetalles` (
  `idDetalles` INT UNSIGNED NOT NULL,
  `idFactura` INT UNSIGNED NOT NULL,
  `idproducto` SMALLINT UNSIGNED NOT NULL,
  `cantidad` TINYINT NOT NULL,
  `precioUnitario` DECIMAL(10,2) UNSIGNED NOT NULL,
  PRIMARY KEY (`idDetalles`),
  INDEX `fk_tblDetalles_tblFacturas1_idx` (`idFactura` ASC),
  INDEX `fk_tblDetalles_tblProductos1_idx` (`idproducto` ASC),
  CONSTRAINT `fk_tblDetalles_tblFacturas1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `inventario`.`tblFacturas` (`idFactura`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tblDetalles_tblProductos1`
    FOREIGN KEY (`idproducto`)
    REFERENCES `inventario`.`tblProductos` (`idproducto`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventario`.`tblPagos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblPagos` (
  `idPago` INT UNSIGNED NOT NULL,
  `idFactura` INT UNSIGNED NOT NULL,
  `fecha` VARCHAR(45) NOT NULL,
  `monto` DECIMAL(10,2) NOT NULL,
  `confirmado` CHAR(1) NOT NULL DEFAULT '\"N\"',
  PRIMARY KEY (`idPago`),
  INDEX `fk_tblPagos_tblFacturas1_idx` (`idFactura` ASC),
  CONSTRAINT `fk_tblPagos_tblFacturas1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `inventario`.`tblFacturas` (`idFactura`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventario`.`tblOtrasAcciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblOtrasAcciones` (
  `idOtrasAcciones` TINYINT UNSIGNED NOT NULL COMMENT 'Otras acciones: \n1. Cambio de mercancía de una tienda a otra\n2. Devolución de mercancía.\n3. Reducción por pérdida/sustracción/robo\n4. Cualquier otra acción que se presente.',
  `accion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idOtrasAcciones`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventario`.`tblMovimientos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblMovimientos` (
  `idMovimientos` INT UNSIGNED NOT NULL,
  `fecha` DATE NOT NULL,
  `idOtrasAcciones` TINYINT UNSIGNED NOT NULL,
  `tiendaOrigen` TINYINT NULL,
  `tiendaDestino` TINYINT NULL,
  PRIMARY KEY (`idMovimientos`),
  INDEX `fk_tblMovimientos_tblOtrasAcciones1_idx` (`idOtrasAcciones` ASC),
  CONSTRAINT `fk_tblMovimientos_tblOtrasAcciones1`
    FOREIGN KEY (`idOtrasAcciones`)
    REFERENCES `inventario`.`tblOtrasAcciones` (`idOtrasAcciones`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventario`.`tblPiezas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblPiezas` (
  `idPiezas` INT UNSIGNED NOT NULL,
  `idproducto` SMALLINT UNSIGNED NOT NULL,
  `cantidad` SMALLINT NOT NULL,
  `tblMovimientos_idMovimientos` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idPiezas`),
  INDEX `fk_tblPiezas_tblProductos1_idx` (`idproducto` ASC),
  INDEX `fk_tblPiezas_tblMovimientos1_idx` (`tblMovimientos_idMovimientos` ASC),
  CONSTRAINT `fk_tblPiezas_tblProductos1`
    FOREIGN KEY (`idproducto`)
    REFERENCES `inventario`.`tblProductos` (`idproducto`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tblPiezas_tblMovimientos1`
    FOREIGN KEY (`tblMovimientos_idMovimientos`)
    REFERENCES `inventario`.`tblMovimientos` (`idMovimientos`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventario`.`tblUsuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventario`.`tblUsuarios` (
  `idUsuario` TINYINT NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `clave` CHAR(32) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
