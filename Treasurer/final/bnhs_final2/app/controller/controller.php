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
		require MVC . 'model/usercontroller.php';
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

	public function info($args){
		if (!is_array($args)){
			echo $this->siteInfo[$args];
		}
		else{
			$string = '<a ';

			if(isset($args[1])){
				$string .= 'href="'.$args[1].':'.$this->siteInfo[$args[0]].'"';
			}
			if(isset($args[2])){
				$string .= 'class="'.$args[2].'" ';
			}
			if(isset($args[3])){
				$string .= 'id="'.$args[3].'" ';
			}

			$string .= ' >'.$this->siteInfo[$args[0]].'</a>';
			echo $string;
		}

	}
}