<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha]);
        echo "Usuário registrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao registrar usuário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVOX - Registre-se</title>
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
        <h2>Registrar-se</h2>
        <form method="POST" action="">
            Nome: <input type="text" name="nome" required>
            Email: <input type="email" name="email" required>
            Senha: <input type="password" name="senha" required>
            <button type="submit">Registrar</button>
        </form>

        <p>Login: <a href="login.php">Login</a></p>
    </div>
</body>

</html>