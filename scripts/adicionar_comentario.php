<?php
include '../config/db_config.php';
include '../config/config.php';

if (isset($_POST['id_filme']) && isset($_POST['texto'])) {
    $id_filme = intval($_POST['id_filme']);
    $texto = htmlspecialchars($_POST['texto']);

    // Supondo que você tenha o ID do usuário na sessão
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Prepara a consulta SQL para inserir o comentário
        $sql = "INSERT INTO comentarios (user_id, id_filme, texto) VALUES (:user_id, :id_filme, :texto)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':id_filme', $id_filme);
        $stmt->bindParam(':texto', $texto);

        if ($stmt->execute()) {
            header("Location: ../views/info_filmes.php?id=$id_filme"); // Redireciona para a página do filme
            exit;
        } else {
            echo "Erro ao adicionar comentário.";
        }
    } else {
        echo "Usuário não está logado.";
    }
}
?>
