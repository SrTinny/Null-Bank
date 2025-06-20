<?php
session_start();

// Verificar se o usuário está autenticado como caixa
/* if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'caixa') {
    header("Location: index.php");
    exit();
} */

// Lógica para operações de caixa aqui
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Caixa</title>
    <link rel="stylesheet" type="text/css" href="../estilos/styles.css">
</head>
<body>
    <div class="container">
        <h2>Caixa NullBank!</h2>

        <form action="caixa_actions.php" method="post">
            <label for="operation">Operação:</label>
            <select name="operation" required>
                <option value="saque">Saque</option>
                <option value="deposito">Depósito</option>
                <option value="transferencia">Transferência</option>
                <!-- Adicione outras operações conforme necessário -->

            </select>
            <br>
            <label for="valor">Valor:</label>
            <input type="text" name="valor" required>

            <input type="submit" value="Executar">
        </form>

        <p><a href="../php/logout.php">Logout</a></p>
    </div>
</body>
</html>
