<?php
session_start();


// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "pw_bd");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Buscar próximos agendamentos
$sql_proximos = "SELECT a.id, s.nome AS salao, a.data, a.horario 
                 FROM agendamentos a
                 JOIN saloes s ON a.cabeleireiro_id = s.id
                 WHERE a.cliente_id = ? AND a.data >= CURDATE()
                 ORDER BY a.data, a.horario";
$stmt = $conn->prepare($sql_proximos);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result_proximos = $stmt->get_result();

// Buscar histórico
$sql_historico = "SELECT a.id, s.nome AS salao, a.data, a.horario 
                  FROM agendamentos a
                  JOIN saloes s ON a.cabeleireiro_id = s.id
                  WHERE a.cliente_id = ? AND a.data < CURDATE()
                  ORDER BY a.data DESC, a.horario DESC";
$stmt = $conn->prepare($sql_historico);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result_historico = $stmt->get_result();

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do Cliente</title>
    <link rel="stylesheet" href="dashboard_cliente.css">
</head>
<body>
    <header>
        <h1>Bem-vindo(a) à sua Dashboard</h1>
        <a href="agendamento.php" class="btn">+ Novo Agendamento</a>
        <a href="logout.php" class="btn sair">Sair</a>
    </header>

    <main>
        <section>
            <h2>📅 Próximos Agendamentos</h2>
            <?php if ($result_proximos->num_rows > 0) { ?>
                <table>
                    <tr>
                        <th>Salão</th>
                        <th>Data</th>
                        <th>Horário</th>
                    </tr>
                    <?php while($row = $result_proximos->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['salao']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                            <td><?= date('H:i', strtotime($row['horario'])) ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>Você não tem agendamentos futuros.</p>
            <?php } ?>
        </section>

        <section>
            <h2>📜 Histórico</h2>
            <?php if ($result_historico->num_rows > 0) { ?>
                <table>
                    <tr>
                        <th>Salão</th>
                        <th>Data</th>
                        <th>Horário</th>
                    </tr>
                    <?php while($row = $result_historico->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['salao']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                            <td><?= date('H:i', strtotime($row['horario'])) ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>Você ainda não tem histórico de agendamentos.</p>
            <?php } ?>
        </section>
    </main>
</body>
</html>
