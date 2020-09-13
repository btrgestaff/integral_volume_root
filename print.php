<?php

require_once('equation.php');

function f($x) 
{
	return 4/$x;
}

$calc = new Calculator();

echo "&#x222b 2->5 f:4/x = ";
print_r($calc::integral(f, 2, 5));

echo "</br></br>";

echo "V 2->5 f:4/x = ";
print_r($calc::volume(f, 2, 5));

echo "</br></br>";

echo "2x+1=0</br>";
print_r($calc::calcroot(2, 1));

echo "</br></br>";

echo "3x^2+6x-8=0</br>";
print_r($calc::calcroot(3, 6, -8));

echo "</br></br>";

echo "x^3+x^2-4x-4=0</br>";
print_r($calc::calcroot(1, 1, -4, -4));
