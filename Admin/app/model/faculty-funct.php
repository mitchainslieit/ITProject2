<?php
require 'app/model/connection.php';
class FacultyFunct {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getNoOfStudent() {
		$query = $this->conn->prepare("SELECT * FROM student");
		$query->execute();
		$getRowCount = $query->rowCount();
		echo $getRowCount;
	}

	public function getNoOfMaleStudent() {
		$query = $this->conn->prepare("SELECT * FROM student WHERE gender='Male'");
		$query->execute();
		$getRowCount = $query->rowCount();
		echo $getRowCount;
	}

	public function getNoOfFemaleStudent() {
		$query = $this->conn->prepare("SELECT * FROM student WHERE gender='Female'");
		$query->execute();
		$getRowCount = $query->rowCount();
		echo $getRowCount;
	}

	public function getNoOfNewStudent() {
		$query = $this->conn->prepare("SELECT * FROM student WHERE curr_stat='New'");
		$query->execute();
		$getRowCount = $query->rowCount();
		echo $getRowCount;
	}

	public function enrollNewStudent($year_level, $lrn, $lastname, $firstname, $middlename, $birthday, $gender, $address, $barangay, $city, $zipcode, $fathersname, $mothersname, $guardiansname, $telno, $cellno, $status) {
		if ($this->checkIfExist($lrn) === 0) {
			$newStud = 'New';
			$password = 'password';
			$schoolyear = date('Y');
			$newAdd = $address.', '.$barangay.', '.$city.' '.$zipcode;
			$usernameStud = str_replace(' ', '', ($firstname[0].$middlename[0].$lastname));
			$usernameParent = str_replace(' ', '', $lastname);
			$getSecID = $this->getSection($gender, $year_level);
			$studentAccid = $this->createAccount($usernameStud, $password, 'Student');
			$parentAccid = $this->createAccount($usernameParent, $password, 'Parent');
			$query = $this->conn->prepare("INSERT INTO student (stud_lrn, last_name, first_name, middle_name, gender, year_level, school_year, guar_mobno, stud_address, stud_bday, guar_name, guar_telno, stud_status, curr_stat, secc_id, accc_id) VALUES (:lrn, :lastname, :firstname, :middlename, :gender, :year_level, :schoolyear, :cellno, :address, :birthday, :guardiansname, :telno, :status, :curr_status, :secc_id, :accc_id)");
			$query->execute(array(
				':lrn' => $lrn,
				':lastname' => $lastname,
				':firstname' => $firstname,
				':middlename' => $middlename,
				':gender' => $gender,
				':year_level' => $year_level,
				':schoolyear' => $schoolyear,
				':cellno' => $cellno,
				':address' => $newAdd,
				':birthday' => $birthday,
				':guardiansname' => $guardiansname,
				':telno' => $telno,
				':status' => $status,
				':curr_status' => $newStud,
				':secc_id' => $getSecID,
				':accc_id' => $studentAccid
			));
			$this->Message("Student has successfully been enrolled!", "rgb(244,0,0)", "faculty-enroll");
		} else {
			$this->Message("That student already exist!", "rgb(244,0,0)", "faculty-enroll");
		}
	}

	public function studList() {
		$query = $this->conn->prepare("SELECT stud_lrn, CONCAT(first_name,' ',middle_name,' ',last_name) as 'Name', CONCAT('GRADE ',year_level,' - ',sec_name) as 'stud_sec', bal_amt FROM student JOIN balance on stud_idb=stud_id JOIN section ON secc_id = sec_id");
		$query->execute();
		$result = $query->fetchAll();
		foreach($result as $row) {
			echo '<tr><td>'.$row['stud_lrn'].'</td><td>'.$row['Name'].'</td><td>'.$row['stud_sec'].'</td><td>'.$row['bal_amt'].'</td></tr>';	
		}
	}

	public function createAccount($username, $password, $acctype) {
		$newPass = password_hash($password, PASSWORD_DEFAULT);
		$queryInsert = $this->conn->prepare("INSERT INTO accounts (username, password, acc_status, acc_type) VALUES (?, ?, 'Active', ?)");
		$queryInsert->bindParam(1, $username);
		$queryInsert->bindParam(2, $newPass);
		$queryInsert->bindParam(3, $acctype);
		$queryInsert->execute();
		$querySearch = $this->conn->prepare("SELECT acc_id FROM accounts WHERE username=?");
		$querySearch->bindParam(1, $username);
		$querySearch->execute();
		$row = $querySearch->fetch();
		$newUsername = $username.$row['acc_id'];
		$getaccid = $row['acc_id'];
		$queryUpdate = $this->conn->prepare("UPDATE accounts SET username=? WHERE username=?");
		$queryUpdate->bindParam(1, $newUsername);
		$queryUpdate->bindParam(2, $username);
		$queryUpdate->execute();
		return $getaccid;
	}

	private function checkIfExist($lrn) {
		$query = $this->conn->prepare("SELECT stud_lrn FROM student WHERE stud_lrn = ?");
		$query->bindParam(1, $lrn);
		$query->execute();
		return $query->rowCount();		
	}

	private function getSection($gender, $year_level) {
		$query = $this->conn->prepare("SELECT  gender, COUNT(gender) AS 'count', secc_id FROM student WHERE year_level = ? AND gender = ? GROUP BY gender , secc_id ORDER BY count ASC LIMIT 1;");
		$query->bindParam(1, $year_level);
		$query->bindParam(2, $gender);
		$query->execute();
		$result = $query->fetch();
		return $query->rowCount() > 0 ? $result['secc_id'] : '1';
	}

	private function Message($message, $color, $page) {
		$newUrl = URL.$page;
		echo "<div style='position: absolute; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999999;'>
		<div style='width:100%; padding: 17px 0; background: ".$color."; color: #fff;'>
				<div class='modal-box' style='width: 100%;'>
					<p style='margin: 0; font-size: 16px;'>".$message." Wait <span class='count'>5</span> seconds or <a style='color: #4b4bff; text-decoration: underline;' href='".$newUrl."'>Click here</a></p>
				</div>
			</div>
		</div>
		<script>
		var sec = 4;
		var timer = setInterval(function() {
			$('.modal-box .count').text(sec--);
			if (sec == -1) {
				clearInterval(timer);
			}
		}, 1000);
		setTimeout(function(){
		   window.location = '".$newUrl."';
		}, 5000);
		</script>";
	}
}
?>