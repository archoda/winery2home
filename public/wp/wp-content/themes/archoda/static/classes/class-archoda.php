<?php

class Archoda
{

    function __construct() {
        // Silence is golden...
    }

    public function WP_Post_Save_Hook()
    {
        add_action( 'save_post', function($post_ID, $post, $update)
        {
            //echo 'update post id: ' . $post_ID . ' ' . print_r($post, false);

        }, 10, 3 );
    }

    public function WP_Admin_Init_Hook_Hide_Editor($pages)
    {
        
        global $Pages;
        
        $Pages = $pages;

        add_action( 'admin_init', function($Pages) {
            
            if ($Pages == null) remove_post_type_support('page', 'editor');

            // $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
            
            // if( !isset( $post_id ) ) return;
            
            // $pagetitle = get_the_title($post_id);
            
            // if($pagetitle == 'Your Page Title'){
            //     remove_post_type_support('page', 'editor');
            // }
        });
    }

    public function WP_Setup_Remove_Actions()
    {
        // Clean Unwanted WP Stuff
		// https://stackoverflow.com/questions/34750148/how-to-delete-remove-wordpress-feed-urls-in-header
		// https://www.wpexplorer.com/clean-wordpress-head/

		remove_action( 'wp_head', 'wp_bootstrap_starter_pingback_header' );
		remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
		remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
		remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
		remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
		remove_action( 'wp_head', 'index_rel_link' ); // index link
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
		remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
		remove_action( 'wp_head', 'wp_shortlink_wp_head'); // Shortlink

    }

    public function WP_Setup_Remove_Actions_Embeds()
    {
        // Clean Unwanted API in head
		// https://wordpress.stackexchange.com/questions/211467/remove-json-api-links-in-header-html
		remove_action( 'wp_head',  'rest_output_link_wp_head' );
		remove_action( 'wp_head',  'wp_oembed_add_discovery_links' );
		remove_action( 'template_redirect', 'rest_output_link_header', 11 );
    }

