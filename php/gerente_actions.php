<?php
session_start();

// Verificar se o usuário está autenticado como gerente
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'gerente') {
    header("Location: ../pages/index.php");
    exit();
}

// Incluir a conexão com o banco de dados
include_once(__DIR__ . "/conexao.php"); // fornece $conn
/** @var mysqli $conn */

// Lógica para processar as ações do gerente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["inserir_funcionario"])) {
        $nome = $_POST["nome"] ?? '';
        $cargo = $_POST["cargo"] ?? '';
        $salario = $_POST["salario"] ?? 0;

    // gerar senha temporária e armazenar hash
    $senhaTemp = bin2hex(random_bytes(4));
    $hash = password_hash($senhaTemp, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO funcionario (matricula, nome, senha, endereco, cidade, cargo, sexo, dt_nascimento, salario, agencia_id) VALUES (NULL, ?, ?, '', '', ?, 'masculino', '1970-01-01', ?, 1)");
    // tipos: nome (s), hash (s), cargo (s), salario (d)
    $stmt->bind_param('sssd', $nome, $hash, $cargo, $salario);
        if ($stmt->execute()) {
            echo "Novo funcionário inserido com sucesso!";
        } else {
            echo "Erro ao inserir funcionário: " . $stmt->error;
        }
    } elseif (isset($_POST["remover_funcionario"])) {
        $matricula = $_POST["matricula"] ?? 0;

        $stmt = $conn->prepare("DELETE FROM funcionario WHERE matricula = ?");
        $stmt->bind_param('i', $matricula);
        if ($stmt->execute()) {
            echo "Funcionário removido com sucesso!";
        } else {
            echo "Erro ao remover funcionário: " . $stmt->error;
        }
    }
}

// Não fechar $conn aqui; deixe o script que incluiu gerenciar o ciclo de vida
?>
