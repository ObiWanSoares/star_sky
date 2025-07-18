<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['player_id']) || !isset($_SESSION['character_creation'])) {
    header('Location: login.php');
    exit;
}

// Fetch playable races from DB
$pdo = connect_db();
$stmt = $pdo->prepare("SELECT id, name, description, bonus_json FROM races WHERE is_playable = 1 ORDER BY name ASC");
$stmt->execute();
$races = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get player gender and convert from PT to EN
$gender_pt = $_SESSION['character_creation']['gender'] ?? 'masculino';
$gender_map = [
    'masculino' => 'male',
    'feminino' => 'female',
    'android' => 'android'
];
$gender = $gender_map[$gender_pt] ?? 'male';

// Utility for pretty bonus string
function format_bonus($bonus_json) {
    $bonus = json_decode($bonus_json, true);
    $lines = [];
    foreach ($bonus as $skill => $value) {
        $label = ucfirst($skill);
        $sign = $value > 0 ? "+" : "";
        $lines[] = "{$label}: {$sign}{$value}";
    }
    return implode(" | ", $lines);
}

// Handle POST "Próximo"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_race_submit'])) {
    $selected_race = $_POST['selected_race'];
    $race_ids = array_column($races, 'id');
    if (in_array($selected_race, $race_ids)) {
        $_SESSION['character_creation']['race'] = $selected_race;
        header('Location: choose_character_3.php');
        exit;
    }
}
// Handle GET/POST "Voltar"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['back'])) {
    header('Location: choose_character_1.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Passo 2: Escolhe a tua raça</title>
    <link rel="stylesheet" href="choose_character_2.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="character-logo">
        <img src="img/star_sky_logo.png" alt="Star Sky Logo" />
    </div>
    <div class="step-title-container">
        <h2 class="character-step-title">Passo 2: Escolhe a tua raça</h2>
    </div>
    <form id="race-selection-form" method="post" autocomplete="off">
        <div class="race-cards">
            <?php foreach ($races as $race): 
                $race_img_name = strtolower(htmlspecialchars($race['name']));
                $img_path = "img/{$race_img_name}_{$gender}.jpg";
            ?>
                <label class="race-card">
                    <input type="radio" name="selected_race" value="<?= htmlspecialchars($race['id']) ?>" style="display:none;">
                    <div class="race-card-btn">
                        <div class="race-img">
                            <img src="<?= $img_path ?>" alt="<?= htmlspecialchars($race['name']) ?> <?= $gender ?>" onerror="this.onerror=null;this.src='img/placeholder.jpg';">
                        </div>
                        <div class="race-title"><?= htmlspecialchars($race['name']) ?></div>
                        <div class="race-desc"><?= htmlspecialchars($race['description']) ?></div>
                        <div class="race-bonus"><?= format_bonus($race['bonus_json']) ?></div>
                    </div>
                </label>
            <?php endforeach; ?>
        </div>
        <div class="bottom-buttons">
            <button type="submit" name="back" class="back-btn">Voltar</button>
            <button type="submit" name="selected_race_submit" class="next-btn" id="next-btn" disabled>Próximo</button>
        </div>
    </form>
    <script src="choose_character_2.js"></script>
</body>
</html>