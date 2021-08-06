-- MySQL Script generated by MySQL Workbench
-- dom 01 ago 2021 18:52:43 -03
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `pessoas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pessoas`;
CREATE TABLE IF NOT EXISTS `pessoas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `endereco` TEXT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

INSERT INTO `pessoas` (`id`, `nome`, `cpf`, `endereco`)
VALUES
 (1, 'Marcelo Ramos', '48349778032', 'Rua Luiz Demo, n 120, Bairro Passagem, Tubarão/SC'),
 (2, 'Renato Silva', '76537136024', 'Rua Alexandre de Sá, n 98, Bairro Dehon, Tubarão/SC'),
 (3, 'Maria Cordeiro', '01054804010', 'Rua Júlio Pozza, n 450, Bairro São João, Tubarão/SC');

-- -----------------------------------------------------
-- Table `contas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `contas`;
CREATE TABLE IF NOT EXISTS `contas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `conta` VARCHAR(50) NULL,
  `saldo` DECIMAL DEFAULT '0',
  `pessoas_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_contas_pessoas_idx` (`pessoas_id` ASC),
  CONSTRAINT `fk_contas_pessoas`
    FOREIGN KEY (`pessoas_id`)
    REFERENCES `pessoas` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `movimentacoes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `movimentacoes`;
CREATE TABLE IF NOT EXISTS `movimentacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `contas_id` INT NOT NULL,
  `valor` VARCHAR(45) NULL,
  `tipo` VARCHAR(45) NULL,
  `datetime` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_movimentacoes_contas1_idx` (`contas_id` ASC),
  CONSTRAINT `fk_movimentacoes_contas1`
    FOREIGN KEY (`contas_id`)
    REFERENCES `contas` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;