<?php
if ( have_posts() ) :
?>
	<h1><?php _e( 'Blog Archive', 'themename' ); ?></h1>
<?php
	echo get_part( 'archive/loop' );
else :
?>
	<h1><?php _e( 'Blog Archive - Sorry, nothing found.', 'themename' ); ?></h1>
<?php
endif;

$args = array(
	'mid_size'           => 4,
	'prev_text'          => __( 'Previous' ),
	'next_text'          => __( 'Next' ),
	'screen_reader_text' => __( 'Archive Pagination' ),
);

the_posts_pagination( $args );
?>
