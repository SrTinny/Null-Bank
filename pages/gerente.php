<?php
session_start();

// Verificar se o usuário está autenticado como gerente
/* if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'gerente') {
    header("Location: index.php");
    exit();
}
 */
// Lógica para gerenciamento de contas aqui
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Gerente</title>
    <link rel="icon" type="image/png" href="../imagens/favicon.png">
    <link rel="stylesheet" type="text/css" href="../estilos/styles.css">
</head>
<body>
    <header class="site-header">
        <div style="display:flex;align-items:center;gap:12px">
            <img src="../imagens/logo.svg" alt="Null-Bank" style="height:28px;">
            <nav class="small" style="margin-left:10px"><a href="index.php">Home</a> · <a href="gerente.php">Gerente</a></nav>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <h2>Sessão Gerente</h2>
            <form action="gerente_actions.php" method="post">
                <div class="form-row">
                    <select class="form-control" name="action" required>
                        <option value="inserir">Inserir Conta</option>
                        <option value="remover">Remover Conta</option>
                        <option value="alterar">Alterar Conta</option>
                    </select>
                </div>
                <div class="form-row">
                    <button class="btn" type="submit">Executar</button>
                </div>
            </form>
            <div class="small"><a href="logout.php">Logout</a></div>
        </div>
    </main>
</body>
</html>
