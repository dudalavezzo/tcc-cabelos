<?php
include "conexao.php";

if (!isset($_GET['lat']) || !isset($_GET['lon'])) {
    echo json_encode([]);
    exit;
}

$lat = floatval($_GET['lat']);
$lon = floatval($_GET['lon']);

// Busca os salões sem filtrar distância ainda, isso pode ser otimizado depois
$sql = "SELECT id, nome, endereco, latitude, longitude FROM saloes";
$result = $conn->query($sql);

$saloes = [];

while ($row = $result->fetch_assoc()) {
    $saloes[] = $row;
}

echo json_encode($saloes);
