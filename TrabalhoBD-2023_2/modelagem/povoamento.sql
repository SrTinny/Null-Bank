-- Insert data into agencia table
INSERT INTO
    `TrabalhoBD-2023_2`.`agencia` (`nome`, `salario_montante_total`, `cidade`)
VALUES
    ('Agencia A', 1000000.00, 'Cidade A'),
    ('Agencia B', 800000.00, 'Cidade B'),
    ('Agencia C', 1200000.00, 'Cidade C');

-- Insert data into funcionario table
INSERT INTO
    `TrabalhoBD-2023_2`.`funcionario` (
        `matricula`,
        `nome`,
        `senha`,
        `endereco`,
        `cidade`,
        `cargo`,
        `sexo`,
        `dt_nascimento`,
        `salario`,
        `agencia_id`
    )
VALUES
    (
        1,
        'Funcionario 1',
        'senha1',
        'Endereco 1',
        'Cidade A',
        'gerente',
        'masculino',
        '1990-01-01',
        5000.00,
        1
    ),
    (
        2,
        'Funcionario 2',
        'senha2',
        'Endereco 2',
        'Cidade B',
        'atendente',
        'feminino',
        '1995-02-15',
        3000.00,
        2
    ),
    (
        3,
        'Funcionario 3',
        'senha3',
        'Endereco 3',
        'Cidade C',
        'caixa',
        'masculino',
        '1988-08-20',
        2500.00,
        3
    );

-- Insert data into dependentes table
INSERT INTO
    `TrabalhoBD-2023_2`.`dependentes` (
        `nome`,
        `dt_nascimento`,
        `parentesco`,
        `idade`,
        `funcionario_matricula`
    )
VALUES
    ('Dependente 1', '2000-05-10', 'filho', NULL, 1),
    ('Dependente 2', '1998-11-25', 'conjuge', NULL, 2),
    ('Dependente 3', '1975-03-03', 'genitor', NULL, 3);

-- Insert data into cliente table
INSERT INTO
    `TrabalhoBD-2023_2`.`cliente` (`cpf`, `nome`, `RG`, `orgao_emissor`, `UF`)
VALUES
    (12345678901, 'Cliente 1', '123ABC', 'SSP', 'SP'),
    (98765432109, 'Cliente 2', '456DEF', 'SSP', 'RJ'),
    (11122233344, 'Cliente 3', '789GHI', 'SSP', 'MG');

-- Insert data into conta table
INSERT INTO
    `TrabalhoBD-2023_2`.`conta` (
        `numero`,
        `saldo`,
        `agencia_id`,
        `funcionario_matricula`
    )
VALUES
    (1001, 5000.00, 1, 1),
    (2002, 3000.00, 2, 2),
    (3003, 1500.00, 3, 3);

-- Insert data into cliente_telefones table
INSERT INTO
    `TrabalhoBD-2023_2`.`cliente_telefones` (`telefone`, `cliente_cpf`)
VALUES
    (1122334455, 12345678901),
    (9988776655, 98765432109),
    (5544332211, 11122233344);

-- Insert data into cliente_email table
INSERT INTO
    `TrabalhoBD-2023_2`.`cliente_email` (`email`, `cliente_cpf`)
VALUES
    ('cliente1@email.com', 12345678901),
    ('cliente2@email.com', 98765432109),
    ('cliente3@email.com', 11122233344);

-- Insert data into conta_poupanca table
INSERT INTO
    `TrabalhoBD-2023_2`.`conta_poupanca` (`taxa de juros`, `conta_numero`)
VALUES
    (5, 1001),
    (4, 2002),
    (6, 3003);

-- Insert data into conta_corrente table
INSERT INTO
    `TrabalhoBD-2023_2`.`conta_corrente` (`dt_contrato`, `conta_numero`)
VALUES
    ('2022-01-01', 1001),
    ('2021-10-15', 2002),
    ('2023-03-20', 3003);

-- Insert data into conta_especial table
INSERT INTO
    `TrabalhoBD-2023_2`.`conta_especial` (`limite_credito`, `conta_numero`)
VALUES
    (2000.00, 1001),
    (1000.00, 2002),
    (3000.00, 3003);

-- Insert data into endereco table
INSERT INTO
    `TrabalhoBD-2023_2`.`endereco` (
        `cliente_cpf`,
        `tipo`,
        `nome`,
        `numero`,
        `bairro`,
        `CEP`,
        `cidade`,
        `estado`,
        `enderecocol`
    )
VALUES
    (
        12345678901,
        'residencial',
        'Rua A',
        '123',
        'Bairro 1',
        '12345-678',
        'Cidade A',
        'SP',
        'Endereco Completo 1'
    ),
    (
        98765432109,
        'comercial',
        'Avenida B',
        '456',
        'Bairro 2',
        '98765-432',
        'Cidade B',
        'RJ',
        'Endereco Completo 2'
    ),
    (
        11122233344,
        'residencial',
        'Rua C',
        '789',
        'Bairro 3',
        '11111-222',
        'Cidade C',
        'MG',
        'Endereco Completo 3'
    );

-- Insert data into possui table
INSERT INTO
    `TrabalhoBD-2023_2`.`possui` (
        `cliente_cpf`,
        `conta_numero`,
        `conta_conjunta`,
        `senha`
    )
VALUES
    (12345678901, 1001, 'sim', 'senha_cliente1'),
    (98765432109, 2002, 'nao', 'senha_cliente2'),
    (11122233344, 3003, 'sim', 'senha_cliente3');

-- Insert data into transacao table
INSERT INTO
    `TrabalhoBD-2023_2`.`transacao` (
        `numero`,
        `tipo`,
        `transacaocol`,
        `data_hora`,
        `valor`,
        `conta_numero`
    )
VALUES
    (
        1,
        'saque',
        'saque',
        '2023-01-10 08:30:00',
        100.00,
        1001
    ),
    (
        2,
        'deposito',
        'deposito',
        '2023-01-15 12:45:00',
        200.00,
        2002
    ),
    (
        3,
        'transferencia',
        'transferencia',
        '2023-02-01 15:20:00',
        50.00,
        3003
    ),
    (
        4,
        'pagamento',
        'pagamento',
        '2023-02-10 10:00:00',
        30.00,
        1001
    ),
    (
        5,
        'estorno',
        'estorno',
        '2023-02-20 14:30:00',
        20.00,
        2002
    );