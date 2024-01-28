<section class="posts-list">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php echo get_part( 'archive/single-grid' ); ?>
	<?php endwhile; ?>
</section>
