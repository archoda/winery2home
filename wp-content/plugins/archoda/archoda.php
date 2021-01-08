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



// Require plugin classes
require_once( __DIR__ . '/classes/archoda.php');



// Manage plugin work
global $ARC;



$ARC = new \ARCHODA\WP();



function WP_Regsiter_Activation_Hook()
{
    $GLOBALS['ARC']->WP_Register( [
        'name' => 'Archoda',
        'plugin' => $_REQUEST['plugin'],
        'file' => __FILE__
    ] );

    # Uncomment the following line to see session test function in action
    $_SESSION['Test'] = ':: $_SESSION[\'Test\'] => Success ::';
    # die( 'Test :: ' . $_SESSION['yest'] . ' :: ' . $GLOBALS['ARC']->WP_Plugin_Name);
}



register_activation_hook(   __FILE__ ,  'WP_Regsiter_Activation_Hook' );



add_action( 'admin_menu' , function() {

    # Uncomment the following line to see session test function in action
    echo $_SESSION['Test'];
});

?>