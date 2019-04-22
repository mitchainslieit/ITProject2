<?php 

require 'connection.php';
class ListTable {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getStudents() {
		$post = explode(' ', $_POST['grade']);
		$_SESSION['tres-grade-lvl'] = $post[1];
	}
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$listTable = new listTable;
$listTable->getStudents();

?>