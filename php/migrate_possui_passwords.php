<?php
// Script simples para migrar senhas em `possui` para hash bcrypt
require_once __DIR__ . '/conexao.php';
/** @var mysqli $conn */

// Contar quantas atualizações foram feitas
$updated = 0;

$conn->begin_transaction();
try {
    $stmt = $conn->prepare('SELECT cliente_cpf, conta_numero, login, senha FROM possui FOR UPDATE');
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $dbSenha = $row['senha'];

        // detectar hashes bcrypt/argon2 (simples check por prefixo)
        $isHash = (strpos($dbSenha, '$2y$') === 0) || (strpos($dbSenha, '$2a$') === 0) || (strpos($dbSenha, '$argon2') === 0);

        if ($isHash) continue; // já está hasheada

        // re-hash e update
        $novoHash = password_hash($dbSenha, PASSWORD_DEFAULT);
        $upd = $conn->prepare('UPDATE possui SET senha = ? WHERE cliente_cpf = ? AND conta_numero = ?');
        $upd->bind_param('sis', $novoHash, $row['cliente_cpf'], $row['conta_numero']);
        $upd->execute();
        if ($upd->affected_rows > 0) $updated++;
    }

    $conn->commit();
    echo "Senhas atualizadas em possui: $updated\n";
} catch (Exception $e) {
    $conn->rollback();
    fwrite(STDERR, "Erro durante migração: " . $e->getMessage() . "\n");
    exit(1);
}

?>
