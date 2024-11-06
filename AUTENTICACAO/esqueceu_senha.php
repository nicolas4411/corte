<?php
include 'conexao.php';
include 'mail.php'; // Arquivo PHPMailer configurado

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $stmt = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id);
        $stmt->fetch();
        
        $codigo = rand(100000, 999999);

        $stmtCodigo = $conexao->prepare("INSERT INTO codigos_redefinicao (usuario_id, codigo) VALUES (?, ?) ON DUPLICATE KEY UPDATE codigo = ?");
        $stmtCodigo->bind_param("isi", $usuario_id, $codigo, $codigo);
        $stmtCodigo->execute();

        enviarCodigoEmail($email, $codigo);

        echo "<script>alert('Um código de redefinição foi enviado para o seu e-mail.'); window.location.href='redefinir_senha.html';</script>";
    } else {
        echo "<script>alert('E-mail não encontrado.'); window.history.back();</script>";
    }
}
?>
