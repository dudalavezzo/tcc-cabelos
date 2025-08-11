<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] !== 'salao') {
    echo "Acesso restrito aos salões.";
    exit;
}

include "cabecalho.php";
include "conexao.php";

// Buscar ID do salão logado
$login = $_SESSION['login'];

$stmt = $conn->prepare("SELECT id FROM usuarios WHERE login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$usuario_id = $usuario['id'];

// Buscar ID na tabela saloes (ligada a usuarios)
$stmt = $conn->prepare("SELECT id, nome FROM saloes WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$salao = $result->fetch_assoc();

if (!$salao) {
    echo "Salão não encontrado.";
    exit;
}

$salao_id = $salao['id'];
$salao_nome = $salao['nome'];

// Buscar agendamentos do salão
if (isset($_GET['filtro_data']) && $_GET['filtro_data'] !== '') {
    $filtro_data = $_GET['filtro_data'];
    $stmt = $conn->prepare("
        SELECT a.data, a.hora, u.nome AS cliente
        FROM agendamentos a
        JOIN usuarios u ON a.cliente_id = u.id
        WHERE a.salao_id = ? AND a.data = ?
        ORDER BY a.hora
    ");
    $stmt->bind_param("is", $salao_id, $filtro_data);
} else {
    $stmt = $conn->prepare("
        SELECT a.data, a.hora, u.nome AS cliente
        FROM agendamentos a
        JOIN usuarios u ON a.cliente_id = u.id
        WHERE a.salao_id = ?
        ORDER BY a.data, a.hora
    ");
    $stmt->bind_param("i", $salao_id);
}

$stmt->bind_param("i", $salao_id);
$stmt->execute();
$agendamentos = $stmt->get_result();
?>

<h2>Painel do Salão: <?= $salao_nome ?></h2>

<?php if ($agendamentos->num_rows == 0): ?>
    <p>Você ainda não recebeu nenhum agendamento.</p>
<?php else: ?>
    <h3>Filtrar agendamentos por data:</h3>
<form method="GET">
    <input type="date" name="filtro_data" value="<?= isset($_GET['filtro_data']) ? $_GET['filtro_data'] : '' ?>">
    <input type="submit" value="Filtrar">
</form>
<br>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Data</th>
            <th>Hora</th>
            <th>Cliente</th>
            <th>Ações</th>

        </tr>
        <?php while ($row = $agendamentos->fetch_assoc()): ?>
            <tr>
                <td><?= date("d/m/Y", strtotime($row['data'])) ?></td>
                <td><?= substr($row['hora'], 0, 5) ?></td>
                <td><?= htmlspecialchars($row['cliente']) ?></td>
                <td>
    <form method="POST" action="cancelar_agendamento.php" onsubmit="return confirm('Tem certeza que deseja cancelar este agendamento?');">
        <input type="hidden" name="data" value="<?= $row['data'] ?>">
        <input type="hidden" name="hora" value="<?= $row['hora'] ?>">
        <input type="submit" value="Cancelar">
    </form>
</td>

            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>

<?php include "rodape.php"; ?>
