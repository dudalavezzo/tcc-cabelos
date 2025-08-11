<?php
include "cabecalho.php";
?>

<div class="text-center mb-5">
    <h1 class="display-5">Salões de Cabeleireiro em Bauru</h1>
    <p class="lead">Encontre salões próximos de você e agende com facilidade.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body text-center">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <h4 class="card-title">Olá, <?= $_SESSION['usuario']; ?> 👋</h4>
                    <p class="card-text">
                        <?php if ($_SESSION['tipo'] === 'cliente'): ?>
                            Pronto para agendar seu próximo horário? É rápido e fácil.
                        <?php elseif ($_SESSION['tipo'] === 'salao'): ?>
                            Veja os agendamentos recebidos no seu salão.
                        <?php endif; ?>
                    </p>

                    <?php if ($_SESSION['tipo'] === 'cliente'): ?>
                        <a href="agendar.php" class="btn btn-primary">Agendar Agora</a>
                    <?php elseif ($_SESSION['tipo'] === 'salao'): ?>
                        <a href="painel_salao.php" class="btn btn-outline-primary">Ver Painel</a>
                    <?php endif; ?>

                <?php else: ?>
                    <h4 class="card-title">Bem-vindo(a) ao Agenda Salões 💇‍♀️</h4>
                    <p class="card-text">Faça login ou cadastre-se para agendar com os melhores salões de Bauru.</p>
                    <a href="login.php" class="btn btn-primary me-2">Login</a>
                    <a href="cadastro.php" class="btn btn-outline-secondary">Cadastre-se</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include "rodape.php"; ?>
