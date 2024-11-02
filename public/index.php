<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>CineVOX - Filmes Populares</title>
    <link rel="stylesheet" href="../assets/css/cards.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
    <link href="../vendor/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
<?php include '../views/nav.php'; ?>
    <div class="container" style="margin-top: 70px;">
        <div class="row">
            <?php
            include '../config/config.php';

            function fetchMovies()
            {
                $url = TMDB_API_POPULAR . '?api_key=' . TMDB_API_KEY;
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
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                        <div class="movie-card" onclick="window.location.href='../views/info_filmes.php?id=<?php echo $movie['id']; ?>'">
                            <img src="https://image.tmdb.org/t/p/w500<?php echo $movie['poster_path']; ?>" alt="<?php echo $movie['title']; ?>">
                            <div class="movie-info">
                                <p class="synopsis">Sinopse: <?php echo $movie['overview']; ?></p>
                                <p class="rating">Nota: <?php echo $movie['vote_average']; ?></p>
                            </div>
                        </div>
                    </div>
            <?php endforeach;
            }
            ?>
        </div>
    </div>

    <footer class="bg-dark text-white pt-4 pb-2">
        <div class="container">
            <div class="row">
                <!-- Links de Navegação -->
                <div class="col-md-6 mb-3">
                    <h5>Explore</h5>
                    <ul class="list-unstyled">
                        <li><a href="../public/index.php" class="text-white-50">Página Inicial</a></li>
                        <li><a href="../public/categorias.php" class="text-white-50">Categorias</a></li>
                    </ul>
                </div>

                <!-- Informações -->
                <div class="col-md-6 mb-3">
                    <h5>Informações</h5>
                    <p class="text-white-50">Todos os direitos reservados © <?php echo date("Y"); ?> CineVOX</p>
                    <p class="text-white-50">Este site utiliza a API do TMDB, mas não é afiliado ao TMDB.</p>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center">
                <p class="mb-0 text-white-50">Desenvolvido por <a href="https://seusite.com" class="text-white-50">Informaticos</a></p>
            </div>
        </div>
    </footer>

    <script src="../assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
