<?php
include 'config.php'; // Inclui o arquivo de configuração

if (isset($_GET['genre_id'])) {
    $genre_id = intval($_GET['genre_id']); // Obtém o ID do gênero e converte para inteiro
    $url = "https://api.themoviedb.org/3/discover/movie?api_key=" . TMDB_API_KEY . "&language=pt-BR&with_genres=" . $genre_id . "&page=1";

    // Faz a requisição para a API
    $response = file_get_contents($url);
    $filmes = json_decode($response, true);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>CineVOX - Filmes por Categoria</title>
    <link rel="stylesheet" href="css/cards.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <link href="node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="navbar">
        <a class="navbar-brand" href="index.php">
            <img src="img/CineVOX.png" alt="logo" style="width: 100px;">
        </a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Alterna navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link active" href="index.php">Populares</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="categorias.php">Categorias</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="favoritos.php">Favoritos</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="buscar.php" method="GET">
                <div class="input">
                    <input class="form-control mr-sm-2" type="search" name="query" id="search-input" placeholder="Buscar filmes..." aria-label="Pesquisar">
                    <i class="bi bi-search"></i>
                </div>
            </form>
            <div class="align-self-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="login.php" class="text-white"><i class="bi bi-person-circle" style="font-size: 30px;"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" id="movie-container" style="margin-top: 70px";>
    <h1>Filmes na Categoria</h1>
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


    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>