<?php
// categorias.php
include 'config.php';

$response = file_get_contents(TMDB_API_GENRES);
$genres = json_decode($response, true)['genres'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>CineVOX - Categorias</title>
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

    <h1>Categorias</h1>
    <ul>
        <?php foreach ($genres as $genre): ?>
            <li><a href="filmes_por_categoria.php?genre_id=<?php echo $genre['id']; ?>"><?php echo htmlspecialchars($genre['name']); ?></a></li>
        <?php endforeach; ?>
    </ul>

    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
