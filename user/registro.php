<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVOX - Registre-se</title>
    <link rel="stylesheet" href="../assets/css/register.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="../vendor/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
</head>

<body>
    <?php
    
    require_once '../config/db_config.php';

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Captura e sanitiza os dados do formulário
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha para segurança

        // Insere o novo usuário no banco de dados
        try {
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->execute();

            echo "<p>Registro realizado com sucesso!</p>";
        } catch (PDOException $e) {
            echo "<p>Erro ao registrar: " . $e->getMessage() . "</p>";
        }
    }
    ?>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="navbar">
        <a class="navbar-brand" href="../public/index.php">
            <img src="../assets/img/CineVOX.png" alt="logo" style="width: 100px;">
        </a>
    </nav>

    <div class="form-container">
        <h2>Registrar-se</h2>
        <form method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required placeholder="Seu nome de usuário">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Seu email">

            <div class="senha-container">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required placeholder="Sua senha">
                <button type="button" id="toggle-eye">
                    <i id="eye-icon" class="bi bi-eye-slash"></i> 
                </button>
            </div>

            <button type="submit">Registrar</button>
        </form>

        <p>Login: <a href="../user/login.php">Login</a></p>
    </div>

    <script src="../assets/js/toggleye.js"></script>
</body>

</html>