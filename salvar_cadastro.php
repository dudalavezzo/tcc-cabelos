<?php
session_start();
include("conexao.php");

$nome = $_POST["nome"];
$login = $_POST["login"];
$senha = $_POST["senha"];

// Verifica se o login já existe
$sql_verifica = "SELECT * FROM usuarios WHERE login = ?";
$stmt_verifica = $conn->prepare($sql_verifica);
$stmt_verifica->bind_param("s", $login);
$stmt_verifica->execute();
$resultado = $stmt_verifica->get_result();

if ($resultado->num_rows > 0) {
    header("Location: cadastro.php?erro=Usuário já existe.");
    exit;
}

// Criptografa a senha antes de salvar
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Insere no banco
$sql = "INSERT INTO usuarios (nome, login, senha) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $login, $senha_hash);

if ($stmt->execute()) {
    session_start();
    $_SESSION["usuario"] = $nome; // salva o nome do usuário na sessão (se quiser usar no cabeçalho)
    header("Location: cabecalho.php");
    exit;
} else {
    header("Location: cadastro.php?erro=Erro ao cadastrar.");
    exit;
}


$conn->close();
?>
