<?php

namespace ARCHODA
{

    class WP
    {
        public bool $WP_Regsitered = false;
        public string $WP_Plugin_Name = '';
        public string $WP_Regsitered_File = '';
        public string $WP_Plugin_Path = '';

        public function _constructor( $_file )
        {
            // Do nothing...
        }

        public function WP_Register( $_data )
        {
            $this->WP_Plugin_Registered = true;
            $this->WP_Plugin_Name = $_data['name'];
            $this->WP_Plugin_File = $_data['plugin'];
            $this->WP_Plugin_path = $_data['file'];
        }

        public function WP_Register_Map()
        {
            $class_vars = get_class_vars( get_class( $this ) );

            foreach ($class_vars as $name => $value) {
                $_SESSION[ $name ] = $value;
            }
        }
    }
}


?>