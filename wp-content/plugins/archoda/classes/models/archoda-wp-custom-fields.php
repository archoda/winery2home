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
    class WP_Custom_Fields_Model extends WP
    {

        //public $Utils;

        public $WP_Custom_Fields_Model = true;
        protected $Custom_Field_DTO = null;
        protected $Custom_Field_DTO_Geneology = null;
        
        public function _constructor( $_data )
        {
            //$this->Utils = parent::Utils;
        }

        protected function DTO_Map( $_data )
        {
            $DTO_Map = $this->DTO_Get();
            $DTO_Map_Key = null;
            $DTO_Map_Value = null;

            // Ensure type model base type
            //if ( !Utils::Compare_Type( $DTO_Map, $_data ) ) die( 'Custom Post Type Model and the param [ @$_data ] do not have the strong type match of \'array\' as required.' );

            //print_r( $DTO_Map );
            $_i = 0;

            // Map Custom Post Type to the DTO            
            array_walk_recursive( $_data , function( $_value , $_key, $_i )
            {
                global $_i;
                $_i++;
                //echo '<br /><br />' . print_r( $DTO_Map , false );
                echo '<br /><br />' . $_i . ': ' . $_key . ' :: ' . $_value . ' :: ' . gettype( $_array );
                //$DTO_Map_Value = $DTO_Map[$_key];
                //$DTO_Data = 
                // Walk child
                //if ( gettype($_value) == 'array') DTO_Map( DTO_Map( $_data ) );
                //echo $_key . ' :: ' . $DTO_Map[$_key] . '<br /><br />';
                //echo $_value . '<br /><br />';
                
                // Ensure type model base type
                // if ( Utils::Compare_Type( $DTO_Map_Key, $_key ) ) {
                //     echo $DTO_Map_Key;
                // }
                
            }, $_i);
        }

        private function DTO_Get()
        {
            // Set and return the DTO model
            return $Custom_Field_DTO = [
                'Post_Id' =>  [ 'Data_Type' => 'int', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                'Meta_Key' => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                'Meta_Value' => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                'Unique' => [ 'Data_Type' => 'boolean', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                'Html' => [
                    [
                        'Tag' => [ 'Name' => 'Label', 'Self_Close' => false, 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                        'Value' => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => true, 'Default_Value' => null ],
                        'Attributes' => [
                            // Unique Attribute
                            'For' => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                            'Form' => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                            // Global Attributes
                            'Id' => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                            'Class' => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                            'Data' => [ 'Data_Type' => 'array', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => null ],
                            'Disabled' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'Draggable' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ],
                            'Hidden' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'Lang' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'Spellcheck' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'Style' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'Tabindex' => [ 'Data_Type' => 'int', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'Title' => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'translate' => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                        ],
                        'Content' => [],
                    ],
                    [
                        'Tag' => [ 'Name' => 'Input', 'Type' => 'Text', 'Self_Close' => true, 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                        'Value' => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => true, 'Default_Value' => null ],
                        'Attributes' => [
                            // Unique Attribute
                            'Accept' => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => null ],
                            'Alt' => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => null ],
                            'Autocomplete' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => null ],
                            // Global Attributes
                            'Id' => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                            'Class' => [ 'Data_Type' => 'string', 'Required' => true, 'Nullable' => false, 'Empty' => false, 'Default_Value' => null ],
                            'Data' => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => null ],
                            'Disabled' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ],
                            'Draggable' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => false, 'Default_Value' => false ],
                            'Hidden' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => false, 'Empty' => true, 'Default_Value' => false ],
                            'Lang' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'Spellcheck' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'Style' => [ 'Data_Type' => 'boolean', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'Tabindex' => [ 'Data_Type' => 'int', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'Title' => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                            'translate' => [ 'Data_Type' => 'string', 'Required' => false, 'Nullable' => true, 'Empty' => true, 'Default_Value' => false ],
                        ],
                        'Content' => [],
                    ]
                ]
            ];
        }

        protected function DTO_Geneology_Get( $_data )
        {

        }


    }

}