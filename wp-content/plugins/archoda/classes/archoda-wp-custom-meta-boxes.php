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
    class WP_Meta_Box extends WP
    {

        public $Meta_Box = true;
        protected $Meta_Box_Data = null;

        function _constructor()
        {
            // Silence is golden...
        }

        protected function Meta_Box_Register( $_data )
        {
            $this->Meta_Box_Data = $_data;

            add_action('add_meta_boxes', function()
            {
                foreach( $this->Meta_Box_Data as $_data)
                {
                    add_meta_box(
                        $_data['Id'] . '-' .rand ( 1000 , 1000000 ),
                        $_data['Title'],
                        $_data['Callback'],
                        $_data['Screen'],
                        $_data['Context'],
                        $_data['Priority'],
                        $_data['Callback_Args'],
                    );
                }

            } );
        }
    }

}

?>