<?php
require '../connection.php';
class ChangeSession {
	public function setParChildrenLRNO() {
		$_SESSION['child_lrno'] = $_POST['lrno'];
	}
}
if (session_start() == PHP_SESSION_NONE) {
	session_start();
}
$run = new ChangeSession;
$run->setParChildrenLRNO();
?>