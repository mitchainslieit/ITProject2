<?php 

require 'connection.php';
class ListTable {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getStudents() {
		$data = array();
		if (isset($_POST['grade'])) {
			if ($_POST['grade'] === 'All') {
				$query = $this->conn->prepare("SELECT stud_lrno, CONCAT(first_name, ' ', middle_name,' ', last_name) as 'Name',  year_level, sec_name, gender, ethnicity, stud_status, curr_stat 
					FROM student JOIN section on section.sec_id = student.secc_id GROUP BY 1");
			} else {
				$grade = explode(" ", $_POST['grade']);
				$query = $this->conn->prepare("SELECT stud_lrno, CONCAT(first_name, ' ', middle_name,' ', last_name) as 'Name',  year_level, sec_name, gender, ethnicity, stud_status, curr_stat 
					FROM student JOIN section on section.sec_id = student.secc_id WHERE year_level=?");
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
		/*$data = array();
		if (isset($_POST['grade'])) {
			if ($_POST['grade'] === 'All') {
				$query = $this->conn->prepare("SELECT stud_lrno, CONCAT(first_name,' ',middle_name,' ',last_name) as 'Name', CONCAT('GRADE ',year_level,' - ',sec_name) as 'stud_sec' FROM student JOIN section ON secc_id = sec_id");
			} else {
				$grade = explode(" ", $_POST['grade']);
				$query = $this->conn->prepare("SELECT stud_lrno, CONCAT(first_name,' ',middle_name,' ',last_name) as 'Name', CONCAT('GRADE ',year_level,' - ',sec_name) as 'stud_sec' FROM student JOIN section ON secc_id = sec_id WHERE year_level=?");
			}
			$query->bindParam(1, $grade[1]);
			$query->execute();

			foreach($query as $row) {
				$row[3] = '<button data-lrn="'.$row['stud_lrno'].'" class="assessment-button""><i class="far fa-eye"></i></button>';
				$row['button'] = '<button data-lrn="'.$row['stud_lrno'].'" class="assessment-button""><i class="far fa-eye"></i></button>';
				$data[] = $row;
			}

			echo json_encode($data);
		} else {
			echo '<script>SCRIPT ERROR</script>';
		}*/
	}
}

$listTable = new listTable;
$listTable->getStudents();

?>