<?php			
	define('MVC', dirname(__DIR__) . '/' . 'app' . '/');
	/*
	dirname(__DIR__) contains that full url of the location of the file example for the login page, C:\xampp\htdocs\bnhs_final\
	*/
	define('URL_PUBLIC_FOLDER', ''); //create a URL_PUBLIC_FOLDER constant variable with an empty value this can be replace if there is only a public folder (this maybe empty)
	define('URL_PROTOCOL', 'http://'); //create a constant variable (URL_PROTOCOL) to use for the url, it can either be a http:// or https://
	define('URL_DOMAIN', $_SERVER['HTTP_HOST']); //create a constant variable containing the header of the current request
	define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME']))); //This constant variable constains the name of the parent folder which for this local development is /bnhs_final
	if(substr(URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER, -1) == '/') { //this test checks if the concatinated url contains forward slash / if yes then return the url without the "/"" else adds "/" in the end 
		define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);
	} else{
		define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER . '/');
	}

	require MVC . 'controller/controller.php';
	require MVC . 'app.php';
?>