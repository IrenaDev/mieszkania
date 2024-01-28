<?php

/**
 * Load Main Scripts/Styles & localize vars to JS
 */
if ( ! function_exists( 'enqueue_theme_scripts' ) ) {

	function enqueue_theme_scripts() {
		global $custom_settings;

		$deps = [];

		if ( isset( $custom_settings->jquery ) && $custom_settings->jquery == true ) {
			$deps[] = 'jquery';
		}
		if ( isset( $custom_settings->block_library ) && $custom_settings->block_library == false ) {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
		}


		// Scripts
		wp_enqueue_script(
			'script',
			get_theme_file_uri( '/assets/js/bundle.min.js' ),
			$deps,
			filemtime( get_theme_file_path( '/assets/js/bundle.min.js' ) ),
			true
		);

		wp_localize_script( 'script', 'vars', [
			'templateUrl' => get_theme_file_uri(),
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
		] );


		// Styles
		wp_enqueue_style(
			'main',
			get_theme_file_uri( '/assets/css/style.css' ),
			false,
			filemtime( get_theme_file_path( '/assets/css/style.css' ) )
		);
	}

}

add_action( 'wp_enqueue_scripts', 'enqueue_theme_scripts' );


/**
 * Load Admin Styles
 */
add_action( 'admin_enqueue_scripts', function() {
	wp_enqueue_style(
		'style-admin',
		get_theme_file_uri( '/assets/css/style-admin.css' ),
		false,
		filemtime( get_theme_file_path( '/assets/css/style-admin.css' ) )
	);
} );


/**
 * Enqueue Third Party Blocks Assets
 */
add_action( 'enqueue_block_assets', function() {
	global $custom_settings;

	if ( isset( $custom_settings->register_scripts ) ) {
		foreach ( $custom_settings->register_scripts as $key => $value ) {
			wp_register_script(
				$key,
				get_theme_file_uri( $value ),
				[],
				filemtime( get_theme_file_path( $value ) ),
				true
			);
		}
	}
} );
