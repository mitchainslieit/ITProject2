<?php
class UserController {

	public function __construct() {
		$this->userSession();
		$this->userRedirect();
	}

	private function userSession() {
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
	}

	private function userRedirect() {
		header('Access-Control-Allow-Origin: *');
		$reqUrl = $this->accessLimiter();
		if ($reqUrl !== "login") {
			if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === "1" && $_SESSION['acc_details'] != 'New') {
				$pageType = explode("-", $reqUrl);
				$userType = strtolower($_SESSION['user_type']);
				if ($userType !== $pageType[0]) {
					$newUrl = "location: ".$userType."-dashboard";
					header ($newUrl);
				}
			} else if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === "1" && $_SESSION['acc_details'] == 'New') {
				if ($reqUrl !== "firstlogin") {
					header ('location: firstlogin');
				}
			} else {
				header ('location: login');
			}
		} else if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === "1") {
			header ('location: admin-dashboard');
		}
	}

	private function accessLimiter() {
		return str_replace('url=', '', $_SERVER['QUERY_STRING']);
	}
}
?>