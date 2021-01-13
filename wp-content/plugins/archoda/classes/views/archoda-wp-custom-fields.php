<?php

/*
 *
 * @Summary: WP Custom class for extending WPs built in post-types
 * @Description: ..
 * 
 * 
 * @link: https://developer.wordpress.org/reference/functions/register_post_type/
 * @since: 1.0.0
 */
 
namespace ARCHODA
{
    class Custom_Field_View extends WP
    {

        public $Custom_Field_View = true;

        protected $Custom_Field_Html = '';
        protected $Custom_Field_Html_Tag = 
        [
            'Type' => '',
            'Attributes' => [],
            'Content' => null,
            'Self_Close' => false
        ];

        function _constructor()
        {
            // Silence is golden...
        }

        protected function Custom_Field_Component( $_data )
        {
            return $this->Custom_Field_Html = $this->Custom_Field_Html_Render( $_data );
        }

        protected function Custom_Field_Html_Render( $_data )
        {
            $Custom_Field_Html = '';
            $Custom_Field_Html_Tag = '';
            $Custom_Field_Html_Tag_Open = '';
            $Custom_Field_Html_Attributes = '';
            $Custom_Field_Html_Content = '';
            $Custom_Field_Html_Tag_Close = null;

            array_walk_recursive( $_data , function( $_value , $_key )
            {
                //echo $_key . ' :: ' . $_value . '<br /><br />';
                if ($_key == 'Text') { 
                    $Custom_Field_Html_Tag = $_value;
                    $Custom_Field_Html_Tag_Open = '<' . $_value;
                }

            });
            foreach( $_data as $_key => $_value)
            {
                // $Data_Post_Id = $_value['Post_Id'];  echo $_value['Post_Id'];
                // $Data_Meta_Key = $_value['Meta_Key'];  echo $_value['Meta_Key'];
               
                // foreach( $_value as $_key2 => $_value2)
                // {
                //     // Html Level
                //     foreach( $_value2 as $_key3 => $_value3)
                //     {
                //         echo '<br /><br />' . $_key3;// . ' ' . print_r( $_value, false );
                //     }
                    
                // }
               
                // if ($_key2['Html]['Type'] == 'Text') { 
                //     $Custom_Field_Html_Tag = $_value;
                //     $Custom_Field_Html_Tag_Open = '<' . $_value;
                // }

                // if ($_key == 'Attributes')
                // {
                //     foreach( $_value as $_key2 => $_val2)
                //     {
                //         $Custom_Field_Html_Attributes .= $_key . '="'. $_value . '" ';
                //     }
                // }

                // if ($_key == 'Self_Close' && $_key) $Custom_Field_Html_Attributes .= ' />';

                // if ($_key == 'Content')
                // {
                //     $Custom_Field_Html_Content = ( gettype( $_key ) == 'array' ) 
                //                                  ? $this->Custom_Field_Html_Render( $_value ) 
                //                                  : $_value;
                // }

                // if ($_key == 'Self_Close' && !$_key) $Custom_Field_Html_Tag_Close = '</' . $Custom_Field_Html_Tag . '>';
            }
            
            // return $Custom_Field_Html = $Custom_Field_Html_Tag_Open . $Custom_Field_Html_Attributes . $Custom_Field_Html_Content . $Custom_Field_Html_Tag_Close;
        }

        protected function Custom_Field_Tag( $_data )
        {
            $Custom_Field_Html = '';

            //
            
            return $Custom_Field_Html;
        }

        protected function Custom_Field_Attributes( $_data )
        {
            return '<{{TAG}}{{ATTRIBUTES}}>{{CONTENT}}</{{TAG}}>';
        }

    }

}

?>