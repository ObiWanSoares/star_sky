<?php
// db.php - ligação PDO à base de dados star_sky

// Certifica-te que a extensão PDO está carregada
if (!extension_loaded('pdo_mysql')) {
    die('A extensão PDO MySQL não está instalada.');
}

// Configurações da base de dados (ajusta conforme o teu ambiente)
define('DB_HOST', 'localhost');
define('DB_NAME', 'star_sky'); // ou 'star_sky'
define('DB_USER', 'root');       // utilizador XAMPP padrão
define('DB_PASS', '');           // senha vazia padrão XAMPP

/**
 * Devolve ligação PDO ativa à base de dados.
 * Usa singleton (só liga uma vez por request).
 * @return PDO
 */
function connect_db() {
    static $pdo;
    if ($pdo) return $pdo;

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        $pdo->exec("SET NAMES 'utf8mb4'");
        return $pdo;
    } catch (PDOException $e) {
        // Em produção podes trocar por mensagem mais amigável ou logar o erro
        die("Erro na ligação à base de dados: " . $e->getMessage());
    }
}
?>