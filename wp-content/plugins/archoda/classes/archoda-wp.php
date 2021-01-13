<?php

namespace ARCHODA
{
    class WP
    {
        public bool $WP_Plugin_Registered = false;
        public string $WP_Plugin_Name = '';
        public string $WP_Plugin_File = '';
        public string $WP_Plugin_Path = '';

        public function _constructor( )
        {
            // Silence is golden...

            // Add Utils class access
            $this->Utils = new Utils();
        }

        public function WP_Initialize()
        {
            // Add SP Save Post Hook (Update)
            add_action('save_post', [ $this, 'WP_Update_Post_Meta_Hook' ]);

            // Add admin menu
            $this->WP_Add_Admin_Menu_Hook();

            // Add admin init
            $this->WP_Add_Admin_Init_Hook();

            // Add Admin Meta Boxes
            $this->WP_Add_Meta_Boxes_Hook();
        }

        public function WP_Register_Activation_Hook( $_Data )
        {
            $this->WP_Plugin_Registered = $_Data['Registered'];
            $this->WP_Plugin_Name = $_Data['Name'];
            $this->WP_Plugin_File = $_Data['File'];
            $this->WP_Plugin_Path = $_Data['Path'];
        }

        public function WP_Register_Deactivation_Hook( $_Data )
        {
            $this->WP_Plugin_Registered = $_Data['Registered'];
            $this->WP_Plugin_Name = $_Data['Name'];
            $this->WP_Plugin_File = $_Data['File'];
            $this->WP_Plugin_Path = $_Data['Path'];
        }

        public function WP_Register_Uninstall_Hook( $_Data )
        {
            $this->WP_Plugin_Registered = $_Data['Registered'];
            $this->WP_Plugin_Name = $_Data['Name'];
            $this->WP_Plugin_File = $_Data['File'];
            $this->WP_Plugin_Path = $_Data['Path'];
        }

        public function WP_Register_Enqueue_Styles( $_data )
        {
            foreach( $_data as $_key )
            {
                wp_enqueue_style( $_key['Handle'] , $_key['File'] , false );
            }
        }

        //print_r(wp_get_current_user()->user_email);
        public function WP_Add_Admin_Menu_Hook( $_data = null )
        {
            add_action( 'admin_menu' , function() {
                
                if ( current_user_can( 'manage_options' ) )
                {
                    $this->WP_Add_Menu_Page([
                        'Page_Title' => 'Archoda Suite',
                        'Menu_Title' => 'Archoda',
                        'Capability' => 'manage_options',
                        'Menu_Slug' => 'archoda-suite',
                        'Callback_Function' => function()
                        { 
                            ?>
                                <div class="wrap">
                                    <h1 class="wp-heading-inline">Archoda Suite</h1>
                                </div>
                            <?php 
                        },
                        'Icon_Url' => 'dashicons-admin-plugins',
                        'Posistion' => 2
                    ]);

                    $this->WP_Add_Submenu_Page([
                        'Parent_Slug' => 'edit.php?post_type=arc-cpt',
                        'Page_Title' => 'Archoda Suite Custom Post Types',
                        'Menu_Title' => 'Custom Post Types',
                        'Capability' => 'manage_options',
                        'Menu_Slug' => 'archoda-suite-settings-custom-post-types',
                        'Callback_Function' => function()
                        { 
                            ?>
                                <div class="wrap">
                                    <h1 class="wp-heading-inline">Archoda Suite Settings: Custom Post Types</h1>
                                </div>
                            <?php 
                        }, 
                        'Posistion' => 0,
                    ]);

                    $this->WP_Add_Submenu_Page([
                        'Parent_Slug' => 'archoda-suite',
                        'Page_Title' => 'Archoda Suite Settings',
                        'Menu_Title' => 'Settings',
                        'Capability' => 'manage_options',
                        'Menu_Slug' => 'archoda-suite-settings',
                        'Callback_Function' => function()
                        { 
                            ?>
                                <div class="wrap">
                                    <h1 class="wp-heading-inline">Archoda Suite Settings</h1>
                                </div>
                            <?php 
                        }, 
                        'Posistion' => 1,
                    ]);
                }
                //else
                // {
                //     $this->WP_Remove_Menu_Page([
                //         'themes.php',
                //         'tools.php',
                //         'edit-tags.php',
                //         'upload.php',
                //         'edit-comments.php',
                //     ]);
                // }   
            
            });
        }

