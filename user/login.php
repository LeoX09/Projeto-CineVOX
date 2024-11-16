<?php
session_start();
include '../config/db_config.php';

// Exibir erros para facilitar o debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Verificar se a conexão com o banco de dados está funcionando
    if (!$pdo) {
        throw new Exception("Falha na conexão com o banco de dados.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Preparar a consulta para buscar o usuário pelo email
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        // Verificar se o usuário existe e a senha está correta
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Armazenar o ID e o nome do usuário na sessão
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_name'] = $usuario['nome'];

            // Redirecionar para a página principal
            header("Location: ../public/index.php");
            exit(); // Encerrar o script após o redirecionamento
        } else {
            echo "Email ou senha inválidos.";
        }
    }
} catch (PDOException $e) {
    echo "Erro ao fazer login: " . $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVOX - Login</title>
    <link rel="stylesheet" href="../assets/css/register.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="../vendor/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="navbar">
        <a class="navbar-brand" href="../public/index.php">
            <img src="../assets/img/CineVOX.png" alt="logo" style="width: 100px;">
        </a>
    </nav>

    <div class="form-container">
        <h2>Login</h2>
        <form method="POST" action="">
            Email: <input type="email" name="email" placeholder="Digite seu email" require>
            <div class="senha-container">
               Senha: <input type="password" id="senha" name="senha" placeholder="Digite sua senha" require>
                <button type="button" id="toggle-eye">
                    <i id="eye-icon" class="bi bi-eye-slash"></i> <!-- Ícone de olho -->
                </button>
                <button type="submit">Login</button>
            </div>
        </form>

        <p><a href="../user/registro.php">Registrar-se</a></p>
    </div>

    <script src="../assets/js/toggleye.js"></script>
</body>

</html>