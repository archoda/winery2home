<?php

/**
 * Archoda
 *
 * @package           PluginPackage
 * @author            Joe Mallory
 * @copyright         Archoda
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Archoda
 * Plugin URI:        https://archodadigital.com
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Archoda: Joe Mallory
 * Author URI:        https://archodadigital.com
 * Text Domain:       archoda
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


/* Copyright (C) Archoda, DBA - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Joe Mallory <jmallory@archodadigital.com>, September 1943
 */


// Start plugin session
session_start();



// Define plugin vars
defined( 'ABSPATH' ) OR exit;



// Require core class
require_once( __DIR__ . '/classes/archoda-wp.php');


// Manage plugin work
global $ARC;



$ARC = new \ARCHODA\WP();



function WP_Register_Activation_Hook()
{
    $GLOBALS['ARC']->WP_Register_Activation_Hook( [
        'Registered' => true,
        'Name' => 'Archoda',
        'File' => __FILE__,
        'Path' => $_REQUEST['plugin']
    ] );

    // Uncomment the following line to see session test function in action
    // $_SESSION['Register_Test_Activation'] = ':: $_SESSION[\'Register_Test_Activation\'] => Success ::';
    // die( 'Register_Test_Activation :: ' . $_SESSION['Register_Test_Activation'] . ' :: ' . $GLOBALS['ARC']->WP_Plugin_Name);
}

function WP_Register_Deactivation_Hook()
{
    $GLOBALS['ARC']->WP_Register_Deactivation_Hook( [
        'Registered' => false,
        'Name' => 'Archoda',
        'File' => __FILE__,
        'Path' => $_REQUEST['plugin']
    ] );

    // Uncomment the following line to see session test function in action
    // $_SESSION['Register_Test_Deactivation'] = ':: $_SESSION[\'Register_Test_Deactivation\'] => Success ::';
    // die( 'Register_Test_Deactivation :: ' . $_SESSION['Register_Test_Deactivation'] . ' :: ' . $GLOBALS['ARC']->WP_Plugin_Name);
}

function WP_Register_Uninstall_Hook()
{
    // Destroy the object
    global $ARC;
    $ARC = null;

    // Uncomment the following line to see session test function in action
    // $_SESSION['Register_Test_Uninstall'] = ':: $_SESSION[\'Register_Test_Uninstall\'] => Success ::';
    // die( 'Register_Test_Uninstall :: ' . $_SESSION['Register_Test_Uninstall'] . ' :: ' . $GLOBALS['ARC']->WP_Plugin_Name);
}

function WP_Admin_Enqueue_Styles()
{
    $GLOBALS['ARC']->WP_Register_Enqueue_Styles( [
        [
            'Handle' => 'archoda',
            'File' => plugin_dir_url( __FILE__ ) . 'assets/css/archoda-wp-custom-field-views.css',
        ]
    ] );
}

// WP Register activation
register_activation_hook( __FILE__ , 'WP_Register_Activation_Hook' );

// WP Register deactivatiom
register_deactivation_hook( __FILE__ , 'WP_Register_Deactivation_Hook' );

// WP Register uninstallation
register_uninstall_hook( __FILE__ , 'WP_Register_Uninstall_Hook' );

// WP Enqueue Styles
add_action( 'admin_enqueue_scripts' , 'WP_Admin_Enqueue_Styles' );

// WP Enqueue Scripts
// add_action( 'wp_enqueue_scripts', 'WP_Admin_Enqueue_Scripts' );

// WP Model Init

// WP Controller Init
$ARC->WP_Initialize();

// WP View Init

?>