        private function WP_Remove_Menu_Page( $_data )
        {
            foreach ( $_data as $menu_slug )
            {
                remove_menu_page( $menu_slug );
            }
        }

        /**
         * 
         * @Summary: WP Add menu item to admin menu 
         * @Description: This will add any menu item to any top-level admin menu
         * 
         * @link: https://developer.wordpress.org/reference/functions/add_menu_page/
         * @since: 1.0.0 
         *
         **/
        private function WP_Add_Menu_Page( $_data )
        {
            add_menu_page(
                $_data['Page_Title'],
                $_data['Menu_Title'],
                $_data['Capability'],
                $_data['Menu_Slug'], 
                $_data['Callback_Function'],
                $_data['Icon_Url'],
                $_data['Posistion']
            );
        }

        /**
         * 
         * 
         * @Summary: WP Add submenu item to admin menu 
         * @Description: This will add any submenu item to any top-level parent menu item according to the 'parents_slug' string 
         * 
         * @link: https://developer.wordpress.org/reference/functions/add_submenu_page/
         * @link: https://wordpress.stackexchange.com/questions/110562/is-it-possible-to-add-custom-post-type-menu-as-another-custom-post-type-sub-menu
         * @link: https://wordpress.stackexchange.com/questions/38241/add-dividers-or-separators-between-nav-menu-items
         * @since: 1.0.0 
         *
         **/
        private function WP_Add_Submenu_Page( $_data )
        {   
            add_submenu_page(
                $_data['Parent_Slug'],
                $_data['Page_Title'],
                $_data['Menu_Title'],
                $_data['Capability'],
                $_data['Menu_Slug'], 
                $_data['Callback_Function'],
                $_data['Posistion'],
            );
        }

        private function WP_Add_Plugins_Page( $_data )
        {
            // add_plugins_page(
            //     string $page_title,
            //     string $menu_title,
            //     string $capability,
            //     string $menu_slug,
            //     callable $function = '',
            //     int $position = null
            // )
        }

