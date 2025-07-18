<?php
session_start();
require_once 'functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = connect_db();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email inválido.";
    } elseif ($password !== $password2) {
        $error = "As passwords não coincidem.";
    } elseif (strlen($password) < 4) {
        $error = "A password deve ter pelo menos 4 caracteres.";
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM players WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $error = "Já existe uma conta com esse email.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO players (email, password) VALUES (?, ?)");
            $stmt->execute([$email, password_hash($password, PASSWORD_DEFAULT)]);
            $playerId = $pdo->lastInsertId();
            $_SESSION['player_id'] = $playerId;
            header('Location: choose_character_1.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Conta | Star Sky</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="register-bg"></div>
    <div class="register-container" role="main">
        <div class="register-logo">
            <img src="img/star_sky_logo.png" alt="Logo Star Sky">
        </div>
        <form method="post" class="register-form" autocomplete="off" aria-labelledby="reg-title">
            <h2 id="reg-title">Criar Conta em Star Sky</h2>
            <?php if ($error): ?>
                <div class="error" role="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required autocomplete="email" placeholder="O teu email">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required minlength="4" autocomplete="new-password" placeholder="Password">
            <label for="password2">Confirmar Password:</label>
            <input type="password" name="password2" id="password2" required minlength="4" autocomplete="new-password" placeholder="Confirmar password">
            <button type="submit" class="main-btn">Criar Conta</button>
            <div class="login-link">
                <a href="login.php" class="back-link">Já tens conta? Fazer login!</a>
            </div>
        </form>
    </div>
</body>
</html>