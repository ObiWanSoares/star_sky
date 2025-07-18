<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['player_id'])) {
    header('Location: login.php');
    exit;
}

$pdo = connect_db();

// Buscar info da raça real
$char = $_SESSION['character_creation'];
$race_stmt = $pdo->prepare("SELECT id, name, image_url, bonus_json FROM races WHERE id = ?");
$race_stmt->execute([$char['race']]);
$race_row = $race_stmt->fetch(PDO::FETCH_ASSOC);

// Gerar imagem da raça, igual ao passo 2
$race_img_name = strtolower(htmlspecialchars($race_row['name']));
$gender_pt = $_SESSION['character_creation']['gender'] ?? 'masculino';
$gender_map = [
    'masculino' => 'male',
    'feminino' => 'female',
    'android' => 'android'
];
$gender = $gender_map[$gender_pt] ?? 'male';
$race_img = "img/{$race_img_name}_{$gender}.jpg";

// Normalizar os bónus da raça
$bonus_skills = [];
if (!empty($race_row['bonus_json'])) {
    $bonus_skills_raw = json_decode($race_row['bonus_json'], true) ?? [];
    foreach ($bonus_skills_raw as $skill_name => $val) {
        $bonus_skills[mb_strtolower(trim($skill_name), 'UTF-8')] = intval($val);
    }
}

// Buscar habilidades reais da BD
$stmt = $pdo->query("SELECT id, name FROM skills ORDER BY id ASC");
$skills_list = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (mb_strtolower($row['name'], 'UTF-8') !== 'haki') {
        $skills_list[$row['name']] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'key' => mb_strtolower(trim($row['name']), 'UTF-8')
        ];
    }
}

// Inicialização dos valores das skills (usando bónus da raça se existirem)
$initial_skills = [];
foreach ($skills_list as $skill_name => $info) {
    $key = $info['key'];
    $initial_skills[$skill_name] = isset($bonus_skills[$key]) ? $bonus_skills[$key] : 0;
}
// Se vierem do POST, mantém
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['skills'] ?? [] as $skill_name => $val) {
        $initial_skills[$skill_name] = intval($val);
    }
}

$max_points = 7;
$max_per_skill = 10;
$min_per_skill = -1;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skills = $_POST['skills'] ?? [];
    $skills = array_map('intval', $skills);

    // Calcula pontos distribuídos (o jogador só pode usar 7 pontos, que são somados aos bónus da raça)
    $total = 0;
    foreach ($skills_list as $skill_name => $info) {
        $key = $info['key'];
        $base = isset($bonus_skills[$key]) ? $bonus_skills[$key] : 0;
        $current = isset($skills[$skill_name]) ? intval($skills[$skill_name]) : $base;
        $total += max(0, $current - $base);
    }

    if (count($skills) !== count($skills_list)) {
        $errors[] = "Preenche todas as habilidades.";
    }
    if ($total > $max_points) {
        $errors[] = "Distribuíste pontos a mais. Total: $total/$max_points";
    }
    if ($total < $max_points) {
        $errors[] = "Ainda tens pontos para distribuir. Total: $total/$max_points";
    }
    foreach ($skills_list as $skill_name => $info) {
        $key = $info['key'];
        $base = isset($bonus_skills[$key]) ? $bonus_skills[$key] : 0;
        $val = isset($skills[$skill_name]) ? intval($skills[$skill_name]) : $base;
        if ($val < $base) {
            $errors[] = "Não podes reduzir a habilidade abaixo do valor inicial (" . $base . ") para " . htmlspecialchars($skill_name) . ".";
            break;
        }
        if ($val < $min_per_skill) {
            $errors[] = "Nenhuma habilidade pode ficar abaixo de $min_per_skill.";
            break;
        }
        if ($val > $max_per_skill) {
            $errors[] = "Nenhuma habilidade pode exceder $max_per_skill.";
            break;
        }
    }

    if (!$errors) {
        $player_id = $_SESSION['player_id'];

        // Atualiza nome da personagem no jogador
        $stmt = $pdo->prepare("UPDATE players SET char_name=? WHERE id=?");
        $ok = $stmt->execute([
            $char['char_name'] ?? '', $player_id
        ]);

        // Cria personagem na tabela characters
        $stmt_char = $pdo->prepare("INSERT INTO characters (nome, player_id) VALUES (?, ?)");
        $stmt_char->execute([$char['char_name'], $player_id]);
        $character_id = $pdo->lastInsertId();

        // Remove habilidades antigas do personagem
        $del_stmt = $pdo->prepare("DELETE FROM character_skill WHERE character_id = ?");
        $del_stmt->execute([$character_id]);

        // Insere habilidades novas
        $ins_stmt = $pdo->prepare("INSERT INTO character_skill (character_id, skill_id, level) VALUES (?, ?, ?)");
        foreach ($skills_list as $skill_name => $info) {
            $level = isset($skills[$skill_name]) ? intval($skills[$skill_name]) : $initial_skills[$skill_name];
            $ins_stmt->execute([$character_id, $info['id'], $level]);
        }

        if ($ok) {
            unset($_SESSION['character_creation']);
            header('Location: game.php');
            exit;
        } else {
            $errors[] = "Erro ao guardar personagem na base de dados.";
        }
    }
}