        public function WP_Add_Admin_Init_Hook()
        {

            add_action('init', function() {
                
                // Create the new Custom Post Type Data Model
                $Custom_Post_Type_Model_Test = [
                    'Post_Type'                       => 'arccpt',
                    'Labels' => [
                        'Name'                        => 'Archoda Suite\'s Custom Post Types',
                        'Singular_Name'               => 'All Custom Post Types',
                        'Menu_Name'                   => 'All Custom Post Types',
                        'Name_Admin_Bar'              => 'Custom Post Types',
                        'Add_New'                     => 'Add New',
                        'Add_New_Item'                => 'Add New Item',
                        'New_Item'                    => 'New Item',
                        'Edit_Item'                   => 'Edit Item',
                        'View_Item'                   => '',
                        'View_Items'                  => '',
                        'Search_Items'                => '',
                        'Not_Found'                   => 'No Items Found',
                        'Not_Found_In_Trash'          => '',
                        'Parent_Item_Colon'           => '',
                        'All_Items'                   => 'Custom Post Types',
                        'Archives'                    => '',
                        'Attributes'                  => '',
                        'Insert_Into_Item'            => '',
                        'Upload_To_This_Item'         => '',
                        'Featured_Image'              => '',
                        'Set_Featured_Image'          => '',
                        'Remove_Featured_Image'       => '',
                        'Use_Featured_Image'          => '',
                        'Filter_Items_List'           => '',
                        'Items_List_Navigation'       => '',
                        'Items_List'                  => '',
                        'Item_Published'              => '',
                        'Item_Published_Privately'    => '',
                        'Item_Reverted_To_Draft'      => '',
                        'Item_Scheduled'              => '',
                        'Item_Updated'                => '',
                    ],
                    'Description'                     => 'An Archoda CPT...',
                    'Public'                          => true,
                    'Hierarchical'                    => false,
                    'Exclude_From_Search'             => true, // Should be same as pulbic
                    'Publicly_Queryable'              => true, // Should be same as pulbic
                    'Show_Ui'                         => true,
                    'Show_In_Menu'                    => 'archoda-suite', // Menu to be show in
                    'Show_In_Nav_Menus'               => true,
                    'Show_In_Admin_Bar'               => true,
                    'Show_In_Rest'                    => true,
                    'Rest_Base'                       => '',
                    'Rest_Controller_Class'           => '',
                    'Menu_Position'                   => 1,
                    'Menu_Icon'                       => '',
                    'Capability_Type'                 => 'post',
                    'Capabilities'                    => [ 'manage_options' ],// LEAVE AS MANAGE OPTIONS!!!
                    'Map_Meta_Cap'                    => true, // LEAVE AS TRUE!!!
                    'Supports'                        => [ 'title' ], // array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
                    'Register_Meta_Box_CB'            => function(){ 
                                                            //echo 'hello';
                                                        },
                    'Taxonomies'                      => [],
                    'Has_Archive'                     => false,
                    'Rewrite'                         => [ 'slug' => 'arccpt' ],
                    'Query_Var'                       => false,
                    'Can_Export'                      => true,
                    'Delete_With_User'                => null,
                    'Template_Lock'                   => false,
                ];

                // #1 Initialize Custom Post Type Model
                $WP_Custom_Post_Type_Model = new WP_Custom_Post_Type_Model();
                
                // #2 Map and validate the Custom Post Type & Model DTO
                Utils::Compare_DTO( $WP_Custom_Post_Type_Model->DTO_Get() , $Custom_Post_Type_Model_Test );
                
                // #3 Initialize a new Custom Post Type
                $WP_Custom_Post_Type = new WP_Custom_Post_Type();

                // #4 Instantiate the Custom Post Type
                $WP_Custom_Post_Type->Register( $Custom_Post_Type_Model_Test );

                // Model as Array to JSON for export...if needed.
                //echo json_encode( $Custom_Post_Type_Model_Test );
                
                // Model as JSON back to Array for inport...if needed.
                //print_r( json_decode(json_encode( $Custom_Post_Type_Model_Test ), true));
            });

        }

