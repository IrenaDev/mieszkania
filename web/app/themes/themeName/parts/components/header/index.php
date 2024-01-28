<?php
$main_logo = 'main-logo'; // ACF ID // icon name

load_blocks_script('header', 'themename/header');
?>
<header class="main-header">
	<?php load_inline_styles(__DIR__, 'header') ; ?>
	<div class="main-header__logo">
		<a href="<?php echo get_bloginfo( 'url' ); ?>" class="main-logo"><span class="screen-reader-text"><?php _e( 'Main Logo', 'themename' ); ?></span><?php echo get_img( $main_logo, 'full' ) ?></a>
	</div>
<?php if ( has_nav_menu( 'navigation' ) ) : ?>
	<div class="main-header__nav">
		<nav class="main-header__desktop-nav" aria-labelledby="nav-heading">
			<span id="nav-heading" class="screen-reader-text"><?php _e( 'Main Navigation', 'themename' ); ?></span>
			<?php wp_nav_menu( array( 'theme_location' => 'navigation', 'container' => false, 'walker' => new Main_Nav_Menu_Walker() ) ); ?>
		</nav>
	</div>
<?php endif; ?>
	<button class="btn-menu" aria-haspopup="true" aria-expanded="false">
		<span></span>
		<span></span>
		<span></span>
		<span class="screen-reader-text"><?php _e('Menu', 'themename'); ?></span>
	</button>
	<div class="main-header__mobile" hidden>
		<nav class="main-header__mobile-nav" aria-labelledby="mobile-nav-heading">
			<span id="mobile-nav-heading" class="screen-reader-text"><?php _e( 'Mobile Navigation', 'themename' ); ?></span>
			<?php wp_nav_menu( array( 'theme_location' => 'navigation', 'container' => false, 'walker' => new Main_Nav_Menu_Walker() ) ); ?>
		</nav>
	</div>
</header>
