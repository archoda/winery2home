<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wpw2h_winery2home' );

/** MySQL database username */
define( 'DB_USER', 'w2hadmin' );

/** MySQL database password */
define( 'DB_PASSWORD', 'w2h@dmin!1' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:8889' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ')@P}+/@V6g?jY@+279FN§Do6WZ|mp+PI?.nO §Zc>/oZl-&P1Xzx!kP>qU{B%U],');
define('SECURE_AUTH_KEY',  ' kWqk.7KtXUC`v$rovPUVMl@gRxG{@V~mY-M}BuT glOX{pc_$`&;9UyV8[K%eO1');
define('LOGGED_IN_KEY',    'or§M6W8&>C%z=V$&meA=F}b9]c6W;QoH%YRVT+&[~FqsoJRVBcyvY`I5K@GA{@;m');
define('NONCE_KEY',        'bQwLR§w{>QkS&QZC|}-7zd_74x{57-s>[<@3@MK%>qD<jN1.^Uq-+J6&e3NE@Jb:');
define('AUTH_SALT',        'dIP)e1B3L&NT4@0k[]wa2O!.JK4?LwXJJ AlTs+KQ[}csEkh~u/:xDPfrvBd(271');
define('SECURE_AUTH_SALT', '7_2iIUz2`3o+_M~)I9F1U@5Ovmv[<Uf1u84tOkhNz`Q§erwnt8f|Wm&l^0=6%}jP');
define('LOGGED_IN_SALT',   'fu9$,u%SU(e{]Xh(7rHuu}|NF@6-3C[klP~&+>&v,PVhu9]zDaBf8l2b.NNn{@+f');
define('NONCE_SALT',       'Cr^[1U/yu926;hsNxK:12[iS]YIi%M/?u`>F3&Qy)UVu_wYO elFK4H[F>^ym$mC');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
// error_reporting(E_ALL);
// ini_set('error_reporting', E_ALL );
// ini_set('display_errors','Off');
define('WP_DISABLE_FATAL_ERROR_HANDLER', true );
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true);
define('WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


/**
 * Set Archoda for customized theme, functions, plugins, etc...
 * 	
 * @since 1.0.0
 */
/** Sets up custom Archoda WordPress vars and included files. */

/**
 * Summary: Import the required Archoda theme configuration file(s);
 * @since 1.0.0
 */
// require_once ABSPATH . 'wp-content/themes/winery2home/classes/archoda.php';
// require_once ABSPATH . 'wp-content/themes/winery2home/classes/archoda-error.php';
// require_once ABSPATH . 'wp-content/themes/winery2home/classes/archoda-emailer.php';

/**
 * Summary: Register the Archoda superglobals
 * @since 1.0.0
 */
// global $ARCHODA;
// global $ARCHODA_ERROR;

/**
 * Summary: Init the the archoda superglobals
 * @since 1.0.0
 */
// $ARCHODA = new ARCHODA();


/**
 * Summary: Set Archoda error handler based on WP shutdown and override error page and display
 * @since 1.0.0
 */
// add_filter('shutdown', function() {
	
// 	// Initialize error capture
// 	$ARCHODA_ERROR = new ARCHODA_ERROR();

// 	// Show output to screen when in debug mode
// 	if (WP_DEBUG)
// 	{
// 		print_r($ARCHODA_ERROR->Error_Handle());
// 	}

// 	//$ARCHODA_EMAILER = new ARCHODA_EMAILER();
// });

// /** Step 2 (from text above). */
// add_action( 'admin_menu', 'my_plugin_menu' );

// /** Step 1. */
// function my_plugin_menu() {
// 	add_options_page('settings.php', 'Archoda Environment Settings', 'Archoda Environment Settings', 'administrator', 'archoda-environment-settings', function() {}, 100000 );
// }

// /** Step 3. */
// function my_plugin_options() {
// 	if ( !current_user_can( 'manage_options' ) )  {
// 		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
// 	}
// 	echo '<div class="wrap">';
// 	echo '<p>Here is where the form would go if I actually had options.</p>';
// 	echo '</div>';
// }

/*
add_action('admin_menu', 'archoda_register_options');

function archoda_register_options() {
	add_submenu_page( 'options-general.php', 'Archoda Option Settings', 'Archoda', 'administrator', 'custom-submenu', 'archoda_initialize_options', 0 );
}

function archoda_initialize_options() { 
	
	?>

	<h1><?php echo get_admin_page_title();?></h1>

	<?php settings_fields( 'custom-submenu' ); ?>

<?php } 

//throw new Exception('err1');
*/
?>