<?php
session_start();

// Verificar se o usuário está autenticado como gerente
/* if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'gerente') {
    header("Location: index.php");
    exit();
} */

// Incluir a conexão com o banco de dados
include_once("../php/conexao.php");

// Lógica para processar as ações do gerente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["inserir_funcionario"])) {
        // Lógica para inserir um novo funcionário
        $nome = $_POST["nome"];
        $cargo = $_POST["cargo"];
        $salario = $_POST["salario"];
        // Adicione mais campos conforme necessário

        $sql = "INSERT INTO funcionario (nome, cargo, salario) VALUES ('$nome', '$cargo', '$salario')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Novo funcionário inserido com sucesso!";
        } else {
            echo "Erro ao inserir funcionário: " . $conn->error;
        }
    } elseif (isset($_POST["remover_funcionario"])) {
        // Lógica para remover um funcionário
        $matricula = $_POST["matricula"];

        $sql = "DELETE FROM funcionario WHERE matricula = '$matricula'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Funcionário removido com sucesso!";
        } else {
            echo "Erro ao remover funcionário: " . $conn->error;
        }
    }
    // Adicione mais lógica para outras ações do gerente conforme necessário
}

// Feche a conexão
$conn->close();
?>
