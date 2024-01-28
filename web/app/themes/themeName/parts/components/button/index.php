<?php
$set_class = isset( $args['set_class'] ) ? $args['set_class'] : '';
$link_target = isset($args['link_target']) ? $args['link_target'] : '_self';
$link_title = isset($args['link_title']) ? $args['link_title'] : 'Button';
$link_url = isset($args['link_url']) ? $args['link_url'] : '#';

$name = 'button';
$button_class = 'wp-block-button__link';
$wrapper_class = 'wp-block-button wp-block-button--template';

! empty( $set_class ) && $wrapper_class .= "  $set_class";

( isset( $args['style'] ) && ! empty( $args['style'] ) ) && $wrapper_class .= ' is-style-' . $args['style'];
?>
<?php load_inline_dependencies('/parts/gutenberg/core-button/', 'core-button'); ?>
<div class="<?php echo $wrapper_class; ?>"><a class="<?php echo $button_class; ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
