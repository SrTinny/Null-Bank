-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema TrabalhoBD-2023_2
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema TrabalhoBD-2023_2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `TrabalhoBD-2023_2-416855` DEFAULT CHARACTER SET utf8 ;
USE `TrabalhoBD-2023_2-416855` ;

-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`agencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`agencia` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `salario_montante_total` DECIMAL NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`funcionario` (
  `matricula` INT NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
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
    REFERENCES `TrabalhoBD-2023_2-416855`.`agencia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`dependentes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`dependentes` (
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
    REFERENCES `TrabalhoBD-2023_2`.`funcionario` (`matricula`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2-416855`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`cliente` (
  `cpf` VARCHAR(11) NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `RG` VARCHAR(15) NOT NULL,
  `orgao_emissor` VARCHAR(45) NOT NULL,
  `UF` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`cpf`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`conta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`conta` (
  `numero` INT NOT NULL,
  `saldo` DECIMAL NOT NULL,
  `agencia_id` INT NOT NULL,
  `funcionario_matricula` INT NOT NULL,
  PRIMARY KEY (`numero`),
  INDEX `fk_conta_agencia1_idx` (`agencia_id` ASC),
  INDEX `fk_conta_funcionario1_idx` (`funcionario_matricula` ASC),
  CONSTRAINT `fk_conta_agencia1`
    FOREIGN KEY (`agencia_id`)
    REFERENCES `TrabalhoBD-2023_2-416855`.`agencia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_conta_funcionario1`
    FOREIGN KEY (`funcionario_matricula`)
    REFERENCES `TrabalhoBD-2023_2-416855`.`funcionario` (`matricula`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`cliente_telefones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`cliente_telefones` (
  `telefone` VARCHAR(11) NOT NULL,
  `cliente_cpf` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`telefone`, `cliente_cpf`),
  INDEX `fk_cliente_telefones_cliente1_idx` (`cliente_cpf` ASC),
  CONSTRAINT `fk_cliente_telefones_cliente1`
    FOREIGN KEY (`cliente_cpf`)
    REFERENCES `TrabalhoBD-2023_2-416855`.`cliente` (`cpf`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`cliente_email`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`cliente_email` (
  `email` VARCHAR(60) NOT NULL,
  `cliente_cpf` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`email`, `cliente_cpf`),
  INDEX `fk_cliente_email_cliente1_idx` (`cliente_cpf` ASC),
  CONSTRAINT `fk_cliente_email_cliente1`
    FOREIGN KEY (`cliente_cpf`)
    REFERENCES `TrabalhoBD-2023_2-416855`.`cliente` (`cpf`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`conta_poupanca`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`conta_poupanca` (
  `taxa de juros` FLOAT NOT NULL,
  `conta_numero` INT NOT NULL,
  PRIMARY KEY (`conta_numero`),
  CONSTRAINT `fk_conta_poupanca_conta1`
    FOREIGN KEY (`conta_numero`)
    REFERENCES `TrabalhoBD-2023_2-416855`.`conta` (`numero`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`conta_corrente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`conta_corrente` (
  `dt_contrato` DATE NOT NULL,
  `conta_numero` INT NOT NULL,
  PRIMARY KEY (`conta_numero`),
  CONSTRAINT `fk_conta_corrente_conta1`
    FOREIGN KEY (`conta_numero`)
    REFERENCES `TrabalhoBD-2023_2-416855`.`conta` (`numero`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`conta_especial`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`conta_especial` (
  `limite_credito` DECIMAL NOT NULL,
  `conta_numero` INT NOT NULL,
  PRIMARY KEY (`conta_numero`),
  CONSTRAINT `fk_conta_especial_conta1`
    FOREIGN KEY (`conta_numero`)
    REFERENCES `TrabalhoBD-2023_2-416855`.`conta` (`numero`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`endereco` (
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
    REFERENCES `TrabalhoBD-2023_2-416855`.`cliente` (`cpf`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`possui`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`possui` (
  `cliente_cpf` VARCHAR(11) NOT NULL,
  `conta_numero` INT NOT NULL,
  `conta_conjunta` VARCHAR(45) NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`cliente_cpf`, `conta_numero`),
  INDEX `fk_cliente_has_conta_conta1_idx` (`conta_numero` ASC),
  INDEX `fk_cliente_has_conta_cliente1_idx` (`cliente_cpf` ASC),
  CONSTRAINT `fk_cliente_has_conta_cliente1`
    FOREIGN KEY (`cliente_cpf`)
    REFERENCES `TrabalhoBD-2023_2-416855`.`cliente` (`cpf`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_cliente_has_conta_conta1`
    FOREIGN KEY (`conta_numero`)
    REFERENCES `TrabalhoBD-2023_2-416855`.`conta` (`numero`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TrabalhoBD-2023_2`.`transacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrabalhoBD-2023_2-416855`.`transacao` (
  `numero` INT NOT NULL AUTO_INCREMENT,
  `tipo` ENUM('saque', 'deposito', 'pagamento', 'estorno', 'transferencia') NOT NULL,
  `data_hora` DATETIME NOT NULL,
  `valor` DECIMAL NOT NULL,
  `conta_numero` INT NOT NULL,
  PRIMARY KEY (`numero`),
  INDEX `fk_transacao_conta1_idx` (`conta_numero` ASC),
  CONSTRAINT `fk_transacao_conta1`
    FOREIGN KEY (`conta_numero`)
    REFERENCES `TrabalhoBD-2023_2-416855`.`conta` (`numero`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Triggers
-- -----------------------------------------------------

-- Trigger que calcula a idade com base na data de nascimento
DELIMITER //

CREATE TRIGGER calcular_idade_dependente
BEFORE INSERT ON `TrabalhoBD-2023_2-416855`.`dependentes`
FOR EACH ROW
BEGIN
    SET NEW.idade = TIMESTAMPDIFF(YEAR, NEW.dt_nascimento, CURDATE());
END;
//

DELIMITER ;

-- Trigger que garante que o salario minimo dos funcionarios seja no minimo de 2500
DELIMITER //

CREATE TRIGGER garantir_salario_minimo
BEFORE INSERT ON `TrabalhoBD-2023_2-416855`.`funcionario`
FOR EACH ROW
BEGIN
    IF NEW.salario < 2500.00 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Salário do funcionário deve ser no mínimo 2500.00';
    END IF;
END;
//

DELIMITER ;

-- Trigger responsável por garantir que o saldo inicial de uma conta seja 0.00
DELIMITER //

CREATE TRIGGER garantir_saldo_inicial
BEFORE INSERT ON `TrabalhoBD-2023_2-416855`.`conta`
FOR EACH ROW
BEGIN
    -- Garantir que o saldo inicial seja 0.00
    IF NEW.saldo <> 0.00 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'O saldo inicial da conta deve ser 0.00';
    END IF;
END;
//

DELIMITER ;

-- Trigger responsável por atualizar o saldo das contas a cada transação
DROP TRIGGER IF EXISTS `TrabalhoBD-2023_2-416855`.`tr_atualizar_saldo`;

DELIMITER $$
USE `TrabalhoBD-2023_2-416855`$$
CREATE DEFINER = CURRENT_USER TRIGGER `TrabalhoBD-2023_2-416855`.`tr_atualizar_saldo` AFTER INSERT ON `transacao` FOR EACH ROW
BEGIN
    DECLARE novo_saldo DECIMAL(10, 2);

    -- Verificar o tipo de transação e atualizar o saldo da conta
    CASE NEW.tipo
        WHEN 'saque' THEN
            SET novo_saldo = (SELECT saldo - NEW.valor FROM `conta` WHERE numero = NEW.conta_numero);
        WHEN 'deposito' THEN
            SET novo_saldo = (SELECT saldo + NEW.valor FROM `conta` WHERE numero = NEW.conta_numero);
        WHEN 'pagamento' THEN
            SET novo_saldo = (SELECT saldo - NEW.valor FROM `conta` WHERE numero = NEW.conta_numero);
        WHEN 'estorno' THEN
            SET novo_saldo = (SELECT saldo + NEW.valor FROM `conta` WHERE numero = NEW.conta_numero);
        WHEN 'transferencia' THEN
            -- Atualizar o saldo das duas contas envolvidas na transferência
            SET novo_saldo = (SELECT saldo - NEW.valor FROM `conta` WHERE numero = NEW.conta_numero);
            UPDATE `conta` SET saldo = (SELECT saldo + NEW.valor FROM `conta` WHERE numero = NEW.conta_destino) WHERE numero = NEW.conta_destino;
    END CASE;

    -- Atualizar o saldo na conta associada à transação
    UPDATE `conta` SET saldo = novo_saldo WHERE numero = NEW.conta_numero;
END$$
DELIMITER ;

-- Trigger responsável por atualizar o salário montante total após uma inserção de funcionário
DROP TRIGGER IF EXISTS `TrabalhoBD-2023_2-416855`.`tr_atualizar_salario_montante`;

DELIMITER $$
USE `TrabalhoBD-2023_2-416855`$$
CREATE DEFINER = CURRENT_USER TRIGGER `TrabalhoBD-2023_2-416855`.`tr_atualizar_salario_montante` AFTER INSERT ON `funcionario` FOR EACH ROW
BEGIN
    DECLARE novo_salario_montante DECIMAL(10, 2);

    -- Calcular o novo salario_montante_total
    SET novo_salario_montante = (SELECT SUM(salario) FROM `funcionario` WHERE agencia_id = NEW.agencia_id);

    -- Atualizar o salario_montante_total na agencia
    UPDATE `agencia` SET salario_montante_total = novo_salario_montante WHERE id = NEW.agencia_id;
END$$
DELIMITER ;

-- Trigger responsável por atualizar o salário montante total após uma remoção de funcionário
DROP TRIGGER IF EXISTS `TrabalhoBD-2023_2-416855`.`tr_atualizar_salario_montante_delete`;

DELIMITER $$
USE `TrabalhoBD-2023_2-416855`$$
CREATE DEFINER = CURRENT_USER TRIGGER `TrabalhoBD-2023_2-416855`.`tr_atualizar_salario_montante_delete` AFTER DELETE ON `funcionario` FOR EACH ROW
BEGIN
    DECLARE novo_salario_montante DECIMAL(10, 2);

    -- Calcular o novo salario_montante_total
    SET novo_salario_montante = (SELECT SUM(salario) FROM `funcionario` WHERE agencia_id = OLD.agencia_id);

    -- Atualizar o salario_montante_total na agencia
    UPDATE `agencia` SET salario_montante_total = COALESCE(novo_salario_montante, 0.00) WHERE id = OLD.agencia_id;
END$$
DELIMITER ;

-- Trigger responsável por atualizar o salário montante total após uma atualização de funcionário
DROP TRIGGER IF EXISTS `TrabalhoBD-2023_2-416855`.`tr_atualizar_salario_montante_update`;

DELIMITER $$
USE `TrabalhoBD-2023_2-416855`$$
CREATE DEFINER = CURRENT_USER TRIGGER `TrabalhoBD-2023_2-416855`.`tr_atualizar_salario_montante_update` AFTER UPDATE ON `funcionario` FOR EACH ROW
BEGIN
    DECLARE novo_salario_montante DECIMAL(10, 2);

    -- Calcular o novo salario_montante_total
    SET novo_salario_montante = (SELECT SUM(salario) FROM `funcionario` WHERE agencia_id = NEW.agencia_id);

    -- Atualizar o salario_montante_total na agencia
    UPDATE `agencia` SET salario_montante_total = COALESCE(novo_salario_montante, 0.00) WHERE id = NEW.agencia_id;
END$$
DELIMITER ;

-- Trigger responsável por garantir que o salário montante total inicial de uma agência seja 0.00
DROP TRIGGER IF EXISTS `TrabalhoBD-2023_2-416855`.`tr_salario_montante_total_inicial`;

DELIMITER $$
USE `TrabalhoBD-2023_2-416855`$$
CREATE DEFINER = CURRENT_USER TRIGGER `TrabalhoBD-2023_2-416855`.`tr_salario_montante_total_inicial` BEFORE INSERT ON `agencia` FOR EACH ROW
BEGIN
    -- Garantir que o salario_montante_total seja 0.00
    SET NEW.salario_montante_total = 0.00;
END$$
DELIMITER ;

-- Trigger responsável por preencher a tabela conta_corrente
DROP TRIGGER IF EXISTS `TrabalhoBD-2023_2-416855`.`tr_preencher_conta_corrente`;

DELIMITER $$
USE `TrabalhoBD-2023_2-416855`$$
CREATE DEFINER = CURRENT_USER TRIGGER `TrabalhoBD-2023_2-416855`.`tr_preencher_conta_corrente` AFTER INSERT ON `conta` FOR EACH ROW
BEGIN
    -- Verificar se a nova conta é do tipo conta_corrente
    IF NEW.tipo_conta = 'corrente' THEN
        INSERT INTO `conta_corrente` (dt_contrato, conta_numero) VALUES (CURDATE(), NEW.numero);
    END IF;
END$$
DELIMITER ;

-- Trigger responsável por limitar o número de dependentes por funcionário
DROP TRIGGER IF EXISTS `TrabalhoBD-2023_2-416855`.`tr_limitar_dependentes`;

DELIMITER $$
USE `TrabalhoBD-2023_2-416855`$$
CREATE DEFINER = CURRENT_USER TRIGGER `TrabalhoBD-2023_2-416855`.`tr_limitar_dependentes` BEFORE INSERT ON `dependentes` FOR EACH ROW
BEGIN
    DECLARE num_dependentes INT;

    -- Contar o número atual de dependentes do funcionário
    SET num_dependentes = (SELECT COUNT(*) FROM `dependentes` WHERE funcionario_matricula = NEW.funcionario_matricula);

    -- Limitar o número de dependentes por funcionário (por exemplo, 5)
    IF num_dependentes >= 5 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Limite de dependentes atingido para este funcionário (limite: 5).';
    END IF;
END$$
DELIMITER ;

-- Trigger responsável por setar o limite de crédito inicial de uma conta especial como R$ 2000,00
DROP TRIGGER IF EXISTS `TrabalhoBD-2023_2-416855`.`tr_setar_limite_credito_inicial`;

DELIMITER $$
USE `TrabalhoBD-2023_2-416855`$$
CREATE DEFINER = CURRENT_USER TRIGGER `TrabalhoBD-2023_2-416855`.`tr_setar_limite_credito_inicial` BEFORE INSERT ON `conta_especial` FOR EACH ROW
BEGIN
    -- Setar o limite de crédito inicial como R$ 2000,00
    SET NEW.limite_credito = 2000.00;
END$$
DELIMITER ;

-- Trigger responsável por setar a taxa de juros de uma conta poupança como sendo 2% ao mês
DROP TRIGGER IF EXISTS `TrabalhoBD-2023_2-416855`.`tr_setar_taxa_juros_inicial`;

DELIMITER $$
USE `TrabalhoBD-2023_2-416855`$$
CREATE DEFINER = CURRENT_USER TRIGGER `TrabalhoBD-2023_2-416855`.`tr_setar_taxa_juros_inicial` BEFORE INSERT ON `conta_poupanca` FOR EACH ROW
BEGIN
    -- Setar a taxa de juros inicial como 2% ao mês
    SET NEW.taxa_juros = 0.02;
END$$
DELIMITER ;

/* -- Trigger responsável por limitar um gerente por agência
DROP TRIGGER IF EXISTS `TrabalhoBD-2023_2-416855`.`tr_limitar_gerente_por_agencia`;

DELIMITER $$
USE `TrabalhoBD-2023_2-416855`$$
CREATE DEFINER = CURRENT_USER TRIGGER `TrabalhoBD-2023_2-416855`.`tr_limitar_gerente_por_agencia` BEFORE INSERT ON `funcionario` FOR EACH ROW
BEGIN
    DECLARE num_gerentes INT;

    -- Contar o número de gerentes associados à agência
    SET num_gerentes = (SELECT COUNT(*) FROM `funcionario` WHERE agencia_id = NEW.agencia_id AND cargo = 'gerente');

    -- Limitar um gerente por agência
    IF NEW.cargo = 'gerente' AND num_gerentes >= 1 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Já existe um gerente associado a esta agência.';
    END IF;
END$$ */


DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
