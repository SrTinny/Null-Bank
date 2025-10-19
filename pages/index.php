<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../estilos/styles.css">
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form action="../php/login.php" method="post">
            <label for="matricula_cpf">Matrícula/CPF:</label>
            <input type="text" name="matricula_cpf" required><br>

            <label for="senha">Senha:</label> <br>
            <input type="password" name="senha" required><br>

            <input type="submit" value="Entrar">
        </form>
        <br>
        <a href="cadastro.php">Cadastre-se</a>
    </div>
</body>

</html>