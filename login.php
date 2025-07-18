<?php
session_start();
require_once 'functions.php';

$msg = '';

// Processa o login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email == '' || $password == '') {
        $msg = 'Preencha todos os campos.';
    } else {
        $pdo = connect_db();
        // Busca também o campo is_admin!
        $stmt = $pdo->prepare("SELECT id, email, password, username, is_admin FROM players WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Login com sucesso
                $_SESSION['player_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];
                header("Location: game.php");
                exit;
            } else {
                $msg = 'Password incorreta.';
            }
        } else {
            // Email não existe, redireciona para registo
            $_SESSION['new_email'] = $email;
            header("Location: register.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Star Sky - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-bg"></div>
    <div class="login-page-container" role="main">
        <div class="logo" aria-label="Logo Star Sky">
            <img src="img/star_sky_logo.png" alt="Logo do Star Sky" />
        </div>
        <form class="login-form" method="post" autocomplete="off" aria-labelledby="login-title">
            <h2 id="login-title">Entrar no Universo Star Sky</h2>
            <?php if($msg): ?>
                <div class="msg" role="alert"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="O teu email" required autofocus autocomplete="username">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required autocomplete="current-password">
            <button type="submit" class="main-btn">Entrar</button>
            <div class="login-links">
                <a href="register.php">Criar conta</a>
                <a href="recover.php">Recuperar password</a>
            </div>
        </form>
        <a href="index.php" class="back-link" aria-label="Voltar ao início">Voltar</a>
    </div>
</body>
</html>