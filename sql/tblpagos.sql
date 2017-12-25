-- -----------------------------------------------------
-- Table `tblpagos2`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tblpagos2` (
  `idtblpagos` INT UNSIGNED NOT NULL,
  `idFactura` INT(10) UNSIGNED NOT NULL,
  `formaPago` TINYINT(1) NOT NULL,
  `referencia` VARCHAR(8) NOT NULL,
  `monto` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`idtblpagos`),
  INDEX `fk_tblpagos_tblfacturas1_idx` (`idFactura` ASC),
  CONSTRAINT `fk_tblpagos_tblfacturas1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `inventario`.`tblfacturas` (`idFactura`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;