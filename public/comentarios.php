<?php
session_start();
// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php"); // Redireciona para a página de login se não estiver logado
    exit;
}

include '../config/config.php';
include '../config/db_config.php';
include '../config/helpers.php';

$user_id = $_SESSION['user_id'];

// Buscar os comentários do usuário no banco de dados
try {
    $stmt = $pdo->prepare("SELECT * FROM comentarios WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar comentários: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Comentários - CineVOX</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/comentarios.css">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="../vendor/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include '../views/nav.php'; ?>

    <div class="container">
        <h1>Meus Comentários</h1>

        <div class="row">
            <?php
            if (empty($comentarios)) {
                echo "<p class='text-white text-center'>Você ainda não fez comentários em nenhum filme.</p>";
            } else {
                foreach ($comentarios as $comentario) {
                    $movieDetails = getMovieDetails($comentario['id_filme'], 'pt-BR');
                    if ($movieDetails) : ?>
                        <div class="col-12 mb-4">
                            <div class="movie-card" onclick="window.location.href='../views/info_filmes.php?id=<?php echo htmlspecialchars($movieDetails['id']); ?>'">
                                <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movieDetails['poster_path']); ?>" alt="<?php echo htmlspecialchars($movieDetails['title']); ?>">
                                <div class="movie-info">
                                    <h5><?php echo htmlspecialchars($movieDetails['title']); ?></h5>
                                    <p><strong>Comentário:</strong> <?php echo htmlspecialchars($comentario['texto']); ?></p>
                                    <small><strong>Data:</strong> <?php echo htmlspecialchars($comentario['data_hora']); ?></small>
                                    <form action="../scripts/delete_comentario.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este comentário?')">
                                        <input type="hidden" name="comentario_id" value="<?php echo htmlspecialchars($comentario['id']); ?>">
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
            <?php
                    endif;
                }
            }
            ?>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>