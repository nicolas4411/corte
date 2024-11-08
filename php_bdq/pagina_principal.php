<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Verifica o cookie de contador de visitas
if (isset($_COOKIE['login_count'])) {
    $loginCount = $_COOKIE['login_count'] + 1; // Incrementa o contador
} else {
    $loginCount = 1; // Primeira visita
}

// Atualiza o cookie com o novo valor e define validade de 30 dias
setcookie('login_count', $loginCount, time() + (30 * 24 * 60 * 60), "/");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Bem-vindo à sua conta!</h2>
    <p>Você está autenticado com sucesso e agora pode acessar a área principal da aplicação.</p>

    <!-- Exibe o número de logins -->
    <p>Esta página foi visitada <?= $loginCount ?> vez(es) neste dispositivo.</p>

    <!-- Botão para acessar outra aplicação -->
    <a href="aplicacao.php" class="btn">Acessar Aplicação</a>

    <!-- Botão para acessar a área de exclusão de conta do usuário logado -->
    <a href="exclusao_usuario.php" class="btn">Excluir Conta (LGPD)</a>

    <!-- Botão de logout -->
    <a href="logout.php" class="logout-btn">Sair</a>
</body>
</html>

