<?php
// config.php
define('TMDB_API_KEY', '849679f956996f27d90a29bc51be2519'); // Substitua pela sua chave real
define('TMDB_API_URL', 'https://api.themoviedb.org/3/movie');

// Você pode usar esta constante para obter filmes populares, se necessário
define('TMDB_API_POPULAR', TMDB_API_URL . '/popular?api_key=' . TMDB_API_KEY . '&language=pt-BR&page=1');
?>
