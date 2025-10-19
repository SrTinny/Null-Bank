<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
    header('Location: ../pages/index.php');
    exit();
}

require_once __DIR__ . '/conexao.php'; // fornece $conn
/** @var mysqli $conn */

$matricula_cpf = $_POST['matricula_cpf'] ?? '';
$senha = $_POST['senha'] ?? '';

// Primeiro, tentar autenticar contra tabela `users` (se existir)
$userCheck = $conn->query("SHOW TABLES LIKE 'users'");
if ($userCheck && $userCheck->num_rows > 0) {
    $stmt = $conn->prepare("SELECT id, matricula, name, password, role FROM users WHERE matricula = ? OR name = ? LIMIT 1");
    $stmt->bind_param('ss', $matricula_cpf, $matricula_cpf);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $u = $res->fetch_assoc();
        if (password_verify($senha, $u['password'])) {
            // sucesso
            $_SESSION['autenticado'] = 'sim';
            $_SESSION['user_id'] = $u['matricula'] ?: $u['id'];
            $_SESSION['user_type'] = $u['role'];
            // mapa simples de role para páginas
            if ($u['role'] === 'admin') header('Location: ../pages/gerente.php');
            else header('Location: ../pages/cliente.php');
            exit();
        }
    }
}

// Próximo fallback: autenticar contra tabela possui (clientes)
$stmt = $conn->prepare("SELECT cliente_cpf, conta_numero, login, senha FROM possui WHERE login = ? LIMIT 1");
$stmt->bind_param('s', $matricula_cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $dbSenha = $row['senha'];

    // Suporte a migração gradual: aceitar hash ou senha em claro e re-hash quando em claro
    $isHash = (strpos($dbSenha, '$2y$') === 0) || (strpos($dbSenha, '$2a$') === 0) || (strpos($dbSenha, '$argon2') === 0);

    $isValid = false;
    if ($isHash) {
        if (password_verify($senha, $dbSenha)) $isValid = true;
    } else {
        if ($dbSenha === $senha) {
            $isValid = true;
            // re-hash e salvar
            $novoHash = password_hash($senha, PASSWORD_DEFAULT);
            $upd = $conn->prepare('UPDATE possui SET senha = ? WHERE cliente_cpf = ? AND conta_numero = ?');
            $upd->bind_param('sis', $novoHash, $row['cliente_cpf'], $row['conta_numero']);
            $upd->execute();
        }
    }

    if ($isValid) {
        $_SESSION['autenticado'] = 'sim';
        $_SESSION['user_id'] = $row['cliente_cpf'];
        $_SESSION['user_type'] = 'cliente';
        header('Location: ../pages/cliente.php');
        exit();
    }
}

// Fallback final: autenticar contra tabela funcionario (legado)
// Mantemos como último para priorizar users -> possui -> funcionario
$stmt = $conn->prepare("SELECT matricula, cargo, senha FROM funcionario WHERE matricula = ? OR cpf = ? LIMIT 1");
$stmt->bind_param('ss', $matricula_cpf, $matricula_cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $dbSenha = $row['senha'];

    $isHash = (strpos($dbSenha, '$2y$') === 0) || (strpos($dbSenha, '$2a$') === 0) || (strpos($dbSenha, '$argon2') === 0);

    $isValid = false;
    if ($isHash) {
        if (password_verify($senha, $dbSenha)) $isValid = true;
    } else {
        if ($dbSenha === $senha) {
            $isValid = true;
            $novoHash = password_hash($senha, PASSWORD_DEFAULT);
            $upd = $conn->prepare('UPDATE funcionario SET senha = ? WHERE matricula = ?');
            $upd->bind_param('si', $novoHash, $row['matricula']);
            $upd->execute();
        }
    }

    if ($isValid) {
        $_SESSION['autenticado'] = 'sim';
        $_SESSION['user_id'] = $row['matricula'];
        $_SESSION['user_type'] = $row['cargo'];

        switch ($row['cargo']) {
            case 'gerente':
                header('Location: ../pages/gerente.php');
                break;
            case 'atendente':
                header('Location: ../pages/atendente.php');
                break;
            case 'caixa':
                header('Location: ../pages/caixa.php');
                break;
            default:
                header('Location: ../pages/index.php');
        }
        exit();
    }
}

// Falha de autenticação
header('Location: ../pages/index.php?error=1');
exit();
?>
