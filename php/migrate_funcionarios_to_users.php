<?php
/**
 * Migra funcionários para tabela `users` e cria a tabela se necessário.
 * Uso: php php/migrate_funcionarios_to_users.php
 */

require_once __DIR__ . '/conexao.php';
/** @var mysqli $conn */

// Criar tabela users se não existir
$create = "CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    matricula INT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

$conn->query($create);

$res = $conn->query('SELECT matricula, nome, senha, cargo FROM funcionario');
$count = 0;
while ($row = $res->fetch_assoc()) {
    $mat = $row['matricula'];
    $nome = $row['nome'];
    $senha = $row['senha'];
    $cargo = $row['cargo'];

    // Detectar hash ou re-hash
    if (strpos($senha, '$2y$') === 0 || strpos($senha, '$argon') === 0) {
        $hash = $senha;
    } else {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
    }

    // Mapeamento de roles simples
    $role = 'user';
    if ($cargo === 'gerente') $role = 'admin';
    if ($cargo === 'caixa') $role = 'cashier';
    if ($cargo === 'atendente') $role = 'attendant';

    $stmt = $conn->prepare('INSERT INTO users (matricula, name, password, role) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('isss', $mat, $nome, $hash, $role);
    if ($stmt->execute()) $count++;
}

echo "Registros migrados: $count\n";

?>
