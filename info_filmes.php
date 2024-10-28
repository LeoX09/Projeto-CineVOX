<?php
include 'config.php'; // Importa o arquivo de configuração

if (isset($_GET['id'])) {
    $id_filme = $_GET['id'];

    // Montando a URL corretamente
    $url = TMDB_API_URL . "/$id_filme?api_key=" . TMDB_API_KEY . "&append_to_response=credits&language=pt-BR"; 

    // Fazendo a requisição
    $response = file_get_contents($url);
    $filme = json_decode($response, true);
    
    // Verifique se a resposta da API está vazia ou não é válida
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
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($filme['title']) ? $filme['title'] : 'Filme não encontrado'; ?></title>
    <link rel="stylesheet" href="style.css"> <!-- Link para o CSS -->
</head>
<body>
    <?php if (isset($filme)): ?>
        <div class="container">
            <h1><?php echo $filme['title']; ?></h1>
            <img src="https://image.tmdb.org/t/p/w500<?php echo $filme['poster_path']; ?>" alt="<?php echo $filme['title']; ?>">
            <p><strong>Sinopse:</strong> <?php echo $filme['overview']; ?></p>
            <p><strong>Data de Lançamento:</strong> <?php echo $filme['release_date']; ?></p>
            <p><strong>Avaliação:</strong> <?php echo $filme['vote_average']; ?></p>
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
                            <img src="https://image.tmdb.org/t/p/w500<?php echo $ator['profile_path']; ?>" alt="<?php echo $ator['name']; ?>">
                        <?php endif; ?>
                        <p><strong><?php echo $ator['name']; ?></strong></p>
                        <p>Como: <?php echo $ator['character']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <h2>Imagens do Filme</h2>
            <div class="images">
                <?php if (!empty($filme['images']['backdrops'])): ?>
                    <?php foreach ($filme['images']['backdrops'] as $imagem): ?>
                        <img src="https://image.tmdb.org/t/p/w500<?php echo $imagem['file_path']; ?>" alt="Backdrop">
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma imagem disponível.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <p>Filme não encontrado.</p>
    <?php endif; ?>
</body>
</html>
