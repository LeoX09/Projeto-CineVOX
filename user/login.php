<?php
session_start();
include '../config/db_config.php';

// Exibir erros para facilitar o debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Verificação se o bd está funcionando
    if (!$pdo) {
        throw new Exception("Falha na conexão com o banco de dados.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = htmlspecialchars(trim($_POST['email']));
        $senha = htmlspecialchars(trim($_POST['senha']));

        // Verificar se os campos não estão vazios
        if (empty($email) || empty($senha)) {
            throw new Exception("Por favor, preencha todos os campos.");
        }

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
            exit();
        } else {
            $error_message = "Email ou senha inválidos.";
        }
    }
} catch (PDOException $e) {
    $error_message = "Erro ao fazer login: " . $e->getMessage();
} catch (Exception $e) {
    $error_message = $e->getMessage();
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
        
        <!-- Mensagem de erro -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Digite seu email" required>

            <div class="senha-container">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                <button type="button" id="toggle-eye" tabindex="-1">
                    <i id="eye-icon" class="bi bi-eye-slash"></i>
                </button>
            </div>

            <button type="submit">Login</button>
        </form>

        <p><a href="../user/registro.php">Registrar-se</a></p>
    </div>
    
    <script src="../assets/js/toggleye.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
