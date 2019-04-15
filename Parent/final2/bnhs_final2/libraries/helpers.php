<?php
Class Helpers {
	function __construct(){
		global $siteInfo;
		$this->siteInfo = $siteInfo;
	}

	public function isActiveMenu($view){
		$extension = null;
		if (isset($_GET['url'])) {
			$url = trim($_GET['url'], '/');
			$url = explode('/', $url);

			$extension = isset($url[0]) ? $url[0] : null;
			unset($url[0], $url[1]);
		}

		if($extension === $view || ($extension === null && $view === "home")){
			return " class=\"active-menu\"";
		} 
	}

	public function bodyClasses($view){
		if($view != "home"){
			echo 'class="inner '.$view.'-page"';
		}
		else{
			echo 'class="home"';
		}
	}

	public function overallPage($view){
		$getPageView = explode("-", $view);
		echo $getPageView[0].'_home';
	}

	public function userType($view) {
		$getPageView = explode("-", $view);
		echo strtoupper($getPageView[0]);
	}

	public function htmlClasses(){
		if($this->siteInfo["suspended"]){
			echo 'class="suspended"';
		}
	}

	public function siteTitle($view) {
		if ($view === "login") {
			echo "<title>BNHS LOGIN</title>";
		}
	}

	public function siteSpecificCSS() {
		echo '<link href="'.URL.'public/styles/'.strtolower($_SESSION['user_type']).'-style.css" rel="stylesheet">';
	}

	public function getFirstName() {
		$fname = "";
		$name = explode(" ",$_SESSION['account_name']);
		for ($c = 0; $c < count($name) - 2; $c++) {
			$fname .= $name[$c];
			if ($c <= (count($name) - 2)) $fname .= ' ';
		}
		echo trim($fname);
	}

	public function getUserImage() {
		echo '<img src="public/images/common/profpic/'.$_SESSION['username'].'.jpg" alt="'.' '.'">';
	}
}

