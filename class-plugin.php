<?php namespace lesson_closure;

/**
 * Plugin Name: Lesson - Lambda, Anonymous Functions, and Closures
 * Plugin URI: http://wpdevelopersclub.com
 * Description: Accompanying lesson code for Lesson - Lambda, Anonymous Functions, and Closures in WordPress
 * Version: 1.0.0
 * Author: Tonya <hello@wpdevelopersclub.com>
 * Author URI: http://wpdevelopersclub.com
 */

//* Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit( 'Cheatin&#8217; uh?' );

class Lesson {

	/** Properties *************************************************************/

	/**
	 * Instance of this singleton object
	 *
	 * @since  1.0.0
	 *
	 * @var Testing
	 */
	private static $_instance = null;

	public $lambda;

	/** Singleton *************************************************************/

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new Lesson();
			self::$_instance->init();
		}

		return self::$_instance;
	}

	/** Getters **************************************************************/

	/**
	 * Vanilla getter
	 *
	 * @since  1.0.0
	 *
	 * @param string    $property_name
	 * @return mixed
	 */
	public function __get( $property_name ) {
		return property_exists($this, $property_name) ? $this->$property_name : null;
	}

	/** Init Methods *********************************************************/

	/**
	 * Initialize the plugin
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	private function init() {
		$this->init_hooks();
	}

	/**
	 * Init the hooks for actions and filters
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	private function init_hooks() {

		if ( ! is_admin() ) {
//			add_action( 'genesis_after_loop', array( $this, 'lesson1') );
//			add_action( 'after_setup_theme', array( $this, 'lesson2' ) );
//			add_action( 'after_setup_theme', array( $this, 'lesson3' ) );
//			add_action( 'after_setup_theme', array( $this, 'lesson4') );
//			add_action( 'after_setup_theme', array( $this, 'lesson5' ) );
		}

		add_action( 'after_setup_theme', array( $this, 'lesson6' ) );
	}

	/*******************************************
	 * Lesson 1 - create_function()
	 * Lambda's pre PHP version 5.3
	 ******************************************/

	public function lesson1() {
		$square_func = create_function( '$a', 'return $a * $a;' );
		echo $square_func( 2 ) . '<br>'; // Outputs 4

		echo $this->square( 2 ) . '<br>'; // Outputs 4

		$avg_func = create_function( '$a', '$t = 0; foreach ( $a as $s ) { $t += $s; } return $t / count( $a );' );
		echo $avg_func( array( 10, 20, 30, 40, 50 ) ) . '<br>';
	}

	/**
	 * Returns the square of the passing in number
	 *
	 * @since 1.0.0
	 *
	 * @param integer   $a
	 * @return integer
	 */
	public function square( $a ) {
		return $a * $a;
	}

	/*******************************************
	 * Lesson 2 - Anonymous functions
	 * PHP version 5.3+
	 ******************************************/

	public function lesson2() {
		//* Without an anonymous function
//		add_filter( 'the_title', array( $this, 'title_callback' ), 10, 2 );

		//* With an anonymous function
		add_filter( 'the_title', function ( $title, $post_id ) {
			return 'Using a closure - ' . $title;
		}, 10, 2 );
	}

	public function title_callback( $title, $post_id ) {
		return 'Using a callback - ' . $title;
	}

	/*******************************************
	 * Lesson 3 - Scope of Anonymous functions
	 * PHP version 5.3+
	 ******************************************/

	public function lesson3() {

		//* Passing args into the anonymous function
		$formatter = '<span style="color: red;">%s</span> - %s';

		//* This will throw an "Undefined variable: $formatter" error
		// as $formatter is outside of the closure's scope
//		add_filter( 'the_title', function ( $title, $post_id ) {
//			global $formatter;
//			return sprintf( $formatter, 'Using a closure', $title );
//		}, 10, 2 );

		//* Pass into the closure via the keyword 'use'
		add_filter( 'the_title', function ( $title, $post_id ) use ( $formatter ) {
			return sprintf( $formatter, 'Using a closure', $title );
		}, 10, 2 );

	}

	/*******************************************
	 * Lesson 4 - Scope of Anonymous functions
	 * PHP version 5.4+
	 ******************************************/

	public function lesson4() {

		$handle  = 'bar';
		$scripts = array(
			'foo' => false,
		);

		add_action( 'do_test', function () use ( $handle, &$scripts ) {
			$this->listener( $handle, $scripts );
		} );

		do_action( 'do_test' );
		var_dump( $scripts );
	}

	function listener( $handle, &$scripts ) {
		$scripts[ $handle ] = true;
		echo '<p>fired!</p>';
	}

	/*******************************************
	 * Lesson 5 - Other examples
	 ******************************************/

	public function lesson5() {
		$dog_func = $this->get_doggie();

		$dog = $dog_func( 'Rover' );
		$dog->bark( 3 );
		$dog->speak( 'I love WordPress' );
		$dog->walk();
	}

	function get_doggie() {
		return function( $name ) {
			include( trailingslashit( __DIR__ ) . 'lib/class-dog.php' );
			return new Dog( $name );
		};
	}

	/*******************************************
	 * Lesson 6 - Real world examples
	 ******************************************/

	public function lesson6() {

		//* Add body class(es)
		add_filter( 'body_class', function( array $classes ) {
			$classes[] = 'testing-example';
			return $classes;
		} );

		//* Modify the Genesis Footer Credits
		add_action( 'genesis_footer_creds_text', function( $credits ) {
			return sprintf( '[footer_copyright after=" %s"] &#x000B7; All Rights Reserved &#x000B7; %s [footer_genesis_link url="http://www.studiopress.com/"] & [footer_wordpress_link].', __( 'WP Developers Club', 'wpdevsclub' ), __( 'Powered with <i class="fa fa-heart"></i> by ', 'wpdevsclub' ) );
		} );

		//* Dynamically load the file & assign the walker
		add_filter( 'wp_edit_nav_menu_walker', function() {
			require_once( trailingslashit( __DIR__ ) . 'lib/menu/class-walker-menu-before.php');
			return '\lesson_closure\Add_Menu_Before_Walker';
		});
	}

	/**
	 * Test execution times
	 *
	 * @since 1.0.0
	 *
	 * @param string $method
	 * @param bool $is_lambda
	 */
	protected function test_lambda_times( $method, $is_lambda = false ) {
		$times = array();
		for ( $iterations = 1; $iterations <= 5; $iterations ++ ) {
			$start_time = microtime( true );
			$i = 1;
			while ( $i <= 1000000 ) {
				$is_lambda ? $method( 2 ) : $this->square( 2 );
				$i ++;
			}
			$times[] = microtime( true ) - $start_time;
		}
		$this->print_results( sprintf( '<h3>Execution times %s a lambda</h3>', $is_lambda ? 'with' : 'without' ), $times, $is_lambda );
	}



	/**
	 * Prints results in a handy table format
	 *
	 * @since 1.0.0
	 *
	 * @param string    $message
	 * @param array     $times
	 */
	protected function print_results( $message, $times ) {
		echo $message;

		echo '<table style="margin-left: 40px; width: 50%;"><thead><th>Iteration</th><th>msecs</th></thead><tbody>';
		foreach ( $times as $index => $time ) {
			printf( "<tr><td>%d</td><td>%.3f</td></tr>", $index, $time * 1000 );
		}
		echo '';
		printf( '<tr><td >Average execution time:</td><td>%.3f</td></tr></tbody></table>', call_user_func( $this->avg_func, $times ) * 1000 );
	}
}

add_action( 'plugins_loaded', 'lesson_closure\launch_plugin' );
/**
 * Launch the plugin after plugins are loaded
 *
 * @since  1.0.0
 *
 * @return void
 */
function launch_plugin() {
	Lesson::get_instance();
}