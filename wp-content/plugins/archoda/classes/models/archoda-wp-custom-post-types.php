<?php

/*
 *
 * @Summary: WP Custom class for extending WPs built in post-types
 * @Description: ..
 * 
 * 
 * @link: https://developer.wordpress.org/reference/functions/add_meta_box/
 * @since: 1.0.0
 */
 
namespace ARCHODA
{
    class WP_Custom_Post_Type_Model extends WP
    {

        public function _constructor( )
        {

        }

        # https://developer.wordpress.org/reference/functions/register_post_type/
        # https://developer.wordpress.org/reference/functions/get_post_type_labels/
        # Data Type only checked when Required = true
        # Required = true ignores Nullable & Empty flags as they inherently cannot be null or empty types
        # Required = false && Nullable = false cannot be Null (Any Type)
        # Required = false && Empty = false cannot be '' (String Only)
        protected function DTO_Get()
        {
            // Set and return the DTO model
            return [
                    'Post_Type'                       => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Labels' => [
                        'Name'                        => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                        'Singular_Name'               => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                        'Menu_Name'                   => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                        'Name_Admin_Bar'              => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                        'Add_New'                     => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Add_New_Item'                => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'New_Item'                    => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Edit_Item'                   => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'View_Item'                   => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'View_Items'                  => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Search_Items'                => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Not_Found'                   => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Not_Found_In_Trash'          => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Parent_Item_Colon'           => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'All_Items'                   => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Archives'                    => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Attributes'                  => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Insert_Into_Item'            => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Upload_To_This_Item'         => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Featured_Image'              => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Set_Featured_Image'          => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Remove_Featured_Image'       => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Use_Featured_Image'          => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Filter_Items_List'           => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Items_List_Navigation'       => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Items_List'                  => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Item_Published'              => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Item_Published_Privately'    => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Item_Reverted_To_Draft'      => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Item_Scheduled'              => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                        'Item_Updated'                => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                    ],
                    'Description'                     => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Public'                          => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Exclude_From_Search'             => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Hierarchical'                    => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Publicly_Queryable'              => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Show_Ui'                         => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Show_In_Menu'                    => [ 'Data_Type' => ['boolean','string'], 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Show_In_Nav_Menus'               => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Show_In_Admin_Bar'               => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Show_In_Rest'                    => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Rest_Base'                       => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                    'Rest_Controller_Class'           => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                    'Menu_Position'                   => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Menu_Icon'                       => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ], // Rule Check Pass
                    'Capability_Type'                 => [ 'Data_Type' => ['string','array'], 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Capabilities'                    => [ 'Data_Type' => 'array', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Map_Meta_Cap'                    => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    // 'Supports'                        => [ 'Data_Type' => 'array', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    // 'Register_Meta_Box_CB'            => [ 'Data_Type' => 'function', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    // 'Taxonomies'                      => [ 'Data_Type' => 'array', 'Required' => false, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    // 'Has_Archive'                     => [ 'Data_Type' => ['boolean','string'], 'Required' => false, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    'Rewrite'                         => [ 'Data_Type' => ['boolean','array'], 'Required' => false, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    // 'Query_Var'                       => [ 'Data_Type' => ['boolean','string'], 'Required' => false, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    // 'Can_Export'                      => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    // 'Delete_With_User'                => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    // 'Template_Lock'                   => [ 'Data_Type' => ['boolean','string'], 'Required' => false, 'Nullable' => false, 'Empty' => false, 'Default_Value' => false ], // Rule Check Pass
                    
                    // Do the rest later.... 
                    // 'Query_Var'                       => true,
                    // 'Hierarchical'                    => false,
                    // 'Has_Archive'                     => true,
                    // 'Rewrite'                         => array( 'slug' => 'arc-cpts' ),
                    // 'Can_Export'                      => true,
                    // 'Delete_With_User'                => false,
                    // 'Template'                        => [],
                    // 'Template_Lock'                   => false,
                ];
        }


    }

}