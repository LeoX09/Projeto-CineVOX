<?php
// categorias.php
include '../config/config.php';

$response = file_get_contents(TMDB_API_GENRES);
$genres = json_decode($response, true)['genres'];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>CineVOX - Categorias</title>
    <link rel="stylesheet" href="../assets/css/categorias.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
    <link href="../vendor/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<?php include '../views/nav.php'?>

    <div style="margin-top: 70px;"></div>
    <div class="container">
        <h1>Categorias</h1>

        <div class="categorias-container">
            <?php foreach ($genres as $genre): ?>
                <div class="categoria">
                    <a href="../public/filmes_por_categoria.php?genre_id=<?php echo $genre['id']; ?>"><?php echo htmlspecialchars($genre['name']); ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <script src="../assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>