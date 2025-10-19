<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="../estilos/styles.css">
</head>

<body>
    <?php
    include_once("../php/conexao.php"); // fornece $conn (mysqli OO)

    // Processar o formulário quando for enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Coletar dados do formulário com fallback
        $cpf = $_POST['cpf'] ?? '';
        $nome = $_POST['nome'] ?? '';
        $rg = $_POST['rg'] ?? '';
        $orgao_emissor = $_POST['orgao_emissor'] ?? '';
        $uf = $_POST['uf'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $tipo = $_POST['tipo'] ?? '';
        $endereco_nome = $_POST['endereco_nome'] ?? '';
        $numero = $_POST['numero'] ?? '';
        $bairro = $_POST['bairro'] ?? '';
        $cep = $_POST['cep'] ?? '';
        $cidade = $_POST['cidade'] ?? '';
        $estado = $_POST['estado'] ?? '';
        $enderecocol = $_POST['enderecocol'] ?? '';
        $email = $_POST['email'] ?? '';

        // Inserções em transação
        try {
            $conn->begin_transaction();

            $stmtCliente = $conn->prepare("INSERT INTO cliente (cpf, nome, RG, orgao_emissor, UF) VALUES (?, ?, ?, ?, ?)");
            $stmtCliente->bind_param('sssss', $cpf, $nome, $rg, $orgao_emissor, $uf);
            $stmtCliente->execute();

            $stmtTel = $conn->prepare("INSERT INTO cliente_telefones (telefone, cliente_cpf) VALUES (?, ?)");
            $stmtTel->bind_param('ss', $telefone, $cpf);
            $stmtTel->execute();

            $stmtEnd = $conn->prepare("INSERT INTO endereco (cliente_cpf, tipo, nome, numero, bairro, CEP, cidade, estado, enderecocol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtEnd->bind_param('ssissssss', $cpf, $tipo, $endereco_nome, $numero, $bairro, $cep, $cidade, $estado, $enderecocol);
            $stmtEnd->execute();

            $stmtEmail = $conn->prepare("INSERT INTO cliente_email (email, cliente_cpf) VALUES (?, ?)");
            $stmtEmail->bind_param('ss', $email, $cpf);
            $stmtEmail->execute();

            $conn->commit();
            $success = true;
        } catch (Exception $e) {
            $conn->rollback();
            $success = false;
            $errorMessage = $e->getMessage();
        }
    }
    ?>
    <div class="container">
        <h2>Cadastro de Cliente</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            CPF: <input type="text" name="cpf" required><br>
            Nome: <input type="text" name="nome" required><br>
            RG: <input type="text" name="rg" required><br>
            Órgão Emissor: <input type="text" name="orgao_emissor" required><br>
            UF: <input type="text" name="uf" required><br>

            <!-- Informações para tabela cliente_telefones -->
            Telefone: <input type="text" name="telefone" required><br>

            <h2>Endereço</h2>
            <!-- Informações para tabela endereco -->
            Tipo: <input type="text" name="tipo" required><br>
            Nome do Endereço: <input type="text" name="endereco_nome" required><br>
            Número: <input type="text" name="numero" required><br>
            Bairro: <input type="text" name="bairro" required><br>
            CEP: <input type="text" name="cep" required><br>
            Cidade: <input type="text" name="cidade" required><br>
            Estado: <input type="text" name="estado" required><br>
            Complemento: <input type="text" name="enderecocol" required><br>

            <!-- Informações para tabela cliente_email -->
            Email: <input type="email" name="email" required><br>

            <input type="submit" value="Cadastrar">
        </form>
    </div>

</body>

</html>