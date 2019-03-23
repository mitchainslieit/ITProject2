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
		$sql = "SELECT * FROM $table";
		$q = $this->conn->query($sql) or die ("failed!");
		
		while($r = $q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;
	}
	public function showTwoTables($table1, $table2, $id1, $id2){

		$sql="SELECT * FROM $table1 join $table2 where $id1 = $id2";
		$q = $this->conn->query($sql) or die("failed!");

		while($r = $q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;
	}
	public function showThreeTables($table1, $table2, $table3, $id1, $id2, $id3){

		$sql="SELECT * from $table1 JOIN $table2 ON $id1=$id2 JOIN $table3 ON $id2=$id3";
		$q = $this->conn->query($sql) or die("failed!");

		while($r = $q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;
	}
	public function showFourTables($table1, $table2, $table3, $table4, $id1, $id2, $id3, $id4){

		$sql="SELECT * from $table1 JOIN $table2 ON $id1=$id2 JOIN $table3 ON $id2=$id3 JOIN $table4 on $id3=$id4";
		$q = $this->conn->query($sql) or die("failed!");

		while($r = $q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;
	}
	public function insertFacultyData($fac_fname, $fac_midinitial, $fac_lname, $fac_dept, $fac_adviser, $table) {
		$password = 'password';
		$usernameFac= str_replace(' ', ' ', ($fac_fname.$fac_midinitial.$fac_lname));
		$FacultyAccid = $this->createAccount($usernameFac, $password, 'Faculty');
		$sql = $this->conn->prepare("INSERT INTO $table SET fac_fname=:fac_fname, fac_lname=:fac_lname, fac_midinitial=:fac_midinitial, fac_dept=:fac_dept, fac_adviser=:fac_adviser, acc_idz=:acc_idz");
		$sql->execute(array(
			'fac_fname' => $fac_fname,
			'fac_lname' => $fac_lname,
			'fac_midinitial' => $fac_midinitial,
			'fac_dept' => $fac_dept,
			'fac_adviser' => $fac_adviser,
			'acc_idz' => $FacultyAccid
		));
		$this->Message("Account has been created!", "rgb(66, 244, 128)", "admin-faculty");
	}
	public function updateFacultyData($id, $fac_fname, $fac_midinitial, $fac_lname, $fac_dept, $fac_adviser, $table){
		try {
			$sql = $this->conn->prepare("UPDATE $table SET 	
				fac_fname=:fac_fname,
				fac_midinitial=:fac_midinitial,
				fac_lname=:fac_lname,
				fac_dept=:fac_dept,
				fac_adviser=:fac_adviser
			WHERE fac_id=:fac_id");
			$sql->execute(array(
				':fac_fname'=>$fac_fname,
				':fac_midinitial'=>$fac_midinitial,
				':fac_lname'=>$fac_lname,
				':fac_dept'=>$fac_dept,
				':fac_adviser'=>$fac_adviser,
				':fac_id'=>$id
			));
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();	
			return false;
		}
		/*$this->Message("Account has been updated!", "rgb(66, 244, 128)", "admin-faculty");*/
	}
	public function updateAccountStatus($id,$acc_status,$table){
		$sql = $this->conn->prepare("UPDATE $table
		SET acc_status=:acc_status
		WHERE acc_id=:acc_id");
		$sql->execute(array(
			':acc_status'=>$acc_status,
			':acc_id'=>$id
		));
	}
	public function deleteFacultyData($id, $table){
		$sql = $this->conn->prepare("DELETE FROM $table WHERE fac_id=:fac_id");
		$sql->execute(array(
			':fac_id'=>$id
		));
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
	public function addFeeType($budget_name, $acc_amount, $table) {
		$query = $this->conn->prepare("INSERT INTO $table (budget_name, acc_amount) VALUES (:budget_name, :acc_amount)");
		$query->execute(array(
			'budget_name' => $budget_name,
			'acc_amount' => $acc_amount
		));
		$this->Message("Fee Type has been added!", "rgb(66, 244, 128)", "admin-feetype");
	}
	public function updateFeeType($id, $budget_name, $acc_amount, $table){
		try {
			$sql = $this->conn->prepare("UPDATE $table SET 	
				budget_name=:budget_name,
				acc_amount=:acc_amount
			WHERE 	
				budget_id=:budget_id");
			$sql->execute(array(
				':budget_name'=>$budget_name,
				':acc_amount'=>$acc_amount,
				':budget_id'=>$id
			));
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();	
			return false;
		}
		$this->Message("Account has been updated!", "rgb(66, 244, 128)", "admin-feetype");
	}
	public function deleteFeeType($id, $table){
		$sql = $this->conn->prepare("DELETE FROM $table WHERE budget_id=:budget_id");
		$sql->execute(array(
			':budget_id'=>$id
		));
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