<?php
include 'db_config.php';
include 'config.php';

try {
    // Ativa as chaves estrangeiras no SQLite
    $pdo->exec("PRAGMA foreign_keys = ON");

    // SQL para criar a tabela de usuários
    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                email TEXT UNIQUE NOT NULL,
                senha TEXT NOT NULL
            )";   
    $pdo->exec($sql);
    echo "Tabela 'usuarios' criada com sucesso.<br>";

    // SQL para criar a tabela de favoritos com chave estrangeira user_id
    $sql = "CREATE TABLE IF NOT EXISTS favoritos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                movie_id INTEGER NOT NULL,
                FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
            )";
    $pdo->exec($sql);
    echo "Tabela 'favoritos' criada com sucesso.<br>";

    // SQL para criar a tabela de comentários com chaves estrangeiras
    $sql = "CREATE TABLE IF NOT EXISTS comentarios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                id_filme INTEGER NOT NULL,
                texto TEXT,
                data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (id_filme) REFERENCES filmes(id),
                FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
            )";
    $pdo->exec($sql);
    echo "Tabela 'comentarios' criada com sucesso.";

} catch (PDOException $e) {
    echo "Erro ao criar tabelas: " . $e->getMessage();
}
?>
