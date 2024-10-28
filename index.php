<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>CineVOX</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="cards.css">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <link href="node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="navbar">
        <a class="navbar-brand" href="index.php">
            <img src="img/CineVOX.png" alt="logo" style="width: 100px;">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="#">Categorias <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="#">Favoritos <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" onsubmit="event.preventDefault(); searchMovies();">
                <div class="input">
                    <input class="form-control mr-sm-2" type="search" id="search-input" placeholder="Buscar filmes..." aria-label="Pesquisar" onkeypress="handleKeyPress(event)">
                    <i class="bi bi-search"></i>
                </div>
            </form>
        </div>
        <div class="align-self-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="login.php" class="text-white"><i class="bi bi-person-circle" style="font-size: 30px;"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 70px;">
        <div id="search-results">
            <?php
            include 'config.php'; // Certifique-se que a TMDB_API_KEY está definida corretamente

            function fetchMovies()
            {
                // Montando a URL corretamente com a chave da API
                $url = TMDB_API_POPULAR . '?api_key=' . TMDB_API_KEY; // A chave da API deve estar correta
                $response = file_get_contents($url);
                
                if ($response === false) {
                    echo "Erro ao buscar filmes.";
                    return [];
                }
                
                return json_decode($response, true);
            }
            
            $movies = fetchMovies();
            if (empty($movies['results'])) {
                echo "Nenhum filme encontrado.";
            } else {
                foreach ($movies['results'] as $movie): ?>
                    <div class="movie-card" onclick="window.location.href='info_filmes.php?id=<?php echo $movie['id']; ?>'">
                        <img src="https://image.tmdb.org/t/p/w500<?php echo $movie['poster_path']; ?>" alt="<?php echo $movie['title']; ?>">
                        <div class="movie-info">
                            <p class="synopse">Sinopse: <?php echo $movie['overview']; ?></p>
                            <p class="rating">Nota: <?php echo $movie['vote_average']; ?></p>
                        </div>
                    </div>
                <?php endforeach;
            }            
            ?>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>
