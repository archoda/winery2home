<?php

// Start PHP Session
session_start();

// Set Vars
$cookieAgeCheck = 'age-check';

// Detect Age-Check
if (!strpos($_SERVER['REQUEST_URI'], $cookieAgeCheck) && $_COOKIE[$cookieAgeCheck] !== 'true')
{
	//header('Location: /age-check');
}

$hostProxy = $_SERVER['HTTP_X_ORIGINAL_HOST'] ;
$protocol = (($_SERVER['HTTPS']) ? 'https' : 'http') . '://';
$host = (($hostProxy) ? $hostProxy : $_SERVER['HTTP_HOST']) . '/';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- STANDARD -->
	<title>Winery2Home.com</title>
	<meta charset="UTF-8">	
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<meta name="robots" content="index,follow">
	<meta name="application-name" content="Winery 2 Home"/>
	<meta name="msapplication-TileColor" content="#F5F2E7" />
	<meta name="msapplication-TileImage" content="/lib/images/favico/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="/lib/images/favico/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="/lib/images/favico/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="/lib/images/favico/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="/lib/images/favico/mstile-310x310.png" />
	<link rel="icon" type="image/png" href="/favicon.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="preload stylesheet" as="style" type="text/css" href="/lib/css/bundle.css">
	<link rel="canonical" href="<?php echo $protocol . $host ?>">
	<base href="<?php echo $protocol . $host ?>" />
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/lib/images/favico/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/lib/images/favico/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/lib/images/favico/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/lib/images/favico/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="/lib/images/favico/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="/lib/images/favico/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="/lib/images/favico/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="/lib/images/favico/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="/lib/images/favico/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="/lib/images/favico/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="/lib/images/favico/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="/lib/images/favico/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="/lib/images/favico/favicon-128.png" sizes="128x128" />
	<!-- FRAMEWORK -->
	<script defer src='/lib/js/bundle.js'></script>
</head>
<body id="body">
</body>
</html>
