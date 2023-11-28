<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula_cpf = $_POST["matricula_cpf"];
    $senha = $_POST["senha"];

    // Conectar ao banco de dados
    $servername = "localhost";
    $db_username = "root";
    $db_password = "tinny123";
    $db_name = "TrabalhoBD-2023_2-416855";

    $conn = new mysqli($servername, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Verificar as credenciais do usuário
    $query = "SELECT * FROM funcionario WHERE (matricula = '$matricula_cpf' OR cpf = '$matricula_cpf') AND senha = '$senha'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['matricula'];
        $_SESSION['user_type'] = $row['cargo'];

        // Redirecionar para a página apropriada
        switch ($_SESSION['user_type']) {
            case 'gerente':
                header("Location: gerente.php");
                break;
            case 'atendente':
                header("Location: atendente.php");
                break;
            case 'caixa':
                header("Location: caixa.php");
                break;
            default:
                echo "Tipo de usuário desconhecido.";
        }
    } else {
        header("Location: index.php?error=1");
    }

    $conn->close();
} else {
    header("Location: index.php");
}
?>
