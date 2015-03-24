<?php namespace lesson_closure;

class Dog {

	public $name;

	public function __construct( $name ) {
		$this->name = $name;
	}

	public function bark( $num_barks = 1 ) {

		for ( $i = 1; $i <= $num_barks; $i++ ) {
			echo 'Woof! ';
		}
		echo '<br>';
	}

	public function speak( $message ) {
		echo $message . '<br>';
	}

	public function walk() {
		echo $this->name . ' is walking';
	}
}