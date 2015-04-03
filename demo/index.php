<?php

function square( $number ) {
	return $number * $number;
}
var_dump( square( 2 ) );  //* output 4


//*
$square_function = create_function( '$number', 'return $number * $number;' );
var_dump( $square_function( 3 ) ); //* output 9

/**
 * Via anonymous function (or Closure) assigned to a variable
 */
$func = function( $number ) {
	return $number * $number;
};
var_dump( $func( 4 ) ); //* Outputs 16