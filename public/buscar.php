<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>CineVOX - Buscar Filmes</title>
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
            if (isset($_GET['query'])) {
                $query = urlencode($_GET['query']);
                $url = "https://api.themoviedb.org/3/search/movie?api_key=" . TMDB_API_KEY . "&query=" . $query . "&language=pt-BR";
                $response = file_get_contents($url);
                $movies = json_decode($response, true);

                if (empty($movies['results'])) {
                    echo "<p>Nenhum filme encontrado para sua pesquisa.</p>";
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
            }
            ?>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
