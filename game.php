<?php
session_start();
require_once 'functions.php';

// Verifica se o jogador está autenticado
if (!isset($_SESSION['player_id'])) {
    header('Location: login.php');
    exit;
}

$pdo = connect_db();
$player_id = $_SESSION['player_id'];

// Buscar nome da personagem do jogador
$stmt = $pdo->prepare("SELECT char_name FROM players WHERE id = ?");
$stmt->execute([$player_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$char_name = $row ? $row['char_name'] : 'Jogador';

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo ao Star Sky</title>
    <link rel="stylesheet" href="game.css">
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-title">Bem-vindo à Star Sky!</div>
        <div class="welcome-player">Jogador: <strong><?= htmlspecialchars($char_name) ?></strong></div>
    </div>
</body>
</html>