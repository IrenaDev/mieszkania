<?php
/**
 * Block with Slider
 *
 * @package WordPress
 * @subpackage themename
 * @since themename 1.0
 */
$block_object = new Block( $block );
$attr = $block_object->attr();
$name = $block_object->name();

if ( have_rows('slider_row') ) :
?>
<section <?php echo $attr; ?>>
	<?php load_inline_styles( __DIR__, $name ); ?>
	<?php load_inline_styles_plugin( 'splide.min' ); ?>
	<?php load_inline_styles_shared( 'sliders' ); ?>
	<header class="slider__header">
		<div class="container">
			<?php $block_object->title('slider__title'); ?>
			<?php $block_object->desc('slider__description'); ?>
		</div>
	</header>

	<div class="slider__container splide">
		<div class="slider__row splide__track">
			<div class="slider__list splide__list">
			<?php
			$int = 1;
			while ( have_rows('slider_row') ) : the_row();
				$title = get_sub_field('title');
				$link = get_sub_field('link');
				$image_id = get_sub_field('image');
				$image = wp_get_attachment_image($image_id, 'slider-img');

				if ( !empty($image) ) :
			?>
				<div class="custom-slide splide__slide">
					<div class="custom-slide__image"><?php echo $image; ?></div>
					<div class="custom-slide__content">
					<?php if (!empty($title)) : ?>
						<h3 class="custom-slide__title"><?php echo $title; ?></h3>
					<?php endif; ?>
					<?php echo get_button($link); ?>
					</div>
				</div>
			<?php
					$int++;
				endif;
			endwhile;
			?>
			</div>
		</div>
	</div>
</section>
<?php
endif;
