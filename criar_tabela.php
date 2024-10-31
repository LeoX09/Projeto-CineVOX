<?php
include 'db_config.php';

try {
    // SQL para criar a tabela de usuários
    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                email TEXT UNIQUE NOT NULL,
                senha TEXT NOT NULL
            )";
    $pdo->exec($sql);
    echo "Tabela 'usuarios' criada com sucesso.";
} catch (PDOException $e) {
    echo "Erro ao criar tabela: " . $e->getMessage();
}
?>
