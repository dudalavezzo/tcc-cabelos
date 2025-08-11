<?php
session_start();
include("conexao.php");

$cliente_id = $_SESSION['id'];
$cabeleireiro_id = $_POST['cabeleireiro_id'];
$data = $_POST['data'];
$horario = $_POST['horario'];

// Verifica se já existe agendamento nesse horário
$sql = "SELECT * FROM agendamentos WHERE cabeleireiro_id = ? AND data = ? AND horario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $cabeleireiro_id, $data, $horario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Este horário já está ocupado!";
} else {
    $sql = "INSERT INTO agendamentos (cliente_id, cabeleireiro_id, data, horario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $cliente_id, $cabeleireiro_id, $data, $horario);

    if ($stmt->execute()) {
        header("Location: cabecalho.php");
    } else {
        echo "Erro ao agendar!";
    }
}
?>
