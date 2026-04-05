<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gestao_escolar";

$conn = new mysqli($host, $user, $pass, $db);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Garante que nomes com acento (João, José) funcionem no banco
$conn->set_charset("utf8mb4");
?>