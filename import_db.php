<?php
$host = 'mainline.proxy.rlwy.net'; // Host público do Railway
$db   = 'railway';                  // Nome da base de dados
$user = 'root';                     // Utilizador
$pass = 'ooVjV5rUMqRDZRTiJttXlpELLTGVbFte'; // Palavra-passe
$port = 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro de ligação: " . $conn->connect_error);
}

// Lê o ficheiro SQL (deve estar no mesmo diretório)
$sql = file_get_contents('export.sql');

if ($conn->multi_query($sql)) {
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->next_result());
    echo "Importação concluída!";
} else {
    echo "Erro ao importar: " . $conn->error;
}

$conn->close();
?>