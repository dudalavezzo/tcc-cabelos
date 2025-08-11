<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "pw_bd"; // Substitua pelo nome real

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
