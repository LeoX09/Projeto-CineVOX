<?php
try {
    // Ajuste o caminho do banco de dados para a pasta "database"
    $pdo = new PDO("sqlite:" . __DIR__ . "/../database/usuario.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    exit();
}
?>