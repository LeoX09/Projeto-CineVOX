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

/* Formata a lista de provedores de streaming disponíveis para exibição, incluindo a logo de cada provedor. */
function formatProviders($providers) {
    // Verifica se há provedores de streaming
    if (!$providers || empty($providers['flatrate'])) {
        return "Não disponível";
    }

    // Inicializa o resultado
    $providerList = '';

    // Itera sobre os provedores disponíveis e formata a exibição
    foreach ($providers['flatrate'] as $provider) {
        $providerName = htmlspecialchars($provider['provider_name']);
        $providerLogo = isset($provider['logo_path']) ? "https://image.tmdb.org/t/p/w500" . $provider['logo_path'] : '';

        // Se tiver a logo, exibe o nome do provedor junto com a logo
        if ($providerLogo) {
            $providerList .= "<img src=\"$providerLogo\" alt=\"$providerName\" class=\"provider-logo\"> $providerName<br>";
        } else {
            // Caso não tenha logo, apenas o nome
            $providerList .= "$providerName<br>";
        }
    }

    // Retorna a lista formatada de provedores
    return $providerList;
}

function getMovieCredits($movieId, $language = 'en') {
    $apiKey = '849679f956996f27d90a29bc51be2519';
    $url = "https://api.themoviedb.org/3/movie/$movieId/credits?api_key=$apiKey&language=$language";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function getComentariosPorFilme($id_filme) {
    global $pdo; // Usa a conexão PDO definida no db_config.php

    // Consulta para buscar os comentários do filme com o id_filme
    $sql = "SELECT c.texto, c.data_hora, u.nome AS usuario_nome
            FROM comentarios c
            JOIN usuarios u ON c.user_id = u.id
            WHERE c.id_filme = :id_filme
            ORDER BY c.data_hora DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_filme', $id_filme, PDO::PARAM_INT); // Faz a ligação segura do parâmetro
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os comentários encontrados
}


