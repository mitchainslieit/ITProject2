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

	public function enrollNewStudent($post) {
		if ($this->checkIfExist($post['stud_lrno']) === 0) {
			$newStud = 'New';
			$password = 'password';
			$schoolyear = date('Y');
			$newAdd = $post['address'].', '.$post['barangay'].', '.$post['city'].' '.$post['zipcode'];
			$usernameStud = str_replace(' ', '', ($post['first_name'][0].$post['middle_name'][0].$post['last_name']));
			$usernameParent = str_replace(' ', '', $post['last_name']);
			$getSecID = $this->getSection($post['gender'], $post['year_level']);
			$studentAccid = $this->createAccount($usernameStud, $password, 'Student');
			$parentAccid = $this->createAccount($usernameParent, $password, 'Parent');
			$query = $this->conn->prepare("INSERT INTO student (stud_lrno, last_name, first_name, middle_name, gender, year_level, school_year, guar_mobno, stud_address, stud_bday, guar_name, guar_telno, nationality, religion, stud_status, curr_stat, secc_id, accc_id) VALUES (:stud_lrno, :last_name, :first_name, :middle_name, :gender, :year_level, :school_year, :guar_mobno, :stud_address, :stud_bday, :guar_name, :guar_telno, :nationality, :religion, :stud_status, :curr_stat, :secc_id, :accc_id)");
			$query->execute(array(
				':stud_lrno' => $post['stud_lrno'],
				':last_name' => $post['last_name'],
				':first_name' => $post['first_name'],
				':middle_name' => $post['middle_name'],
				':gender' => $post['gender'],
				':year_level' => $post['year_level'],
				':school_year' => $schoolyear,
				':guar_mobno' => $post['guar_mobno'],
				':stud_address' => $newAdd,
				':stud_bday' => $post['stud_bday'],
				':guar_name' => $post['guar_name'],
				':guar_telno' => $post['guar_telno'],
				':nationality' => $post['nationality'],
				':religion' => $post['religion'],
				':stud_status' => $post['enroll-status'],
				':curr_stat' => $newStud,
				':secc_id' => $getSecID,
				':accc_id' => $studentAccid
			));
			$this->Message("The student has successfully been enrolled, redirecting you to the assessment page.", "rgb(0,244,0)", "faculty-assess");
		} else {
			$this->Message("That student already exist!", "rgb(244,0,0)", "faculty-enroll");
		}
	}

	public function studList() {
		$query = $this->conn->prepare("SELECT stud_lrno, CONCAT(first_name,' ',middle_name,' ',last_name) as 'Name', CONCAT('GRADE ',year_level,' - ',sec_name) as 'stud_sec' FROM student JOIN section ON secc_id = sec_id");
		$query->execute();
		$result = $query->fetchAll();
		foreach($result as $row) {
			echo '<tr><td>'.$row['stud_lrno'].'</td><td>'.$row['Name'].'</td><td>'.$row['stud_sec'].'</td><td><button data-lrn="'.$row['stud_lrno'].'" class="assessment-button""><i class="far fa-eye"></i></button></td></tr>';	
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
		$query = $this->conn->prepare("SELECT stud_lrno FROM student WHERE stud_lrno = ?");
		$query->bindParam(1, $lrn);
		$query->execute();
		return $query->rowCount();		
	}

	private function getSection($gender, $year_level) {
		$query = $this->conn->prepare("SELECT CASE WHEN sec1.count > sec2.count THEN '2' WHEN sec1.count = sec2.count THEN '1' ELSE '1' END AS 'secc_id' FROM (SELECT  COUNT(gender) AS 'count' FROM student WHERE year_level = :yrlvl AND gender = :gender AND secc_id = '1') sec1 JOIN (SELECT  COUNT(gender) AS 'count' FROM student WHERE year_level = :yrlvl AND gender = :gender AND secc_id = '2') sec2;");
		$query->execute(array(
			':gender' => $gender,
			':yrlvl' => $year_level
		));
		$result = $query->fetch();
		return $result['secc_id'];
	}

	public function oldStud() {
		$query = $this->conn->prepare("SELECT stud_id, stud_lrno, CONCAT(first_name,' ',middle_name,' ',last_name) as 'Name', stud_status FROM student");
		$query->execute();
		$result = $query->fetchAll();
		foreach($result as $row) {
			echo '<tr> <td>'.$row['stud_lrno'].'</td> <td>'.$row['Name'].'</td> <td> <select class="filtEnrollTable">';
			switch ($row['stud_status']) {
				case 'Officially Enrolled' : 
					echo '<option value="Officially Enrolled-'.$row['stud_id'].'">Officially Enrolled</option>
					<option value="Not Enrolled-'.$row['stud_id'].'">Not Enrolled
					</option><option value="Temporary Enrolled-'.$row['stud_id'].'">Temporary Enrolled</option>'; 
					break;
				case 'Not Enrolled' : 
					echo '<option value="Not Enrolled-'.$row['stud_id'].'">Not Enrolled</option>
					<option value="Officially Enrolled-'.$row['stud_id'].'">Officially Enrolled</option>
					<option value="Temporary Enrolled-'.$row['stud_id'].'">Temporary Enrolled</option>'; 
					break;
				case 'Temporarily Enrolled' : 
					echo '<option value="Temporary Enrolled-'.$row['stud_id'].'">Temporary Enrolled</option>
					<option value="Not Enrolled-'.$row['stud_id'].'">Not Enrolled</option>
					<option value="Officially Enrolled-'.$row['stud_id'].'">Officially Enrolled</option>'; 
					break;
				default: break;
			}
			echo '</select><a class="enable-function"><i class="fas fa-edit"></i></a></td></tr>';
		}
	}

	public function getAnnouncements() {
		$query = $this->conn->prepare("SELECT title, post FROM announcements WHERE view_lim = '0'");
		$query->execute();
		$result = $query->fetchAll();
		foreach($result as $row) {
			echo 
			'<div class="announcement">
				<h2 class="title">'.$row['title'].'</h2>
				<p class="description">'.$row['post'].'</p>
			</div>';
		}
	}
	private function Message($message, $color, $page) {
		$newUrl = URL.$page;
		echo "<div data-type='error-message' style='position: absolute; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999999;'>
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