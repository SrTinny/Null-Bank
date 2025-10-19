-- Script reduzido do esquema para nullbank (sem triggers)

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `nullbank` DEFAULT CHARACTER SET utf8 ;
USE `nullbank` ;

-- Table `nullbank`.`agencia`
CREATE TABLE IF NOT EXISTS `nullbank`.`agencia` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `salario_montante_total` DECIMAL NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- Table `nullbank`.`funcionario`
CREATE TABLE IF NOT EXISTS `nullbank`.`funcionario` (
  `matricula` INT NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `endereco` VARCHAR(45) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  `cargo` ENUM('gerente', 'atendente', 'caixa') NOT NULL,
  `sexo` ENUM('masculino', 'feminino') NOT NULL,
  `dt_nascimento` DATE NOT NULL,
  `salario` DECIMAL NOT NULL,
  `agencia_id` INT NOT NULL,
  PRIMARY KEY (`matricula`),
  INDEX `fk_funcionario_agencia1_idx` (`agencia_id` ASC),
  CONSTRAINT `fk_funcionario_agencia1`
    FOREIGN KEY (`agencia_id`)
    REFERENCES `nullbank`.`agencia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- Table `nullbank`.`dependentes`
CREATE TABLE IF NOT EXISTS `nullbank`.`dependentes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `dt_nascimento` DATE NOT NULL,
  `parentesco` ENUM('filho', 'conjuge', 'genitor') NOT NULL,
  `idade` INT NOT NULL,
  `funcionario_matricula` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nome_completo_UNIQUE` (`nome` ASC),
  INDEX `fk_dependentes_funcionario1_idx` (`funcionario_matricula` ASC),
  CONSTRAINT `fk_dependentes_funcionario1`
    FOREIGN KEY (`funcionario_matricula`)
    REFERENCES `nullbank`.`funcionario` (`matricula`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Table `nullbank`.`cliente`
CREATE TABLE IF NOT EXISTS `nullbank`.`cliente` (
  `cpf` VARCHAR(11) NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `RG` VARCHAR(15) NOT NULL,
  `orgao_emissor` VARCHAR(45) NOT NULL,
  `UF` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`cpf`))
ENGINE = InnoDB;

-- Table `nullbank`.`conta`
CREATE TABLE IF NOT EXISTS `nullbank`.`conta` (
  `numero` INT NOT NULL,
  `saldo` DECIMAL NOT NULL,
  `agencia_id` INT NOT NULL,
  `funcionario_matricula` INT NOT NULL,
  PRIMARY KEY (`numero`),
  INDEX `fk_conta_agencia1_idx` (`agencia_id` ASC),
  INDEX `fk_conta_funcionario1_idx` (`funcionario_matricula` ASC),
  CONSTRAINT `fk_conta_agencia1`
    FOREIGN KEY (`agencia_id`)
    REFERENCES `nullbank`.`agencia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_conta_funcionario1`
    FOREIGN KEY (`funcionario_matricula`)
    REFERENCES `nullbank`.`funcionario` (`matricula`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Table `nullbank`.`cliente_telefones`
CREATE TABLE IF NOT EXISTS `nullbank`.`cliente_telefones` (
  `telefone` VARCHAR(11) NOT NULL,
  `cliente_cpf` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`telefone`, `cliente_cpf`),
  INDEX `fk_cliente_telefones_cliente1_idx` (`cliente_cpf` ASC),
  CONSTRAINT `fk_cliente_telefones_cliente1`
    FOREIGN KEY (`cliente_cpf`)
    REFERENCES `nullbank`.`cliente` (`cpf`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Table `nullbank`.`cliente_email`
CREATE TABLE IF NOT EXISTS `nullbank`.`cliente_email` (
  `email` VARCHAR(60) NOT NULL,
  `cliente_cpf` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`email`, `cliente_cpf`),
  INDEX `fk_cliente_email_cliente1_idx` (`cliente_cpf` ASC),
  CONSTRAINT `fk_cliente_email_cliente1`
    FOREIGN KEY (`cliente_cpf`)
    REFERENCES `nullbank`.`cliente` (`cpf`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- Table `nullbank`.`conta_poupanca`
CREATE TABLE IF NOT EXISTS `nullbank`.`conta_poupanca` (
  `taxa_juros` FLOAT NOT NULL,
  `conta_numero` INT NOT NULL,
  PRIMARY KEY (`conta_numero`),
  CONSTRAINT `fk_conta_poupanca_conta1`
    FOREIGN KEY (`conta_numero`)
    REFERENCES `nullbank`.`conta` (`numero`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Table `nullbank`.`conta_corrente`
CREATE TABLE IF NOT EXISTS `nullbank`.`conta_corrente` (
  `dt_contrato` DATE NOT NULL,
  `conta_numero` INT NOT NULL,
  PRIMARY KEY (`conta_numero`),
  CONSTRAINT `fk_conta_corrente_conta1`
    FOREIGN KEY (`conta_numero`)
    REFERENCES `nullbank`.`conta` (`numero`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Table `nullbank`.`conta_especial`
CREATE TABLE IF NOT EXISTS `nullbank`.`conta_especial` (
  `limite_credito` DECIMAL NOT NULL,
  `conta_numero` INT NOT NULL,
  PRIMARY KEY (`conta_numero`),
  CONSTRAINT `fk_conta_especial_conta1`
    FOREIGN KEY (`conta_numero`)
    REFERENCES `nullbank`.`conta` (`numero`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Table `nullbank`.`endereco`
CREATE TABLE IF NOT EXISTS `nullbank`.`endereco` (
  `cliente_cpf` VARCHAR(11) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `numero` VARCHAR(45) NOT NULL,
  `bairro` VARCHAR(45) NOT NULL,
  `CEP` VARCHAR(45) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  `enderecocol` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`cliente_cpf`),
  CONSTRAINT `fk_endereco_cliente1`
    FOREIGN KEY (`cliente_cpf`)
    REFERENCES `nullbank`.`cliente` (`cpf`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Table `nullbank`.`possui`
CREATE TABLE IF NOT EXISTS `nullbank`.`possui` (
  `cliente_cpf` VARCHAR(11) NOT NULL,
  `conta_numero` INT NOT NULL,
  `conta_conjunta` VARCHAR(45) NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`cliente_cpf`, `conta_numero`),
  INDEX `fk_cliente_has_conta_conta1_idx` (`conta_numero` ASC),
  INDEX `fk_cliente_has_conta_cliente1_idx` (`cliente_cpf` ASC),
  CONSTRAINT `fk_cliente_has_conta_cliente1`
    FOREIGN KEY (`cliente_cpf`)
    REFERENCES `nullbank`.`cliente` (`cpf`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_cliente_has_conta_conta1`
    FOREIGN KEY (`conta_numero`)
    REFERENCES `nullbank`.`conta` (`numero`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Table `nullbank`.`transacao`
CREATE TABLE IF NOT EXISTS `nullbank`.`transacao` (
  `numero` INT NOT NULL AUTO_INCREMENT,
  `tipo` ENUM('saque', 'deposito', 'pagamento', 'estorno', 'transferencia') NOT NULL,
  `data_hora` DATETIME NOT NULL,
  `valor` DECIMAL NOT NULL,
  `conta_numero` INT NOT NULL,
  PRIMARY KEY (`numero`),
  INDEX `fk_transacao_conta1_idx` (`conta_numero` ASC),
  CONSTRAINT `fk_transacao_conta1`
    FOREIGN KEY (`conta_numero`)
    REFERENCES `nullbank`.`conta` (`numero`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
