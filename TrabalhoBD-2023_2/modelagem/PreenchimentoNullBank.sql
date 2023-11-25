-- Insert data into agencia table
INSERT INTO `NullBank`.`agencia` (`nome`, `salario_montante_total`, `cidade`)
VALUES
    ('Agencia1', 1000000, 'City1'),
    ('Agencia2', 800000, 'City2'),
    ('Agencia3', 1200000, 'City3');

-- Insert data into funcionario table
INSERT INTO `NullBank`.`funcionario` (`matricula`, `nome`, `senha`, `endereco`, `cidade`, `cargo`, `sexo`, `dt_nascimento`, `salario`, `agencia_id`)
VALUES
    (1, 'John Doe', 'password1', 'Address1', 'City1', 'gerente', 'masculino', '1990-01-01', 50000, 1),
    (2, 'Jane Smith', 'password2', 'Address2', 'City2', 'atendente', 'feminino', '1995-03-15', 35000, 2),
    (3, 'Bob Johnson', 'password3', 'Address3', 'City3', 'caixa', 'masculino', '1988-07-20', 40000, 1);

-- Insert data into dependentes table
INSERT INTO `NullBank`.`dependentes` (`nome`, `dt_nascimento`, `parentesco`, `idade`, `funcionario_matricula`)
VALUES
    ('Child1', '2005-02-10', 'filho', 17, 1),
    ('Spouse1', '1988-12-05', 'conjuge', 34, 2),
    ('Parent1', '1960-06-25', 'genitor', 61, 3);

-- Insert data into cliente table
INSERT INTO `NullBank`.`cliente` (`cpf`, `nome`, `RG`, `orgao_emissor`, `UF`)
VALUES
    (12345678901, 'Client1', 'ABC123', 'SSP', 'SP'),
    (23456789012, 'Client2', 'XYZ456', 'SSP', 'RJ'),
    (34567890123, 'Client3', 'DEF789', 'SSP', 'MG');

-- Insert data into conta table
INSERT INTO `NullBank`.`conta` (`numero`, `saldo`, `agencia_id`, `funcionario_matricula`)
VALUES
    (1001, 1500.50, 1, 1),
    (1002, 2000.75, 2, 2),
    (1003, 300.25, 3, 3);

-- Insert data into cliente_telefones table
INSERT INTO `NullBank`.`cliente_telefones` (`telefone`, `cliente_cpf`)
VALUES
    (1234567890, 12345678901),
    (9876543210, 23456789012),
    (5555555555, 34567890123);

-- Insert data into cliente_email table
INSERT INTO `NullBank`.`cliente_email` (`email`, `cliente_cpf`)
VALUES
    ('client1@email.com', 12345678901),
    ('client2@email.com', 23456789012),
    ('client3@email.com', 34567890123);

-- Insert data into conta_poupanca table
INSERT INTO `NullBank`.`conta_poupanca` (`taxa_de_juros`, `conta_numero`)
VALUES
    (3, 1001),
    (2, 1002),
    (1, 1003);

-- Insert data into conta_corrente table
INSERT INTO `NullBank`.`conta_corrente` (`dt_contrato`, `conta_numero`)
VALUES
    ('2023-01-15', 1001),
    ('2023-02-20', 1002),
    ('2023-03-10', 1003);

-- Insert data into conta_especial table
INSERT INTO `NullBank`.`conta_especial` (`limite_credito`, `conta_numero`)
VALUES
    (1000, 1001),
    (500, 1002),
    (200, 1003);

-- Insert data into endereco table
INSERT INTO `NullBank`.`endereco` (`cliente_cpf`, `tipo`, `nome`, `numero`, `bairro`, `CEP`, `cidade`, `estado`, `enderecocol`)
VALUES
    (12345678901, 'Residential', 'Home', '123', 'Suburb', '12345-678', 'City1', 'State1', 'Home Address 1'),
    (23456789012, 'Work', 'Office', '456', 'Downtown', '98765-432', 'City2', 'State2', 'Office Address 2'),
    (34567890123, 'Residential', 'House', '789', 'Countryside', '56789-012', 'City3', 'State3', 'Home Address 3');

-- Insert data into possui table
INSERT INTO `NullBank`.`possui` (`cliente_cpf`, `conta_numero`, `conta_conjunta`, `senha`)
VALUES
    (12345678901, 1001, 'Sim', 'senha1'),
    (23456789012, 1002, 'Não', 'senha2'),
    (34567890123, 1003, 'Sim', 'senha3');

-- Insert data into transacao table
INSERT INTO `NullBank`.`transacao` (`numero`, `tipo`, `transacaocol`, `data_hora`, `valor`, `conta_numero`)
VALUES
    (1, 'Debit', 'saque', '2023-11-25 12:30:00', 100.50, 1001),
    (2, 'Credit', 'deposito', '2023-11-25 13:45:00', 500.25, 1002),
    (3, 'Debit', 'transferencia', '2023-11-25 14:20:00', 200.75, 1003);
