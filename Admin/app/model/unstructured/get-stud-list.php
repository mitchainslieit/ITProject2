<?php 

require '../connection.php';
class GetStud {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getStudents() {
		$data = array();
		if (isset($_POST['grade'])) {
			if ($_POST['grade'] === 'All') {
				$query = $this->conn->prepare("SELECT stud_lrn, CONCAT(first_name,' ',middle_name,' ',last_name) as 'Name', CONCAT('GRADE ',year_level,' - ',sec_name) as 'stud_sec', bal_amt FROM student JOIN balance on stud_idb=stud_id JOIN section ON secc_id = sec_id");
			} else {
				$grade = explode(" ", $_POST['grade']);
				$query = $this->conn->prepare("SELECT stud_lrn, CONCAT(first_name,' ',middle_name,' ',last_name) as 'Name', CONCAT('GRADE ',year_level,' - ',sec_name) as 'stud_sec', bal_amt FROM student JOIN balance on stud_idb=stud_id JOIN section ON secc_id = sec_id WHERE year_level=?");
			}
			$query->bindParam(1, $grade[1]);
			$query->execute();

			foreach($query as $row) {
				$data[] = $row;
			}
			echo json_encode($data);
		} else {
			echo '<script>SCRIPT ERROR</script>';
		}
	}
}

$getStud = new GetStud;
$getStud->getStudents();

?>