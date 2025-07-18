<?php
// functions.php - Funções utilitárias do Star Sky

require_once __DIR__ . '/db.php';

/**
 * Faz login do utilizador (guarda dados na sessão)
 * @param array $user Dados do utilizador (array da tabela players)
 */
function login_user($user) {
    $_SESSION['player_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['is_admin'] = $user['is_admin'] ?? 0;
}

/**
 * Faz logout do utilizador (remove sessão)
 */
function logout_user() {
    session_unset();
    session_destroy();
}

/**
 * Verifica se o utilizador está autenticado
 * @return bool
 */
function is_logged_in() {
    return isset($_SESSION['player_id']);
}

/**
 * Devolve o username do utilizador autenticado, ou null se não houver
 * @return string|null
 */
function current_username() {
    return $_SESSION['username'] ?? null;
}

/**
 * Devolve o ID do utilizador autenticado, ou null se não houver
 * @return int|null
 */
function current_user_id() {
    return $_SESSION['player_id'] ?? null;
}

/**
 * Verifica se o utilizador autenticado é admin
 * @return bool
 */
function is_admin() {
    return !empty($_SESSION['is_admin']);
}

/**
 * Obtém os dados completos do utilizador autenticado (diretamente da base de dados)
 * @return array|null
 */
function get_current_player() {
    if (!is_logged_in()) return null;
    $pdo = connect_db();
    $stmt = $pdo->prepare("SELECT * FROM players WHERE id = ?");
    $stmt->execute([$_SESSION['player_id']]);
    return $stmt->fetch() ?: null;
}

/**
 * Sanitiza uma string para HTML seguro (atalho)
 * @param string $string
 * @return string
 */
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Redireciona de forma segura para outra página
 * @param string $url
 */
function redirect($url) {
    header("Location: $url");
    exit;
}
?>