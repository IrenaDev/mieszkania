<article class="single-grid">
	<header class="single-grid__heading">
		<h2 class="single-grid__title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
	</header>
	<div class="single-grid__content">
		<?php the_excerpt(); ?>
	</div>
</article>
