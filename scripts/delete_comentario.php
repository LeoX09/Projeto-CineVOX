<?php
session_start();
include '../config/config.php';
include '../config/db_config.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo "Você precisa estar logado para excluir comentários.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Verificar se o ID do comentário foi passado via POST
if (isset($_POST['comentario_id'])) {
    $comentario_id = $_POST['comentario_id'];

    try {
        // Verificar se o comentário pertence ao usuário
        $stmt = $pdo->prepare("SELECT * FROM comentarios WHERE id = ? AND user_id = ?");
        $stmt->execute([$comentario_id, $user_id]);
        $comentario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$comentario) {
            echo "Comentário não encontrado ou você não tem permissão para excluir.";
            exit;
        }

        // Excluir o comentário
        $deleteStmt = $pdo->prepare("DELETE FROM comentarios WHERE id = ? AND user_id = ?");
        $deleteStmt->execute([$comentario_id, $user_id]);

        // Redirecionar para a página de comentários após a exclusão
        header("Location: ../public/comentarios.php");
        exit();
        
    } catch (PDOException $e) {
        echo "Erro ao excluir comentário: " . $e->getMessage();
    }
} else {
    echo "ID do comentário não encontrado.";
}
?>
