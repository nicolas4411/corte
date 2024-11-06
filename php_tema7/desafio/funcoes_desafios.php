<?php
// Função para verificar aceitação do desafio 1
function verificarAceitacao($nome, $sexo, $idade) {
   if ($sexo == "Feminino"  && $idade < 25){
      return "$nome Võce foi aceita ";
   } else {
      return "$nome  võce foi reprovada ";
   }

}

// Função para ordenar números do desafio 2
function ordenarNumeros($num1, $num2, $num3) {
   
}

// Função para calcular média do desafio 3
function calcularMediaAluno($nota1, $nota2, $nota3) {
    $media = ($nota1 + $nota2 + $nota3) /3;
   if ($media >= 7){
      return "aprovado";  
   }else{
      return "reprovado";
   }
   
   
    
   
}
?>
