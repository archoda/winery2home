<?php
/**
 * Summary.
 *
 * Description.
 *
 * @since x.x.x
 *
 * @see Function/method/class relied on
 * @link URL
 * @global type $varname Description.
 * @global type $varname Description.
 *
 * @param type $var Description.
 * @param type $var Optional. Description. Default.
 * @return type Description.
 */



class ARCHODA_OWASP {

        function __construct()
        {
        	// Do something...
            $this::XSSPoweredBy();
        }

        function XSSPoweredBy()
        {
        	header_remove('X-Powered-By');
        }

        function XSSContentSecurityPolicy($_value)
        {	
        	$value = ($_value != null) ? $_value : 'none';

        	header('Content-Security-Policy: ' . $value);

        }

        function XSSXFrameOptions($_value)
        {	
        	$value = ($_value != null) ? $_value : 'none';

        	header('X-Frame-Options: ' . $value);

        }

        function XSSXContentTypeOptions($_value)
        {
        	$value = ($_value != null) ? $_value : 'none';

        	header('X-Content-Type-Options: ' . $value);
        }

        function XSSReferrerPolicy($_value)
        {
        	$value = ($_value != null) ? $_value : 'none';

        	header('Referrer-Policy: ' . $value);

        }

        function XSSPermissionPolicy($_value)
        {
        	$value = ($_value != null) ? $_value : 'none';

        	header('Permission-Policy: ' . $value);

        }

        function XSSExpectCT($_value)
        {
        	$value = ($_value != null) ? $_value : 'none';

        	header('Expect-CT: ' . $value);
        	
        }

        function XSSStrictTransportSecurity($_value)
        {
        	$value = ($_value != null) ? $_value : 'none';

        	header('Strict-Transport-Security: ' . $value);

        }

        function XSSSanitizeQuerystring($query, $htmlStrip)
        {
            // Sanitize HTML check
            $querystring = ($htmlStrip && is_bool($htmlStrip)) 
                    ? $this::XSSSanitizeStripHTML($query)
                    : $query;

            // Sanitize Slashes
            $querystring = $this::XSSSanitizeStripSlashes($querystring);

            // Sanitize C Slashes
            $querystring = $this::XSSSanitizeStripBackslashes($querystring);

            // Sanitize all acceptible chars...for now
            $querystring = htmlspecialchars($querystring, ENT_QUOTES, 'utf-8');

            return $querystring;
        }

        function XSSSanitizeStripHTML($data)
        {
            return preg_replace('/\<(\/)?[a-zA-Z]{0,}(([^\>])*)?\>/', '', urldecode($data));
        }

        function XSSSanitizeStripSlashes($data)
        {
            return preg_replace('/\//', '', $data);
        }

        function XSSSanitizeStripBackslashes($data)
        {
            return str_replace('\\', '', $data);
        }

    }

?>