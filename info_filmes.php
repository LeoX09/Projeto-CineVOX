<?php
include 'config.php'; // Importa o arquivo de configuração

if (isset($_GET['id'])) {
    $id_filme = intval($_GET['id']); // Garante que o ID seja um número inteiro para evitar erros

    // Montando a URL corretamente
    $url = "https://api.themoviedb.org/3/movie/$id_filme?api_key=" . TMDB_API_KEY . "&append_to_response=credits,images&language=pt-BR";

    // Fazendo a requisição
    $response = file_get_contents($url);

    // Verifique se a requisição foi bem-sucedida
    if ($response !== false) {
        $filme = json_decode($response, true);

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
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="categorias.php">Categorias</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="favoritos.php">Favoritos</a>
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

    <div style="margin-top: 70px;">

        <?php if (isset($filme)): ?>
            <div class="container">
                <h1><?php echo htmlspecialchars($filme['title']); ?></h1>
                <div class="image-button-container">
                    <img class="img_title" src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($filme['poster_path']); ?>" alt="<?php echo htmlspecialchars($filme['title']); ?>">
                    <div class="favorite-container">
                        <button id="favorite-button" class="favorite-btn">Favoritar</button>
                    </div>
                </div>
                <p><strong>Sinopse:</strong> <?php echo htmlspecialchars($filme['overview']); ?></p>
                <p><strong>Data de Lançamento:</strong> <?php echo htmlspecialchars($filme['release_date']); ?></p>
                <p><strong>Avaliação:</strong> <?php echo htmlspecialchars($filme['vote_average']); ?></p>
                <p><strong>Gêneros:</strong>
                    <?php 
                    $generos = array_map(function($gen) use ($generosTraduzidos) {
                        return $generosTraduzidos[$gen['name']] ?? $gen['name'];
                    }, $filme['genres']);
                    echo implode(', ', $generos);
                    ?>
                </p>

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
