<?php namespace wpdevsclub_demo;

use Closure;

class Calculator {

	public function solve( Closure $expression, $args ) {

		if ( is_callable( $expression ) ) {
			return $expression( $args );
		}
	}

	public function add( $number1, $number2 ) {
		return $number1 + $number2;
	}

	public function square( $number ) {
		return $number * $number;
	}

	public function multiply( $number1, $number2 ) {
		return $number1 * $number2;
	}
}

$expression = function( $number ) {
	echo 'fired!';
	return $number * $number;
};
$calculator = new Calculator();
var_dump( $calculator->solve( $expression, 5 ) ); //* output 25