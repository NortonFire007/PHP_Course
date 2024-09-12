<?php

$stringVar = "Це рядок";
$intVar = 42;
$floatVar = 3.14;
$boolVar = true;

echo $stringVar . "<br>";
echo $intVar . "<br>";
echo $floatVar . "<br>";
echo ($boolVar ? 'true' : 'false') . "<br>";

var_dump($stringVar);
var_dump($intVar);
var_dump($floatVar);
var_dump($boolVar);
?>
