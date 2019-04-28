<?php
require '../connection.php';
class ChangeSession {
	public function setParChildrenLRNO() {
		$_SESSION['child_lrno'] = $_POST['lrno'];
		echo $_POST['lrno'];
	}

	public function filtYear() {
		$_SESSION['year'] = $_POST['year'];
		echo $_POST['year'];
	}
}
if (session_start() == PHP_SESSION_NONE) {
	session_start();
}
$run = new ChangeSession;

$run->setParChildrenLRNO();
$run->filtYear();
?>