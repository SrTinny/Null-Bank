<?php
// Arquivo de conexão - padronizado para fornecer $conn (mysqli OO)
// Valores compatíveis com o docker-compose
$servername = "nullbank-db";
$db_username = "root";
$db_password = "tinny123";
$db_name = "nullbank";

/** @var mysqli $conn */
$conn = new mysqli($servername, $db_username, $db_password, $db_name);

// checar conexão
if ($conn->connect_error) {
    // Exibir erro e abortar — scripts dependem de conexão válida
    throw new Exception('Falha na conexão com DB: ' . $conn->connect_error);
}

// Não fechar a conexão aqui: arquivos que incluem esperam usar $conn
