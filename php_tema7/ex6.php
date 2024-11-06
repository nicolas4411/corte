<?php
// Configura o fuso horário para o fuso horário local
date_default_timezone_set('America/Sao_Paulo');

// Exibe a data e hora atual formatada
$dataFormatada = date("d/m/Y H:i:s");
echo "Data e hora atual: $dataFormatada";
?>
