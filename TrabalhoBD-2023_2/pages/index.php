<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../estilos/styles.css">
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="../php/processa_login.php">
            Nome de Usuário, Email ou CPF: <input type="text" name="username" required><br>
            Senha: <input type="password" name="password" required><br>
            <input type="submit" value="Entrar">
        </form>

        <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
    </div>
</body>

</html>
