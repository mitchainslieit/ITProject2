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
		$sql = $this->conn->prepare("SELECT * FROM $table") or die ("failed!");
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
	public function addSection($sec_name,$grade_lvl){
		try {
			$created=date('Y-m-d H:i:s');	
			$sql1=$this->conn->prepare("INSERT INTO Section SET sec_name=:sec_name, grade_lvl=:grade_lvl, timestamp_sec=:timestamp_sec");
			if($sql1->execute(array(
				':sec_name' => $sec_name,
				':grade_lvl' => $grade_lvl,
				':timestamp_sec' => $created
			))){
				$sql2=$this->conn->prepare("SELECT * FROM section");
				$sql2->execute();
				$this->Prompt("A new section has been created! Class = <span class='prompt'>$sec_name</span> Grade Level = <span class='prompt'>$grade_lvl</span>", "rgb(1, 58, 6)", "admin-section");
			}else{	
				$this->Prompt("Failed to add section!", "rgb(175, 0, 0)", "admin-section");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function updateSection($id, $sec_name, $grade_lvl){
		try {
			$sql=$this->conn->prepare("UPDATE Section 
			SET  sec_name=:sec_name, 
				grade_lvl=:grade_lvl
			WHERE sec_id=:sec_id");	
			if($sql->execute(array(
				':sec_name'=> $sec_name, 
				':grade_lvl'=> $grade_lvl,
				':sec_id' => $id
			))){
				$this->Prompt("Section has been updated", "rgb(1, 58, 6)", "admin-section");
			}else{
				$this->Prompt("Failed to update section", "rgb(175, 0, 0)", "admin-section");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}	
	public function deleteSection($id){
		try {
			$sql = $this->conn->prepare("
				DELETE FROM Section WHERE sec_id =:sec_id");
			if($sql->execute(array(
				':sec_id'=>$id
			))){
				$this->Message("The section has been deleted!", "rgb(175, 0, 0)", "admin-section");
			}else{	
				$this->Prompt("Failed to delete section!", "rgb(175, 0, 0)", "admin-section");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function showClasses(){
		$sql=$this->conn->prepare("SELECT fac_no, CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS fullname, sec_name, grade_lvl, fac_id, sec_id FROM faculty JOIN section ON fac_id=fac_idv WHERE fac_adviser='Yes'");
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
	public function section() {
		$sql = $this->conn->prepare("SELECT sec_id, sec_name, grade_lvl FROM Section");
		$sql->execute();
		while ($row = $sql->fetch()) {
			echo "<option value='" . $row['sec_id'] . "'>".$row['grade_lvl']." - " . $row['sec_name'] . "</option>";
		}
	}
	public function faculty_id() {
		$query = $this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, fac_id FROM Faculty");
		$query->execute();
		$facultyname = array();
		while ($row = $query->fetch()) {
			$faculty_id[]=$row['fac_id'];
		}
		return $faculty_id;
	}
	public function facultyname() {
		$query = $this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, fac_id FROM Faculty");
		$query->execute();
		$facultyname = array();
		while ($row = $query->fetch()) {
			$facultyname[] = $row['facultyname'];
		}
		return $facultyname;
	}
	public function addClass($sec_id, $fac_idv){	
		try {
			$sql=$this->conn->prepare("UPDATE Section 
			SET  fac_idv=:fac_idv
			WHERE sec_id=:sec_id");
			if($sql->execute(array(
				':fac_idv'=> $fac_idv,
				':sec_id' => $sec_id
			))){
				$sql2=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, sec_name FROM section JOIN faculty on fac_id=fac_idv WHERE fac_idv=?");
				$sql2->bindParam(1, $fac_idv);
				$sql2->execute();
				$row = $sql2->fetch();
				$facultyName = $row['facultyname'];
				$sec_name = $row['sec_name'];
				$this->Prompt("A new class has been created! Class = <span class='prompt'>$sec_name</span> Teacher-in-charge = <span class='prompt'>$facultyName</span>", "rgb(1, 58, 6)", "admin-classes");
			}else{
				$this->Prompt("Failed to add class", "rgb(175, 0, 0)", "admin-classes");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}	
	public function updateClass($sec_id, $fac_idv){
		try {
			$sql=$this->conn->prepare("UPDATE Section 
			SET  fac_idv=:fac_idv
			WHERE sec_id=:sec_id");
			if($sql->execute(array(
				':fac_idv'=> $fac_idv,
				':sec_id' => $sec_id
			))){
				$this->Prompt("Class has been updated", "rgb(1, 58, 6)", "admin-classes");
			}else{
				$this->Prompt("Failed to update class", "rgb(175, 0, 0)", "admin-classes");
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
	}
	public function createFacultyAccount($username, $password){
		$created=date('Y-m-d H:i:s');
		$newPass = password_hash($password, PASSWORD_DEFAULT);
		$queryInsert = $this->conn->prepare("INSERT INTO accounts (username, password, acc_status, acc_type, timestamp_acc) VALUES (?, ?, 'Active', 'Faculty',?)");
		$queryInsert->bindParam(1, $username);
		$queryInsert->bindParam(2, $newPass);
		$queryInsert->bindParam(3, $created);
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
			$FacultyAccid = $this->createFacultyAccount($usernameFac, $password, 'Faculty');
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
				$this->Prompt("Account has been created! Username = <span class='prompt'>$usernameFac</span> Password = <span class='prompt'>$password </span>", "rgb(1, 58, 6)", "admin-faculty");
			}else{
				$this->Prompt("Failed to add faculty data", "rgb(175, 0, 0)", "admin-faculty");
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
				$this->Prompt("Failed to update faculty data", "rgb(175, 0, 0)", "admin-faculty");
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
				$this->Prompt("Failed to change status!", "rgb(175, 0, 0)", "admin-faculty");
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
				$this->Prompt("Failed to delete Faculty Data!", "rgb(175, 0, 0)", "admin-faculty");
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
	public function createPTAAccount($username, $password){
		$created=date('Y-m-d H:i:s');
		$newPass = password_hash($password, PASSWORD_DEFAULT);
		$queryInsert = $this->conn->prepare("INSERT INTO accounts (username, password, acc_status, acc_type, timestamp_acc) VALUES (?, ?, 'Active', 'Treasurer', ?)");
		$queryInsert->bindParam(1, $username);
		$queryInsert->bindParam(2, $newPass);
		$queryInsert->bindParam(3, $created);
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
	public function insertPTAData($pr_fname, $pr_midname, $pr_lname, $pr_address, $stude_id) {
		try {
			$created=date('Y-m-d H:i:s');
			$password = 'password';
			$usernamePTA= str_replace(' ', ' ', ($pr_fname.$pr_midname.$pr_lname));
			$PTAAccid = $this->createPTAAccount($usernamePTA, $password, 'Parent');
			$sql = $this->conn->prepare("INSERT INTO parent SET pr_fname=:pr_fname, pr_lname=:pr_lname, pr_midname=:pr_midname, pr_address=:pr_address, timestamp_pr=:timestamp_pr, acc_idx=:acc_idx, stude_id=:stude_id");
			
			if($sql->execute(array(
				':pr_fname' => $pr_fname,
				':pr_lname' => $pr_lname,  
				':pr_midname' => $pr_midname,
				':pr_address' => $pr_address,
				':timestamp_pr' => $created,
				':acc_idx' => $PTAAccid,
				':stude_id' => $stude_id
				
			))){
				$this->Prompt("Account has been created! Username = <span class='prompt'>$usernamePTA</span> Password = <span class='prompt'>$password </span>", "rgb(1, 58, 6)", "admin-parent");
			}else{
				$this->Prompt("Failed to add faculty data", "rgb(175, 0, 0)", "admin-parent");
			}
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}	
	}
	public function studentList() {
		$sql = $this->conn->prepare("SELECT stud_id, CONCAT(first_name,' ',middle_name,' ',last_name) as studentName FROM student");
		$sql->execute();
		while ($row = $sql->fetch()) {
			echo "<option value='" . $row['stud_id'] . "'>" . $row['studentName'] . "</option>";
		}
	}
	private function Prompt($message, $color, $page) {
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