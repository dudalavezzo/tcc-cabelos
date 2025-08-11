<?php
session_start();
include "conexao.php";

if (!isset($_SESSION['login']) || $_SESSION['tipo'] !== 'salao') {
    echo "Acesso negado.";
    exit;
}

$login = $_SESSION['login'];
$data = $_POST['data'];
$hora = $_POST['hora'];

// Buscar ID do salão logado
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$res = $stmt->get_result();
$usuario = $res->fetch_assoc();

$stmt = $conn->prepare("SELECT id FROM saloes WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario['id']);
$stmt->execute();
$res = $stmt->get_result();
$salao = $res->fetch_assoc();

// Deleta o agendamento
$stmt = $conn->prepare("DELETE FROM agendamentos WHERE salao_id = ? AND data = ? AND hora = ?");
$stmt->bind_param("iss", $salao['id'], $data, $hora);
$stmt->execute();

header("Location: painel_salao.php");
exit;
