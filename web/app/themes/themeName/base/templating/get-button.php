<?php

/**
 * Get theme button base on ACF Link field
 *
 * @param array ACF Link field
 * @param string Gutenberg style name
 * @param string additional custom class
 */
if ( ! function_exists( 'get_button' ) ) {

	function get_button( $link, $style = '', $custom_class = '' ) {
		$link_html = '';

		if ( ! empty( $link ) && is_array( $link ) ) {
			$link_url    = $link['url'];
			$link_title  = $link['title'];
			$link_target = $link['target'] ? $link['target'] : '_self';

			$args = [
				'link_url'    => $link_url,
				'link_title'  => $link_title,
				'link_target' => $link_target,
				'style'       => $style,
				'set_class'   => $custom_class
			];

			$link_html = get_part( 'components/button/index', $args );
		}

		return $link_html;
	}

}