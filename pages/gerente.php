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
    <link rel="stylesheet" type="text/css" href="../estilos/styles.css">
</head>
<body>
    <div class="container">
        <h2>Sessão Gerente!</h2>

        <form action="gerente_actions.php" method="post">
            <label for="action">Ação:</label>
            <select name="action" required>
                <option value="inserir">Inserir Conta</option>
                <option value="remover">Remover Conta</option>
                <option value="alterar">Alterar Conta</option>
            </select>

            <input type="submit" value="Executar">
        </form>

        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
