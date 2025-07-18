<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['player_id'])) {
    header('Location: login.php');
    exit;
}

$random_first_names = ["Nova", "Orion", "Lyra", "Kai", "Vega", "Cassio", "Riven", "Zara", "Atlas", "Mira"];
$random_last_names = ["Starborn", "Skye", "Voss", "Solaris", "Zenith", "Nebula", "Astra", "Quasar", "Dray", "Lucis"];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $char_name = trim($_POST['char_name'] ?? '');
    $gender = $_POST['gender'] ?? '';
    if ($char_name === '') $errors[] = "O nome da personagem é obrigatório.";
    if (!in_array($gender, ['masculino', 'feminino', 'android'])) $errors[] = "Por favor, escolhe o género.";

    if ($char_name !== '') {
        $pdo = connect_db();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM players WHERE LOWER(char_name) = LOWER(?)");
        $stmt->execute([$char_name]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = "Esse nome de personagem já existe. Escolhe outro!";
        }
    }
    if (!$errors) {
        $_SESSION['character_creation'] = [
            'char_name' => $char_name,
            'gender' => $gender
        ];
        header('Location: choose_character_2.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criação de Personagem - Passo 1</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="choose_character_1.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="logo-left">
        <img src="img/star_sky_logo.png" alt="Star Sky Logo" />
    </div>
    <div class="main-content">
        <div class="character-form-container">
            <form method="post" class="character-form" id="character-form" autocomplete="off">
                <h2>Passo 1: Nome & Género</h2>
                <?php foreach ($errors as $error): ?>
                    <div class="form-error"><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
                <div class="input-row">
                    <label for="char_name_input">Nome da Personagem:</label>
                    <input type="text" name="char_name" id="char_name_input" value="<?= htmlspecialchars($_POST['char_name'] ?? '') ?>" autocomplete="off" maxlength="30">
                    <button type="button" id="random-name-btn" class="random-name-btn">Gerar nome aleatório</button>
                </div>
                <div class="gender-section">
                    <div class="gender-label-row">
                        <label>Género:</label>
                        <span class="gender-tip" title="A escolha do género é apenas para personalização visual e narrativa, não afeta habilidades nem progresso no jogo.">?</span>
                    </div>
                </div>
            </form>
        </div>
        <div class="gender-cards-row">
            <label class="gender-card<?= (($_POST['gender'] ?? '') === 'masculino') ? ' selected' : '' ?>">
                <input type="radio" name="gender" value="masculino" <?= (($_POST['gender'] ?? '') === 'masculino') ? 'checked' : '' ?> form="character-form" required>
                <div class="gender-card-content">
                    <div class="gender-icon">
                        <img src="img/genero_homem.png" alt="Homem" class="gender-img" />
                    </div>
                    <div class="gender-info">
                        <span class="gender-title">Homem</span>
                        <span class="gender-desc">Forte, clássico e pronto para a aventura.</span>
                    </div>
                </div>
            </label>
            <label class="gender-card<?= (($_POST['gender'] ?? '') === 'feminino') ? ' selected' : '' ?>">
                <input type="radio" name="gender" value="feminino" <?= (($_POST['gender'] ?? '') === 'feminino') ? 'checked' : '' ?> form="character-form" required>
                <div class="gender-card-content">
                    <div class="gender-icon">
                        <img src="img/genero_mulher.png" alt="Mulher" class="gender-img" />
                    </div>
                    <div class="gender-info">
                        <span class="gender-title">Mulher</span>
                        <span class="gender-desc">Elegante, destemida e cheia de coragem.</span>
                    </div>
                </div>
            </label>
            <label class="gender-card<?= (($_POST['gender'] ?? '') === 'android') ? ' selected' : '' ?>">
                <input type="radio" name="gender" value="android" <?= (($_POST['gender'] ?? '') === 'android') ? 'checked' : '' ?> form="character-form" required>
                <div class="gender-card-content">
                    <div class="gender-icon">
                        <img src="img/genero_androide.png" alt="Android" class="gender-img" />
                    </div>
                    <div class="gender-info">
                        <span class="gender-title">Android</span>
                        <span class="gender-desc">Tecnológico, misterioso e imparável.</span>
                    </div>
                </div>
            </label>
        </div>
        <div class="action-row">
            <a href="index.php" class="back-link">Voltar</a>
            <button type="submit" form="character-form" class="main-btn">Próximo</button>
        </div>
    </div>
    <script>
    window.randomNamesFirst = <?= json_encode($random_first_names) ?>;
    window.randomNamesLast = <?= json_encode($random_last_names) ?>;
    document.addEventListener("DOMContentLoaded", function () {
        // Cartão selecionado ao escolher género
        document.querySelectorAll('.gender-card input[type="radio"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.gender-card').forEach(function(card){ card.classList.remove('selected'); });
                radio.closest('.gender-card').classList.add('selected');
            });
        });
        // Gerador de nome aleatório funcional
        document.getElementById('random-name-btn').addEventListener('click', function() {
            function gerarNome() {
                let first = window.randomNamesFirst[Math.floor(Math.random() * window.randomNamesFirst.length)];
                let last = window.randomNamesLast[Math.floor(Math.random() * window.randomNamesLast.length)];
                return first + ' ' + last;
            }
            let nome = gerarNome();
            document.getElementById('char_name_input').value = nome;
        });
    });
    </script>
</body>
</html>