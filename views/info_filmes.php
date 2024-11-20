<?php
include '../config/config.php';
include '../config/db_config.php';
include '../config/helpers.php';

if (isset($_GET['id'])) {
    $id_filme = intval($_GET['id']);
    $filme = getMovieDetails($id_filme, 'pt-BR');
    $providers = getMovieProviders($id_filme, 'BR');
    $trailerKey = getMovieTrailerKey($filme, 'en');
    $comentario = getComentariosPorFilme($id_filme);
    if (!$filme) {
        echo "Filme não encontrado.";
        exit;
    }

    // Pega os créditos do filme e procura o diretor
    $credits = getMovieCredits($id_filme, 'pt-BR');
    $directorName = '';
    $directorImage = '';
    foreach ($credits['crew'] as $crewMember) {
        if ($crewMember['job'] === 'Director') {
            $directorName = $crewMember['name'];
            $directorImage = $crewMember['profile_path']; // Agora pegamos a imagem também
            break;
        }
    }

    // Verifica a disponibilidade de provedores de streaming e formata a lista
    $providerList = formatProviders($providers);
} else {
    echo "Nenhum filme selecionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title><?php echo htmlspecialchars($filme['title'] ?? 'Filme não encontrado'); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/info.css">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="../vendor/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container" style="margin-top: 70px">
        <div class="movie-info">
            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($filme['poster_path']); ?>" alt="<?php echo htmlspecialchars($filme['title']); ?>" class="poster">

            <div class="movie-details">
                <h1><?php echo htmlspecialchars($filme['title']); ?></h1>
                <p><strong>Diretor:</strong> <?php echo htmlspecialchars($directorName); ?></p>
                <?php if ($directorImage): ?>
                    <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($directorImage); ?>" alt="Diretor" class="director-img">
                <?php endif; ?>

                <?php if (isset($credits['crew'][0]['profile_path'])): ?>
                    <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($credits['crew'][0]['profile_path']); ?>" alt="Diretor" class="director-img">
                <?php endif; ?>

                <p><strong>Sinopse:</strong> <?php echo htmlspecialchars($filme['overview']); ?></p>

                <p><strong>Avaliação:</strong> <?php echo formatStars($filme['vote_average']); ?> (<?php echo htmlspecialchars($filme['vote_count']); ?> avaliações)</p>

                <div class="buttons">
                    <button class="favorite-btn" onclick="adicionarFavorito(<?php echo $id_filme; ?>)">Favoritar</button>
                </div>

                <!-- Provedores de streaming -->
                <div class="streaming-providers">
                    <strong>Disponível em:</strong>
                    <?php echo $providerList; ?>
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


        <section class="comments-section">
            <h2>Comentários</h2>
            <?php if ($comentario): ?>
                <?php foreach ($comentario as $coment): ?>
                    <div class="comment">
                        <p><strong><?php echo htmlspecialchars($coment['usuario_nome']); ?></strong> <span><?php echo htmlspecialchars($coment['data_hora']); ?></span></p>
                        <p><?php echo nl2br(htmlspecialchars($coment['texto'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum comentário disponível para este filme.</p>
            <?php endif; ?>
        </section>

        <form action="../scripts/adicionar_comentario.php" method="POST">
            <input type="hidden" name="id_filme" value="<?php echo $id_filme; ?>">
            <textarea name="texto" placeholder="Adicione um comentário..." required></textarea>
            <button type="submit">Enviar</button>
        </form>

        <script src="../assets/js/script.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>