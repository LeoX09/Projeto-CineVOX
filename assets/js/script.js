// Função para buscar filmes na API do TMDB
function searchMovies() {
    const query = $('#search-input').val();
    if (!query) return;

    const apiUrl = `https://api.themoviedb.org/3/search/movie?api_key=849679f956996f27d90a29bc51be2519&query=${encodeURIComponent(query)}&language=pt-BR`;

    $.get(apiUrl, function(data) {
        const resultsContainer = $('#search-results');
        resultsContainer.empty(); // Limpa os resultados anteriores

        if (data.results.length === 0) {
            resultsContainer.html('<p>Nenhum filme encontrado.</p>');
            return;
        }

        data.results.forEach(movie => {
            const movieCard = $(`
                <div class="movie-card">
                    <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" alt="${movie.title}">
                    <h3>${movie.title}</h3>
                    <p>Nota: ${movie.vote_average}</p>
                    <button class="rate-movie-btn" data-id="${movie.id}" data-title="${movie.title}">Avaliar</button>
                </div>
            `);
            resultsContainer.append(movieCard);
        });
    }).fail(function(error) {
        console.error('Erro ao buscar filmes:', error);
    });
}

// Função para detectar a tecla Enter e iniciar a pesquisa
function handleKeyPress(event) {
    if (event.key === 'Enter') {
        searchMovies();
    }
}

// Função para avaliar um filme (para ser implementada)
function rateMovie(movieId, movieTitle) {
    console.log(`Avaliar o filme: ${movieTitle} (ID: ${movieId})`);
    // Lógica para avaliar o filme aqui
}

// Escurecer a navbar ao rolar
$(window).on('scroll', function() {
    const navbar = $('#navbar');
    if ($(document).scrollTop() > 50) {
        navbar.addClass('navbar-scrolled'); // Adiciona classe para escurecer
    } else {
        navbar.removeClass('navbar-scrolled'); // Remove classe
    }
});

// Adicionar favorito
function adicionarFavorito(movieId) {
    $.post('../scripts/adicionar_favoritos.php', { movie_id: movieId }, function(response) {
        alert(response);
    });
}

// Remover favorito
function removerFavorito(movieId) {
    $.post('../scripts/remover_favoritos.php', { movie_id: movieId }, function(response) {
        alert(response);
    });
}

// Event listener para botão de avaliar
$(document).on('click', '.rate-movie-btn', function() {
    const movieId = $(this).data('id');
    const movieTitle = $(this).data('title');
    rateMovie(movieId, movieTitle);
});
