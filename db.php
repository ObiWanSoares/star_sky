<?php
// db.php - ligação PDO à base de dados star_sky

// Certifica-te que a extensão PDO está carregada
if (!extension_loaded('pdo_mysql')) {
    die('A extensão PDO MySQL não está instalada.');
}

// Detectar se estás local ou online (Render)
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1') {
    // Localhost
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'star_sky');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    // ONLINE (Render, Railway, etc.)
    define('DB_HOST', 'host_do_railway');
    define('DB_NAME', 'nome_da_base_de_dados');
    define('DB_USER', 'utilizador');
    define('DB_PASS', 'password');
}

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
        die("Erro na ligação à base de dados: " . $e->getMessage());
    }
}
?>