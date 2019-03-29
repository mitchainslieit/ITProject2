<?php
require 'app/model/connection.php';
class AdminFunct {
	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}
	public function getById($id){

		$sql=$this->conn->prepare("SELECT * FROM Faculty WHERE fac_id = :fac_id");
		$sql->execute(array(':fac_id'=>$id));
		$editRow = $sql->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	public function showSingleTable($table){
		$sql = $this->conn("SELECT * FROM $table") or die ("failed!");
		$sql->execute();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}else{
			echo 'Nothing to display!';
		}
	}
	public function showTwoTables($table1, $table2, $id1, $id2){
		try {
			$sql=$this->conn->query("SELECT * FROM $table1 join $table2 where $id1 = $id2") or die("failed!");
			$sql->execute();
			if($sql->rowCount()>0){
				while($r = $sql->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				return $data;
			}else{
				echo 'Nothing to display!';
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function showClasses(){
		$sql=$this->conn->prepare("SELECT * FROM faculty JOIN section ON fac_id=fac_idv WHERE fac_adviser='Yes'");
		$sql->execute();
		if($sql->rowCount()>0){
			while($r=$sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}else{
			echo 'Nothing to display!';
		}
	}
	public function addClass($sec_name, $sec_type, $grade_lvl, $fac_idv){
		try {
			$created=date('Y-m-d H:i:s');	
			$sql=$this->conn->prepare("INSERT INTO Section SET sec_name=:sec_name, sec_type=:sec_type, grade_lvl=:grade_lvl, timestamp_sec=:timestamp_sec, fac_idv=:fac_idv");
			if($sql->execute(array(
				':sec_name' => $sec_name,
				':sec_type' => $sec_type,
				':grade_lvl' => $grade_lvl,
				':timestamp_sec' => $created,	
				':fac_idv' => $fac_idv
			))){
				$sql2=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname FROM section JOIN faculty on fac_id=fac_idv WHERE fac_idv=?");
				$sql2->bindParam(1, $fac_idv);
				$sql2->execute();
				$row = $sql2->fetch();
				$facultyName = $row['facultyname'];
				$this->Promt("A new class has been created! Class = <span class='prompt'>$sec_name</span> Teacher-in-charge = <span class='prompt'>$facultyName</span>", "rgb(1, 58, 6)", "admin-classes");
			}else{
				$this->Promt("Failed to add faculty data", "rgb(175, 0, 0)", "admin-classes");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function facultylist(){
		$sql = $this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, fac_id FROM Faculty WHERE fac_adviser='Yes' and fac_id NOT IN (SELECT fac_idv FROM section JOIN faculty ON fac_id=fac_idv) ");
		$sql->execute();
		while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
			echo "<option value='" . $row['fac_id'] . "'>" . $row['facultyname'] . "</option>";
		}
		/*$facultylist = array();
		while ($row = $sql->fetch()) {
			$facultylist[] = $row['facultyname'];
		}
		return $facultylist;	*/
	}
	public function updateClasses($table){
		$sql=$this->conn->prepare("UPDATE $table 
		SET fac_id=:fac_id, sec_name=:sec_name, sec_type=:sec_type, grade_lvl=:grade_lvl");
	}
	
	public function createAccount($username, $password){
		$newPass = password_hash($password, PASSWORD_DEFAULT);
		$queryInsert = $this->conn->prepare("INSERT INTO accounts (username, password, acc_status, acc_type) VALUES (?, ?, 'Active', 'Faculty')");
		$queryInsert->bindParam(1, $username);
		$queryInsert->bindParam(2, $newPass);
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
	public function insertFacultyData($fac_no, $fac_fname, $fac_midname, $fac_lname, $fac_dept, $fac_adviser) {
		try {
			$created=date('Y-m-d H:i:s');
			$password = 'password';
			$usernameFac= str_replace(' ', ' ', ($fac_fname.$fac_midname.$fac_lname));
			$FacultyAccid = $this->createAccount($usernameFac, $password, 'Faculty');
			$sql = $this->conn->prepare("INSERT INTO faculty SET fac_no=:fac_no, fac_fname=:fac_fname, fac_lname=:fac_lname, fac_midname=:fac_midname, fac_dept=:fac_dept, fac_adviser=:fac_adviser, timestamp_fac=:timestamp_fac, acc_idz=:acc_idz");
			
			if($sql->execute(array(
				'fac_no' =>$fac_no,
				'fac_fname' => $fac_fname,
				'fac_lname' => $fac_lname,
				'fac_midname' => $fac_midname,
				'fac_dept' => $fac_dept,
				'fac_adviser' => $fac_adviser,
				'timestamp_fac' => $created,
				'acc_idz' => $FacultyAccid
			))){
				$this->Promt("Account has been created! Username = <span class='prompt'>$usernameFac</span> Password = <span class='prompt'>$password </span>", "rgb(1, 58, 6)", "admin-faculty");
			}else{
				$this->Promt("Failed to add faculty data", "rgb(175, 0, 0)", "admin-faculty");
			}
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}
		
	}
	public function updateFacultyData($id, $fac_no, $fac_fname, $fac_midname, $fac_lname, $fac_dept, $fac_adviser){
		try {
			$sql = $this->conn->prepare("UPDATE faculty
			SET 	fac_no=:fac_no,
				fac_fname=:fac_fname,
				fac_midname=:fac_midname,
				fac_lname=:fac_lname,
				fac_dept=:fac_dept,
				fac_adviser=:fac_adviser
			WHERE fac_id=:fac_id");
			if($sql->execute(array(
				':fac_no'=>$fac_no,
				':fac_fname'=>$fac_fname,
				':fac_midname'=>$fac_midname,
				':fac_lname'=>$fac_lname,
				':fac_dept'=>$fac_dept,
				':fac_adviser'=>$fac_adviser,
				':fac_id'=>$id
			))){
				$this->Message("You have updated the account of <span class='prompt'>$fac_fname $fac_lname</span>", "rgb(1, 58, 6)", "admin-faculty");	
			}else{
				$this->Promt("Failed to update faculty data", "rgb(175, 0, 0)", "admin-faculty");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function updateAccountStatus($id, $acc_status){
		try {
			$sql = $this->conn->prepare("UPDATE accounts
			SET acc_status=:acc_status
			WHERE acc_id=:acc_id");
			if($sql->execute(array(
				':acc_status'=>$acc_status,
				':acc_id'=>$id
			))){
				$this->Message("You have successfully changed the account status!", "rgb(1, 58, 6)", "admin-faculty");	
			}else{	
				$this->Promt("Failed to change status!", "rgb(175, 0, 0)", "admin-faculty");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function deleteFacultyData($id){
		try {
			$sql = $this->conn->prepare("
				DELETE a.*, b.* 
				FROM faculty a 
				LEFT JOIN accounts b 
				ON b.acc_id = a.acc_idz 
				WHERE a.acc_idz =:acc_idz");
			if($sql->execute(array(
				':acc_idz'=>$id
			))){
				$this->Message("The account has been deleted!", "rgb(175, 0, 0)", "admin-faculty");
			}else{	
				$this->Promt("Failed to delete Faculty Data!", "rgb(175, 0, 0)", "admin-faculty");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function department() {
		$query = $this->conn->prepare("SELECT fac_dept FROM Faculty");
		$query->execute();
		$department = array();
		while ($row = $query->fetch()) {
			$department[] = $row['fac_dept'];
		}
		return $department;
	}
	private function Promt($message, $color, $page) {
		$newUrl = URL.$page;
		echo "
			<div data-type='error-message' style='position: fixed; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999999;'>
				<div style='width:100%; padding: 17px 0; background: ".$color."; color: #fff;'>
					<div class='modal-box' style='width: 100%;'>
						<p style='margin: 0; font-size: 16px;'>".$message." <a style='color: #4b4bff; text-decoration: underline;' href='".$newUrl."'>Close</a></p>
					</div>
				</div>
			</div>
		<script>
		var sec = 60;
		var timer = setInterval(function() {
			$('.modal-box .count').text(sec--);
			if (sec == -1) {
				clearInterval(timer);
			}
		}, 1000);
		setTimeout(function(){
		   window.location = '".$newUrl."';
		}, 60000);
		</script>";
	}
	
	private function Message($message, $color, $page) {
		$newUrl = URL.$page;
		echo "<div data-type='error-message' style='position: fixed; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999999;'>
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