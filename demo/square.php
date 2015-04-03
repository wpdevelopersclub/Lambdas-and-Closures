<?php namespace wpdevsclub_demo;


class Square {

	public function solve( $number ) {
		return $number * $number;
	}

}

$square = new Square();
var_dump( $square->solve( 4 ) ); //* output 16