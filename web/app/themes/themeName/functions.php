<?php

/**
 * Init theme base scripts
 */
require_once ( get_theme_file_path( '/base/init.php' ) );


/**
 * Include All Inc Files
 */
foreach ( get_glob_folders_path( '/inc/*/*.php' ) as $file_path ) {
	require_once( get_theme_file_path( $file_path ) );
}


/**
 * Register Gutenberg Blocks Options / scripts
 */
if ( ! function_exists( 'register_options_blocks' ) ) {

	function register_options_blocks() {
		foreach ( get_glob_folders_path( '/parts/gutenberg/*/register.php' ) as $file_path ) {
			require_once( get_theme_file_path( $file_path ) );
		}
	}

}
add_action( 'init', 'register_options_blocks' );

/**
 * Register ACF Gutenberg Blocks
 */
if ( ! function_exists( 'register_acf_blocks' ) ) {

	function register_acf_blocks() {
		foreach ( get_glob_folders_path( '/parts/gutenberg/acf-*/block.json' ) as $file_path ) {
			register_block_type( get_theme_file_path( $file_path ) );
		}
	}

}
add_action( 'acf/init', 'register_acf_blocks' );