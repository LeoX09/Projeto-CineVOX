<?php
try {
    // Ajuste o caminho do banco de dados para a pasta "database"
    $pdo = new PDO("sqlite:" . __DIR__ . "/../database/usuarios.sqlite"); // Verifique o nome correto do arquivo do banco de dados
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ativa o modo de erro
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Define o modo de busca padrão
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Desativa a emulação de prepared statements
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    exit();
}
?>
