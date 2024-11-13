<?php
session_start();
include '../config/config.php';
include '../config/db_config.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo "Você precisa estar logado para remover filmes dos favoritos.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Verificar se o ID do filme foi passado
if (isset($_POST['movie_id'])) {
    $movie_id = $_POST['movie_id'];

    try {
        // Remover o filme dos favoritos
        $stmt = $pdo->prepare("DELETE FROM favoritos WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$user_id, $movie_id]);

        // Redirecionar para a página de favoritos
        header("Location: ../public/favoritos.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao remover favorito: " . $e->getMessage();
    }
} else {
    echo "ID do filme não encontrado.";
}
?>
