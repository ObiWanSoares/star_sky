<?php
require_once 'functions.php';
$pdo = connect_db();

$token = $_GET['token'] ?? '';
$msg = "";

// Verificar o token quando a página é acedida
if ($token && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $stmt = $pdo->prepare("SELECT id FROM players WHERE reset_token = ? AND reset_expires_at > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    if (!$user) {
        $msg = "Token inválido ou expirado.";
        $token = '';
    }
}

// Submissão do formulário: redefinir password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    if (strlen($password) < 4) {
        $msg = "A password deve ter pelo menos 4 caracteres.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM players WHERE reset_token = ? AND reset_expires_at > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        if ($user) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE players SET password = ?, reset_token = NULL, reset_expires_at = NULL WHERE id = ?");
            $stmt->execute([$hash, $user['id']]);
            $msg = "Password alterada com sucesso! <a href='login.php'>Entrar</a>";
            $token = '';
        } else {
            $msg = "Token inválido ou expirado.";
            $token = '';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Password | Star Sky</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="reset_password.css">
</head>
<body>
    <div class="login-bg"></div>
    <div class="reset-container" role="main">
        <div class="logo"><img src="../img/Star_Sky_logo.png" alt="Logo Star Sky" /></div>
        <h2>Redefinir Password</h2>
        <?php if ($msg): ?>
            <div class="msg" role="alert"><?= $msg ?></div>
        <?php endif; ?>
        <?php if ($token): ?>
        <form method="post" class="reset-form" autocomplete="off">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <label for="password">Nova password:</label>
            <input type="password" name="password" id="password" required autofocus minlength="4" placeholder="Nova password">
            <button type="submit" class="main-btn">Redefinir</button>
        </form>
        <?php endif; ?>
        <a href="login.php" class="back-link" aria-label="Voltar ao login">⬅️ Voltar</a>
    </div>
</body>
</html>