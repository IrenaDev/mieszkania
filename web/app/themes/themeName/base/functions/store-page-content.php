<?php

/**
 * Store The Content
 */
if ( ! function_exists( 'store_page_content' ) ) {

	function store_page_content( $p_obj ) {
		global $styles_arr;

		$content = $p_obj->post_content;
		$value = apply_filters('the_content', $content);

		$styles_arr = [];

		return $value;
	}

}