<?php

/*
 *
 * @Summary: WP Custom class for extending WPs built in post-types
 * @Description: ..
 * 
 * 
 * @link: https://developer.wordpress.org/reference/functions/register_post_type/
 * @link: https://developer.wordpress.org/plugins/post-types/registering-custom-post-types/
 * @link: https://codex.wordpress.org/Function_Reference/post_meta_Function_Examples
 * @since: 1.0.0
 */
 
namespace ARCHODA
{
    class WP_Custom_Post_Type extends WP
    {

        public $WP_Custom_Post_Type = true;
        protected $Model = null;

        function _constructor()
        {
            // Silence is golden...
        }

        protected function Register( $_data )
        {
            $this->Model = [
                'labels'                    => [
                    'name'                  => _x( $_data['Labels']['Name'], 'Post type general name', 'textdomain' ),
                    'singular_name'         => _x( $_data['Labels']['Singular_Name'], 'Post type singular name', 'textdomain' ),
                    'menu_name'             => _x( $_data['Labels']['Menu_Name'], 'Admin Menu text', 'textdomain' ),
                    'name_admin_bar'        => _x( $_data['Labels']['Name_Admin_Bar'], 'Add New on Toolbar', 'textdomain' ),
                    'add_new'               => __( $_data['Labels']['Add_New'], 'textdomain' ),
                    'add_new_item'          => __( $_data['Labels']['Add_New_Item'], 'textdomain' ),
                    'new_item'              => __( $_data['Labels']['New_Item'], 'textdomain' ),
                    'edit_item'             => __( $_data['Labels']['Edit_Item'], 'textdomain' ),
                    'view_item'             => __( $_data['Labels']['View_Item'], 'textdomain' ),
                    'view_items'            => __( $_data['Labels']['View_Items'], 'textdomain' ),
                    'search_items'          => __( $_data['Labels']['Search_Items'], 'textdomain' ),
                    'not_found'             => __( $_data['Labels']['Not_Found'], 'textdomain' ),
                    'not_found_in_trash'    => __( $_data['Labels']['Not_Found_In_Trash'], 'textdomain' ),
                    'parent_item_colon'     => __( $_data['Labels']['Parent_Item_Colon'], 'textdomain' ),
                    'all_items'             => __( $_data['Labels']['All_Items'], 'textdomain' ),
                    'archives'              => _x( $_data['Labels']['Archives'], 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
                    'attributes'            => _x( $_data['Labels']['Attributes'], 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
                    'insert_into_item'      => _x( $_data['Labels']['Insert_Into_Item'], 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
                    'uploaded_to_this_item' => _x( $_data['Labels']['Upload_To_This_Item'], 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
                    'featured_image'        => _x( $_data['Labels']['Featured_Image'], 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
                    'set_featured_image'    => _x( $_data['Labels']['Set_Featured_Image'], 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
                    'remove_featured_image' => _x( $_data['Labels']['Remove_Featured_Image'], 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
                    'use_featured_image'    => _x( $_data['Labels']['Use_Featured_Image'], 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
                    'filter_items_list'     => _x( $_data['Labels']['Filter_Items_List'], 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
                    'items_list_navigation' => _x( $_data['Labels']['Items_List_Navigation'], 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
                    'items_list'            => _x( $_data['Labels']['Items_List'], 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
                    'items_published'       => _x( $_data['Labels']['Item_Published'], '...', 'textdomain' ),
                    'items_published_privately' => _x( $_data['Labels']['Item_Published_Privately'], '...', 'textdomain' ),
                    'items_reverted_to_draft' => _x( $_data['Labels']['Item_Reverted_To_Draft'], '...', 'textdomain' ),
                    'items_scheduled' => _x( $_data['Labels']['Item_Scheduled'], '...', 'textdomain' ),
                    'items_updated' => _x( $_data['Labels']['Item_Updated'], '...', 'textdomain' ),
                ],
                'description'               => _x( $_data['Description'], 'Post type general description', 'textdomain' ), // string,
                'public'                    => $_data['Public'], // true,
                'hierarchical'              => $_data['Hierarchical'], // false,
                'exlude_from_search'        => $_data['Exclude_From_Search'], // false,
                'publicly_queryable'        => $_data['Publicly_Queryable'], // true,
                'show_ui'                   => $_data['Show_Ui'], // true,
                'show_in_menu'              => $_data['Show_In_Menu'], // true,
                'show_in_nav_menus'         => $_data['Show_In_Nav_Menus'], // true,
                'show_in_admin_bar'         => $_data['Show_In_Admin_Bar'], // true,
                'show_in_rest'              => $_data['Show_In_Rest'], // true,
                'rest_base'                 => $_data['Rest_Base'], // true,
                'rest_controller_class'     => $_data['Rest_Controller_Class'], // true,
                'capability_type'           => $_data['Capability_Type'], // 'post',
                'capabilities'              => $_data['Capabilities'], // 'array( 'post' ),
                'map_meta_cap'              => $_data['Map_Meta_Cap'], // false,
                'menu_position'             => $_data['Menu_Position'], // null,
                'menu_icon'                 => $_data['Menu_Icon'], // null,
                'supports'                  => $_data['Supports'], // 
                // 'register_meta_box_cb'      => $_data['Register_Meta_Box_CB'], // 
                // 'taxonomies'                => $_data['Taxonomies'], // 
                // 'has_archive'               => $_data['Has_Archive'], // true,
                'rewrite'                   => $_data['Rewrite'], // bool or array( 'slug' => 'book' ),
                // 'query_var'                 => $_data['Query_Var'], // true,
                // 'can_export'                => $_data['Can_Export'], // 
                // 'delete_with_user'          => $_data['Delete_With_User'], // 
                // 'template'                  => $_data['Template'], // 
                // 'template_lock'             => $_data['Template_Lock'], // 
            ];

            return register_post_type( $_data['Post_Type'], $this->Model );
        }

        protected function Unregister( $_data )
        {
            unregister_post_type( $_data['Post_Type'] );
        }

        protected function Update( $_data )
        {

        }
    }
}

?>