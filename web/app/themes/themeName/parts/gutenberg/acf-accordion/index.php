<?php
/**
 * Block with Accordion
 *
 * @package WordPress
 * @subpackage themename
 * @since themename 1.0
 */
$block_object = new Block( $block );
$attr = $block_object->attr();
$name = $block_object->name();
$id = $block['id'];

if ( have_rows('accordion_row') ) :
?>
<section <?php echo $attr; ?>>
	<?php echo load_inline_styles( __DIR__, $name ); ?>
	<header class="accordion__header">
		<div class="container">
			<?php $block_object->title('accordion__title'); ?>
			<?php $block_object->desc('accordion__description'); ?>
		</div>
	</header>
	<div class="container accordion__container">
		<div class="single-accordion">
			<div class="single-accordion__row">
			<?php
			$int = 1;
			while ( have_rows('accordion_row') ) : the_row();
				$title = get_sub_field('title');
				$content = get_sub_field('content');
				$single_class = "single-accordion__item";
				$id_hash = "$id-$int";

				if ( !empty( $content ) ) :
			?>
				<div class="<?php echo $single_class; ?>">
					<h2 id="heading-<?php echo $id_hash; ?>" class="single-accordion__header">
						<button class="single-accordion__trigger" type="button" aria-expanded="false" aria-controls="body-<?php echo $id_hash; ?>">
							<span class="single-accordion__icon" aria-hidden="true"></span>
						<?php if ( !empty( $title ) ) : ?>
							<span class="single-accordion__text"><?php echo $title; ?></span>
						<?php endif; ?>
						</button>
					</h2>
					<div id="body-<?php echo $id_hash; ?>" class="single-accordion__content" aria-labelledby="heading-<?php echo $id_hash; ?>" hidden>
						<div class="single-accordion__body">
							<?php echo $content; ?>
						</div>
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
