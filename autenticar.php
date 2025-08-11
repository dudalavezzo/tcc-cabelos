<?php
session_start();
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome, tipo, senha FROM usuarios WHERE login = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Se você usa senha com hash (recomendado)
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];

            if ($usuario['tipo'] === 'cliente') {
                header("Location: dashboard_cliente.php");
                exit;
            } elseif ($usuario['tipo'] === 'empresa') {
                header("Location: dashboard_salao.php");
                exit;
            } else {
                $erro = "Tipo de usuário inválido.";
            }
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
} else {
    $erro = "Requisição inválida.";
}

header("Location: login.php?erro=" . urlencode($erro));
exit;
