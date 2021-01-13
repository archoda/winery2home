<?php

namespace ARCHODA
{
    class Utils extends WP
    {
        function _constructor()
        {
            // Silence is golden...
        }

        public static function Compare_Type( $_a , $_b )
        { 
            return ( gettype( $_a ) === gettype( $_b ) ) ? true : false;
        }

        public static function Compare_DTO( $_model, $_data, $_dto = null )
        {  
            // Walk Model
            array_walk( $_model , function( $_value, $_key, $_dto )
            {
                // Recusive on Detect Array Wrapper
                if ( !array_key_exists('Data_Type', $_value) )
                {
                    self::Compare_DTO( $_dto['Model'][$_key] , $_dto['Data'][$_key] , $_dto );
                }
                // DTO Rules
                else if ( is_array( $_value ))
                {   
                    // Skip Callback???
                    if ( is_callable( $_dto['Data'][$_key] ))
                    {
                        // echo $_key . ' :: ' . http_build_query( $_dto[0][$_key] ) . '<br />';
                        // echo $_key;// . ' :: ' . print_r( $_dto[1][$_key] , false );
                    }
                    else
                    {
                        // Walk Model Rules
                        foreach ( $_dto['Model'][$_key] as $_key2 => $_value2 )
                        {
                            // Validate Required
                            if ( $_key2 == 'Required' )
                            {
                                // Validate Data_Type when Required ONLY
                                if ( $_key2 == 'Data_Type' && $_dto['Model'][$_key]['Required'] ) 
                                { 
                                    if ( !self::Compare_DTO_Data_Type( $_dto['Model'][$_key]['Data_Type'],  $_dto['Data'][$_key] ) ) 
                                    die( sprintf( 'Error: Custom Post Type\'s <strong>\'%s\'</strong> Map Rule for <strong>\'%s\'</strong> does not match the type <strong>\'%s\'</strong>', $_key, $_key2, $_dto['Model'][$_key]['Data_Type'] ) );
                                }

                                if ( $_dto['Model'][$_key]['Required'] && !self::Compare_DTO_Required( $_dto['Model'][$_key]['Data_Type'], $_dto['Model'][$_key]['Required'],  $_dto['Data'][$_key] ) ) 
                                die( sprintf( 'Error: Custom Post Type\'s <strong>\'%s\'</strong> Map Rule for <strong>\'%s\'</strong> has value of <strong>\'%s\'</strong>', $_key , $_key2 ,  $_dto['Data'][$_key] ) );
                            }
                            else
                            {
                                // Validate Empty Value
                                if ( $_key2 == 'Empty' ) 
                                {
                                    if ( $_dto['Model'][$_key]['Empty'] && !self::Compare_DTO_Empty( $_dto['Model'][$_key]['Data_Type'], $_dto['Model'][$_key]['Empty'],  $_dto['Data'][$_key] ) ) 
                                    die( sprintf( 'Custom Post Type\'s <strong>\'%s\'</strong> Map Rule for <strong>\'%s\'</strong> has a value of <strong>\'%s\'</strong>', $_key, $_key2, $_dto['Data'][$_key] ) );
                                }

                                // Validate Nullable
                                if ( $_key2 == 'Nullable' ) 
                                {
                                    if ( !$_dto['Model'][$_key]['Nullable'] && !self::Compare_DTO_Nullable( $_dto['Model'][$_key]['Data_Type'], $_dto['Model'][$_key]['Nullable'],  $_dto['Data'][$_key] ) ) 
                                    die( sprintf( 'Error: Custom Post Type\'s <strong>\'%s\'</strong> Map Rule for <strong>\'%s\'</strong> has value of <strong>\'%s\'</strong>', $_key, $_key2, $_dto['Data'][$_key] ) );
                                }
                            }

                            // Validate Default Value
                            if ( $_key2 == 'Default_Value' ) 
                            {
                                if ( $_dto['Model'][$_key]['Default_Value'] && !self::Compare_DTO_Default_Value( $_dto['Model'][$_key]['Data_Type'], $_dto['Model'][$_key]['Default_Value'],  $_dto['Data'][$_key] ) ) 
                                die( sprintf( 'Error: Custom Post Type\'s <strong>\'%s\'</strong> Map Rule for <strong>\'%s\'</strong> has a value of <strong>\'%s\'</strong>', $_key, $_key2, $_dto['Data'][$_key] ) );
                            }

                        }
                        //echo $_key . ' :: ' . http_build_query( $_dto['Model'][$_key] ) . '<br />';
                        //echo $_key . ' :: ' . gettype($_dto['Data'][$_key]);
                        //echo '<br />';
                    }
                }
                else
                {
                    // Throw error as we could not map it...
                }

            }, $_dto = [ 'Model' => $_model, 'Data' => $_data ] );
        }

        private static function Compare_DTO_Data_Type( $_a , $_b )
        {
            if ( is_array( $_b ) )
            {
                $valid = false;

                foreach( $_b as $_bb )
                {
                    if ($_a === gettype( $_bb ))
                    {
                        $valid == true;
                        break;
                    }
                }

                return $valid;
            }
            else
            {
                return ($_a === gettype( $_b ) );
            }
        }

        private static function Compare_DTO_Required( $_a , $_b , $_c )
        {
            if ( $_b && $_c != null) return true;

            return false;
        }

        private static function Compare_DTO_Nullable( $_a , $_b , $_c )
        {
            if ( $_b && $_c === null || !$_b && $_c !== null ) return true;

            return false;
        }

        private static function Compare_DTO_Empty( $_a , $_b , $_c )
        {
            if ( $_a === 'string' && !$_b && $_c == null) return false;

            return true;
        }

        private static function Compare_DTO_Default_Value( $_a , $_b , $_c )
        {
            if ( !$_b && $_c == null) return false;

            return true;
        }
    }

}

?>