<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>CineVOX - Buscar Filmes</title>
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

    <div class="container" style="margin-top: 70px;">
        <div class="row">
            <?php
            include 'config.php';

            if (isset($_GET['query'])) {
                $query = urlencode($_GET['query']);
                $url = "https://api.themoviedb.org/3/search/movie?api_key=" . TMDB_API_KEY . "&query=" . $query . "&language=pt-BR";
                $response = file_get_contents($url);
                $movies = json_decode($response, true);

                if (empty($movies['results'])) {
                    echo "<p>Nenhum filme encontrado para sua pesquisa.</p>";
                } else {
                    foreach ($movies['results'] as $movie): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="movie-card" onclick="window.location.href='info_filmes.php?id=<?php echo $movie['id']; ?>'">
                                <img src="https://image.tmdb.org/t/p/w500<?php echo $movie['poster_path']; ?>" alt="<?php echo $movie['title']; ?>">
                                <div class="movie-info">
                                    <p class="synopsis">Sinopse: <?php echo $movie['overview']; ?></p>
                                    <p class="rating">Nota: <?php echo $movie['vote_average']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                }
            }
            ?>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
