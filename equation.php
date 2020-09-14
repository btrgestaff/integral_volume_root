<?php

class Calculator 
{
	function calcroot()
	{
		$numargs = func_num_args();
		$args = func_get_args();
		switch($numargs) {
			case '0': 
				return 'Error: input coefficients';
				break;
			case '1' :
				return 'Error: insuffient number of coefficients';
				break;	
			case '2' :
				return Calculator::line($args[0], $args[1]);
				break;
			case '3' :
				return Calculator::square($args[0], $args[1], $args[2]);
				break;
			case '4' : 
				return Calculator::cube($args[0], $args[1], $args[2], $args[3]);
				break;
			default :
				echo 'Too much arguments';	
		}
	}

	// Integrate using trapezoidal method
	function integral($f, $a, $b, $eps = 0.0001)
	{
		$N = 1/$eps;
		$dx = ($b-$a) / $N;
		$result = 0.5*$f($a) + 0.5*$f($b);
		for($i = 1; $i < $N; $i++) {
			$result += $f($a+$i*$dx);
		}
		$result *= $dx;
		return $result;
	}

	// Найти обьем фигуры вращения
	function volume($f, $a, $b, $eps = 0.0001)
	{
		return Calculator::integral(function($x) use ($f) { return $f($x) * $f($x); }, $a, $b, $eps);
	}

	private function line($a = 0, $b = 0)
	{
	    if (is_numeric($a) && is_numeric($b)) {
		if ($a != 0) {
		    return [
			"x" => -$b / $a
		    ];
		}
	    } else {
		print_r('Input numbers:');
	    }
	    return [];
	}

	private function square($a, $b, $c)
	{
	    if (is_numeric($a) && is_numeric($b) && is_numeric($c)) {
		if ($a === 0) {
		    return line($b, $c);
		} elseif ($a != 0) {
		    $D = $b * $b - 4 * $a * $c;
		    if ($D < 0) {
			print_r('No rational roots');
		    } else {
			$x1 = (-$b + sqrt($D)) / 2 * $a;
			$x2 = (-$b - sqrt($D)) / 2 * $a;
			return [
			    "x1" => $x1,
			    "x2" => $x2
			];
		    }
		}
	    } else {
		print_r('Input numbers');
	    }
	    return [];
	}

	private function cube($x1 = 0, $x2 = 0, $x3 = 0, $x4 = 0)
	{
	    if (is_numeric($x1) && is_numeric($x2) && is_numeric($x3) && is_numeric($x4)) {
		if ($x1 === 0) {
		    return [(square($x2, $x3, $x4))];
		} elseif ($x1 != 0) {

		    $a = $x2 / $x1;
		    $b = $x3 / $x1;
		    $c = $x4 / $x1;

		    $Q = ($a * $a - 3 * $b) / 9;
		    $R = (2 * $a * $a * $a - 9 * $a * $b + 27 * $c) / 54;
		    $S = $Q * $Q * $Q - $R * $R;

		    if ($S > 0) {
			$alpha = 1 / 3 * acos($R / (pow($Q, 3 / 2)));

			$x1 = round((-2) * pow($Q, 1 / 2) * cos($alpha) - $a / 3, 3);
			$x2 = round((-2) * pow($Q, 1 / 2) * cos($alpha + 2 / 3 * pi()) - $a / 3, 3);
			$x3 = round((-2) * pow($Q, 1 / 2) * cos($alpha - 2 / 3 * pi()) - $a / 3, 3);

			return [
			    "x1" => ("$x1 <br/>"),
			    "x2" => ("$x2 <br/>"),
			    "x3" => ("$x3 <br/>"),
			];
		    } elseif ($S < 0) {

			if ($Q > 0) {
			    $alpha = 1 / 3 * acosh(abs($R) / (pow($Q, 3 / 2)));
			    $Re = round(gmp_sign(settype($R, "integer")) * pow($Q, 1 / 2) * cosh($alpha) - $a / 3, 3);
			    $Im = round(pow(3, 1 / 2) * pow($Q, 1 / 2) * sinh($alpha), 3);

			    $x1 = round((-2) * gmp_sign(settype($R, "integer")) * pow($Q, 1 / 2) * cosh($alpha) - $a / 3, 3);

			    return [
				"x1" => ("$x1 <br/>"),
				"x2" => ("$Re + $Im * i<br/>"),
				"x3" => ("$Re - $Im * i<br/>"),
			    ];
			}

			if ($Q < 0) {
			    $alpha = 1 / 3 * asinh(abs($R) / (pow(abs($Q), 3 / 2)));
			    $Re = gmp_sign(settype($R, "integer")) * pow(abs($Q), 1 / 2) * sinh($alpha) - $a / 3;
			    $Im = pow(3, 1 / 2) * pow(abs($Q), 1 / 2) * cosh($alpha);

			    $x1 = -2 * gmp_sign(settype($R, "integer")) * pow(abs($Q), 1 / 2) * sinh($alpha) - $a / 3;

			    return [
				"x1" => ("$x1 <br/>"),
				"x2" => ("$Re + $Im * i<br/>"),
				"x3" => ("$Re - $Im * i<br/>"),
			    ];
			}

			if ($Q === 0) {
			    $x1 = round(-pow($c - $a ** 3 / 27, 1 / 3) - $a / 3,  3);
			    $Re = round((-1) * ($a + $x1) / 2, 3);
			    $Im = round(1 / 2 * pow(abs(($a - 3 * $x1) * ($a + $x1) - 4 * $b), 1 / 2), 3);


			    return [
				"x1" => ("$x1 <br/>"),
				"x2" => ("$Re + $Im * i<br/>"),
				"x3" => ("$Re - $Im * i<br/>"),
			    ];
			}
		    } elseif ($S == 0) {
			$x1 = round((-2) * pow($R, 1 / 3) - $a / 3, 3);
			$x2 = round(pow($R, 1 / 3) - $a / 3, 3);

			return [
			    "x1" => $x1,
			    "x2" => $x2,
			];
		    }
		} else {
		    print_r('Input numbers');
		}
		return [];
	    }
	}
}
