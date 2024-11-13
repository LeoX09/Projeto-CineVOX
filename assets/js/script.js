// Função para buscar filmes na API do TMDB
function searchMovies() {
    const query = document.getElementById('search-input').value;
    if (!query) return;

    const apiUrl = `https://api.themoviedb.org/3/search/movie?api_key=849679f956996f27d90a29bc51be2519&query=${encodeURIComponent(query)}&language=pt-BR`;

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const resultsContainer = document.getElementById('search-results');
            resultsContainer.innerHTML = ''; // Limpa os resultados anteriores

            if (data.results.length === 0) {
                resultsContainer.innerHTML = '<p>Nenhum filme encontrado.</p>';
                return;
            }   

            data.results.forEach(movie => {
                const movieCard = document.createElement('div');
                movieCard.classList.add('movie-card');
                movieCard.innerHTML = `
                    <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" alt="${movie.title}">
                    <h3>${movie.title}</h3>
                    <p>Nota: ${movie.vote_average}</p>
                    <button onclick="rateMovie('${movie.id}', '${movie.title}')">Avaliar</button>
                `;
                resultsContainer.appendChild(movieCard);
            });
        })
        .catch(error => console.error('Erro ao buscar filmes:', error));
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

// Função para escurecer a navbar ao rolar
window.onscroll = function() {
    const navbar = document.getElementById('navbar');
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        navbar.classList.add('navbar-scrolled'); // Adiciona classe para escurecer
    } else {
        navbar.classList.remove('navbar-scrolled'); // Remove classe
    }
};

function adicionarFavorito(movieId) {
    $.post('../scripts/adicionar_favoritos.php', { movie_id: movieId }, function(response) {
        alert(response);
    });
}

function removerFavorito(movieId) {
    $.post('../scripts/remover_favoritos.php', { movie_id: movieId }, function(response) {
        alert(response);
    });
}
