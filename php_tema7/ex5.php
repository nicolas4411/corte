<?php
echo "<table border='1'>";
echo "<tr><th>Valor</th><th>Caractere</th></tr>";

for ($i = 0; $i <= 255; $i++) {
    echo "<tr>";
    echo "<td>$i</td>";
    echo "<td>" . chr($i) . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "<br>";

// Obtendo o código ASCII do caractere 'A'
$codigo_ASCII = ord('A');
echo "O código ASCII de 'A' é: $codigo_ASCII";

?>
