<?php include "cabecalho.php"; ?>

<h2>Cadastro de Salão</h2>

<form action="salvar_cadastro_salao.php" method="POST">
    <label>Nome do salão:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Login:</label><br>
    <input type="text" name="login" required><br><br>

    <label>Senha:</label><br>
    <input type="password" name="senha" required><br><br>

    <label>Endereço:</label><br>
    <input type="text" name="endereco" required><br><br>

    <label>Latitude:</label><br>
    <input type="text" name="latitude" required><br><br>

    <label>Longitude:</label><br>
    <input type="text" name="longitude" required><br><br>

    <input type="submit" value="Cadastrar Salão">
</form>

<?php include "rodape.php"; ?>
