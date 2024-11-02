<button onclick="showMyReviews()">Minhas Avaliações</button>

Carroussel tá dando muito B.O
    <div id="Carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/home2.jpg" class="d-block w-100" alt="Filme 1">
            </div>
            <div class="carousel-item">
                <img src="img/home1.jpg" class="d-block w-100" alt="Filme 2">
            </div>
            <div class="carousel-item">
                <img src="img/home3.jpg" class="d-block w-100" alt="Filme 3">
            </div>
        </div>

        <a class="carousel-control-prev" href="#movieCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#movieCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

/* Estilo do Carrossel */
#movieCarousel {
    width: auto;
    margin: auto; /* Centraliza o carrossel e adiciona margem superior */
    overflow: hidden; /* Esconde partes das imagens que saem da área */
}

.carousel-item img {
    height: 450px; /* Altura fixa para todas as imagens */
    width: 100%;
    object-fit: fill; /* Corta as imagens para preencher o espaço sem distorcer */
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0); /* Fundo semitransparente para os ícones */
}

.carousel-control-prev-icon:focus,
.carousel-control-next-icon:focus {
    outline: none; /* Remove o contorno de foco */
}

    $pdo = new PDO("sqlite:C:/Users/leand/OneDrive/Documentos/projeto_dev.web/projeto_cinevox/usuarios.sqlite");

Deixa pro sistema de favoritos quando o sistema de conta estiver feito

   <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="../public/index.php">
                <img src="../assets/img/CineVOX.png" alt="logo" style="width: 100px;">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Alterna navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link active" href="../public/index.php">Populares</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link active" href="../public/categorias.php">Categorias</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link active" href="../public/favoritos.php">Favoritos</a>
                    </li>
                </ul>

                <form class="form-inline my-2 my-lg-0" action="../public/buscar.php" method="GET">
                    <div class="input">
                        <input class="form-control mr-sm-2" type="search" name="query" id="search-input" placeholder="Buscar filmes..." aria-label="Pesquisar">
                        <i class="bi bi-search"></i>
                    </div>
                </form>

                <div class="align-self-end">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="../user/login.php" class="text-white"><i class="bi bi-person-circle" style="font-size: 30px;"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    Toda função da info_filmes ébuscada dentro da pasta helpers.php.

    A parte dos Users, possui uma barra de navegação diferente pois não quero que nessa parte do site ele só tenha acesso a página inicial