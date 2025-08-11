<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Cadastro</h2>
        <form action="salvar_cadastro.php" method="POST">
            <label for="nome">Nome completo</label>
            <input type="text" id="nome" name="nome" required>

            <label for="login">Usuário</label>
            <input type="text" id="login" name="login" required>

            <label for="tipo">Tipo de usuário</label>
            <select id="tipo" name="tipo" required>
                <option value="">Selecione...</option>
                <option value="cliente">Cliente</option>
                <option value="empresa">Empresa</option>
            </select>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Cadastrar</button>

            <?php 
                if(isset($_GET["erro"]) && !empty($_GET["erro"])) {
                    echo "<div class='alert alert-danger'>";
                    echo $_GET["erro"];
                    echo "</div>";
                } elseif(isset($_GET["sucesso"])) {
                    echo "<div class='alert alert-success'>";
                    echo "Cadastro realizado com sucesso!";
                    echo "</div>";
                }
            ?>
        </form>

        <div class="mt-3">
            <p>Já possui uma conta?</p>
            <a href="login.php" class="btn btn-secondary">Voltar ao Login</a>
        </div>
    </div>
</body>
</html>
