
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema busca_service
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `busca_service` DEFAULT CHARACTER SET utf8 ;
USE `busca_service` ;

-- -----------------------------------------------------
-- Table `busca_service`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `busca_service`.`cliente` (
  `idcli` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(60) NOT NULL,
  `cpf` VARCHAR(14) NOT NULL,
  `telefone` VARCHAR(18) NOT NULL,
  `cep` VARCHAR(9) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  `bairro` VARCHAR(45) NOT NULL,
  `perfil` VARCHAR(3) NOT NULL COMMENT 'ADM=Administrador\\nPRO=Profissional\\nCLI=Cliente',
  `status` TINYINT(1) NOT NULL COMMENT 'Somente \"0\" ou \"1\"',
  `dataregcli` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcli`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `busca_service`.`profissional`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `busca_service`.`profissional` (
  `idpro` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(60) NOT NULL,
  `cpf` VARCHAR(14) NOT NULL,
  `telefone` VARCHAR(18) NOT NULL,
  `telefone2` VARCHAR(18) NULL,
  `cep` VARCHAR(9) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  `bairro` VARCHAR(45) NOT NULL,
  `titulo` VARCHAR(100) NOT NULL,
  `descricaonegocio` TEXT NOT NULL,
  `fotoprin` BLOB NOT NULL,
  `fotosec` BLOB NULL,
  `fotosec2` BLOB NULL,
  `perfil` VARCHAR(3) NOT NULL COMMENT 'ADM=Administrador\\nPRO=Profissional\\nCLI=Cliente',
  `status` TINYINT(1) NOT NULL COMMENT 'Somente \"0\" ou \"1\"',
  `dataregpro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpro`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `busca_service`.`servico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `busca_service`.`servico` (
  `idserv` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `categoria` VARCHAR(45) NOT NULL,
  `status` TINYINT(1) NOT NULL COMMENT 'Somente \"0\" ou \"1\"',
  `dataregserv` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cliente_idcli` INT NOT NULL,
  PRIMARY KEY (`idserv`, `cliente_idcli`),
  INDEX `fk_servico_cliente1_idx` (`cliente_idcli` ASC),
  CONSTRAINT `fk_servico_cliente1`
    FOREIGN KEY (`cliente_idcli`)
    REFERENCES `busca_service`.`cliente` (`idcli`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `busca_service`.`pagamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `busca_service`.`pagamento` (
  `idpag` INT NOT NULL AUTO_INCREMENT,
  `data` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valor` DECIMAL(9,2) NOT NULL,
  `numero` INT NOT NULL,
  `link` VARCHAR(255) NOT NULL,
  `cliente_idcli` INT NOT NULL,
  PRIMARY KEY (`idpag`, `cliente_idcli`),
  INDEX `fk_pagamento_cliente1_idx` (`cliente_idcli` ASC),
  CONSTRAINT `fk_pagamento_cliente1`
    FOREIGN KEY (`cliente_idcli`)
    REFERENCES `busca_service`.`cliente` (`idcli`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `busca_service`.`profissional_has_servico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `busca_service`.`profissional_has_servico` (
  `profissional_idpro` INT NOT NULL,
  `servico_idserv` INT NOT NULL,
  PRIMARY KEY (`profissional_idpro`, `servico_idserv`),
  INDEX `fk_profissional_has_servico_servico1_idx` (`servico_idserv` ASC),
  INDEX `fk_profissional_has_servico_profissional1_idx` (`profissional_idpro` ASC),
  CONSTRAINT `fk_profissional_has_servico_profissional1`
    FOREIGN KEY (`profissional_idpro`)
    REFERENCES `busca_service`.`profissional` (`idpro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profissional_has_servico_servico1`
    FOREIGN KEY (`servico_idserv`)
    REFERENCES `busca_service`.`servico` (`idserv`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
