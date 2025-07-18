<?php
require_once 'functions.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = trim($_POST['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Por favor, insere um email válido.";
        } else {
            $pdo = connect_db();
            $stmt = $pdo->prepare("SELECT * FROM players WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                // Gerar token seguro para reset de password
                $token = bin2hex(random_bytes(16));
                $expires = date("Y-m-d H:i:s", time() + 3600); // 1 hora de validade

                // Atualizar utilizador com token e data de expiração
                $update = $pdo->prepare("UPDATE players SET reset_token = ?, reset_expires_at = ? WHERE email = ?");
                $update->execute([$token, $expires, $email]);

                require_once 'send_email.php';

                // Link absoluto para reset de password (ajusta para o domínio real depois)
                $link = "http://localhost/star_sky/reset_password.php?token=$token";

                $assunto = "Recuperação de Palavra-passe - Star Sky";
                $mensagem = "<p>Clica no link abaixo para redefinir a tua password:</p>
                             <p><a href='$link'>$link</a></p>";

                $resultado = enviarEmail($email, $assunto, $mensagem);

                $msg = $resultado === true ? "Enviámos o link para o teu email." : "Erro ao enviar email: " . htmlspecialchars($resultado);
            } else {
                // Mensagem neutra por segurança
                $msg = "Se o email existir, enviámos o link.";
            }
        }
    } catch (Exception $e) {
        $msg = "Ocorreu um erro: " . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Password | Star Sky</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="forgot_password.css">
</head>
<body>
    <div class="login-bg"></div>
    <div class="forgot-container" role="main">
        <div class="logo"><img src="../img/Star_Sky_logo.png" alt="Logo Star Sky" /></div>
        <form method="POST" class="forgot-form" aria-labelledby="forgot-title">
            <h2 id="forgot-title">Recuperar Password</h2>
            <label for="email">Email</label>
            <input name="email" id="email" type="email" placeholder="O teu email" required autofocus>
            <button type="submit" class="main-btn">Enviar link</button>
            <?php if ($msg): ?>
                <div class="msg" role="alert"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>
        </form>
        <a href="login.php" class="back-link" aria-label="Voltar ao login">⬅️ Voltar</a>
    </div>
</body>
</html>