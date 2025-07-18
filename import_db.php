<?php
$host = 'mainline.proxy.rlwy.net';
$db   = 'railway';
$user = 'root';
$pass = 'ooVjV5rUMqRDZRTiJttXlpELLTGVbFte';
$port = 3306;

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents('export.sql');
    $conn->exec($sql);

    echo "Importação concluída!";
} catch (PDOException $e) {
    echo "Erro ao importar: " . $e->getMessage();
}
?>