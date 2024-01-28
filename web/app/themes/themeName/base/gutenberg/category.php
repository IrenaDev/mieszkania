<?php

/**
 * Register Gutenberg Categories
 */
add_filter( 'block_categories_all', function( $categories ) {
	global $custom_settings;

	if ( isset( $custom_settings->gutenberg_categories ) ) {
		$cat_array = array();

		foreach ( $custom_settings->gutenberg_categories as $cat ) {
			$cat_array[] = array(
				'slug' => $cat[0],
				'title' => __($cat[1], 'themename'),
				'icon'  => $cat[2],
			);
		}

		return array_merge(
			$cat_array,
			$categories
		);
	}
}, 10, 2 );
