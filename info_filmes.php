<?php
include 'config.php'; // Importa o arquivo de configuração

if (isset($_GET['id'])) {
    $id_filme = intval($_GET['id']); // Garante que o ID seja um número inteiro

    // Montando a URL corretamente para obter dados completos do filme e provedores de streaming
    $url = "https://api.themoviedb.org/3/movie/$id_filme?api_key=" . TMDB_API_KEY . "&append_to_response=videos,credits,images,reviews&language=pt-BR";
    $providersUrl = "https://api.themoviedb.org/3/movie/$id_filme/watch/providers?api_key=" . TMDB_API_KEY;

    // Fazendo a requisição para obter os detalhes do filme
    $response = file_get_contents($url);

    // Fazendo a requisição para obter os provedores de streaming
    $providersResponse = file_get_contents($providersUrl);

    // Verifique se a requisição foi bem-sucedida
    if ($response !== false && $providersResponse !== false) {
        $filme = json_decode($response, true);
        $providersData = json_decode($providersResponse, true);

        // Verifica se o filme está disponível para uma região específica (por exemplo, Brasil - BR)
        $countryCode = 'BR';
        $providers = $providersData['results'][$countryCode] ?? null;

        // Verifique se a resposta da API contém dados válidos
        if (isset($filme['status_code']) && $filme['status_code'] === 34) {
            echo "Filme não encontrado.";
            exit;
        }

        // Dicionário de gêneros em inglês para português
        $generosTraduzidos = [
            "Action" => "Ação",
            "Adventure" => "Aventura",
            "Animation" => "Animação",
            "Comedy" => "Comédia",
            "Crime" => "Crime",
            "Documentary" => "Documentário",
            "Drama" => "Drama",
            "Family" => "Família",
            "Fantasy" => "Fantasia",
            "History" => "História",
            "Horror" => "Terror",
            "Music" => "Música",
            "Mystery" => "Mistério",
            "Romance" => "Romance",
            "Science Fiction" => "Ficção Científica",
            "TV Movie" => "Filme para TV",
            "Thriller" => "Suspense",
            "War" => "Guerra",
            "Western" => "Faroeste",
        ];

        // Obtendo a chave do trailer (legenda)
        $trailerKey = '';
        foreach ($filme['videos']['results'] as $video) {
            if ($video['site'] === 'YouTube' && $video['type'] === 'Trailer') {
                // Verifica se a chave 'language' existe ou se é 'en' (legendado)
                if (!isset($video['language']) || $video['language'] === 'en') {
                    $trailerKey = $video['key'];
                    break;
                }
            }
        }

        // Obtendo a descrição detalhada
        $descricaoDetalhada = htmlspecialchars($filme['overview']);

        // Obtendo críticas
        $criticas = $filme['reviews']['results'];
    } else {
        echo "Erro ao obter informações do filme.";
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
    <title><?php echo isset($filme['title']) ? htmlspecialchars($filme['title']) : 'Filme não encontrado'; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/info.css">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
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
        </div>
        <div class="align-self-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="login.php" class="text-white"><i class="bi bi-person-circle" style="font-size: 30px;"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <div style="margin-top: 70px;">

        <?php if (isset($filme)): ?>
            <div class="container">
                <h1><?php echo htmlspecialchars($filme['title']); ?></h1>
                <div class="content-wrapper">
                    <div class="image-button-container">
                        <img class="img_title" src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($filme['poster_path']); ?>" alt="<?php echo htmlspecialchars($filme['title']); ?>">
                        <div class="rating-container">
                            <p><strong>Classificação:</strong>
                                <?php
                                $rating = htmlspecialchars($filme['vote_average']);
                                $maxRating = 10; // A nota máxima
                                $numStars = 5; // Número de estrelas que você deseja exibir
                                $starPercentage = ($rating / $maxRating) * 100; // Calcula o percentual da nota em relação à nota máxima

                                for ($i = 0; $i < $numStars; $i++) {
                                    if ($i < $starPercentage / (100 / $numStars)) {
                                        echo '<i class="bi bi-star-fill" style="color: gold;"></i>'; // Estrela preenchida
                                    } else {
                                        echo '<i class="bi bi-star" style="color: gray;"></i>'; // Estrela vazia
                                    }
                                }
                                ?>
                            </p>

                            <div class="platforms">
                                <?php if ($providers): ?>
                                    <div>
                                        <p style="margin-top: 8px;"><strong>Streaming:</strong></p>
                                        <?php if (isset($providers['flatrate'])): ?>
                                            <?php foreach ($providers['flatrate'] as $provider): ?>
                                                <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                                    <img src="https://image.tmdb.org/t/p/w45<?php echo $provider['logo_path']; ?>" alt="<?php echo htmlspecialchars($provider['provider_name']); ?>" style="margin-right: 8px;">
                                                    <span><?php echo htmlspecialchars($provider['provider_name']); ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>Não disponível</p>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <p>Não há informações de plataformas disponíveis para esta região.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="button-container" style="margin-left: 10px;">
                        <button id="favorite-button" class="favorite-btn">Favoritar</button>
                        <button id="watch-later-button" class="watch-later-btn">Assistir Depois</button>
                    </div>

                    <p class="synopsis"><strong>Sinopse:</strong> <?php echo htmlspecialchars($filme['overview']); ?></p>
                    <p><strong>Data de Lançamento:</strong> <?php echo htmlspecialchars($filme['release_date']); ?></p>
                    <p><strong>Gêneros:</strong>
                        <?php
                        $generos = array_map(function ($gen) use ($generosTraduzidos) {
                            return $generosTraduzidos[$gen['name']] ?? $gen['name'];
                        }, $filme['genres']);
                        echo implode(', ', $generos);
                        ?>
                    </p>
                </div>

                <h2>Trailer</h2>
                <div class="trailer">
                    <?php if ($trailerKey): ?>
                        <iframe width="75%" height="450" src="https://www.youtube.com/embed/<?php echo $trailerKey; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <?php else: ?>
                        <p>Trailer não disponível.</p>
                    <?php endif; ?>
                </div>

                <h2>Críticas</h2>
                <div class="reviews">
                    <?php if (empty($criticas)): ?>
                        <p>Nenhuma crítica disponível.</p>
                    <?php else: ?>
                        <?php foreach ($criticas as $critica): ?>
                            <div class="review">
                                <div class="review-author">
                                    <?php if (!empty($critica['author_details']['avatar_path'])): ?>
                                        <?php
                                        // Remove a barra inicial se existir
                                        $avatarPath = ltrim($critica['author_details']['avatar_path'], '/');
                                        ?>
                                        <img src="https://image.tmdb.org/t/p/w500/<?php echo $avatarPath; ?>" alt="<?php echo htmlspecialchars($critica['author']); ?>" class="avatar">
                                    <?php else: ?>
                                        <img src="img/default-avatar.png" alt="Avatar padrão" class="avatar"> <!-- Imagem padrão se não houver avatar -->
                                    <?php endif; ?>
                                    <strong><?php echo htmlspecialchars($critica['author']); ?></strong>
                                </div>
                                <p><?php echo htmlspecialchars($critica['content']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <h2>Elenco</h2>
                <div class="cast">
                    <?php foreach ($filme['credits']['cast'] as $ator): ?>
                        <div class="actor">
                            <?php if ($ator['profile_path']): ?>
                                <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($ator['profile_path']); ?>" alt="<?php echo htmlspecialchars($ator['name']); ?>">
                            <?php endif; ?>
                            <p><strong><?php echo htmlspecialchars($ator['name']); ?></strong></p>
                            <p>Como: <?php echo htmlspecialchars($ator['character']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <p>Filme não encontrado.</p>
        <?php endif; ?>
    </div>

    <script src="script.js"></script>
    <script src="info.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>