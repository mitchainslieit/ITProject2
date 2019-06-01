<?php 

require '../connection.php';
class GetOldStud {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function updateStatus() {
		if (isset($_POST['enroll'])) {
			$getValues = explode('-', $_POST['enroll']);
			$query = $this->conn->prepare("UPDATE student SET stud_status = ?, curr_stat='Old' WHERE stud_id=?" );
			$query->bindParam(1, $getValues[0]);
			$query->bindParam(2, $getValues[1]);
			$query->execute();
		}
	}
}

$getOldStud = new GetOldStud;
$getOldStud->updateStatus();
?>