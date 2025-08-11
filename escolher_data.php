<?php
session_start();
include "cabecalho.php";
include "conexao.php";

if (!isset($_GET['salao_id']) || !isset($_GET['data'])) {
    echo "Parâmetros inválidos.";
    exit;
}

$salao_id = $_GET['salao_id'];
$data = $_GET['data'];

// Horários possíveis por dia
$horarios_possiveis = [
    "09:00", "10:00", "11:00",
    "13:00", "14:00", "15:00", "16:00", "17:00"
];

// Buscar horários já agendados
$stmt = $conn->prepare("SELECT hora FROM agendamentos WHERE salao_id = ? AND data = ?");
$stmt->bind_param("is", $salao_id, $data);
$stmt->execute();
$result = $stmt->get_result();

$horarios_ocupados = [];
while ($row = $result->fetch_assoc()) {
    $horarios_ocupados[] = substr($row['hora'], 0, 5); // "10:00:00" → "10:00"
}

// Calcular horários disponíveis
$horarios_disponiveis = array_diff($horarios_possiveis, $horarios_ocupados);
?>

<h2>Horários disponíveis para <?= $data ?></h2>

<?php if (empty($horarios_disponiveis)): ?>
    <p>Nenhum horário disponível para esta data.</p>
<?php else: ?>
    <form action="salvar_agendamento.php" method="POST">
        <input type="hidden" name="salao_id" value="<?= $salao_id ?>">
        <input type="hidden" name="data" value="<?= $data ?>">

        <label>Escolha um horário:</label><br>
        <select name="hora" required>
            <?php foreach ($horarios_disponiveis as $hora): ?>
                <option value="<?= $hora ?>"><?= $hora ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Confirmar agendamento">
    </form>
<?php endif; ?>

<?php include "rodape.php"; ?>

