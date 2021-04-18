<?php

/**
 * Plugin Name: Archoda
 * Plugin URI: http://archodadigital.com
 * Description: Custom theme control plugin
 * Version: 1.0
 * Author: Joe Mallory
 * Author URI: http://archodadigital.com
 */

add_action( 'rest_api_init', function ()
{

    // JS API https://developer.wordpress.com/
    register_rest_route( 'wineries', 'products', array(
        'methods' => 'GET',
        'callback' => function() {

            // Clear cache - if required
            wp_cache_flush();

            // Run DB Query
            $wpq = new WP_Query([
                'post_type' 		=> 'wineries',
                'posts_per_page' 	=> -1,
            ]);
            
            // Create the Wineries Array
            $Wineries = [];

            // Get all the ACF Wineries
            foreach($wpq->posts as $key => $value)
            {
                array_push($Wineries, get_fields($value->ID));
            }
            
            // Create a response object with ACF Wineries
            $response = new WP_REST_Response($Wineries, 200);

            // Set headers
            $response->set_headers([ 'Cache-Control' => 'must-revalidate, no-cache, no-store, private' ]);
            //$response->set_headers([ 'Cache-Control' => 'max-age=3600, must-revalidate']);

            // Return response with ACF Wineries
            return $response;
        },
    ) );

} );

?>