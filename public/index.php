<?php

// Start PHP Session
session_start();

// Set Vars
$cookieAgeCheck = 'age-check';

// Detect Age-Check
if (!strpos($_SERVER['REQUEST_URI'], $cookieAgeCheck) && $_COOKIE[$cookieAgeCheck] !== 'true')
{
	header('Location: /age-check');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">	
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes" />
	<meta name="robots" content="index,follow">
	<title>Winery2Home.com</title>
	<link rel="icon" type="image/png" href="/favicon.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="preload stylesheet" as="style" type="text/css" href="/lib/css/bundle.css">
	<link rel="canonical" href="https://www.winery2home.com">
	<base href="/" />
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
	<meta name="application-name" content="Winery 2 Home"/>
	<meta name="msapplication-TileColor" content="#F5F2E7" />
	<meta name="msapplication-TileImage" content="/lib/images/favico/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="/lib/images/favico/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="/lib/images/favico/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="/lib/images/favico/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="/lib/images/favico/mstile-310x310.png" />

	<!-- <script>
		(function(h,o,t,j,a,r){
			h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
			h._hjSettings={hjid:1769770,hjsv:6};
			a=o.getElementsByTagName('head')[0];
			r=o.createElement('script');r.async=1;
			r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
			a.appendChild(r);
		})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	</script> -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163724990-1"></script> -->
	<!-- <script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-163724990-1');
	</script> -->
	<script defer src='/lib/js/bundle.js'></script>
</head>
<body id="body"></body>
</html>
