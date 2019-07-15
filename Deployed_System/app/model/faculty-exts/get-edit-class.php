<?php 

require '../connection.php';
class GetEditClass {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function editSubj() {
		if (isset($_POST['enroll'])) {
			$getValues = explode('-', $_POST['enroll']);
			$query = $this->conn->prepare("UPDATE subject SET subj_name = ? WHERE subj_id=?" );
			$query->bindParam(1, $getValues[0]);
			$query->bindParam(2, $getValues[1]);
			$query->execute();
		}
	}
}

$getEditClass = new GetEditClass;
$getEditClass->editSubj();
?>