<?php
/**
 * Block CTA
 *
 * @package WordPress
 * @subpackage themename
 * @since themename 1.0
 */
$block_object = new Block( $block );
$attr = $block_object->attr();
$name = $block_object->name();

$template = array(
	array('core/heading', array(
		'level' => 2,
		'content' => 'Title Goes Here',
	)),
    array( 'core/paragraph', array(
        'content' => 'Description Goes Here',
    ) )
);
?>
<section <?php echo $attr; ?>>
	<?php echo load_inline_styles( __DIR__, $name ); ?>
	<div class="cta__content">
		<InnerBlocks template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>"/>
	</div>
</section>
