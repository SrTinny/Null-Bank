<?php
include_once("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";

    // Verificar as credenciais na tabela correspondente (por exemplo, tabela de funcionários)
    $sql = "SELECT * FROM funcionario WHERE (nome = '$username' OR cpf = '$username' OR email = '$username') AND senha = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Credenciais corretas, redirecionar para a área do caixa
        header("Location: ../pages/caixa.php");
        exit();
    } else {
        // Credenciais incorretas, exibir mensagem de erro ou redirecionar para a página de login
        echo "Credenciais incorretas. Tente novamente.";
    }
}

// Fechar a conexão
$conn->close();
?>
