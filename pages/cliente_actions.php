<?php
session_start();
require_once __DIR__ . '/../php/conexao.php';

// Espera: operation (saque|deposito|transferencia), valor, conta_destino (se transferencia)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cliente.php');
    exit();
}

$operation = $_POST['operation'] ?? '';
$valorRaw = $_POST['valor'] ?? '';
$contaDestino = $_POST['conta_destino'] ?? '';

// Normalizar valor
$valor = floatval(str_replace([',', ' '], ['.', ''], $valorRaw));
if ($valor <= 0) {
    $_SESSION['flash_error'] = 'Valor inválido.';
    header('Location: cliente.php'); exit();
}

// Determinar conta origem a partir da sessão (ou do POST se disponível)
$contaOrigem = null;
if (isset($_SESSION['user_cpf'])) {
    $cpf = preg_replace('/\D/', '', $_SESSION['user_cpf']);
    $stmt = $conn->prepare('SELECT p.conta_numero FROM possui p WHERE p.cliente_cpf = ? LIMIT 1');
    $stmt->bind_param('s', $cpf);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($r = $res->fetch_row()) { $contaOrigem = $r[0]; }
    $stmt->close();
}

if (!$contaOrigem) {
    $_SESSION['flash_error'] = 'Conta de origem não encontrada na sessão.';
    header('Location: cliente.php'); exit();
}

try {
    $conn->begin_transaction();

    // obter saldo atual
    $stmt = $conn->prepare('SELECT saldo FROM conta WHERE numero = ? FOR UPDATE');
    $stmt->bind_param('i', $contaOrigem);
    $stmt->execute();
    $res = $stmt->get_result();
    if (!($row = $res->fetch_assoc())) {
        throw new Exception('Conta de origem não encontrada');
    }
    $saldoOrigem = (float)$row['saldo'];
    $stmt->close();

    if ($operation === 'deposito') {
        // inserir transacao e atualizar saldo
        $stmt = $conn->prepare('INSERT INTO transacao (tipo, data_hora, valor, conta_numero) VALUES (?, NOW(), ?, ?)');
        $tipo = 'deposito';
        $stmt->bind_param('sdi', $tipo, $valor, $contaOrigem);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare('UPDATE conta SET saldo = saldo + ? WHERE numero = ?');
        $stmt->bind_param('di', $valor, $contaOrigem);
        $stmt->execute();
        $stmt->close();

    } elseif ($operation === 'saque') {
        if ($saldoOrigem < $valor) throw new Exception('Saldo insuficiente');

        $stmt = $conn->prepare('INSERT INTO transacao (tipo, data_hora, valor, conta_numero) VALUES (?, NOW(), ?, ?)');
        $tipo = 'saque';
        $stmt->bind_param('sdi', $tipo, $valor, $contaOrigem);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare('UPDATE conta SET saldo = saldo - ? WHERE numero = ?');
        $stmt->bind_param('di', $valor, $contaOrigem);
        $stmt->execute();
        $stmt->close();

    } elseif ($operation === 'transferencia') {
        $contaDestino = intval($contaDestino);
        if (!$contaDestino) throw new Exception('Conta destino inválida');
        if ($contaDestino == $contaOrigem) throw new Exception('Conta destino igual à origem');
        if ($saldoOrigem < $valor) throw new Exception('Saldo insuficiente');

        // inserir transacao origem
        $stmt = $conn->prepare('INSERT INTO transacao (tipo, data_hora, valor, conta_numero) VALUES (?, NOW(), ?, ?)');
        $tipo = 'transferencia';
        $stmt->bind_param('sdi', $tipo, $valor, $contaOrigem);
        $stmt->execute();
        $stmt->close();

        // inserir transacao destino (deposito)
        $stmt = $conn->prepare('INSERT INTO transacao (tipo, data_hora, valor, conta_numero) VALUES (?, NOW(), ?, ?)');
        $tipo2 = 'deposito';
        $stmt->bind_param('sdi', $tipo2, $valor, $contaDestino);
        $stmt->execute();
        $stmt->close();

        // atualizar saldos
        $stmt = $conn->prepare('UPDATE conta SET saldo = saldo - ? WHERE numero = ?');
        $stmt->bind_param('di', $valor, $contaOrigem);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare('UPDATE conta SET saldo = saldo + ? WHERE numero = ?');
        $stmt->bind_param('di', $valor, $contaDestino);
        $stmt->execute();
        $stmt->close();

    } else {
        throw new Exception('Operação inválida');
    }

    $conn->commit();
    $_SESSION['flash_success'] = 'Operação realizada com sucesso.';
    header('Location: cliente.php'); exit();

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['flash_error'] = 'Erro na operação: ' . $e->getMessage();
    header('Location: cliente.php'); exit();
}

?>
