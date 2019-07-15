<?php
require '../connection.php';
class TreasurerSession {
	public function filterYearLevel() {
		$_SESSION['year_level'] = $_POST['yr_lvl'];
		header('location: treasurer-statistics');
	}
}
if (session_start() == PHP_SESSION_NONE) {
	session_start();
}
$run = new TreasurerSession;
$run->filterYearLevel();
?>