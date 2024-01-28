<?php

/**
 * Walker for the main navigation
 */
add_filter( 'walker_nav_menu_start_el', function( $output, $item, $depth, $args ){

	// Only add class to 'top level' items on the 'navigation' menu.
	if ( 'navigation' == $args->theme_location ) {
		if ( in_array("menu-item-has-children", $item->classes )) {
			$output .= '<button class="menu-item__dropdown" aria-expanded="false" aria-haspopup="true" type="button"><span class="screen-reader-text">' . $item->post_title . ' Submenu</span><span class="menu-item__icon" aria-hidden="true"></span></button>';
		}
	}

	return $output;
}, 10, 4);

class Main_Nav_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// ! You default class names.
		$classes = array( 'sub-menu', 'menu-item__submenu' );
		// ! Example of using arguments.
		if ( 'header-menu' === $args->theme_location ) {
			$default_class_name_key = array_search( 'sub-menu', $classes );
			if ( false !== $default_class_name_key ) {
				unset( $classes[ $default_class_name_key ] );
			}
			$classes[] = 'header-submenu';
			$classes[] = "depth-{$depth}";
		}

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<ul{$class_names} hidden>{$n}";
	}
}
