    <?php
/* Obtém os detalhes de um filme a partir da API TMDB. */
function getMovieDetails($id, $lang = 'en') {
    $url = "https://api.themoviedb.org/3/movie/$id?api_key=" . TMDB_API_KEY . "&append_to_response=videos,credits,images,reviews&language=$lang";
    $response = @file_get_contents($url);
    if ($response) {
        return json_decode($response, true);
    }
    return null;
}

/* Obtém as informações dos provedores de streaming disponíveis para um filme específico em uma determinada região. */
function getMovieProviders($id, $region) {
    $url = "https://api.themoviedb.org/3/movie/$id/watch/providers?api_key=" . TMDB_API_KEY;
    $response = @file_get_contents($url);
    $providersData = $response ? json_decode($response, true) : null;
    
    // Verifica se providersData não é nulo e se contém resultados para a região especificada
    if ($providersData && isset($providersData['results'][$region])) {
        return $providersData['results'][$region];
    }
    return null; // Retorna null se não houver provedores disponíveis
}

function getMovieTrailerKey($filme, $lang = 'en') {
    // Verifica se 'videos' e 'results' existem no array do filme
    if (isset($filme['videos']) && isset($filme['videos']['results'])) {
        foreach ($filme['videos']['results'] as $video) {
            // Confere se o vídeo é do YouTube e é um trailer
            if ($video['site'] === 'YouTube' && $video['type'] === 'Trailer') {
                // Verifica se a chave 'language' existe antes de acessar
                if (!isset($video['language']) || $video['language'] === $lang) {
                    return $video['key'];
                }
            }
        }
    }
    return null; // Retorna null se não encontrar um trailer apropriado
}

/* Formata a avaliação do filme em estrelas. */
function formatStars($rating) {
    $numStars = 5;
    $filledStars = round(($rating / 10) * $numStars);
    return str_repeat('<i class="bi bi-star-fill" style="color: gold;"></i>', $filledStars) . 
           str_repeat('<i class="bi bi-star" style="color: gray;"></i>', $numStars - $filledStars);
}

/* Formata a lista de provedores de streaming disponíveis para exibição. */
function formatProviders($providers) {
    if (!$providers || empty($providers['flatrate'])) return "Não disponível";
    return implode(', ', array_map(fn($p) => htmlspecialchars($p['provider_name']), $providers['flatrate']));
}

/* Traduz e formata os gêneros de um filme para português. */
function formatGenres($genres) {
    $generosTraduzidos = [
        "Action" => "Ação", "Adventure" => "Aventura", "Animation" => "Animação", "Comedy" => "Comédia",
        "Crime" => "Crime", "Documentary" => "Documentário", "Drama" => "Drama", "Family" => "Família",
        "Fantasy" => "Fantasia", "History" => "História", "Horror" => "Terror", "Music" => "Música",
        "Mystery" => "Mistério", "Romance" => "Romance", "Science Fiction" => "Ficção Científica",
        "TV Movie" => "Filme para TV", "Thriller" => "Suspense", "War" => "Guerra", "Western" => "Faroeste"
    ];
    return implode(', ', array_map(fn($g) => $generosTraduzidos[$g['name']] ?? $g['name'], $genres));
}

/* Formata as críticas do filme */
function formatReviews($reviews) {
    if (isset($reviews['results']) && is_array($reviews['results']) && !empty($reviews['results'])) {
        return array_map(function($review) {
            return [
                'author' => htmlspecialchars($review['author']),
                'content' => htmlspecialchars($review['content']),
                'rating' => formatStars($review['rating'] ?? 0) // Se houver avaliação
            ];
        }, $reviews['results']);
    }
    return []; // Retorna array vazio se não houver críticas
}

function getMovieCredits($movieId, $language = 'en') {
    $apiKey = '849679f956996f27d90a29bc51be2519';
    $url = "https://api.themoviedb.org/3/movie/$movieId/credits?api_key=$apiKey&language=$language";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

