<?php
include "conexao.php";

$nome = $_POST['nome'];
$login = $_POST['login'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$endereco = $_POST['endereco'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

$conn->begin_transaction();

try {
    // Inserir o usuário (com tipo = salao)
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, login, senha, tipo) VALUES (?, ?, ?, 'salao')");
    $stmt->bind_param("sss", $nome, $login, $senha);
    $stmt->execute();
    $usuario_id = $stmt->insert_id;

    // Criar a tabela 'saloes' se ainda não existir
    $conn->query("CREATE TABLE IF NOT EXISTS saloes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        nome VARCHAR(100) NOT NULL,
        endereco VARCHAR(255) NOT NULL,
        latitude DECIMAL(10,8) NOT NULL,
        longitude DECIMAL(11,8) NOT NULL,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )");

    // Inserir os dados do salão
    $stmt2 = $conn->prepare("INSERT INTO saloes (usuario_id, nome, endereco, latitude, longitude) VALUES (?, ?, ?, ?, ?)");
    $stmt2->bind_param("issdd", $usuario_id, $nome, $endereco, $latitude, $longitude);
    $stmt2->execute();

    $conn->commit();

    echo "Salão cadastrado com sucesso!";
    echo '<br><a href="login.php">Fazer login</a>';
} catch (Exception $e) {
    $conn->rollback();
    echo "Erro ao cadastrar salão: " . $e->getMessage();
}
?>
