<?php

define('TMDB_API_KEY', '849679f956996f27d90a29bc51be2519');
define('TMDB_API_URL', 'https://api.themoviedb.org/3/movie');

// Filmes populares
define('TMDB_API_POPULAR', TMDB_API_URL . '/popular?api_key=' . TMDB_API_KEY . '&language=pt-BR&page=1');

// Adicionando URL para gêneros (categorias)
define('TMDB_API_GENRES', 'https://api.themoviedb.org/3/genre/movie/list?api_key=' . TMDB_API_KEY . '&language=pt-BR');

function obterFilmePorId($id_filme) {
    $api_url = "https://api.themoviedb.org/3/movie/$id_filme?api_key=" . TMDB_API_KEY . "&language=pt-BR";
    $response = file_get_contents($api_url);
    
    if ($response === false) {
        return false;
    }

    return json_decode($response, true);
}
?>


