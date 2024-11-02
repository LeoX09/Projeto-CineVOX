<nav class="navbar col-12 navbar-expand-lg navbar-dark fixed-top mb-3" id="navbar">
    <div class="container-fluid col-11 m-auto">
        <a class="navbar-brand" href="../public/index.php">
            <img src="../assets/img/CineVOX.png" alt="logo" style="width: 100px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link active" href="../public/index.php">Populares</a></li>
                <li class="nav-item"><a class="nav-link active" href="../public/categorias.php">Categorias</a></li>
                <li class="nav-item"><a class="nav-link active" href="../public/favoritos.php">Favoritos</a></li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="buscar.php" method="GET">
                <div class="input">
                    <input class="form-control mr-sm-2" type="search" name="query" id="search-input" placeholder="Buscar filmes..." aria-label="Pesquisar">
                    <i class="bi bi-search"></i>
                </div>
            </form>
            <a href="../user/login.php" class="nav-item nav-link text-white"><i class="bi bi-person-circle" style="font-size: 30px;"></i></a>
        </div>
    </div>
</nav>