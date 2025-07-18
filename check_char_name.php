<?php
require_once 'functions.php';
$name = trim($_GET['name'] ?? '');
$pdo = connect_db();
$stmt = $pdo->prepare("SELECT COUNT(*) FROM players WHERE LOWER(char_name) = LOWER(?)");
$stmt->execute([$name]);
echo json_encode(['exists' => $stmt->fetchColumn() > 0]);