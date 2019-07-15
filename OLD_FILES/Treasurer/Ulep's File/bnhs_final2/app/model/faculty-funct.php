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

	public function enrollNewStudent($schoolyear, $lrn, $lastname, $firstname, $middlename, $birthday, $gender, $address, $barangay, $city, $zipcode, $fathersname, $mothersname, $guardiansname, $telno, $cellno) {
		if ($this->checkIfExist($lrn) === 0) {
			$usernameStud = str_replace(' ', '', ($firstname[0].$middlename[0].$lastname));
			$usernameParent = str_replace(' ', '', $lastname);
			$password = 'password';
			$this->createAccount($usernameStud, $password, 'Student');
			$this->createAccount($usernameParent, $password, 'Parent');
			$student_date = [
				'schoolyear' => $schoolyear,
				'lrn' => $lrn,
				'lastname' => $lastname,
				'firstname' => $firstname,
				'middlename' => $middlename,
				'birthday' => $birthday,
				'gender' => $gender,
				'address' => $address,
				'barangay' => $barangay,
				'city' => $city,
				'zipcode' => $zipcode,
				'fathersname' => $fathersname,
				'mothersname' => $mothersname,
				'guardiansname' => $guardiansname,
				'telno' => $telno,
				'cellno' => $cellno
			];
		} else {
			$this->Message("That student already exist!", "rgb(244,0,0)", "faculty-enroll");
		}
		/*$query = $this->conn->prepare("SELECT * FROM student WHERE stud_lrn=?");
		$query->bindParam(1, $lrn);
		$query->execute();*/
		/*$query = "INSERT INTO student ('stud_lrn', 'last_name', 'first_name', 'middle_name', 'gender', 'year_level', 'school_year', 'guar_mobno', 'stud_address', 'stud_bday', 'guar_name', 'guar_telno', 'stud_status', 'curr_stat', 'secc_id', 'facc_id', 'accc_id') VALUES ()";*/

		/*
		IFs
		1. If existing LRN or Student (Student by Name?)
		2. Sectioning By Gender

		Logic:
		1. Check for data duplication (LRN or Name)
		2. Create an account for the student and the parent
		3. Insert Student information
		4. 
		*/
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
		$queryUpdate = $this->conn->prepare("UPDATE accounts SET username=? WHERE username=?");
		$queryUpdate->bindParam(1, $newUsername);
		$queryUpdate->bindParam(2, $username);
		$queryUpdate->execute();
	}

	private function checkIfExist($lrn) {
		$query = $this->conn->prepare("SELECT stud_lrn FROM student WHERE stud_lrn = ?");
		$query->bindParam(1, $lrn);
		$query->execute();
		return $query->rowCount();		
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