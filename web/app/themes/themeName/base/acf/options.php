<?php

/**
 * ACF Options Pages
 */
add_action( 'acf/init', function() {
	global $custom_settings;

	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page( [
			'page_title' => 'Theme General Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'theme-general-settings',
			'capability' => 'edit_posts',
			'redirect'   => false
		] );

		if ( isset( $custom_settings->theme_settings_pages ) ) {
			foreach ( $custom_settings->theme_settings_pages as $subpage ) {
				acf_add_options_sub_page( [
					'page_title'  => $subpage->page_title,
					'menu_title'  => $subpage->menu_title,
					'parent_slug' => 'theme-general-settings',
				] );
			}
		}
	}
} );