// Corrigir género para começar com maiúscula
$genero = isset($char['gender']) ? ucfirst(mb_strtolower($char['gender'], 'UTF-8')) : '';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criação de Personagem - Passo 4</title>
    <link rel="stylesheet" href="choose_character_3.css">
</head>
<body>
    <div class="main-character-wrap">
        <aside class="char-sidebar">
            <div class="char-sidebar-inner">
                <div class="char-avatar-box" style="margin-top: 18px;">
                    <img src="<?= htmlspecialchars($race_img) ?>" alt="Raça escolhida" class="char-avatar-img">
                </div>
                <div class="char-sidebar-info">
                    <div class="char-info-label">Nome:</div>
                    <div class="char-info-value"><?= htmlspecialchars($char['char_name'] ?? '') ?></div>
                    <div class="char-info-label">Género:</div>
                    <div class="char-info-value"><?= htmlspecialchars($genero) ?></div>
                </div>
            </div>
        </aside>
        <main class="char-main">
            <div class="character-logo">
                <img src="img/star_sky_logo.png" alt="Star Sky Logo" />
            </div>
            <div class="char-content-center">
                <div class="character-step-container" style="display: flex; align-items: center; background: rgba(20,30,44,0.78); border-radius: 10px; padding: 20px 40px; margin-bottom: 18px; width: 100%; min-height: 44px; justify-content: flex-start;">
                    <span class="character-step-title" style="margin: 0; padding: 0; white-space: nowrap;">Passo 4: Distribui os Pontos de Habilidade</span>
                </div>
                <div class="skills-points-remaining">
                    Pontos restantes: <span id="points-remaining"><?= $max_points - array_sum(array_map(function($name, $info) use ($bonus_skills, $initial_skills) {
                        $key = $info['key'];
                        $base = isset($bonus_skills[$key]) ? $bonus_skills[$key] : 0;
                        return max(0, $initial_skills[$name] - $base);
                    }, array_keys($skills_list), $skills_list)) ?></span> / <?= $max_points ?>
                </div>
                <?php foreach ($errors as $error): ?>
                    <div class="form-error"><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
                <form method="post" class="skills-form" id="skills-form" autocomplete="off">
                    <div class="skills-list">
                        <?php foreach ($skills_list as $skill_name => $info):
                            $key = $info['key'];
                            $value = intval($initial_skills[$skill_name] ?? 0);
                            ?>
                        <div class="skill-row" data-skill="<?= htmlspecialchars($skill_name) ?>">
                            <span class="skill-label"><?= htmlspecialchars($skill_name) ?></span>
                            <div class="skill-controls">
                                <button type="button" class="skill-btn skill-minus" aria-label="Diminuir <?= htmlspecialchars($skill_name) ?>">-1</button>
                                <span class="skill-value" id="skill-<?= htmlspecialchars($skill_name) ?>"><?= $value ?></span>
                                <button type="button" class="skill-btn skill-plus" aria-label="Aumentar <?= htmlspecialchars($skill_name) ?>">+1</button>
                                <input type="hidden" name="skills[<?= htmlspecialchars($skill_name) ?>]" value="<?= $value ?>">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="finalize-btn" id="finalize-btn" disabled>Finalizar Processo de Criação de Personagem</button>
                </form>
            </div>
        </main>
    </div>
    <a href="choose_character_2.php" class="back-link">Voltar</a>
    <script src="choose_character_3.js"></script>
</body>
</html>