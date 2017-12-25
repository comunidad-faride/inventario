-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema inv231217
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema inv231217
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `inv231217` DEFAULT CHARACTER SET utf8 ;
-- -----------------------------------------------------
-- Schema new_schema1
-- -----------------------------------------------------
USE `inv231217` ;

-- -----------------------------------------------------
-- Table `inv231217`.`tbltiendas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tbltiendas` (
  `idtblTienda` TINYINT(3) UNSIGNED NOT NULL,
  `nombreTienda` VARCHAR(50) NOT NULL,
  `Responsable` VARCHAR(50) NOT NULL,
  `direccion` VARCHAR(145) NOT NULL,
  `telefono` VARCHAR(11) CHARACTER SET 'latin2' NOT NULL,
  PRIMARY KEY (`idtblTienda`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inv231217`.`tblopciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tblopciones` (
  `idOpciones` TINYINT(2) UNSIGNED NOT NULL,
  `opcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idOpciones`),
  UNIQUE INDEX `opcion_UNIQUE` (`opcion` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inv231217`.`tblfacturas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tblfacturas` (
  `idFactura` INT(10) UNSIGNED NOT NULL,
  `idtblTienda` TINYINT(3) UNSIGNED NOT NULL,
  `idOpciones` TINYINT(2) UNSIGNED NOT NULL COMMENT '1 para ventas y 0 para entregas',
  `fecha` DATE NOT NULL,
  `numFactura` INT(10) UNSIGNED NULL DEFAULT NULL,
  `comentario` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idFactura`),
  INDEX `fk_tblFacturas_tblTiendas_idx` (`idtblTienda` ASC),
  INDEX `tblfactuas_tblopciones` (`idOpciones` ASC),
  CONSTRAINT `tblfacturas_ibfk_1`
    FOREIGN KEY (`idtblTienda`)
    REFERENCES `inv231217`.`tbltiendas` (`idtblTienda`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `tblfacturas_ibfk_3`
    FOREIGN KEY (`idOpciones`)
    REFERENCES `inv231217`.`tblopciones` (`idOpciones`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inv231217`.`tblproductos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tblproductos` (
  `idproducto` SMALLINT(5) UNSIGNED NOT NULL,
  `producto` VARCHAR(45) CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci' NOT NULL,
  PRIMARY KEY (`idproducto`),
  UNIQUE INDEX `unico_nombre_producto` (`producto` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inv231217`.`tbldetalles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tbldetalles` (
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
    REFERENCES `inv231217`.`tblfacturas` (`idFactura`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tblDetalles_tblProductos1`
    FOREIGN KEY (`idproducto`)
    REFERENCES `inv231217`.`tblproductos` (`idproducto`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inv231217`.`tblformaspago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tblformaspago` (
  `idFormaPago` TINYINT(3) UNSIGNED NOT NULL,
  `formaPago` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`idFormaPago`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inv231217`.`tblpagos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tblpagos` (
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
    REFERENCES `inv231217`.`tblfacturas` (`idFactura`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inv231217`.`tblusuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tblusuarios` (
  `idUsuario` TINYINT(4) NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `clave` CHAR(32) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `inv231217`.`tblbancos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tblbancos` (
  `idBanco` TINYINT(2) UNSIGNED NOT NULL,
  `banco` VARCHAR(20) NOT NULL,
  `tipo_cuenta` VARCHAR(10) NOT NULL,
  `num_cuenta` CHAR(20) NOT NULL,
  PRIMARY KEY (`idBanco`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inv231217`.`tbltipomovban`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tbltipomovban` (
  `idtipomovimiento` TINYINT(2) UNSIGNED NOT NULL,
  `movimiento_bancario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idtipomovimiento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inv231217`.`tblcontrolingresos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tblcontrolingresos` (
  `idcontrol` INT UNSIGNED NOT NULL,
  `idtblTienda` TINYINT(3) UNSIGNED NOT NULL,
  `fecha` DATE NOT NULL,
  `comentario` VARCHAR(150) NULL,
  PRIMARY KEY (`idcontrol`),
  INDEX `fk_tblcontrolingresos_tbltiendas1_idx` (`idtblTienda` ASC),
  CONSTRAINT `fk_tblcontrolingresos_tbltiendas1`
    FOREIGN KEY (`idtblTienda`)
    REFERENCES `inv231217`.`tbltiendas` (`idtblTienda`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inv231217`.`tblingresos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tblingresos` (
  `idingresos` INT UNSIGNED NOT NULL,
  `idBanco` TINYINT(2) UNSIGNED NOT NULL,
  `idtipomovimiento` TINYINT(2) UNSIGNED NOT NULL,
  `idcontrol` INT UNSIGNED NOT NULL,
  `montoIngreso` DECIMAL(12,2) NOT NULL,
  PRIMARY KEY (`idingresos`),
  INDEX `fk_tblingresos_tblbancos1_idx` (`idBanco` ASC),
  INDEX `fk_tblingresos_tbltipomovban1_idx` (`idtipomovimiento` ASC),
  INDEX `fk_tblingresos_tblcontrolingresos1_idx` (`idcontrol` ASC),
  CONSTRAINT `fk_tblingresos_tblbancos1`
    FOREIGN KEY (`idBanco`)
    REFERENCES `inv231217`.`tblbancos` (`idBanco`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tblingresos_tbltipomovban1`
    FOREIGN KEY (`idtipomovimiento`)
    REFERENCES `inv231217`.`tbltipomovban` (`idtipomovimiento`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tblingresos_tblcontrolingresos1`
    FOREIGN KEY (`idcontrol`)
    REFERENCES `inv231217`.`tblcontrolingresos` (`idcontrol`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inv231217`.`tblpagos2`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inv231217`.`tblpagos2` (
  `idtblpagos` INT UNSIGNED NOT NULL,
  `idFactura` INT(10) UNSIGNED NOT NULL,
  `idFormaPago` TINYINT(3) UNSIGNED NOT NULL,
  `referencia` VARCHAR(8) NOT NULL,
  `monto` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`idtblpagos`),
  INDEX `fk_tblpagos_tblfacturas1_idx` (`idFactura` ASC),
  INDEX `fk_tblpagos2_tblformaspago1_idx` (`idFormaPago` ASC),
  CONSTRAINT `fk_tblpagos_tblfacturas1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `inv231217`.`tblfacturas` (`idFactura`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tblpagos2_tblformaspago1`
    FOREIGN KEY (`idFormaPago`)
    REFERENCES `inv231217`.`tblformaspago` (`idFormaPago`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
