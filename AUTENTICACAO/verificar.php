<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $codigo = $_POST['codigo'];

    $stmt = $conexao->prepare("SELECT u.id FROM usuarios u JOIN codigos_verificacao c ON u.id = c.usuario_id WHERE u.email = ? AND c.codigo = ? AND TIMESTAMPDIFF(MINUTE, c.criado_em, NOW()) <= 10");
    $stmt->bind_param("ss", $email, $codigo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id);
        $stmt->fetch();

        $stmtUpdate = $conexao->prepare("UPDATE usuarios SET verificado = 1 WHERE id = ?");
        $stmtUpdate->bind_param("i", $usuario_id);
        $stmtUpdate->execute();

        // Redireciona o usuário para a página de login após verificação bem-sucedida
        echo "<script>alert('Conta verificada com sucesso! Faça login.'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Código inválido ou expirado.'); window.history.back();</script>";
    }
}
?>
