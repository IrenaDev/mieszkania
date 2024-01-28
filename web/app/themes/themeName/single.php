<?php
/**
 * Single Blog Post template.
 *
 * @package    WordPress
 * @subpackage themename
 * @since      themename 1.0
 */
get_header();
the_post();
?>
<main id="page-content" role="main" class="page-content page-content--single">
	<h1><?php the_title(); ?></h1>
	<div id="content" tabindex="-1" class="page-content__wrapper">
		<?php the_content(); ?>
	</div>
</main>
<?php
get_footer();
