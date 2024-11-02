<?php
include '../config/config.php'; // Arquivo de configuração
include '../config/helpers.php';

if (isset($_GET['id'])) {
    $id_filme = intval($_GET['id']);
    $filme = getMovieDetails($id_filme, 'pt-BR');
    $providers = getMovieProviders($id_filme, 'BR');
    $trailerKey = getMovieTrailerKey($filme, 'en');

    if (!$filme) {
        echo "Filme não encontrado.";
        exit;
    }
} else {
    echo "Nenhum filme selecionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($filme['title'] ?? 'Filme não encontrado'); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/info.css">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="../vendor/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container">
        <div class="movie-info">
            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($filme['poster_path']); ?>" alt="<?php echo htmlspecialchars($filme['title']); ?>" class="poster">

            <div class="movie-details">
                <h1><?php echo htmlspecialchars($filme['title']); ?></h1>
                <p><strong>Sinopse:</strong> <?php echo htmlspecialchars($filme['overview']); ?></p>
                <p><strong>Streaming:</strong> <?php echo formatProviders($providers); ?></p>
                <p><strong>Avaliação:</strong> <?php echo formatStars($filme['vote_average']); ?> (<?php echo htmlspecialchars($filme['vote_count']); ?> avaliações)</p>
                <div class="buttons">
                    <button class="favorite-btn">Favoritar</button>
                    <button class="watch-later-btn">Assistir Depois</button>
                </div>
            </div>
        </div>

        <h2 class="trailer-title">Trailer</h2>
<div class="trailer">
    <?php if ($trailerKey): ?>
        <iframe class="trailer-iframe" src="https://www.youtube.com/embed/<?php echo $trailerKey; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <?php else: ?>
        <p>Trailer não disponível.</p>
    <?php endif; ?>
</div>

        <aside class="sidebar">
            <h2>Elenco</h2>
            <div class="cast">
                <?php foreach ($filme['credits']['cast'] as $ator): ?>
                    <div class="actor">
                        <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($ator['profile_path']); ?>" alt="<?php echo htmlspecialchars($ator['name']); ?>">
                        <p><?php echo htmlspecialchars($ator['name']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </aside>
    </div>


    <script src="../assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>