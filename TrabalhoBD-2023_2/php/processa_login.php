<?php
include_once("conexao.php");

session_start();

$usuario_autenticado = false;

$login = isset($_POST["login"]) ? strval($_POST["login"]) : "";
$senha = isset($_POST["password"]) ? md5($_POST["password"]) : "";

$stmt = $conexao->prepare("SELECT COUNT(*) AS num FROM Funcionarios WHERE (matricula = :login OR cpf = :login OR email = :login) AND senha = :senha");

$stmt->bindParam(":login", $login);
$stmt->bindParam(":senha", $senha);

if ($stmt->execute()) {
    $retorno_consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $valor = (int) $retorno_consulta[0]['num'];
    
    if ($valor > 0) {
        $stmt = $conexao->prepare("SELECT cargo FROM Funcionarios WHERE (matricula = :login OR cpf = :login OR email = :login) AND senha = :senha");

        $stmt->bindParam(":login", $login);
        $stmt->bindParam(":senha", $senha);

        if ($stmt->execute()) {
            $retorno_consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $cargo = $retorno_consulta[0]['cargo'];

            switch ($cargo) {
                case 'caixa':
                    header('Location: ../paginas/caixa.php');
                    break;
                case 'gerente':
                    header('Location: ../paginas/gerente.php');
                    break;
                case 'atendente':
                    header('Location: ../paginas/atendente.php');
                    break;
            }
            
            $_SESSION['login_funcionario'] = $login;
            $_SESSION['autenticado'] = 'sim';
        }
    } else {
        $stmt = $conexao->prepare("SELECT COUNT(*) AS num FROM Clientes WHERE (cpf = :login OR email = :login) AND senha_login = :senha");

        $stmt->bindParam(":login", $login);
        $stmt->bindParam(":senha", $senha);

        if ($stmt->execute()) {
            $retorno_consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $valor = (int) $retorno_consulta[0]['num'];

            if ($valor > 0) {
                header('Location: ../paginas/escolha-conta.php');
                $_SESSION['autenticado'] = 'sim';
                $_SESSION['login_usuário'] = $login;
            } else {
                if ($login === "Admin" && $senha === md5("Root")) {
                    header('Location: https://www.db4free.net/phpMyAdmin/index.php?route=/database/structure&db=nullbank_469870');
                } else {
                    header('Location: ../paginas/index.php?login=erro');
                    $_SESSION['autenticado'] = 'nao';
                }
            }
        }
    }
}
?>
