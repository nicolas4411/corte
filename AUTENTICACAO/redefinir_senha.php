<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $codigo = $_POST['codigo'];
    $nova_senha = password_hash($_POST['nova_senha'], PASSWORD_BCRYPT);

    $stmt = $conexao->prepare("SELECT u.id FROM usuarios u JOIN codigos_redefinicao c ON u.id = c.usuario_id WHERE u.email = ? AND c.codigo = ? AND TIMESTAMPDIFF(MINUTE, c.criado_em, NOW()) <= 10");
    $stmt->bind_param("ss", $email, $codigo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id);
        $stmt->fetch();

        $stmtUpdate = $conexao->prepare("UPDATE usuarios SET senha_hash = ? WHERE id = ?");
        $stmtUpdate->bind_param("si", $nova_senha, $usuario_id);
        $stmtUpdate->execute();

        echo "<script>alert('Senha redefinida com sucesso!'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Código inválido ou expirado.'); window.history.back();</script>";
    }
}
?>
