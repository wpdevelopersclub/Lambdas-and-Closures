<?php namespace tonya;

class Add_Menu_Before_Walker extends \Walker_Nav_Menu_Edit {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker_Nav_Menu::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * As there is no hook, this is a direct copy of the start_el() method 
	 * with the new custom field added into it.
	 * 
	 * Start the element output.
	 *
	 * @see Walker_Nav_Menu_Edit::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		parent::start_el( $output, $item, $depth, $args, $id );

		$item_id = esc_attr( $item->ID );

		$pos = strpos( $output, '</p>', strpos( $output, 'field-move', 3000 ) );

		$field = '<p class="field-custom description description-wide">';
			$field .= sprintf( '<label for="edit-menu-item-menu-before-%s">', $item_id );
				$field .= __( 'Before Menu', 'tonya' ) . '<br />';
				$field .= sprintf( '<input type="text" id="edit-menu-item-menu-before-%1$s" class="widefat code edit-menu-item-menu-before" name="menu-item-menu-before[%1$s]" value="%2$s" />', $item_id, esc_attr( $item->menu_before ) );
			$field .= '</label>';
		$field .= '</p>';

		$output = substr_replace( $output, $field, $pos, 4 );
	}

}