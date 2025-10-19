<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link rel="icon" type="image/png" href="../imagens/favicon.png">
    <link rel="stylesheet" href="../estilos/styles.css">
</head>

<body>
    <?php
    include_once("../php/conexao.php"); // fornece $conn (mysqli OO)
    // Ligar relatório de erros do mysqli para lançar exceções em falhas de query
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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
            $inTransaction = true;

            // Normalizar e validar CPF: manter apenas dígitos e checar tamanho
            $cpf = preg_replace('/\D+/', '', $cpf);
            if (strlen($cpf) !== 11) {
                $success = false;
                $errorMessage = 'CPF inválido: deve conter 11 dígitos numéricos.';
                // não prosseguir com inserções
                $inTransaction = false;
                goto render_form;
            }

            // Verificar se cliente já existe
            $chk = $conn->prepare("SELECT COUNT(*) FROM cliente WHERE cpf = ?");
            $chk->bind_param('s', $cpf);
            $chk->execute();
            $chk->bind_result($existingCount);
            $chk->fetch();
            $chk->close();
            if (!empty($existingCount)) {
                $success = false;
                $errorMessage = 'Cliente já cadastrado com esse CPF.';
                $inTransaction = false;
                goto render_form;
            }

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
        } catch (mysqli_sql_exception $e) {
            // Garantir rollback e registrar erro para depuração
            if (!empty($inTransaction)) {
                $conn->rollback();
            }
            $success = false;
            $errorMessage = $e->getMessage();
            error_log("[cadastro.php] Erro ao inserir cliente: " . $errorMessage);
        }
        render_form:
    }
    ?>
    <header class="site-header">
        <div style="display:flex;align-items:center;gap:12px">
            <img src="../imagens/logo.svg" alt="Null-Bank" style="height:28px;">
            <nav class="small" style="margin-left:10px"><a href="index.php">Home</a> · <a href="cadastro.php">Cadastro</a></nav>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <h2>Cadastro de Cliente</h2>
            <?php if (isset($success) && $success === true): ?>
                <div class="message success">Cadastro realizado com sucesso.</div>
            <?php elseif (isset($success) && $success === false): ?>
                <div class="message error">Erro ao cadastrar cliente: <?php echo htmlspecialchars($errorMessage ?? 'erro desconhecido'); ?></div>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-row"><input class="form-control" type="text" name="cpf" placeholder="CPF (11 dígitos)" required></div>
                <div class="form-row"><input class="form-control" type="text" name="nome" placeholder="Nome completo" required></div>
                <div class="form-row"><input class="form-control" type="text" name="rg" placeholder="RG" required></div>
                <div class="form-row"><input class="form-control" type="text" name="orgao_emissor" placeholder="Órgão Emissor" required></div>
                <div class="form-row"><input class="form-control" type="text" name="uf" placeholder="UF" required></div>

                <div class="form-row"><input class="form-control" type="text" name="telefone" placeholder="Telefone" required></div>

                <h2 style="margin-top:18px">Endereço</h2>
                <div class="form-row row">
                    <input class="form-control" type="text" name="tipo" placeholder="Tipo (Residencial/Comercial)" required>
                    <input class="form-control" type="text" name="numero" placeholder="Número" required>
                </div>
                <div class="form-row"><input class="form-control" type="text" name="endereco_nome" placeholder="Nome do Endereço" required></div>
                <div class="form-row"><input class="form-control" type="text" name="bairro" placeholder="Bairro" required></div>
                <div class="form-row row">
                    <input class="form-control" type="text" name="cep" placeholder="CEP" required>
                    <input class="form-control" type="text" name="cidade" placeholder="Cidade" required>
                </div>
                <div class="form-row row">
                    <input class="form-control" type="text" name="estado" placeholder="Estado" required>
                    <input class="form-control" type="text" name="enderecocol" placeholder="Complemento">
                </div>

                <div class="form-row"><input class="form-control" type="email" name="email" placeholder="Email" required></div>

                <div class="form-row"><button class="btn" type="submit">Cadastrar</button></div>
            </form>
        </div>
    </main>

</body>

</html>