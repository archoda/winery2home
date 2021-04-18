<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Archoda
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="content-type" content="text/html;charset=<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes" />
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_directory');?>/build/lib/css/bundle.css" />
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page" class="site">

	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'archoda' ); ?></a>
	
	<div id="modal" class="modal">
		<div id="modal-content" class="modal-content">
			Modal Content
		</div>
	</div>
	
	<header id="header" class="header">

			<img src="<?php echo bloginfo('template_directory');?>/build/lib/images/winery2home-logo.svg" title="" alt="Winery2Home logo" />

			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$archoda_description = get_bloginfo( 'description', 'display' );
			if ( $archoda_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $archoda_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>

		<nav id="nav-main" class="nav nav-main">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'archoda' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'nav-main-menu',
					'menu_id'        => 'nav-main-menu',
				)
			);
			?>

		</nav><!-- #site-navigation -->
	</header><!-- #header -->
