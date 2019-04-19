<?php
	// error_reporting(E_ALL);

	$siteInfo= [
			//general info
			"company_name" => "Company Name", 
			"phone" =>  "000-000-0000", 		  //either no format or dashed format
			"email" => "email@domain.com",   //by default is used as recipient email 

			//seo
			"ga_tracking_id" => '',

			//pivate policy link 
			"policy_link" => '', //change the value to privacy-policy for Privacy Policy Page

			//Cookie
			"cookie" => false, //false to disable cookie

			//suspension
			"suspended" => false
			];

			
	define('MVC', dirname(__DIR__) . '/' . 'app' . '/');
	define('URL_PUBLIC_FOLDER', '');
	define('URL_PROTOCOL', 'http://');
	define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
	define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
	if(substr(URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER, -1) == '/') {
		define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);
	} else{
		define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER . '/');
	}

	require MVC . 'controller/controller.php';
	require MVC . 'app.php';