        /**
         * 
         *
         * @link: https://developer.wordpress.org/reference/functions/add_meta_box/
         * @link: https://wptheming.com/2010/08/custom-metabox-for-post-type/ 
         * 
        **/
        public function WP_Add_Meta_Boxes_Hook()
        {
            $WP_Meta_Box = new WP_Meta_Box();

            $WP_Meta_Box->Meta_Box_Register(
                [
                    [
                        'Id' => "General Settings",
                        'Title' => "General Settings",
                        'Callback' => function() {
                            
                            $WP_Custom_Field = new WP_Custom_Field();
                            
                            $WP_Custom_Field->WP_Custom_Field_Component(
                                [
                                    'Post_Id' =>  get_post( $_GET['post'], false)->ID,
                                    'Meta_Key' => 'slug',
                                    'Meta_Value' => 'Slug',
                                    'Unique' =>  true,
                                    'Html' => [
                                        'Type' => 'Text',
                                        'Label' => [
                                            'Value' => 'Post Type Slug',
                                            'Attributes' => [
                                                'Id' => 'label-slug',
                                                'Class' => 'label-slug',
                                                'For' => 'slug',
                                                'Hidden' => false,
                                                'Disabled' => false,
                                            ]
                                        ],
                                        'Attributes' => [
                                            'Id' => 'slug',
                                            'Name' => 'slug',
                                            'Class' => 'text',
                                            'Content-Editable' => '',
                                            'Data' => [],
                                            'Hidden' => false,
                                            'Disabled' => false,
                                            'Placeholder' => '(e.g. custom-type)',
                                        ]
                                    ]
                                ]
                            );

                            $WP_Custom_Field->WP_Custom_Field_Component(
                                [
                                    'Post_Id' =>  get_post( $_GET['post'], false)->ID,
                                    'Meta_Key' => 'plural-label',
                                    'Meta_Value' => 'Custom Types',
                                    'Unique' =>  true,
                                    'Html' => [
                                        'Type' => 'Text',
                                        'Label' => [
                                            'Value' => 'Plural Label',
                                            'Attributes' => 
                                            [
                                                'Id' => 'label-plural-label',
                                                'Class' => 'label-plural-label',
                                                'For' => 'slug',
                                                'Hidden' => false,
                                                'Disabled' => false,
                                            ],
                                        ],
                                        'Attributes' => [
                                            'Id' => 'slug',
                                            'Name' => 'plural-label',
                                            'Class' => 'text',
                                            'Hidden' => false,
                                            'Disabled' => false,
                                            'Placeholder' => '(e.g. Custom Types)',
                                        ]
                                    ]
                                ]
                            );

                            $WP_Custom_Field->WP_Custom_Field_Component(
                                [
                                    'Post_Id' =>  get_post( $_GET['post'], false)->ID,
                                    'Meta_Key' => 'singular-label',
                                    'Meta_Value' => 'Custom Type',
                                    'Unique' =>  true,
                                    'Html' => [
                                    'Type' => 'Text',
                                    'Label' => [
                                        'Value' => 'Singular Label',
                                        'Attributes' => [
                                                'Id' => 'label-singular-label',
                                                'Class' => 'label-singular-label',
                                                'For' => 'slug',
                                                'Hidden' => false,
                                                'Disabled' => false,
                                            ],
                                        ],
                                        'Attributes' => [
                                            'Id' => 'slug',
                                            'Name' => 'singular-label',
                                            'Class' => 'text',
                                            'Hidden' => false,
                                            'Disabled' => false,
                                            'Placeholder' => '(e.g. Custom Type)',
                                        ]
                                    ]
                                ]
                            );

                            //$Custom_Field_View = new Custom_Field_View();
                            
                            //$Custom_Field_View->Custom_Field_Component( $Custom_Field->Custom_Field_List );

                            echo $WP_Custom_Field->WP_Custom_Field_Render();
                            
                        },
                        'Screen' => "arccpt",
                        'Context' => "advanced",
                        'Priority' => "core",
                        'Callback_Args' => [],
                    ],
                    [
                        'Id' => "Advanced Settings",
                        'Title' => "Advanced Settings",
                        'Callback' => function() { echo 'example'; },
                        'Screen' => "arccpt",
                        'Context' => "advanced",
                        'Priority' => "core",
                        'Callback_Args' => [],
                    ],
                    [
                        'Id' => "Developer Settings",
                        'Title' => "Developer Settings",
                        'Callback' => function() { echo 'example'; },
                        'Screen' => "arccpt",
                        'Context' => "advanced",
                        'Priority' => "core",
                        'Callback_Args' => [],
                    ]
                ]
            );
        }

        public function WP_Update_Post_Meta_Hook( $_post_id )
        {
            // Don't auto update data on an autosave...
            if (defined ( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

            // Yeah, this, lol...
            if ($parent_id = wp_is_post_revision( $_post_id ) )
            {
                $_post_id = $parent_id;
            }

            // Save the data...
            update_post_meta(
                $_post_id,
                'slug' ,
                sanitize_text_field ( $_POST['slug'] )
            );
        }
    }

    // Include utils
    require_once( __DIR__ . '/utils/archoda-utils.php' );

    // Include Custom_Post_Type class extension
    require_once( 'archoda-wp-custom-post-types.php' );
    require_once( __DIR__ . '/models/archoda-wp-custom-post-types.php' );

    // Include Custom_Meta_Box class extension
    require_once( 'archoda-wp-custom-meta-boxes.php' );
    
    // Include Custom_Field class extension
    require_once( 'archoda-wp-custom-fields.php' );

    // Include Custom_Field_View class extension
    require_once( __DIR__ . '/views/archoda-wp-custom-fields.php' );
}
    


?>