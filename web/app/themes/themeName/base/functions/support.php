<?php

/**
 * Add Theme Support
 */
add_action( 'after_setup_theme', function() {
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-full' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	add_editor_style( 'assets/css/style-editor.css' );
} );