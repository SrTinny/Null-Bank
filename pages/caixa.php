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
    <link rel="icon" type="image/png" href="../imagens/favicon.png">
    <link rel="stylesheet" type="text/css" href="../estilos/styles.css">
</head>
<body>
    <header class="site-header">
        <div style="display:flex;align-items:center;gap:12px">
            <img src="../imagens/logo.svg" alt="Null-Bank" style="height:28px;">
            <nav class="small" style="margin-left:10px"><a href="index.php">Home</a> · <a href="caixa.php">Caixa</a></nav>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <h2>Operações de Caixa</h2>
            <form action="caixa_actions.php" method="post">
                <div class="form-row">
                    <select class="form-control" name="operation" required>
                        <option value="saque">Saque</option>
                        <option value="deposito">Depósito</option>
                        <option value="transferencia">Transferência</option>
                    </select>
                </div>
                <div class="form-row"><input class="form-control" type="text" name="valor" placeholder="Valor" required></div>
                <div class="form-row"><button class="btn" type="submit">Executar</button></div>
            </form>
            <div class="small"><a href="../php/logout.php">Logout</a></div>
        </div>
    </main>
</body>
</html>
