<?php

class App {
	protected $controller = null;
	protected $action = null;

	public function __construct(){
		$this->URLParams();
		$this->getController();
	}

	private function URLParams(){
		if (isset($_GET['url'])) {
			$url = trim($_GET['url'], '/');
			$url = explode('/', $url);
			$this->controller = isset($url[0]) ? $url[0] : null;
			$this->action = isset($url[1]) ? $url[1] : null;
			unset($url[0], $url[1]);
		} //get current page url then set the value of $controller and $action and if $url doesn't have any value then return null
	}

	private function getController(){    
		$ctrl = "controller";

		if ($this->controller === null){
			$this->controller = "login";
		} // if it is null redirect to login

		if(file_exists(MVC . 'controller/' . $this->controller . '.php')){   
			require MVC . 'controller/'.$this->controller.'.php';
			$page = new $this->controller();
			$ctrl = $this->controller;
		} else{
			$page = new $ctrl();
		} // check if controller exist else redirect to the requested page

		if(file_exists(MVC . 'view/' . $this->controller . '.php')){
			if($this->action != null){
				if(method_exists($ctrl, $this->action)){
					$page->{$this->action}(); 
				} else {
					header("Location:".URL.$this->controller);
				}
			} else {
				$page->index($this->controller); 
			}
		} else {
			header("Location:".URL."error");
		} // check if the requested page is available else redirect to error page
	}
}

