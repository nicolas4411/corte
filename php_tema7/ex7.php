<?php
// Exemplo usando implode
$array = array("apple", "banana", "orange");
echo "Array antes do implode: ";
var_dump($array); // Visualiza o array antes do implode
echo "<br>";

$string = implode(", ", $array);
echo "String resultante após o implode: $string"."<br>"; // Visualiza a string resultante

// Exemplo usando explode
$string = "apple, banana, orange";
echo "String antes do explode: $string <br>";
$array = explode(", ", $string);
echo "Array resultante após o explode: ";
var_dump($array); // Visualiza o array resultante
?>
