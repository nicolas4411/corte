<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Exclui o usuário do banco de dados
    $stmt = $conexao->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        session_destroy(); // Destroi a sessão após exclusão
        echo "<script>alert('Sua conta foi excluída com sucesso.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Erro ao excluir conta.'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Excluir Conta</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Excluir Conta</h2>
    <p>Esta ação não pode ser desfeita. Deseja realmente excluir sua conta?</p>

    <!-- Formulário para confirmação de exclusão -->
    <form method="POST">
        <button type="submit" class="logout-btn">Excluir Conta</button>
        <a href="pagina_principal.php" class="btn">Cancelar</a>
    </form>
</body>
</html>

