-- Povoamento adaptado para schema `nullbank`

INSERT INTO `nullbank`.`agencia` (`nome`, `salario_montante_total`, `cidade`) VALUES
('Agência A', 1000000, 'Cidade A'),
('Agência B', 1200000, 'Cidade B'),
('Agência C', 900000, 'Cidade C');

INSERT INTO `nullbank`.`funcionario` (`matricula`, `nome`, `senha`, `endereco`, `cidade`, `cargo`, `sexo`, `dt_nascimento`, `salario`, `agencia_id`) VALUES
(1, 'João Silva', 'senha123', 'Rua 123', 'Cidade A', 'gerente', 'masculino', '1980-01-15', 8000, 1),
(2, 'Maria Oliveira', 'senha456', 'Avenida XYZ', 'Cidade B', 'atendente', 'feminino', '1995-05-20', 4000, 2),
(3, 'Pedro Santos', 'senha789', 'Rua ABC', 'Cidade C', 'caixa', 'masculino', '1992-08-10', 5000, 3);

INSERT INTO `nullbank`.`dependentes` (`nome`, `dt_nascimento`, `parentesco`, `idade`, `funcionario_matricula`) VALUES
('Filho 1', '2005-02-28', 'filho', 17, 1),
('Esposa 1', '1982-12-10', 'conjuge', 40, 1),
('Filho 2', '2010-07-15', 'filho', 11, 2);

INSERT INTO `nullbank`.`cliente` (`cpf`, `nome`, `RG`, `orgao_emissor`, `UF`) VALUES
('11122233344', 'Carlos Pereira', '123456789', 'SSP', 'SP'),
('22233344455', 'Ana Oliveira', '987654321', 'Detran', 'RJ');

INSERT INTO `nullbank`.`conta` (`numero`, `saldo`, `agencia_id`, `funcionario_matricula`) VALUES
(1001, 0.00, 1, 1),
(2001, 0.00, 2, 2),
(3001, 0.00, 3, 3);

INSERT INTO `nullbank`.`cliente_telefones` (`telefone`, `cliente_cpf`) VALUES
('11112222333', '11122233344'),
('99998888777', '22233344455');

INSERT INTO `nullbank`.`cliente_email` (`email`, `cliente_cpf`) VALUES
('carlos@email.com', '11122233344'),
('ana@email.com', '22233344455');

INSERT INTO `nullbank`.`conta_poupanca` (`taxa_juros`, `conta_numero`) VALUES
(0.03, 1001),
(0.02, 2001);

INSERT INTO `nullbank`.`conta_corrente` (`dt_contrato`, `conta_numero`) VALUES
('2021-01-10', 3001);

INSERT INTO `nullbank`.`conta_especial` (`limite_credito`, `conta_numero`) VALUES
(1000, 1001),
(500, 2001);

INSERT INTO `nullbank`.`endereco` (`cliente_cpf`, `tipo`, `nome`, `numero`, `bairro`, `CEP`, `cidade`, `estado`, `enderecocol`) VALUES
('11122233344', 'Residencial', 'Rua A', '123', 'Centro', '12345-678', 'Cidade A', 'SP', 'Casa'),
('22233344455', 'Comercial', 'Avenida B', '456', 'Centro', '98765-432', 'Cidade B', 'RJ', 'Sala 301');

INSERT INTO `nullbank`.`possui` (`cliente_cpf`, `conta_numero`, `conta_conjunta`, `login`, `senha`) VALUES
('11122233344', 1001, 'N', 'carlos123', 'senha123'),
('22233344455', 2001, 'N', 'ana456', 'senha456');

INSERT INTO `nullbank`.`transacao` (`tipo`, `data_hora`, `valor`, `conta_numero`) VALUES
('saque', '2023-01-15 08:30:00', 50.00, 1001),
('deposito', '2023-01-20 14:45:00', 200.00, 2001),
('transferencia', '2023-02-05 10:00:00', 1000.00, 1001);
