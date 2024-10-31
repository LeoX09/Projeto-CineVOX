<?php
include 'db_config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        $codigo = rand(100000, 999999); // Gera um código de recuperação
        $_SESSION['codigo_recuperacao'] = $codigo;
        $_SESSION['email_recuperacao'] = $email;

        // Aqui, você enviaria o código para o email do usuário
        echo "Código de recuperação enviado para seu email!";
    } else {
        echo "Email não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVOX - Recuperação</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="navbar">
        <a class="navbar-brand" href="index.php">
            <img src="img/CineVOX.png" alt="logo" style="width: 100px;">
        </a>
    </nav>

    <div class="form-container">
    <h2>Recuperação de senha</h2>
        <form method="POST" action="">
            Email: <input type="email" name="email" required>
            <button type="submit">Enviar Código de Recuperação</button>
        </form>

        <p>Voltar ao <a href="login.php">login</a></p>
    </div>
</body>

</html>