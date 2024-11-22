<?php
// Verificar se a sessão já foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top mb-3" id="navbar">
    <div class="container-fluid col-11 m-auto">
        <a class="navbar-brand" href="../public/index.php">
            <img src="../assets/img/CineVOX.png" alt="logo" style="width: 100px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link active" href="../public/index.php">Populares</a></li>
                <li class="nav-item"><a class="nav-link" href="../public/categorias.php">Categorias</a></li>
                <li class="nav-item"><a class="nav-link" href="../public/favoritos.php">Favoritos</a></li>
                <li class="nav-item"><a class="nav-link" href="../public/comentarios.php">Comentários</a></li>
            </ul>
            <form class="form-inline my-2 my-lg-0 mx-lg-2" action="../public/buscar.php" method="GET">
                <div class="input">
                    <input class="form-control mr-sm-2" type="search" name="query" id="search-input" placeholder="Buscar filmes..." aria-label="Pesquisar">
                    <i class="bi bi-search"></i>
                </div>
            </form>
            <?php if (isset($_SESSION['user_name'])): ?>
                <span class="nav-item nav-link text-white">Olá, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="../user/logout.php" class="nav-item nav-link text-white"><i class="bi bi-box-arrow-right"></i></a>
            <?php else: ?>
                <a href="../user/login.php" class="nav-item nav-link text-white"><i class="bi bi-person-circle" style="font-size: 30px;"></i></a>
            <?php endif; ?>
        </div>
    </div>
</nav>
