<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="autenticar.php" method="POST">
            <label for="username">Usuário</label>
            <input type="text" id="username" name="login" required>

            <label for="password">Senha</label>
            <input type="password" id="password" name="senha" required>

            <button type="submit">Entrar</button>

            <?php 
                if(isset($_GET["erro"]) && !empty($_GET["erro"])) {
                    echo "<div class='alert alert-danger mt-2'>";
                    echo $_GET["erro"];
                    echo "</div>";
                }
            ?>
        </form>

        <div class="mt-3">
            <p>Ainda não possui cadastro?</p>
            <a href="cadastro.php" class="btn btn-secondary">Cadastrar</a>
        </div>
    </div>
</body>
</html>
