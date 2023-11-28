<?php
    session_start();

    // Verifica se o usuário está autenticado


    include_once("../php/conexao.php");

    // Simulando informações do cliente (substitua isso pelos dados reais do seu banco de dados)
    $nomeCliente = "nome";
    $cpfCliente = $_SESSION['login_usuario']; // Supondo que o CPF seja armazenado na sessão
    $saldoCliente = 1000.00; // Substitua isso pelo saldo real do cliente

    // Lógica para realizar as transações (saque, transferência, depósito, estorno) vai aqui

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Cliente</title>
    <link rel="stylesheet" href="estilos/estilo.css">
</head>
<body>
    <header>
        <h1>Bem-vindo, <?php echo $nomeCliente; ?></h1>
    </header>

    <section id="informacoes-cliente">
        <h2>Informações do Cliente</h2>
        <p>CPF: <?php echo $cpfCliente; ?></p>
        <p>Saldo: R$ <?php echo number_format($saldoCliente, 2, ',', '.'); ?></p>
    </section>

    <section id="transacoes">
        <h2>Realizar Transações</h2>

        <form action="processa_transacao.php" method="post">
            <label for="tipo_transacao">Selecione o tipo de transação:</label>
            <select name="tipo_transacao" id="tipo_transacao" required>
                <option value="saque">Saque</option>
                <option value="transferencia">Transferência</option>
                <option value="deposito">Depósito</option>
                <option value="estorno">Estorno</option>
            </select>

            <label for="valor_transacao">Informe o valor da transação:</label>
            <input type="number" name="valor_transacao" id="valor_transacao" step="0.01" required>

            <button type="submit">Realizar Transação</button>
        </form>
    </section>

    <footer>
        <a href="logout.php">Sair</a>
    </footer>
</body>
</html>
