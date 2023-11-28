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
    <link rel="stylesheet" type="text/css" href="../estilos/styles.css">
</head>
<body>
    <div class="container">
        <h2>NullBank!</h2>

        <?php
        // Exibir informações do cliente (substitua com a lógica real)
        echo "<p>Nome: Cliente Exemplo</p>";
        echo "<p>CPF: 123.456.789-00</p>";
        echo "<p>Saldo: R$ 1000.00</p>";
        ?>

        <form action="cliente_actions.php" method="post">
            <label for="operation">Operação:</label>
            <select name="operation" id="operationSelect" required>
                <option value="saque">Saque</option>
                <option value="deposito">Depósito</option>
                <option value="transferencia">Transferência</option>
                <!-- Adicione outras operações conforme necessário -->
            </select>
            <br>
            <label for="valor">Valor:</label>
            <input type="text" name="valor" required>

            <div id="contaDestinoField" style="display:none;">
                <label for="conta_destino">Conta Destino:</label>
                <input type="text" name="conta_destino">
            </div>

            <div id="saqueForm" style="display:none;">
                <!-- Formulário específico para saque (adicione campos conforme necessário) -->
            </div>

            <div id="depositoForm" style="display:none;">
                <!-- Formulário específico para depósito (adicione campos conforme necessário) -->
            </div>

            <div id="transferenciaForm" style="display:none;">
                <!-- Formulário específico para transferência (adicione campos conforme necessário) -->
            </div>

            <input type="submit" value="Executar">
        </form>

        <p><a href="cliente.php">Nova Transação</a> | <a href="logout.php">Logout</a></p>
    </div>

    <script>
        document.getElementById('operationSelect').addEventListener('change', function () {
            var operation = this.value;
            
            // Ocultar todos os formulários
            document.getElementById('saqueForm').style.display = 'none';
            document.getElementById('depositoForm').style.display = 'none';
            document.getElementById('transferenciaForm').style.display = 'none';
            document.getElementById('contaDestinoField').style.display = 'none';

            // Exibir formulário específico com base na operação selecionada
            if (operation === 'saque') {
                document.getElementById('saqueForm').style.display = 'block';
            } else if (operation === 'deposito') {
                document.getElementById('depositoForm').style.display = 'block';
            } else if (operation === 'transferencia') {
                document.getElementById('transferenciaForm').style.display = 'block';
                document.getElementById('contaDestinoField').style.display = 'block';
            }
        });
    </script>
</body>
</html>
