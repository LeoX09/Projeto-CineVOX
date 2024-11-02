<?php
include '../config/config.php';

$nome_categoria = "Filmes na Categoria"; // Nome padrão

if (isset($_GET['genre_id'])) {
    $genre_id = intval($_GET['genre_id']);

    // Requisição para buscar o nome da categoria
    $url_categoria = "https://api.themoviedb.org/3/genre/movie/list?api_key=" . TMDB_API_KEY . "&language=pt-BR";
    $response_categoria = file_get_contents($url_categoria);
    $categorias = json_decode($response_categoria, true);

    // Busca o nome da categoria correspondente ao ID
    if (isset($categorias['genres'])) {
        foreach ($categorias['genres'] as $categoria) {
            if ($categoria['id'] == $genre_id) {
                $nome_categoria = "Filmes na Categoria: " . htmlspecialchars($categoria['name']);
                break;
            }
        }
    }

    // Faz a requisição para obter filmes na categoria
    $url_filmes = "https://api.themoviedb.org/3/discover/movie?api_key=" . TMDB_API_KEY . "&language=pt-BR&with_genres=" . $genre_id . "&page=1";
    $response_filmes = file_get_contents($url_filmes);
    $filmes = json_decode($response_filmes, true);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>CineVOX - Filmes por Categoria</title>
    <link rel="stylesheet" href="../assets/css/cards.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
    <link href="../vendor/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<?php include '../views/nav.php'?>

    <div class="container" id="movie-container" style="margin-top: 70px;">
    <h1 class="title"><?php echo $nome_categoria; ?></h1>
    <div class="row">
        <?php if (isset($filmes['results'])): ?>
            <?php foreach ($filmes['results'] as $filme): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4"> <!-- 4 cards em telas grandes -->
                    <div class="movie-card" onclick="window.location.href='info_filmes.php?id=<?php echo $filme['id']; ?>'">
                        <img src="https://image.tmdb.org/t/p/w500<?php echo $filme['poster_path']; ?>" alt="<?php echo htmlspecialchars($filme['title']); ?>" class="img-fluid">
                        <div class="movie-info">
                            <p class="synopsis">Sinopse: <?php echo htmlspecialchars($filme['overview']); ?></p>
                            <p class="rating">Nota: <?php echo htmlspecialchars($filme['vote_average']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum filme encontrado para esta categoria.</p>
        <?php endif; ?>
    </div>
</div>

    <script src="../assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>
