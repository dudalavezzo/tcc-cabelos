<?php
session_start();
include "conexao.php";

if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] !== 'cliente') {
    echo "Acesso não autorizado.";
    exit;
}

$login = $_SESSION['login'];
$data = $_POST['data'];
$hora = $_POST['hora'] . ":00"; // Ex: "10:00" → "10:00:00"
$salao_id = $_POST['salao_id'];

// Buscar ID do cliente
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();
$cliente_id = $cliente['id'];

// Verifica se o horário ainda está disponível
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM agendamentos WHERE salao_id = ? AND data = ? AND hora = ?");
$stmt->bind_param("iss", $salao_id, $data, $hora);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['total'] > 0) {
    echo "Este horário já foi agendado. Por favor, volte e escolha outro.";
    exit;
}

// Inserir agendamento
$stmt = $conn->prepare("INSERT INTO agendamentos (cliente_id, salao_id, data, hora) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $cliente_id, $salao_id, $data, $hora);
$stmt->execute();

echo "Agendamento realizado com sucesso!";
