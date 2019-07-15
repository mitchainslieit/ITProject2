<?php
class Controller { 
	function __construct(){  
		global $siteInfo;
		$this->siteInfo = $siteInfo;
		$this->loadHelpers();
	}

	protected function loadHelpers(){
		require 'libraries/helpers.php';
		$this->helpers = new Helpers();
	}

	public function index($view){
		$usertype = explode("-", $view);
		require MVC . 'controller/usercontroller.php';
		$executeController = new UserController;
		switch ($usertype[0]) {
			case 'login':
				require MVC . 'view/'.$view.'.php';
				break;
			default: 
				require MVC . 'view/template/header.php';
				require MVC . 'view/'.$view.'.php';
				require MVC . 'view/template/footer.php';	
				break;
		}
	}
}