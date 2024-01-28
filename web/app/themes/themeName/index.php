<?php
/**
 * Theme index file.
 * @package    WordPress
 * @subpackage themename
 * @since      themename 1.0
 */
get_header();

?>
<main id="page-content" role="main" class="page-content page-content--index">
	<div class="container">
		<div id="content" tabindex="-1" class="page-content__wrapper">
			<?php echo get_part('archive/index'); ?>
		</div>
	</div>
</main>
<?php
get_footer();
