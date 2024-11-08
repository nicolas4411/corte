<?php
session_start(); // Inicia a sessão no início do arquivo
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conexao->prepare("SELECT id, senha_hash, verificado FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $senha_hash, $verificado);
        $stmt->fetch();

        if (password_verify($senha, $senha_hash)) {
            if ($verificado) {
                $_SESSION['user_id'] = $id; // Armazena o ID do usuário na sessão
                header("Location: pagina_principal.php"); // Redireciona para a página principal
                exit();
            } else {
                echo "<script>alert('Conta ainda não verificada. Verifique seu e-mail.'); window.location.href='verificar.html';</script>";
            }
        } else {
            echo "<script>alert('Senha incorreta.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado.'); window.history.back();</script>";
    }
}
?>
