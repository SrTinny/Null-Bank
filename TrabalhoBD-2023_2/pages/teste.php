<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibição de Tabelas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            color: #333;
        }
    </style>
</head>
<body>

<?php
// Conectar ao banco de dados
$servername = "da_java.mysql.dbaas.com.br";
$username = "da_java";
$password = "Tecnicas*2023@";
$dbname = "da_java";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Função para exibir dados de uma tabela
function exibirTabela($conn, $tabela)
{
    $sql = "SELECT * FROM $tabela";
    $result = $conn->query($sql);

    echo "<h2>Tabela: $tabela</h2>";

    if ($result->num_rows > 0) {
        echo "<table><tr>";
        // Exibir cabeçalho da tabela
        $headerShown = false;
        while ($row = $result->fetch_assoc()) {
            if (!$headerShown) {
                echo "<tr>";
                foreach (array_keys($row) as $colName) {
                    echo "<th>$colName</th>";
                }
                echo "</tr>";
                $headerShown = true;
            }

            // Exibir dados da tabela
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "A tabela está vazia.";
    }
}

// Lista de tabelas para exibir
$tabelas = array(
/*     "agencia",
    "funcionario",
    "dependentes",
    "cliente",
    "conta",
    "cliente_telefones",
    "cliente_email",
    "conta_poupanca",
    "conta_corrente",
    "conta_especial",
    "endereco",
    "possui",
    "transacao" */
    "javalar"
);

// Exibir todas as tabelas
foreach ($tabelas as $tabela) {
    exibirTabela($conn, $tabela);
}

$conn->close();
?>

</body>
</html>
