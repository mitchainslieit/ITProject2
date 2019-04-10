<?php 

require 'connection.php';
class ListTable {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getStudents() {
		$temp = explode(' ', $_POST['data'][0]);
		$grade = $temp[0] === 'All' ? 'All' : $temp[1];
		$status = $_POST['data'][1];
		if (isset($_POST['data'])) {
			if ($_POST['data'][0] === 'All') {
				$sql=$this->conn->prepare("SELECT stud_lrno, CONCAT(first_name, ' ', middle_name,' ', last_name) as 'Name',  year_level, sec_name, CONCAT('₱', FORMAT(pay_amt, 2)), CONCAT('₱', FORMAT(bal_amt, 2)), bal_status 
					FROM student JOIN balance ON student.stud_id = balance.stud_idb 
					JOIN section on section.sec_id = student.secc_id 
					JOIN balpay bp ON bp.bal_ida = balance.stud_idb 
					JOIN payment ON payment.pay_id = bp.pay_ida 
					WHERE bal_status = :status GROUP BY 1");
				$sql->execute(array(
					':status' => $status
				));
			} else {
				$sql=$this->conn->prepare("SELECT stud_lrno, CONCAT(first_name, ' ', middle_name,' ', last_name) as 'Name',  year_level, sec_name, CONCAT('₱', FORMAT(pay_amt, 2)), CONCAT('₱', FORMAT(bal_amt, 2)), bal_status 
					FROM student JOIN balance ON student.stud_id = balance.stud_idb 
					JOIN section on section.sec_id = student.secc_id 
					JOIN balpay bp ON bp.bal_ida = balance.stud_idb 
					JOIN payment ON payment.pay_id = bp.pay_ida 
					WHERE year_level = :grade AND bal_status = :status GROUP BY 1") or die ("failed!");
				$sql->execute(array(
					':grade' => $grade,
					':status' => $status
				));
			}
			$data = array();
			foreach ($sql as $row) {
				$data[] = $row;
			}
			echo json_encode($data);
		} else {
			echo 'not working!';
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