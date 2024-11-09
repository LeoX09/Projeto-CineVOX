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
    <style>
        /* Estilos para centralização */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center; /* Centraliza horizontalmente */
            margin-top: 70px; /* Para espaçamento acima */
        }

        .categorias-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Centraliza os itens dentro do container */
            margin-top: 20px; /* Espaço entre o título e as categorias */
        }

        .categoria {
            margin: 10px; /* Espaçamento entre as categorias */
            padding: 15px;
            background-color: #f8f9fa; /* Fundo claro para as categorias */
            border: 1px solid #ddd; /* Borda leve */
            border-radius: 5px; /* Cantos arredondados */
            text-align: center; /* Centraliza o texto */
            transition: background-color 0.3s; /* Transição suave para o hover */
        }

        .categoria a {
            text-decoration: none; /* Remove o sublinhado do link */
            color: #333; /* Cor do texto */
            font-weight: bold; /* Deixa o texto em negrito */
        }

        .categoria:hover {
            background-color: #e2e6ea; /* Muda a cor do fundo ao passar o mouse */
        }
    </style>
</head>

<body>

<?php include '../views/nav.php'?>

    <div class="container">
        <h1>Categorias</h1>

        <div class="categorias-container">
            <?php foreach ($genres as $genre): ?>
                <div class="categoria">
                    <a href="../public/filmes_por_categoria.php?genre_id=<?php echo $genre['id']; ?>">
                        <?php echo htmlspecialchars($genre['name']); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
