<?php
    session_start();

    // Verifica se o usuário está autenticado
    //include_once("../php/processa_acesso.php");

    include_once("../php/conexao.php");

    $login = $_SESSION["cpf"];
    $conta_numero = $_SESSION['conta_numero'];

    $stmt = $conexao->prepare("SELECT nome FROM cliente WHERE cpf = '$cpf'");
    if($stmt->execute()){
        $retorno_consulta = $stmt->fetch(PDO::FETCH_ASSOC);
        $nome = $retorno_consulta[0]['nome'];
    }

    //pegando saldo da conta pertencente à agência cujo id foi informado na tela de escolher conta
    $stmt = $conexao->prepare("SELECT saldo FROM Contas WHERE num_conta = '$num_conta'");
    if($stmt->execute()){
        $retorno_consulta = $stmt->fetch(PDO::FETCH_ASSOC);
        $saldo = $retorno_consulta[0]['saldo'];
    }   

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
