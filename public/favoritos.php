<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php"); // Redireciona para a página de login se não estiver logado
    exit;
}
include '../config/config.php';
include '../config/db_config.php';
include '../config/helpers.php';

$user_id = $_SESSION['user_id'];

// Buscar os filmes favoritos do usuário no banco de dados
try {
    $stmt = $pdo->prepare("SELECT * FROM favoritos WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar favoritos: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos - CineVOX</title>
    <link rel="stylesheet" href="../assets/css/favoritos.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="../vendor/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include '../views/nav.php'; ?>

    <div class="container" style="margin-top: 70px;">
        <h1>Filmes Favoritos</h1>

        <div class="row">
            <?php
            if (empty($favoritos)) {
                echo "<p>Você ainda não adicionou filmes aos favoritos.</p>";
            } else {
                foreach ($favoritos as $favorito) {
                    $movieDetails = getMovieDetails($favorito['movie_id'], 'pt-BR');
                    if ($movieDetails): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                            <div class="movie-card" onclick="window.location.href='../views/info_filmes.php?id=<?php echo htmlspecialchars($movieDetails['id']); ?>'">
                                <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movieDetails['poster_path']); ?>" alt="<?php echo htmlspecialchars($movieDetails['title']); ?>">
                                <div class="movie-info">
                                    <form method="post" action="../scripts/remover_favoritos.php">
                                        <input type="hidden" name="movie_id" value="<?php echo $movieDetails['id']; ?>">
                                        <button type="submit" class="remove-favorite-btn">Remover dos Favoritos</button>
                                    </form>
                                </div>
                            </div>
                        </div>
            <?php endif;
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