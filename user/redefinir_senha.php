<?php
include '../config/db_config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['email_recuperacao'])) {
    $codigo = $_POST['codigo'];
    $nova_senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);

    if ($codigo == $_SESSION['codigo_recuperacao']) {
        $email = $_SESSION['email_recuperacao'];
        $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
        if ($stmt->execute([$nova_senha, $email])) {
            echo "Senha alterada com sucesso!";
            session_unset(); // Limpa a sessão
            session_destroy();
        } else {
            echo "Erro ao redefinir a senha.";
        }
    } else {
        echo "Código de recuperação inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVOX - Redefinir Senha</title>
    <link rel="stylesheet" href="../assets/css/register.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="navbar">
        <a class="navbar-brand" href="../public/index.php">
            <img src="../assets/img/CineVOX.png" alt="logo" style="width: 100px;">
        </a>
    </nav>

    <div class="form-container">
        <form method="POST" action="">
            Código de Recuperação: <input type="text" name="codigo" required>
            Nova Senha: <input type="password" name="nova_senha" required>
            <button type="submit">Redefinir Senha</button>
        </form>
    </div>
</body>

</html>