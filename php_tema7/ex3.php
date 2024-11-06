<?php
// Definição da função
function gerarNumeroAleatorio() {
    $numero = rand(1, 100); // Gera um número aleatório entre 1 e 100
    return $numero; // Retorna o número gerado
}

// Chamada da função e exibição do resultado
$numeroAleatorio = gerarNumeroAleatorio();
echo "Número aleatório gerado: $numeroAleatorio";
?>
