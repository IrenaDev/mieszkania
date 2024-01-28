<?php

/**
 * Plugin Name:  Redirect if wp-admin
 * Description:  prevent accessing wp-admin with `:3000` in url
 * Version:      1.0.0
 */
if ( defined( 'WP_ENV' ) && WP_ENV !== 'production' && is_admin() ) {
	add_action( 'admin_enqueue_scripts', function() {
		wp_enqueue_script( 'redirect-if-wp-admin', get_theme_file_uri( '/assets/js/wp-admin/redirect.min.js' ), array(), false, true );
	} );
}
