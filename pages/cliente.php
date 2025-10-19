<?php
session_start();

// Verificar se o usuário está autenticado como cliente
/* if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'cliente') {
    header("Location: index.php");
    exit();
} */

// Lógica para informações do cliente e operações aqui
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Cliente</title>
    <link rel="icon" type="image/png" href="../imagens/favicon.png">
    <link rel="stylesheet" type="text/css" href="../estilos/styles.css">
</head>
<body>
    <header class="site-header">
        <div style="display:flex;align-items:center;gap:12px">
            <img src="../imagens/logo.svg" alt="Null-Bank" style="height:28px;">
            <nav class="small" style="margin-left:10px"><a href="index.php">Home</a> · <a href="cliente.php">Minha Conta</a></nav>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <h2>Minha Conta</h2>
            <?php
            // Exibir informações do cliente (substitua com a lógica real)
            echo "<p class='small'>Nome: <strong>Cliente Exemplo</strong></p>";
            echo "<p class='small'>CPF: <strong>123.456.789-00</strong></p>";
            echo "<p class='small'>Saldo: <strong>R$ 1000.00</strong></p>";
            ?>

            <form action="cliente_actions.php" method="post">
                <div class="form-row">
                    <select class="form-control" name="operation" id="operationSelect" required>
                        <option value="saque">Saque</option>
                        <option value="deposito">Depósito</option>
                        <option value="transferencia">Transferência</option>
                    </select>
                </div>
                <div class="form-row"><input class="form-control" type="text" name="valor" placeholder="Valor" required></div>

                <div id="contaDestinoField" style="display:none;" class="form-row">
                    <input class="form-control" type="text" name="conta_destino" placeholder="Conta destino">
                </div>

                <div class="form-row"><button class="btn" type="submit">Executar</button></div>
            </form>

            <div class="small"><a href="cliente.php">Nova Transação</a> | <a href="../php/logout.php">Logout</a></div>
        </div>
    </main>

</body>
</html>
</body>
</html>