    public function WP_Setup_Remove_Actions_Emojis()
    {
        // Clean Unwanted WP Emoji conversions
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );	
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    }


    public function WP_Setup_Admin_Role_Winery_Remove_Menu_Items()
    {
        
        add_action('admin_head', function() {
             echo '<style type="text/css">
                    #screen-meta,
                    #screen-meta-links,
                    #wp-admin-bar-gform-forms,
                    #wpadminbar li#wp-admin-bar-gform-forms,
                    #collapse-menu { display: none !important; }
                    </style>';
        });

        // Remove Menu Items
        add_action('wp_before_admin_bar_render',function()
        {

            global $wp_admin_bar;
            $wp_admin_bar->remove_menu('site-name');
            $wp_admin_bar->remove_menu('updates');
            $wp_admin_bar->remove_menu('comments');
            $wp_admin_bar->remove_menu('new-content');
            $wp_admin_bar->remove_menu('wpseo-menu');
            $wp_admin_bar->remove_menu('gform-forms');
            //$wp_admin_bar->remove_menu('top-secondary');

        }, 0);
        
        add_action('admin_init', function()
        {
            remove_menu_page( 'index.php'); // Admin Dashboard Page(s)

            remove_menu_page( 'edit.php' ); // Admin Posts Page(s)
            remove_menu_page( 'edit.php?post_type=page' ); // Admin Posts Page(s)
            remove_menu_page( 'post-new.php' ); // Admin Posts New Page(s)
            remove_menu_page( 'themes.php' ); // Admin Themes 'Appearance' Page(s)
            

            remove_menu_page( 'edit-comments.php' ); // Admin Comments Page(s)

            remove_menu_page( 'upload.php' ); // Admin Posts Page(s)
            
            remove_menu_page( 'media-new.php' ); // Admin Posts Page(s)
            
            remove_menu_page( 'profile.php'); // Admin Profule Page(s)

            remove_menu_page( 'plugins.php'); // Admin Plugins Page(s)
            remove_menu_page( 'plugin-install.php'); // Admin Plugin Install Page(s)
            remove_menu_page( 'plugin-editor.php'); // Admin PLugin Editor Page(s)

            remove_menu_page( 'users.php'); // Admin Profile Page(s)


            remove_menu_page( 'tools.php'); // Admin Tools Page(s)
            remove_menu_page( 'import.php'); // Admin Tools Page(s)
            remove_menu_page( 'export.php'); // Admin Tools Page(s)
            remove_menu_page( 'site-health.php'); // Admin Tools Page(s)
            remove_menu_page( 'export-perosnal-data.php'); // Admin Tools Page(s)
            remove_menu_page( 'erase-personal-data.php'); // Admin Tools Page(s)

            remove_menu_page( 'options-general.php'); // Admin Options General Page(s)
            remove_menu_page( 'options-writing.php '); // Admin Options Writing Page(s)
            remove_menu_page( 'options-Reading.php '); // Admin Options Reading Page
            remove_menu_page( 'options-discussion.php'); // Admin Options Discussion Page(s)
            remove_menu_page( 'options-media.php'); // Admin Options Media Page(s)
            remove_menu_page( 'options-permalinks.php'); // Admin Options Permalinks Page(s)
            remove_menu_page( 'options-privacy.php'); // Admin Options Privacy Page(s)

            remove_menu_page( 'gf_edit_forms' ); // Admin Gravity Forms Page(s)
            remove_menu_page( 'wpseo_dashboard' ); // Admin Gravity Forms Page(s)
            remove_menu_page( 'edit.php?post_type=acf-field-group' ); // Admin Advanced Custom Fields Page(s)
            remove_menu_page( 'cptui_main_menu' ); // Admin Custom Post Type UI Page(s)

           
        
        });
    }

    public function WP_Setup_Admin_Role_Remove_Menu_Items()
    {
        
        add_action('admin_head', function() {
             echo '<style type="text/css">
                    #screen-meta,
                    #screen-meta-links,
                    #wp-admin-bar-gform-forms,
                    #wpadminbar li#wp-admin-bar-gform-forms,
                    #collapse-menu { display: none !important; }
                    </style>';
        });

        // Remove Menu Items
        add_action('wp_before_admin_bar_render',function()
        {

            global $wp_admin_bar;
            $wp_admin_bar->remove_menu('site-name');
            $wp_admin_bar->remove_menu('updates');
            $wp_admin_bar->remove_menu('comments');
            $wp_admin_bar->remove_menu('new-content');
            $wp_admin_bar->remove_menu('wpseo-menu');
            $wp_admin_bar->remove_menu('gform-forms');
            //$wp_admin_bar->remove_menu('top-secondary');

        }, 0);
        
        add_action('admin_init', function()
        {

            remove_menu_page( 'index.php'); // Admin Dashboard Page(s)

            remove_menu_page( 'edit.php' ); // Admin Posts Page(s)
            remove_menu_page( 'edit.php?post_type=page' ); // Admin Posts Page(s)
            remove_menu_page( 'post-new.php' ); // Admin Posts New Page(s)
            remove_menu_page( 'themes.php' ); // Admin Themes 'Appearance' Page(s)
            

            remove_menu_page( 'edit-comments.php' ); // Admin Comments Page(s)

            remove_menu_page( 'upload.php' ); // Admin Posts Page(s)
            
            remove_menu_page( 'media-new.php' ); // Admin Posts Page(s)
            
            //remove_menu_page( 'profile.php'); // Admin Profule Page(s)

            remove_menu_page( 'plugins.php'); // Admin Plugins Page(s)
            remove_menu_page( 'plugin-install.php'); // Admin Plugin Install Page(s)
            remove_menu_page( 'plugin-editor.php'); // Admin PLugin Editor Page(s)

            remove_menu_page( 'users.php'); // Admin Profile Page(s)


            remove_menu_page( 'tools.php'); // Admin Tools Page(s)
            remove_menu_page( 'import.php'); // Admin Tools Page(s)
            remove_menu_page( 'export.php'); // Admin Tools Page(s)
            remove_menu_page( 'site-health.php'); // Admin Tools Page(s)
            remove_menu_page( 'export-perosnal-data.php'); // Admin Tools Page(s)
            remove_menu_page( 'erase-personal-data.php'); // Admin Tools Page(s)

            remove_menu_page( 'options-general.php'); // Admin Options General Page(s)
            remove_menu_page( 'options-writing.php '); // Admin Options Writing Page(s)
            remove_menu_page( 'options-Reading.php '); // Admin Options Reading Page
            remove_menu_page( 'options-discussion.php'); // Admin Options Discussion Page(s)
            remove_menu_page( 'options-media.php'); // Admin Options Media Page(s)
            remove_menu_page( 'options-permalinks.php'); // Admin Options Permalinks Page(s)
            remove_menu_page( 'options-privacy.php'); // Admin Options Privacy Page(s)

            remove_menu_page( 'gf_edit_forms' ); // Admin Gravity Forms Page(s)
            remove_menu_page( 'wpseo_dashboard' ); // Admin Gravity Forms Page(s)
            remove_menu_page( 'edit.php?post_type=acf-field-group' ); // Admin Advanced Custom Fields Page(s)
            remove_menu_page( 'cptui_main_menu' ); // Admin Custom Post Type UI Page(s)

           
        
        });
    }

    public function WP_Setup_Admin_Role_Remove_Yoast_From_Post_Types($_array)
    {
        // https://wordpress.stackexchange.com/questions/108707/can-yoast-seo-fields-be-removed-from-custom-post-type
        
        global $v;
        $v = $_array;

        add_action( 'add_meta_boxes', function($v)
        {
            remove_meta_box('wpseo_meta', $v, 'normal');

        }, 11);
    }


    function WP_Wineries_Get_All()
    {
        // $posts = get_posts(array(
		// 	'post_type'			=> 'wineries',
		// 	'posts_per_page'	=> -1,
		// 	'order'				=> 'DESC',
		// 	'compare'			=> Array(
		// 							'key'	 		=> 'post_content',
		// 							'value'			=> array('phone number'),
		// 							'compare'		=> 'LIKE'
		// 	)
		// ));
		// echo $posts[0]->ID;
		// //var_dump($posts);
		// echo print_r(get_fields($posts[0]->ID));
        
        // $wpq = new WP_Query([
        //     'post_type' => 'wineries',
        //     'posts_per_page' => -1,
        //     //'s' => 'phone number'
        //     // 'meta_query' => [
        //     // 	[
        //     // 		'key' => 'post_content',
        //     // 		'compare' => '>',
        //     // 		'value' => 8,
        //     // 		'type' => 'numeric'
        //     // 	]
        //     // ]
        // ]);

        // echo print_r($wpq, true);

    }
}


?>