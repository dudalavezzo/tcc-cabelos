<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['tipo'] !== 'cliente') {
    echo "Acesso negado.";
    exit;
}

include "cabecalho.php";
include "conexao.php";

// Buscar ID do cliente
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE login = ?");
$stmt->bind_param("s", $_SESSION['login']);
$stmt->execute();
$res = $stmt->get_result();
$cliente = $res->fetch_assoc();

// Buscar agendamentos
$stmt = $conn->prepare("
    SELECT a.data, a.hora, s.nome AS salao
    FROM agendamentos a
    JOIN saloes s ON a.salao_id = s.id
    WHERE a.cliente_id = ?
    ORDER BY a.data, a.hora
");
$stmt->bind_param("i", $cliente['id']);
$stmt->execute();
$res = $stmt->get_result();
?>

<h2>Meus Agendamentos</h2>

<?php if ($res->num_rows == 0): ?>
    <p>Você ainda não agendou nenhum horário.</p>
<?php else: ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Data</th>
            <th>Hora</th>
            <th>Salão</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?= date("d/m/Y", strtotime($row['data'])) ?></td>
                <td><?= substr($row['hora'], 0, 5) ?></td>
                <td><?= htmlspecialchars($row['salao']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>

<?php include "rodape.php"; ?>
