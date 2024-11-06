<?php
include 'conexao.php';
include 'mail.php'; // Arquivo PHPMailer configurado

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    $stmt = $conexao->prepare("INSERT INTO usuarios (email, senha_hash) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $senha);

    if ($stmt->execute()) {
        $codigo = rand(100000, 999999);

        $usuario_id = $conexao->insert_id;
        $stmtCodigo = $conexao->prepare("INSERT INTO codigos_verificacao (usuario_id, codigo) VALUES (?, ?)");
        $stmtCodigo->bind_param("is", $usuario_id, $codigo);
        $stmtCodigo->execute();

        // Enviar e-mail com código
        enviarCodigoEmail($email, $codigo);

        // Redireciona o usuário para a página de verificação
        echo "<script>alert('Registro realizado! Verifique seu e-mail para confirmar.'); window.location.href='verificar.html';</script>";
    } else {
        echo "<script>alert('Erro no registro. E-mail já cadastrado ou erro no sistema.'); window.history.back();</script>";
    }
}
?>
