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
    class WP_Custom_Field extends WP
    {

        public $Custom_Field = true;
        protected $Custom_Field_List = [];

        function _constructor()
        {
            // Silence is golden...
        }

        protected function WP_Custom_Field_Component( $_data )
        {
            array_push( $this->Custom_Field_List , $_data );
        }

        protected function WP_Custom_Field_Render()
        {
            $WP_Custom_Field_Template = '';
            
            foreach( $this->Custom_Field_List as $_data )
            {
                $WP_Custom_Field_Type = $_data['Html']['Type'];
                
                if ( $WP_Custom_Field_Type == 'Text' )
                {
                    $WP_Custom_Field_Template .= $this->WP_Custom_Field_Render_Label( $_data ) . $this->WP_Custom_Field_Render_Text( $_data );
                }
                else if ( $WP_Custom_Field_Type == 'Textarea' )
                {

                }
                else
                {
                    // Report bad type.....
                }
            }

            return $WP_Custom_Field_Template;
        }

        protected function WP_Custom_Field_Render_Label( $_data )
        {
            $WP_Custom_Field_Label_Template = '<label{{Attributes}}>{{Value}}</label>';
            $WP_Custom_Field_Label_Template_Value = ucfirst( $_data['Html']['Label']['Value'] );
            $WP_Custom_Field_Label_Template_Attributes = '';

            foreach ( $_data['Html']['Label']['Attributes'] as $_key => $_value )
            {
                if ($_value != '')
                {
                    
                    $_key = strtolower($_key);
                    $_value = ( getType($_value) == 'boolean')
                             ? '' : ('="' . $_value . '" ');

                    $WP_Custom_Field_Label_Template_Attributes .= (($WP_Custom_Field_Label_Template_Attributes == '') ? ' ' : '' ) . $_key . $_value;
                }
            }

            $WP_Custom_Field_Label_Template = str_replace(
                '{{Value}}', 
                $WP_Custom_Field_Label_Template_Value,
                str_replace(
                    '{{Attributes}}', 
                    $WP_Custom_Field_Label_Template_Attributes,
                    $WP_Custom_Field_Label_Template, 
                )
            );

            return $WP_Custom_Field_Label_Template;
        }

        protected function WP_Custom_Field_Render_Text( $_data )
        {
            $WP_Custom_Field_Template = '<input type="text"{{Attributes}} value="{{Value}}" />';
            $WP_Custom_Field_Template_Value = $_data['Meta_Value'];
            $WP_Custom_Field_Template_Attributes = '';

            foreach ( $_data['Html']['Attributes'] as $_key => $_value )
            {
                // Handle data-[name]
                if ( ( $_key ) == 'Data')
                {

                }
                else
                {
                    if ($_value != '')
                    {
                        $_key = $_key;
                        $_value = ( gettype($_value) == 'bool')
                                ? '' : ('="' . $_value . '" ');

                        $WP_Custom_Field_Template_Attributes .= $_key . $_value;
                    }
                }
            }

            $WP_Custom_Field_Template = str_replace(
                '{{Value}}', 
                $WP_Custom_Field_Template_Value,
                str_replace( 
                    '{{Attributes}}', 
                    $WP_Custom_Field_Template_Attributes,
                    $WP_Custom_Field_Template, 
                ),
            );

            return $WP_Custom_Field_Template;
        }

        protected function WP_Custom_Field_Get( )
        {               
            return get_post_meta(
                $this->Custom_Field_Data['Post_Id'], 
                $this->Custom_Field_Data['Meta_Key'], 
                $this->Custom_Field_Data['Unique'], 
            );
        }

        protected function WP_Custom_Field_Set( )
        {
            return update_post_meta(
                $this->Custom_Field_Data['Post_Id'],
                $this->Custom_Field_Data['Meta_Key'],
                $this->Custom_Field_Data['Meta_Value'],
                $this->Custom_Field_Data['Unique'],
            );
        }

        protected function WP_Custom_Field_List()
        {
            return $this->Custom_Field_List;
        }

    }
}

?>