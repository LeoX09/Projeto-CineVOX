<?php
try {
    // Ajuste o nome do banco de dados aqui
    $pdo = new PDO("sqlite:" . __DIR__ . "/usuario.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    exit();
}
?>