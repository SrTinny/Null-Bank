<?php
session_start();

// Autenticação comentada por enquanto — mantenha se desejar ativar
// if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'cliente') {
//     header("Location: index.php");
//     exit();
// }

// Tentar buscar dados do cliente pela sessão (espera-se que exista 'user_cpf')
$clienteNome = 'Cliente Exemplo';
$clienteCpf = '12345678900';
$clienteSaldo = 'R$ 0,00';

if (isset($_SESSION['user_cpf'])) {
    $clienteCpf = preg_replace('/\D/', '', $_SESSION['user_cpf']);
    // incluir conexão e buscar nome/saldo se disponível
    try {
        require_once __DIR__ . '/../php/conexao.php';
        $stmt = $conn->prepare('SELECT c.nome, co.numero AS conta_numero, co.saldo FROM cliente c LEFT JOIN possui p ON p.cliente_cpf = c.cpf LEFT JOIN conta co ON co.numero = p.conta_numero WHERE c.cpf = ? LIMIT 1');
        $stmt->bind_param('s', $clienteCpf);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $clienteNome = $row['nome'] ?? $clienteNome;
            if (!empty($row['conta_numero'])) {
                $contaNumero = $row['conta_numero'];
                $clienteSaldo = 'R$ ' . number_format((float)$row['saldo'], 2, ',', '.');
            }
        }
        $stmt->close();
    } catch (Exception $e) {
        // manter valores padrão em caso de erro
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta — Null-Bank</title>
    <link rel="icon" type="image/svg+xml" href="../imagens/favicon.svg">
    <link rel="stylesheet" type="text/css" href="../estilos/styles.css">
    <script>
    // Mostrar/ocultar campo conta destino
    function onOperationChange(v){
        var el = document.getElementById('contaDestinoField');
        el.style.display = (v === 'transferencia') ? 'block' : 'none';
    }
    </script>
</head>
<body>
    <header class="nb-header">
        <div class="container nb-header-inner">
            <a class="nb-brand" href="index.php">
                <img src="../imagens/logo.svg" alt="Null-Bank" class="nb-logo" height="28">
                <span class="nb-title">Null-Bank</span>
            </a>
            <nav class="nb-nav">
                <a href="index.php">Início</a>
                <a href="cadastro.php">Cadastrar</a>
                <a href="cliente.php">Minha Conta</a>
                <a href="gerente.php">Gerente</a>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <h2>Minha Conta</h2>
            <?php if (!empty($_SESSION['flash_success'])): ?>
                <div class="message success"><?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['flash_error'])): ?>
                <div class="message error"><?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
            <?php endif; ?>
            <p class="small">Nome: <strong><?php echo htmlspecialchars($clienteNome); ?></strong></p>
            <p class="small">CPF: <strong><?php echo preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $clienteCpf); ?></strong></p>
            <p class="small">Saldo: <strong><?php echo $clienteSaldo; ?></strong></p>

            <form action="cliente_actions.php" method="post">
                <div class="form-row">
                    <select class="form-control" name="operation" id="operationSelect" required onchange="onOperationChange(this.value)">
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
