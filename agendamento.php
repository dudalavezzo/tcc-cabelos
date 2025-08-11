<?php
session_start();
include("conexao.php");

// Verifica login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$cliente_id = $_SESSION['usuario_id'];

$salao_selecionado = isset($_GET['salao_id']) ? intval($_GET['salao_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $salao_id = intval($_POST['salao_id']);
    $data_agendada = $_POST['data_agendada'];
    $hora_agendada = $_POST['hora_agendada'];

    if ($salao_id && $data_agendada && $hora_agendada) {
        // Checa se horário está livre
        $sql_check = "SELECT COUNT(*) AS total FROM agendamentos WHERE salao_id = ? AND data_agendada = ? AND hora_agendada = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("iss", $salao_id, $data_agendada, $hora_agendada);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result()->fetch_assoc();

        if ($res_check['total'] == 0) {
            $sql_insert = "INSERT INTO agendamentos (cliente_id, salao_id, data_agendada, hora_agendada) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iiss", $cliente_id, $salao_id, $data_agendada, $hora_agendada);
            if ($stmt_insert->execute()) {
                $msg_sucesso = "Agendamento realizado com sucesso!";
            } else {
                $msg_erro = "Erro ao salvar agendamento.";
            }
        } else {
            $msg_erro = "Esse horário já está ocupado.";
        }
    } else {
        $msg_erro = "Preencha todos os campos.";
    }
}

// Busca lista de salões
$sql_saloes = "SELECT id, nome, endereco FROM saloes ORDER BY nome";
$result_saloes = $conn->query($sql_saloes);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Agendar Horário</title>
    <link rel="stylesheet" href="agendamento.css" />
</head>
<body>
    <h1>Agendar Horário</h1>

    <?php if (isset($msg_sucesso)): ?>
        <p style="color:green;"><?= $msg_sucesso ?></p>
    <?php endif; ?>

    <?php if (isset($msg_erro)): ?>
        <p style="color:red;"><?= $msg_erro ?></p>
    <?php endif; ?>

    <h2>Escolha o salão</h2>
    <ul>
    <?php while ($salao = $result_saloes->fetch_assoc()): ?>
        <li>
            <a href="agendamento.php?salao_id=<?= $salao['id'] ?>">
                <?= htmlspecialchars($salao['nome']) ?> - <?= htmlspecialchars($salao['endereco']) ?>
            </a>
        </li>
    <?php endwhile; ?>
    </ul>

    <?php if ($salao_selecionado): 
        $sql_sel = "SELECT nome FROM saloes WHERE id = ?";
        $stmt_sel = $conn->prepare($sql_sel);
        $stmt_sel->bind_param("i", $salao_selecionado);
        $stmt_sel->execute();
        $res_sel = $stmt_sel->get_result()->fetch_assoc();
        $nome_salao = $res_sel['nome'] ?? 'Salão não encontrado';

        $data_selecionada = $_POST['data_agendada'] ?? date('Y-m-d');

        $sql_horarios_ocupados = "SELECT hora_agendada FROM agendamentos WHERE salao_id = ? AND data_agendada = ?";
        $stmt_horarios = $conn->prepare($sql_horarios_ocupados);
        $stmt_horarios->bind_param("is", $salao_selecionado, $data_selecionada);
        $stmt_horarios->execute();
        $res_horarios = $stmt_horarios->get_result();

        $horarios_ocupados = [];
        while ($row = $res_horarios->fetch_assoc()) {
            $horarios_ocupados[] = $row['hora_agendada'];
        }

        $horarios_disponiveis = ["09:00", "10:00", "11:00", "13:00", "14:00", "15:00", "16:00", "17:00"];
    ?>

    <h2>Agendar no salão: <?= htmlspecialchars($nome_salao) ?></h2>

    <form method="post" action="agendamento.php?salao_id=<?= $salao_selecionado ?>">
        <input type="hidden" name="salao_id" value="<?= $salao_selecionado ?>" />

        <label for="data_agendada">Escolha a data:</label>
        <input type="date" id="data_agendada" name="data_agendada" value="<?= htmlspecialchars($data_selecionada) ?>" min="<?= date('Y-m-d') ?>" required onchange="this.form.submit()" />

        <br/><br/>

        <label>Escolha o horário:</label><br/>
        <?php foreach ($horarios_disponiveis as $hora):
            $disabled = in_array($hora, $horarios_ocupados) ? "disabled" : "";
        ?>
            <input type="radio" name="hora_agendada" id="hora_<?= str_replace(':', '', $hora) ?>" value="<?= $hora ?>" <?= $disabled ?> required />
            <label for="hora_<?= str_replace(':', '', $hora) ?>">
                <?= $hora ?> <?= $disabled ? "(Indisponível)" : "" ?>
            </label><br/>
        <?php endforeach; ?>

        <br/>
        <button type="submit">Confirmar Agendamento</button>
    </form>
    <?php endif; ?>
</body>
</html>
