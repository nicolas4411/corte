<?php
// Definição da função
function calcularMedia($numeros) {
    $soma = 0;
    foreach ($numeros as $numero) {
        $soma += $numero;
    }
    $media = $soma / count($numeros);
    return $media;
}

// Lista de números
$listaNumeros = array(10, 20, 30);

// Chamada da função e exibição do resultado
$media = calcularMedia($listaNumeros);
echo "A média dos números " . implode(", ", $listaNumeros) . " é: $media";
?>
