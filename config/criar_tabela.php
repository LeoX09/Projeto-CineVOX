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
    echo "Tabela 'usuarios' criada com sucesso.<br>";

    // SQL para criar a tabela de favoritos com a chave estrangeira user_id
    $sql = "CREATE TABLE IF NOT EXISTS favoritos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER,
                movie_id INTEGER NOT NULL,
                FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
            )";
    $pdo->exec($sql);
    echo "Tabela 'favoritos' criada com sucesso.";
} catch (PDOException $e) {
    echo "Erro ao criar tabelas: " . $e->getMessage();
}
?>
