<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="../imagens/favicon.png">
    <link rel="stylesheet" type="text/css" href="../estilos/styles.css">
</head>

<body>
    <header class="site-header">
        <div style="display:flex;align-items:center;gap:12px">
            <img src="../imagens/logo.svg" alt="Null-Bank" style="height:28px;">
            <nav class="small" style="margin-left:10px"><a href="index.php">Home</a> · <a href="cadastro.php">Cadastro</a></nav>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <h2>Entrar</h2>
            <form action="../php/login.php" method="post">
                <div class="form-row">
                    <input class="form-control" type="text" name="matricula_cpf" placeholder="Matrícula ou CPF" required>
                </div>
                <div class="form-row">
                    <input class="form-control" type="password" name="senha" placeholder="Senha" required>
                </div>
                <div class="form-row">
                    <button class="btn" type="submit">Entrar</button>
                </div>
            </form>
            <div class="small">Não tem conta? <a href="cadastro.php">Cadastre-se</a></div>
        </div>
    </main>
</body>

</html>