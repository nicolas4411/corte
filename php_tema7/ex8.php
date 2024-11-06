<?php
	$numero = 23412345.67;
	$separador_decimal = ',';
	$separador_milhar = '.';
	$casas_decimais = 2;
	$prefixo = 'R$ ';
	$sufixo = ' (BRL)';
	$numero_formatado = number_format($numero, $casas_decimais, $separador_decimal, $separador_milhar);
	$numero_formatado = $prefixo . $numero_formatado . $sufixo;
	echo $numero_formatado; // Saída: R$ 12.345,67 (BRL)
	
	//Exemplo de função
	function formatar($numero) {
		$retorno = number_format($numero, 2, ',', '.');
		return $retorno;		
	}
	
	echo '<br>' . formatar($numero);
?>
