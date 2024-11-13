<?php
session_start();
include '../config/db_config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['movie_id'])) {
    echo "Usuário não autenticado ou ID do filme não fornecido.";
    exit();
}

$user_id = $_SESSION['user_id'];
$movie_id = $_POST['movie_id'];

try {
    $stmt = $pdo->prepare("INSERT INTO favoritos (user_id, movie_id) VALUES (:user_id, :movie_id)");
    $stmt->execute(['user_id' => $user_id, 'movie_id' => $movie_id]);
    echo "Filme adicionado aos favoritos com sucesso.";
} catch (PDOException $e) {
    echo "Erro ao adicionar filme aos favoritos: " . $e->getMessage();
}
?>
