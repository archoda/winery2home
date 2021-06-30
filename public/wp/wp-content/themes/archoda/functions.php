<?php
/**
 * Archoda functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Archoda
 */


if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'archoda_setup' ) ) :
	
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
		
	// Set-up Report ALL Errors
	ini_set('error_reporting', E_ALL);

	// Load Archoda Classes
	require_once(get_template_directory() . '/static/classes/class-archoda.php');
	require_once(get_template_directory() . '/static/classes/class-archoda-email-handler.php');
	require_once(get_template_directory() . '/static/classes/class-archoda-gravity-forms.php');
	require_once(get_template_directory() . '/static/classes/class-archoda-snipcart.php');

	 function archoda_setup() {
		
		try
		{
			global $Archoda;
			global $ArchodaEmail;
			global $ArchodaGravityForms;
			global $ArchodaSnipcart;
	
			$Archoda 					= new Archoda();
			$ArchodaEmail 				= new ArchodaEmail((array('To' => 'jmallory@archodaDigital.com')));
			$ArchodaGravityForms 		= new ArchodaGravityForms();
			$ArchodaSnipcart 			= new ArchodaSnipcart(array('Email' => $ArchodaEmail));

			/*
				-------------------------------------------------------
				HANDLE USER REQUESTS
				-------------------------------------------------------
			*/
			if (!is_admin())
			{
				// $Archoda->WP_Setup_Remove_Actions();
				// $Archoda->WP_Setup_Remove_Actions_Embeds();
				// $Archoda->WP_Setup_Remove_Actions_Emojis();
				
				/* 
					API
				*/
				$Archoda->WP_API_Wineries_All_Init();
				$Archoda->WP_API_Wineries_Featured_Init();
				$Archoda->WP_API_Wineries_Filtered_Init();
				
				/* 
					API: SNIPCART
				*/

				$ArchodaSnipcart->WP_API_WebHooks_Validation_Init();
				$ArchodaSnipcart->WP_API_Webhooks_Validation_Shipping_Init();
				$ArchodaSnipcart->WP_API_Webhooks_Validation_Product_Init();
			}

			/*
				-------------------------------------------------------
				HANDLE ADMIN REUQESTS
				-------------------------------------------------------
			*/
			if (is_admin())
			{

				/*
					WP CORE FUNCTION HOOKS/ACTIONS
				*/

				$Archoda->WP_Admin_Init_Hook_Hide_Editor(null);
				$Archoda->WP_Post_Save_Hook();

				//$Archoda->WP_Wineries_Get_All();

				/*
					WP ADMIN MANAGEMENT
				*/

				// Remove Yoast from all Custom Post Types
				//$Archoda->WP_Setup_Admin_Role_Remove_Yoast_From_Post_Types(['wineries', 'test']);

				// Only show minimal if not SuperAdmin
				if (in_array( 'superadmin', (array) wp_get_current_user()->roles))
				{
					// Remove nothing
				} 
				else if (in_array( 'administrator', (array) wp_get_current_user()->roles))
				{
					// Only show minimal if not SuperAdmin
					//$Archoda->WP_Setup_Admin_Role_Remove_Menu_Items();
					//wp_redirect('/wp/wp-admin/edit.php?post_type=wineries');
				}
				else
				{
					// Only show minimal if not SuperAdmin
					//$Archoda->WP_Setup_Admin_Role_Winery_Remove_Menu_Items();
					//wp_redirect('/wp/wp-admin/edit.php?post_type=wineries');
				}
			}

			/*
				-------------------------------------------------------
				HANDLE FOR ALL REUQESTS
				-------------------------------------------------------
			*/

			/*
				WP ADMIN IMAGE RESIZE OPTIONS
				---
				Note: Set width @'9999' and crop @false to constrain resize to fixed height
			*/

			remove_image_size( 'thumbnail' );
			remove_image_size( 'medium' );
			remove_image_size( 'medium_large' );
			remove_image_size( 'large' );
			remove_image_size( 'full_size' );

			add_image_size('Winery Product Image Thumbnail', 150, false);
			add_image_size('Winery Product Image Desktop', 9999, 720, false);
			add_image_size('Winery Product Image Tablet', 9999, 600, false);
			add_image_size('Winery Product Image Mobile', 9999, 392, false);
			
			add_image_size('Winery 16:9 Image Thumbnail', 9999, 150, false);
			add_image_size('Winery 16:9 Image Desktop', 9999, 522, false);
			add_image_size('Winery 16:9 Image Tablet', 9999, 422, false);
			add_image_size('Winery 16:9 Image Mobile', 9999, 300, false);

			/*
				GRAVITY FORMS
			*/

			// Encrypt DB Entry Data Before saving
			add_filter( 'gform_save_field_value', function($value, $entry, $field, $form)
			{
				global $ArchodaGravityForms;
				return $ArchodaGravityForms->EncryptHook($value, $entry, $field, $form);

			}, 10, 5 );
			
			// Decrypt DB Entry Data Before displaying to the user
			add_filter( 'gform_get_input_value', function($value, $entry, $field, $form)
			{
				//if (is_admin() && rgget('view') == 'entry')
				//{
					global $ArchodaGravityForms;
					return $ArchodaGravityForms->DecryptHook($value, $entry, $field, $form);
				//}

			}, 10, 5 );

		}
		catch (Expression $e)
		{
			// Do nothing for now....
		}

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Winery2Home, use a find and replace
		 * to change 'archoda' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'archoda', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'archoda' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'archoda_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'archoda_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function archoda_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'archoda_content_width', 640 );
}
add_action( 'after_setup_theme', 'archoda_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function archoda_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'archoda' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'archoda' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'archoda_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function archoda_scripts() {
	wp_enqueue_style( 'archoda-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'archoda-style', 'rtl', 'replace' );

	wp_enqueue_script( 'archoda-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'archoda_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

