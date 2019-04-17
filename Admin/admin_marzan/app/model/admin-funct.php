<?php
require 'app/model/connection.php';
class AdminFunct {
	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
		$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}
	/**************** GENERAL ****************/
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
		}
		return $sql;
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
			}
			return $sql;
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
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
	/**************** END GENERAL ****************/
	/**************** FEE TYPE *******************/
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
	/**************** END FEE TYPE **************/

	/******** STUDENT PAYMENT STATUS ***********/
	public function showPaymentStatus(){
		$sql=$this->conn->query("SELECT *
				FROM student JOIN balance ON student.stud_id = balance.stud_idb 
				JOIN section on section.sec_id = student.secc_id 
				JOIN balpay bp ON bp.bal_ida = balance.stud_idb 
				JOIN payment ON payment.pay_id = bp.pay_ida GROUP BY 1") or die ("failed!");
		while($row=$sql->fetch(PDO::FETCH_ASSOC)){
			$data[]=$row;
		}
		return $data;
	}
	/********* END STUDENT PAYMENT STATUS **********/

	/**************** SUBJECT *******************/
	public function addSubject($subj_dept, $subj_name){
		try {
			$created=date('Y-m-d H:i:s');	
			$sql1=$this->conn->prepare("INSERT INTO Subject SET subj_dept=:subj_dept, subj_name=:subj_name, timestamp_subj=:timestamp_subj");
			if($sql1->execute(array(
				':subj_dept' => $subj_dept,
				':subj_name' => $subj_name,
				':timestamp_subj' => $created
			))){
				$this->Prompt("A new subject has been created! Subject Code = <span class='prompt'>$subj_dept</span> Subject Name  = <span class='prompt'>$subj_name</span>", "rgb(1, 58, 6)", "admin-subjects");
			}else{	
				$this->Prompt("Failed to add subject!", "rgb(175, 0, 0)", "admin-subjects");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function updateSubject($subj_id, $subj_dept, $subj_name){
		try {
			$sql=$this->conn->prepare("UPDATE Subject 
			SET  subj_dept=:subj_dept, 
				subj_name=:subj_name
			WHERE subj_id=:subj_id");	
			if($sql->execute(array(
				':subj_dept' => $subj_dept,
				':subj_name' => $subj_name,
				':subj_id' => $subj_id
			))){
				$this->Prompt("Subject has been updated", "rgb(1, 58, 6)", "admin-subjects");
			}else{
				$this->Prompt("Failed to update subject", "rgb(175, 0, 0)", "admin-subjects");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}	
	public function deleteSubject($subj_id){
		try {
			$sql = $this->conn->prepare("
				DELETE FROM Subject WHERE subj_id =:subj_id");
			if($sql->execute(array(
				':subj_id'=>$subj_id
			))){
				$this->Message("The subject has been deleted!", "rgb(1, 58, 6)", "admin-subjects");
			}else{	
				$this->Prompt("Failed to delete subject!", "rgb(175, 0, 0)", "admin-subjects");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	/**************** END SUBJECT ****************/
	
	/**************** SECTION *******************/
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
				$this->Message("The section has been deleted!", "rgb(1, 58, 6)", "admin-section");
			}else{	
				$this->Prompt("Failed to delete section!", "rgb(175, 0, 0)", "admin-section");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	/**************** END SECTION ****************/
	
	/**************** CLASS **********************/
	public function showClasses(){
		$sql=$this->conn->prepare("SELECT fac_no, CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS fullname, sec_name, grade_lvl, fac_id, sec_id FROM faculty JOIN section ON fac_id=fac_idv WHERE fac_adviser='Yes'");
		$sql->execute();
		if($sql->rowCount()>0){
			while($r=$sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}
	public function section() {
		$sql = $this->conn->prepare("SELECT sec_id, sec_name, grade_lvl FROM Section");
		$sql->execute();
		while ($row = $sql->fetch()) {
			echo "<option value='" . $row['sec_id'] . "'>".$row['grade_lvl']." - " . $row['sec_name'] . "</option>";
		}
	}
	public function facultylist(){
		$sql = $this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, fac_id FROM Faculty WHERE fac_adviser='Yes' and fac_id NOT IN (SELECT fac_idv FROM section JOIN faculty ON fac_id=fac_idv) ");
		$sql->execute();
		while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
			echo "<option value='" . $row['fac_id'] . "'>" . $row['facultyname'] . "</option>";
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
	/**************** END CLASS *********************/
	
	/****************FACULTY ACCOUNT ****************/
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
			$usernameFac= str_replace(' ', ' ', ($fac_fname[0].$fac_midname[0].$fac_lname));
			$FacultyAccid = $this->createFacultyAccount($usernameFac, $password, 'Faculty');
			$sql1 = $this->conn->prepare("INSERT INTO faculty SET fac_no=:fac_no, fac_fname=:fac_fname, fac_lname=:fac_lname, fac_midname=:fac_midname, fac_dept=:fac_dept, fac_adviser=:fac_adviser, timestamp_fac=:timestamp_fac, acc_idz=:acc_idz");
			if($sql1->execute(array(
				':fac_no' =>$fac_no,
				':fac_fname' => $fac_fname,
				':fac_lname' => $fac_lname,
				':fac_midname' => $fac_midname,
				':fac_dept' => $fac_dept,
				':fac_adviser' => $fac_adviser,
				':timestamp_fac' => $created,
				':acc_idz' => $FacultyAccid
			))){
				$sql2=$this->conn->prepare("SELECT * FROM faculty JOIN accounts ON acc_idz=acc_id ORDER BY 1 DESC LIMIT 1");
				$sql2->execute();
				$row=$sql2->fetch(PDO::FETCH_ASSOC);
				$username=$row['username'];
				$this->Prompt("Account has been created! Username = <span class='prompt'>$username</span> Password = <span class='prompt'>$password </span>", "rgb(1, 58, 6)", "admin-faculty");
			}else{
				$this->Prompt("This user already exist!", "rgb(175, 0, 0)", "admin-faculty");
			}
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}	
	}
	public function updateFacultyData($id, $fac_no, $fac_fname, $fac_midname, $fac_lname, $fac_dept, $fac_adviser, $sec_privilege){
		try {
			$sql = $this->conn->prepare("UPDATE faculty
			SET 	fac_no=:fac_no,
				fac_fname=:fac_fname,
				fac_midname=:fac_midname,
				fac_lname=:fac_lname,
				fac_dept=:fac_dept,
				fac_adviser=:fac_adviser,
				sec_privilege=:sec_privilege
			WHERE fac_id=:fac_id");
			if($sql->execute(array(
				':fac_no'=>$fac_no,
				':fac_fname'=>$fac_fname,
				':fac_midname'=>$fac_midname,
				':fac_lname'=>$fac_lname,
				':fac_dept'=>$fac_dept,
				':fac_adviser'=>$fac_adviser,
				':sec_privilege'=>$sec_privilege,
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
				$this->Message("The account has been deleted!", "rgb(1, 58, 6)", "admin-faculty");
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
	/**************** END FACULTY ACCOUNT ****************/
	
	/*************** PTA/PARENT ACCOUNT *****************/
	public function studentList() {
		$sql = $this->conn->prepare("SELECT stud_id, CONCAT(first_name,' ',middle_name,' ',last_name) as studentName FROM student");
		$sql->execute();
		while ($row = $sql->fetch()) {
			echo "<option value='" . $row['stud_id'] . "'>" . $row['studentName'] . "</option>";
		}
	}
	public function studentId(){
		$sql=$this->conn->prepare("SELECT stud_id FROM student");
		$sql->execute();
		$studentId = array();
		while($row = $sql->fetch()){
			$studentId[] = $row["stud_id"];
		}
		return $studentId;
	}
	public function studentName(){
		$sql=$this->conn->prepare("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) AS studentName FROM student");
		$sql->execute();
		$studentName = array();
		while($row = $sql->fetch()){
			$studentName[] = $row["studentName"];
		}
		return $studentName;
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
	public function insertPTAData($guar_fname, $guar_midname, $guar_lname, $guar_address) {
		try {
			$password = 'password';
			$usernamePTA= str_replace(' ', ' ', ($guar_fname[0].$guar_midname[0].$guar_lname));
			$PTAAccid = $this->createPTAAccount($usernamePTA, $password, 'guardian');
			$sql = $this->conn->prepare("INSERT INTO guardian SET guar_fname=:guar_fname, guar_lname=:guar_lname, guar_midname=:guar_midname, guar_address=:guar_address, acc_idx=:acc_idx");
			if($sql->execute(array(
				':guar_fname' => $guar_fname,
				':guar_lname' => $guar_lname,  
				':guar_midname' => $guar_midname,
				':guar_address' => $guar_address,
				':acc_idx' => $PTAAccid
				
			))){
				$sql2=$this->conn->prepare("SELECT * FROM guardian JOIN accounts ON acc_idx=acc_id ORDER BY 1 DESC LIMIT 1");
				$sql2->execute();
				$row=$sql2->fetch(PDO::FETCH_ASSOC);
				$username=$row['username'];
				$this->Prompt("Account has been created! Username = <span class='prompt'>$username</span> Password = <span class='prompt'>$password </span>", "rgb(1, 58, 6)", "admin-parent");
			}else{
				$this->Prompt("Failed to add Treasurer data", "rgb(175, 0, 0)", "admin-parent");
			}
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}	
	}
	public function updatePTAData($guar_id, $guar_fname, $guar_midname, $guar_lname, $guar_address, $guar_mobno, $guar_telno) {
		try {
			$sql1 = $this->conn->prepare("UPDATE guardian SET 
					guar_fname=:guar_fname, 
					guar_lname=:guar_lname, 
					guar_midname=:guar_midname, 
					guar_address=:guar_address,
					guar_mobno=:guar_mobno,
					guar_telno=:guar_telno
				WHERE guar_id=:guar_id
				");
			
			if($sql1->execute(array(
				':guar_fname' => $guar_fname,
				':guar_lname' => $guar_lname,  
				':guar_midname' => $guar_midname,
				':guar_address' => $guar_address,
				':guar_mobno' => $guar_mobno,
				':guar_telno' => $guar_telno,
				':guar_id' => $guar_id
			))){
				$sql2 = $this->conn->prepare("SELECT * FROM guardian");
				$this->Prompt("Successfully updated the account of <span class='prompt'>$guar_fname $guar_midname $guar_lname</span>", "rgb(1, 58, 6)", "admin-parent");
			}else{
				$this->Prompt("Failed to update Treasurer data", "rgb(175, 0, 0)", "admin-parent");
			}
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}	
	}
	public function deletePTAData($id){
		try {
			$sql = $this->conn->prepare("
				DELETE a.*, b.* 
				FROM parent a 
				LEFT JOIN accounts b 
				ON b.acc_id = a.acc_idx 
				WHERE a.acc_idx =:acc_idx");
			if($sql->execute(array(
				':acc_idx'=>$id
			))){
				$this->Message("The account has been deleted!", "rgb(1, 58, 6)", "admin-parent");
			}else{	
				$this->Prompt("Failed to delete Account Data!", "rgb(175, 0, 0)", "admin-parent");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function showParentList(){
		$sql=$this->conn->query("SELECT * FROM student s JOIN guardian g ON s.guar_id=g.guar_id JOIN accounts ON acc_idx=acc_id;");
		$sql->execute();
		if($sql->rowCount()>0){
			while($r=$sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}
	public function showTreasurerList(){
		$sql=$this->conn->query("SELECT * FROM guardian JOIN accounts c ON acc_idx=acc_id WHERE c.acc_type='Treasurer'");
		$sql->execute();
		if($sql->rowCount()>0){
			while($r=$sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}
	public function updateParentAccount1($newUsername, $password){
		$newPass = password_hash($password, PASSWORD_DEFAULT);
		$querySearch = $this->conn->prepare("SELECT acc_id FROM accounts WHERE username=?");
		$querySearch->bindParam(1, $username);
		$querySearch->execute();
		$row = $querySearch->fetch();
		$newUsername = $username.$row['acc_id'];
		$getaccid = $row['acc_id'];
		$queryUpdate = $this->conn->prepare("UPDATE accounts SET username=? WHERE acc_id=?");
		$queryUpdate->bindParam(1, $newUsername);
		$queryUpdate->bindParam(2, $getaccid);
		$queryUpdate->execute();
		return $getaccid;
	}
	public function updateParentAccount2($guar_id, $guar_fname, $guar_midname, $guar_lname, $guar_address, $guar_mobno, $guar_telno) {
		try {
			$usernameParent= str_replace(' ', ' ', ($guar_fname[0].$guar_midname[0].$guar_lname));
			$sql3=$this->conn->prepare("SELECT username,acc_idx FROM guardian g JOIN accounts c ON acc_idx=acc_id WHERE g.guar_id=:guar_id");
			$sql3->bindParam(":guar_id", $guar_id);
			$sql3->execute();
			$row=$sql3->fetch(PDO::FETCH_ASSOC);
			$newUsername=$usernameParent.$row['acc_idx'];
			$acc_idx=$row['acc_idx'];
			$password = 'password';
			$newPass = password_hash($password, PASSWORD_DEFAULT);
			$sql3 = $this->conn->prepare("UPDATE accounts SET 
					username=:username,
					password=:password
				WHERE acc_id=:acc_idx
				");
			
			$sql3->execute(array(
				':username' => $newUsername,
				':password' => $newPass,
				':acc_idx' => $acc_idx
			));
			$sql1 = $this->conn->prepare("UPDATE guardian SET 
					guar_fname=:guar_fname, 
					guar_lname=:guar_lname, 
					guar_midname=:guar_midname, 
					guar_address=:guar_address,
					guar_mobno=:guar_mobno,
					guar_telno=:guar_telno
				WHERE guar_id=:guar_id
				");
			
			if($sql1->execute(array(
				':guar_fname' => $guar_fname,
				':guar_lname' => $guar_lname,  
				':guar_midname' => $guar_midname,
				':guar_address' => $guar_address,
				':guar_mobno' => $guar_mobno,
				':guar_telno' => $guar_telno,
				':guar_id' => $guar_id
			))){
				$sql2=$this->conn->prepare("SELECT * FROM guardian JOIN accounts ON acc_idx=acc_id WHERE guar_id=?");
				$sql2->bindParam(1, $guar_id);
				$sql2->execute();
				$row=$sql2->fetch(PDO::FETCH_ASSOC);
				$username=$row['username'];
				$this->Prompt("Account has been created! Username = <span class='prompt'>$username</span> Password = <span class='prompt'>$password </span>", "rgb(1, 58, 6)", "admin-parent");
			}else{
				$this->Prompt("Failed to update Treasurer data", "rgb(175, 0, 0)", "admin-parent");
			}
			
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}	
	}
	/**************** END PTA ACCOUNT ****************/
	
	/**************** STUDENT  ***********************/
	public function showStudentList(){
		try {
			$sql=$this->conn->query("SELECT * FROM student JOIN accounts ON accc_id=acc_id") or die("failed!");
			$sql->execute();
			if($sql->rowCount()>0){
				while($r = $sql->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				return $data;
			}
			return $sql;
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	/**************** END STUDENT ****************/
	
	/**************** ANNOUNCEMENT **************/
	public function insertEvent($title, $post, $date_start, $date_end, $view_lim, $attachment){
		try{
			$checkbox = $_POST['view_lim'];
			$sql = "INSERT INTO announcements SET title=:title, date_start=:date_start, date_end=:date_end, post=:post, view_lim=('";
			for($i=0; $i<sizeof ($checkbox);$i++) {
				$sql .= $checkbox[$i];
				if ($i<sizeof ($checkbox) - 1) {
					$sql .= ",";
				}
			}
			$sql .= "'), attachment=:attachment, post_adminid=:post_adminid";
			$sql=$this->conn->prepare($sql);
			if($sql->execute(array(
			':title'  => $title,
			':date_start' => $date_start,
			':date_end' => $date_end,
			':post' => $post,
			':attachment' => (empty($attachment['name']) ? null : $attachment['name']),
			':post_adminid' => $_SESSION['accid']))){
				$this->Prompt("An announcement has been created! Title = <span class='prompt'>$title</span> Start Date = <span class='prompt'>$date_start </span> End Date = <span class='prompt'>$date_end </span>", "rgb(1, 58, 6)", "admin-events");
			}else{
				$this->Prompt("Failed to post announcement", "rgb(175, 0, 0)", "admin-events");
			}
			
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}
		/*if(!empty($attachment['name'])) move_uploaded_file($attachment['tmp_name'], 'attachment/'.$attachment['name']);*/
		$file = $attachment['name'];
		$size = $attachment['size'];
		$temp1 = $attachment['tmp_name'];
		$pathWithFile = "attachment/".$file; //set upload folder path
		
		$sql2=$this->conn->prepare("SELECT * FROM announcements ORDER BY 1 DESC LIMIT 1");
		$sql2->execute();
        	$row=$sql2->fetch(PDO::FETCH_ASSOC);	
		$id=$row['ann_id'];
		$fileToDel = trim(strval($row['attachment']));
		$new_path = realpath('attachment/'.$fileToDel);
		/*@unlink($new_path);*/
		
		$temp2 = $attachment['tmp_name'];
		$staticValue="attachment";
		$path = "attachment/";
		$openBracket="[";
		$closeBracket="]";
		$filename = "$staticValue$openBracket$id$closeBracket".basename($file);
        	$newname = $path . $filename;
		if(!empty($attachment['name'])){
			if(!file_exists($newname)){
				if($filesize < 20000000){ //check file size of 20mb
					/*move_uploaded_file($temp1, $pathWithFile);*/ //move temporary file to your folder
					move_uploaded_file($temp2, $newname);
			        	$sql3 = $this->conn->prepare("UPDATE announcements SET attachment=:attachment WHERE ann_id=:ann_id");
					$sql3->execute(array(
						':attachment' => $filename,
						':ann_id' => $id
					));
				}else{
					$this->Prompt("Maximum file size 20mb!", "rgb(175, 0, 0)", "admin-events");
				}
			}else{
				$this->Prompt("Successfully updated the announcement  Title = <span class='prompt'>$title</span> Start Date = <span class='prompt'>$date_start </span> End Date = <span class='prompt'>$date_end </span>, but the attachment already exist! Please change the filename and re-upload the file using the edit operator!", "rgb(175, 0, 0)", "admin-events");
			}
		}
	}
	
	public function viewLimValue() {
		$query = $this->conn->prepare("SELECT view_lim FROM announcements");
		$query->execute();
		$viewLimValue = array();
		while ($row = $query->fetch()) {
			$viewLimValue[] = $row['view_lim'];
		}
		return $viewLimValue;
	}
	
	public function viewLim($ann_id){
		$sql=$this->conn->prepare("SELECT * FROM announcements WHERE ann_id=:ann_id");
		$sql->execute(array(
			':ann_id' => $ann_id
		));
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		$viewLim= $row['view_lim'];
		if('0' == $viewLim){echo "All";}
		else if('1' == $viewLim){echo "Faculty Only";}
		else if('2' == $viewLim){echo "Parent Only";}
		else if('3' == $viewLim){echo "Student Only";}
		else if('4' == $viewLim){echo "Treasurer Only";}
		else if(('1,2') == $viewLim){echo "Faculty and Parent";}
		else if('1,3' == $viewLim){echo "Faculty and Student";}
		else if('1,4' == $viewLim){echo "Faculty and Treasurer";}
		else if('2,3' == $viewLim){echo "Parent and Student";}
		else if('2,4' == $viewLim){echo "Parent and Treasurer";}
		else if('3,4' == $viewLim){echo "Student and Treasurer";}
		else if('1,2,3' == $viewLim){echo "Faculty, Parent and Student";}
		else if('1,3,4' == $viewLim){echo "Faculty, Student and Treasurer";}
		else if('2,3,4' == $viewLim){echo "Parent, Student and Treasurer";}
		else if('1,2,3,4' == $viewLim){echo "All";}
		
	}
	
	public function updateEvent($ann_id, $title, $post, $date_start, $date_end, $view_lim, $attachment){
		if(!empty($attachment['name'])) {			
			$file = $attachment['name'];
			$size = $attachment['size'];
			$temp = $attachment['tmp_name'];
			$path = "attachment/".$file; //set upload folder path
		
			if(!file_exists($path)){
				if($size < 20000000){
					$sql2= $this->conn->prepare("SELECT * FROM announcements WHERE ann_id =:ann_id");
					$sql2->execute(array(
						':ann_id' => $ann_id
					));	
					$row=$sql2->fetch(PDO::FETCH_ASSOC);
					$id=$row['ann_id'];
					$fileToDel = trim(strval($row['attachment']));
					$new_path = realpath('attachment/'.$fileToDel);
					@unlink($new_path);
					/*move_uploaded_file($temp, $path); */
					
					$temp2 = $attachment['tmp_name'];
					$staticValue="attachment";
					$path = "attachment/";
					$openBracket="[";
					$closeBracket="]";
					$filename = "$staticValue$openBracket$id$closeBracket".basename($file);
			        	$newname = $path . $filename;
			        	move_uploaded_file($temp2, $newname);
			        	$sql3 = $this->conn->prepare("UPDATE announcements SET attachment=:attachment WHERE ann_id=:ann_id");
					$sql3->execute(array(
						':attachment' => $filename,
						':ann_id' => $id
					));
				}else{
					$this->Prompt("Maximum file size (20mb)!", "rgb(175, 0, 0)", "admin-events");
				}
			}else{
				$this->Prompt("Successfully updated the announcement  Title = <span class='prompt'>$title</span> Start Date = <span class='prompt'>$date_start </span> End Date = <span class='prompt'>$date_end </span>, but the attachment already exist! Please change the filename and re-upload the file using the edit operator!", "rgb(175, 0, 0)", "admin-events");
			}
		}
		try{
			if(!empty($attachment['name'])) {
				$checkbox = $_POST['view_lim'];
				$sql1 = "UPDATE announcements SET title=:title, date_start=:date_start, date_end=:date_end, post=:post, view_lim=('";
				for($i=0; $i<sizeof ($checkbox);$i++) {
					$sql1 .= $checkbox[$i];
					if ($i<sizeof ($checkbox) - 1) {
						$sql1 .= ",";
					}
				}
				$sql1 .= "'), attachment=:attachment WHERE ann_id=:ann_id";
				$sql1=$this->conn->prepare($sql1);
				if($sql1->execute(array(
				':title'  => $title,
				':date_start' => $date_start,
				':date_end' => $date_end,
				':post' => $post,
				':attachment' => $attachment['name'],
				':ann_id' => $ann_id))){
					$this->Prompt("An announcement has been updated! Title = <span class='prompt'>$title</span> Start Date = <span class='prompt'>$date_start </span> End Date = <span class='prompt'>$date_end </span>", "rgb(1, 58, 6)", "admin-events");
				}else{
					$this->Prompt("Failed to post announcement", "rgb(175, 0, 0)", "admin-events");
				}
			} else {
				$checkbox = $_POST['view_lim'];
				$sql1 = "UPDATE announcements SET title=:title, date_start=:date_start, date_end=:date_end, post=:post, view_lim=('";
				for($i=0; $i<sizeof ($checkbox);$i++) {
					$sql1 .= $checkbox[$i];
					if ($i<sizeof ($checkbox) - 1) {
						$sql1 .= ",";
					}
				}
				$sql1 .= "') WHERE ann_id=:ann_id";
				$sql1=$this->conn->prepare($sql1);
				if($sql1->execute(array(
				':ann_id' => $ann_id,
				':title'  => $title,
				':post' => $post,
				':date_start' => $date_start,
				':date_end' => $date_end))){
					$this->Prompt("An announcement has been updated! Title = <span class='prompt'>$title</span> Start Date = <span class='prompt'>$date_start </span> End Date = <span class='prompt'>$date_end </span>", "rgb(1, 58, 6)", "admin-events");
				}else{
					$this->Prompt("Failed to post announcement", "rgb(175, 0, 0)", "admin-events");
				}
			}
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}
		
	}
	
	/*public function viewFile(){
		$sql = $this->conn->prepare("SELECT attachment FROM announcements");
		$sql->execute();
		$viewFile = array();
		while ($row = $query->fetch()) {
			$viewFile[] = $row['attachment'];
		}
		echo "<td><a href="'attachment/'.$row['file']." target='_blank'>view file</a></td>"
	}*/
	
	public function deleteEvent($ann_id){
		try {
			$sql1= $this->conn->prepare('SELECT attachment FROM announcements WHERE ann_id =:ann_id');
			$sql1->bindParam(':ann_id',$ann_id);
			$sql1->execute();	
			$row=$sql1->fetch(PDO::FETCH_ASSOC);
			$file = $row['attachment'];
			$dir = "attachment/".$file;
			chmod($dir, 0777);
			@unlink($dir);
			
			$sql2 = $this->conn->prepare("DELETE FROM announcements WHERE ann_id =:ann_id");
			if($sql2->execute(array(
				':ann_id'=>$ann_id
			))){
				$this->Message("The announcement has been deleted!", "rgb(1, 58, 6)", "admin-events");
			}else{	
				$this->Prompt("Failed to delete announcement!", "rgb(175, 0, 0)", "admin-events");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	/**************** END ANNOUNCEMENT *********
	
	/**************** REPORTS **************/
	public function showEnrolled(){
		$sql=$this->conn->query("SELECT *
				FROM student JOIN section ON section.sec_id = student.secc_id 
      			WHERE stud_status='Officially Enrolled'") or die ("failed!");
		while($row=$sql->fetch(PDO::FETCH_ASSOC)){
			$data[]=$row;
		}
		return $data;
	}
	public function getMiscFee(){
		$sql=$this->conn->prepare("SELECT * FROM balance");
		$sql->execute();
		$rowCount=$sql->fetch();
		echo " ". number_format($rowCount['misc_fee'], 2) . " ";
		}
	public function getTotalBDOF(){
		$sql=$this->conn->prepare("SELECT sum(acc_amount) FROM budget_info");
		$sql->execute();
		$rowCount=$sql->fetch();
		echo " ". number_format($rowCount['sum(acc_amount)'], 2) . " ";
	}
	public function showPaymentHistory($stud_lrno, $first_name, $middle_name, $last_name, $year_level, $sec_name, $orno, $pay_date, $pay_amt, $bal_amt){
		$sql=$this->conn->query("SELECT stud_lrno, first_name, middle_name, last_name, year_level, sec_name, orno, DATE_FORMAT(pay_date, '%M %e, %Y - %H:%i:%S') as payment_date, pay_amt, remain_bal
				FROM student JOIN balance ON student.stud_id = balance.stud_idb 
				JOIN section on section.sec_id = student.secc_id 
				JOIN balpay bp ON bp.bal_ida = balance.stud_idb 
				JOIN payment ON payment.pay_id = bp.pay_ida") or die ("failed!");
		while($row=$sql->fetch(PDO::FETCH_ASSOC)){
			$data[]=$row;
		}
		return $data;
	}
	/**************** END REPORTS ****************/

	/*************** PROMT / MESSAGE  ***********/
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
	/**************** END PROMPT / MESSAGE ****************/
	
}
?>