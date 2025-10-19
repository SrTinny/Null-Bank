<?php
/**
 * Script de migração de senhas legadas (texto) para hashes seguros.
 * Uso: php php/migrate_passwords.php
 * Certifique-se de configurar `php/conexao.php` corretamente para ambiente.
 */

require_once __DIR__ . '/conexao.php'; // fornece $conn
/** @var mysqli $conn */

$res = $conn->query('SELECT matricula, senha FROM funcionario');
$updated = 0;
while ($row = $res->fetch_assoc()) {
    $mat = $row['matricula'];
    $senha = $row['senha'];

    if (strpos($senha, '$2y$') !== 0 && strpos($senha, '$argon') !== 0) {
        // parece texto claro -> re-hash
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('UPDATE funcionario SET senha = ? WHERE matricula = ?');
        $stmt->bind_param('si', $hash, $mat);
        if ($stmt->execute()) $updated++;
    }
}

echo "Senhas atualizadas: $updated\n";

?>
