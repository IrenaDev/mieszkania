<?php
/**
 * Theme Header
 *
 * @package    WordPress
 * @subpackage themename
 * @since      themename 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page">
		<a class="skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'themename' ); ?></a>
		<?php echo get_part('components/header/index'); ?>
