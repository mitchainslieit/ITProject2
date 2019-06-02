<?php
require 'app/model/connection.php';
class AdminFunct{
	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
		$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	
	}
	/**************** GENERAL ****************/
	public function insertLogs($log_event, $log_desc){
		try {
			$admin_id=$_SESSION['accid'];
			$sql3=$this->conn->prepare("INSERT INTO logs SET log_event=:log_event, log_desc=:log_desc, user_id=:user_id");
			$sql3->execute(array(
				':log_event' => $log_event, 
				':log_desc' => $log_desc, 
				':user_id' => $admin_id
			)); 	
		}catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function addRequest($request_desc){
		try {
			$sql3=$this->conn->prepare("INSERT INTO request SET request_type='Insert', request_desc=:request_desc, request_id='Temporary'");
			$sql3->execute(array(
				':request_desc' => $request_desc, 
			)); 	
		}catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function updateRequest($req_id, $request_desc){
		try {
			$sql3=$this->conn->prepare("UPDATE request SET request_type='Update', request_desc=:request_desc, request_status='Temporary' where request_id=:request_id");
			$sql3->execute(array(
				':request_desc' => $request_desc, 
				':request_id' =>$req_id
			)); 	
		}catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function deleteRequest($req_id, $request_desc){
		try {
			$sql3=$this->conn->prepare("UPDATE request SET request_type=:request_type, request_desc=:request_desc, request_status='Temporary' where request_id=:request_id");
			$sql3->execute(array(
				':request_type' => 'Delete', 
				':request_desc' => $request_desc, 
				':request_id' =>$req_id
			)); 	
		}catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function getRequestID(){
		$queryGetID=$this->conn->prepare("SELECT request_id FROM request ORDER BY request_id desc LIMIT 1");
		$queryGetID->execute();
		$rowQueryGetID=$queryGetID->fetch(PDO::FETCH_ASSOC);
		$request_id=$rowQueryGetID['request_id'];
		return $request_id;
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
	public function multipleDeleteFee(){
		$checkbox = $_POST['check'];
		if($checkbox !== null){
			for($i=0;$i<count($checkbox);$i++){
				$del_id = $checkbox[$i]; 
			
				$queryGetID=$this->conn->prepare("SELECT * FROM budget_info_temp where bd_id=:bd_id");
				$queryGetID->execute(array(
					':bd' => $del_id
				));
				$rowQueryGetID=$queryGetID->fetch(PDO::FETCH_ASSOC);
				$req_id=$rowQueryGetID['bd_request'];
				$budget_name=$rowQueryGetID['bd_name'];
				$request_desc='Delete Fee Type '.$budget_name;
				
				$this->deleteRequest($req_id, $request_desc);
				$this->alert("Success!", "The delete request has been sent for Fee Type  $budget_name.", "success", "admin-feetype");
			
				
			/*	$sql1=$this->conn->prepare("SELECT budget_name, total_amount FROM budget_info WHERE budget_id=:budget_id");
				$sql1->execute(array(
					':budget_id'=>$del_id
				));
				$row=$sql1->fetch(PDO::FETCH_ASSOC);
				$budget_name=$row['budget_name'];
				$budget_amt=$row['total_amount'];
				
				$query14=$this->conn->prepare("SELECT SUM(total_amount) as misc_fee FROM budget_info");
				$query14->execute();
				$row14=$query14->fetch(PDO::FETCH_ASSOC);
				$prev_misc_fee2=$row14['misc_fee'];
				
				$sql2=$this->conn->prepare("DELETE FROM budget_info WHERE budget_id=:budget_id");
				if($sql2->execute(array(
					':budget_id'=>$del_id
				))){
					$query1=$this->conn->prepare("SELECT SUM(total_amount) as misc_fee FROM budget_info");
					$query1->execute();
					$row1=$query1->fetch(PDO::FETCH_ASSOC);
					$prev_misc_fee=$row1['misc_fee'];
					
					$query7=$this->conn->prepare("SELECT ($prev_misc_fee2 - $prev_misc_fee) as difference FROM balance");
					$query7->execute();
					$row7=$query7->fetch(PDO::FETCH_ASSOC);
					$difference2=$row7['difference'];
					
					$query3=$this->conn->prepare("SELECT * FROM balance");
					$query3->execute();
					if($query3->rowCount() > 0){
						$query4=$this->conn->prepare("UPDATE balance SET misc_fee = $prev_misc_fee, bal_amt = (bal_amt - $difference2)");
						$query4->execute();
						$query13=$this->conn->prepare("SELECT * FROM balance");
						$query13->execute();
						$result13 = $query13->fetchAll();
						foreach ($result13 as $row13) {
							if($row13['bal_amt'] == 0){
								$query14=$this->conn->prepare("UPDATE balance SET bal_status='Cleared' WHERE bal_amt='0'");
								$query14->execute();
							}
						}
					}
					
					$query10 = $this->conn->prepare("SELECT * FROM payment");
					$query10->execute();
					if($query10->rowCount() > 0){
						$query11=$this->conn->prepare("SELECT max(pay_id) as pay_id from payment group by balb_id");
						$query11->execute();
						$result = $query11->fetchAll();
						foreach($result as $row) {
							$query12=$this->conn->prepare("UPDATE payment set remain_bal = (remain_bal -:difference) WHERE pay_id=:pay_id");
							$query12->execute(array(
								':difference' => $budget_amt,
								':pay_id' => $row['pay_id']
							)) or die ('failed');
						}
					}
					$log_event="Delete";
					$log_desc="Deleted the Fee Type ".$budget_name;
					$this->insertLogs($log_event, $log_desc);
					$this->alert("Success!", "The selected item/s has been successfully deleted", "success", "admin-feetype");
				}else{
					$this->alert("Error!", "You are not allowed to delete the selected item/s", "error", "admin-feetype");
				}*/
			}
		}else{
			$this->alert("Error!", "Please select atleast one item", "error", "admin-feetype");
		}
	}
	public function addFeeType($budget_name, $total_amount) {
		try{
			$query1=$this->conn->prepare("SELECT SUM(total_amount) as misc_fee FROM budget_info");
			$query1->execute();
			$row1=$query1->fetch(PDO::FETCH_ASSOC);
			$prev_misc_fee=$row1['misc_fee'];
			
			$curYear = date('Y');
			$request_desc='Add Fee Type '.$budget_name.' with amount of '.$total_amount;
			$this->addRequest($request_desc);
			$request_id=$this->getRequestID();
			
			$query2=$this->conn->prepare("INSERT INTO budget_info_temp (bd_name, tot_amt, acc_amt, bd_sy, bd_request) VALUES(:bd_name, :tot_amt, '0', :bd_sy, :bd_request)");
			
			if($query2->execute(array(
				':bd_name' => $budget_name,
				':tot_amt' => $total_amount,
				':bd_request' => $request_id,
				':bd_sy' => $curYear
			))){
				/*superadmin add fee type*/
				/*$query3=$this->conn->prepare("SELECT SUM(total_amount) as misc_fee, (SUM(total_amount) - $prev_misc_fee) as difference FROM budget_info");
				$query3->execute();
				$row3=$query3->fetch(PDO::FETCH_ASSOC);
				$difference=$row3['difference'];

				$query4=$this->conn->prepare("SELECT bal_amt, bal_id FROM balance");
				$query4->execute();
				if($query4->rowCount() > 0){	
					$query5=$this->conn->prepare("UPDATE balance SET misc_fee = (misc_fee +:difference), bal_amt = (bal_amt +:difference), bal_status='Not Cleared'");
					$query5->execute(array(
						':difference' => $difference,
						':difference' => $difference
					));
				}		

				$query6 = $this->conn->prepare("SELECT * FROM payment");
				$query6->execute();
				if($query6->rowCount() > 0){
					$query7=$this->conn->prepare("SELECT max(pay_id) as pay_id from payment group by balb_id");
					$query7->execute();
					$result = $query7->fetchAll();
					foreach($result as $row) {
						$query8=$this->conn->prepare("UPDATE payment set remain_bal = (remain_bal +:difference) WHERE pay_id=:pay_id");
						$query8->execute(array(
							':difference' => $difference,
							':pay_id' => $row['pay_id']
						)) or die ('failed');
					}
				}
				*/
				$this->alert("Success!", "The request has been sent!", "success", "admin-feetype");
			}else{	
				$this->alert("Error!", "Failed to add Fee Type! This Fee Type already exist.", "error", "admin-feetype");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function updateFeeType($id, $budget_name, $total_amount){
		try{
			$queryGetID=$this->conn->prepare("SELECT * FROM budget_info_temp where bd_id=:bd_id");
			$queryGetID->execute(array(
				':bd_id' => $id
			));
			$rowQueryGetID=$queryGetID->fetch(PDO::FETCH_ASSOC);
			$req_id=$rowQueryGetID['bd_request'];
			$request_desc='Update Fee Type '.$budget_name. ' with amount of '.$total_amount;
			$this->updateRequest($req_id, $request_desc);
			
			$query1=$this->conn->prepare("SELECT SUM(total_amount) as misc_fee FROM budget_info");
			$query1->execute();
			$row1=$query1->fetch(PDO::FETCH_ASSOC);
			$prev_misc_fee=$row1['misc_fee'];
			
			$sql1=$this->conn->prepare("UPDATE budget_info_temp SET bd_name=:bd_name, tot_amt=:tot_amt WHERE bd_id=:bd_id");
			if($sql1->execute(array(
				':bd_name' => $budget_name,
				':tot_amt' => $total_amount,
				':bd_id'=>$id
			))){
				/*superadmin update fee type*/
				/*$query6=$this->conn->prepare("SELECT SUM(total_amount) as misc_fee FROM budget_info");
				$query6->execute();
				$row6=$query6->fetch(PDO::FETCH_ASSOC);
				$prev_misc_fee2=$row6['misc_fee'];
				
				$query7=$this->conn->prepare("SELECT ($prev_misc_fee2 - misc_fee) as difference FROM balance");
				$query7->execute();
				$row7=$query7->fetch(PDO::FETCH_ASSOC);
				$difference2=$row7['difference'];
				
				$query8=$this->conn->prepare("SELECT * FROM balance");
				$query8->execute();
				if($query8->rowCount() > 0){
					$query9=$this->conn->prepare("UPDATE balance SET misc_fee = (misc_fee + $difference2), bal_amt = (bal_amt + $difference2)");
					$query9->execute();
					$query13=$this->conn->prepare("SELECT * FROM balance");
					$query13->execute();
					$result13 = $query13->fetchAll();
					foreach ($result13 as $row13) {
						if($row13['bal_amt'] == 0){
							$query14=$this->conn->prepare("UPDATE balance SET bal_status='Cleared' WHERE bal_amt='0'");
							$query14->execute();
						}else{
							$query15=$this->conn->prepare("UPDATE balance SET bal_status='Not Cleared' WHERE bal_amt > '0'");
							$query15->execute();
						}
					}
				}
				$query10 = $this->conn->prepare("SELECT * FROM payment");
				$query10->execute();
				if($query10->rowCount() > 0){
					$query11=$this->conn->prepare("SELECT max(pay_id) as pay_id from payment group by balb_id");
					$query11->execute();
					$result2 = $query11->fetchAll();
					foreach($result2 as $row) {
						$query12=$this->conn->prepare("UPDATE payment set remain_bal = (remain_bal +:difference) WHERE pay_id=:pay_id");
						$query12->execute(array(
							':difference' => $difference2,
							':pay_id' => $row['pay_id']
						)) or die ('failed');
					}
				}
				$sql2=$this->conn->prepare("SELECT * FROM budget_info WHERE budget_id=?");
				$sql2->bindParam(1, $id);
				$sql2->execute();
				$row=$sql2->fetch(PDO::FETCH_ASSOC);
				$budget_name=$row['budget_name'];
				$log_event="Update";
				$log_desc="Updated the Fee Type ".$budget_name." with amount of ".number_format($total_amount, 2);
				$this->insertLogs($log_event, $log_desc);*/
				$this->alert("Success!", "The update request has been sent for Fee Type  $budget_name with amount of $total_amount.", "success", "admin-feetype");
			}else{	
				 $this->alert("Error!", "Failed to update Fee Type!", "error", "admin-feetype");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function deleteFeeType($id, $table){
		try{
			$queryGetID=$this->conn->prepare("SELECT * FROM budget_info_temp where bd_id=:bd_id");
			if($queryGetID->execute(array(
				':bd_id' => $id
			))){
				$rowQueryGetID=$queryGetID->fetch(PDO::FETCH_ASSOC);
				$req_id=$rowQueryGetID['bd_request'];
				$budget_name=$rowQueryGetID['bd_name'];
				$request_desc='Delete Fee Type '.$budget_name;
				
				$this->deleteRequest($req_id, $request_desc);
				$this->alert("Success!", "The delete request has been sent for Fee Type  $budget_name.", "success", "admin-feetype");
			}else{
				$this->alert("Error!", "Failed to delete Fee Type!", "error", "admin-feetype");
			}
			/*superadmin delete fee type*/
			/*$sql1=$this->conn->prepare("SELECT budget_name, total_amount FROM budget_info WHERE budget_id=:budget_id");
			$sql1->execute(array(
				':budget_id'=>$id
			));
			$row=$sql1->fetch(PDO::FETCH_ASSOC);
			$budget_name=$row['budget_name'];
			$budget_amt=$row['total_amount'];
			
			$query14=$this->conn->prepare("SELECT SUM(total_amount) as misc_fee FROM budget_info");
			$query14->execute();
			$row14=$query14->fetch(PDO::FETCH_ASSOC);
			$prev_misc_fee2=$row14['misc_fee'];
			
			$sql2=$this->conn->prepare("DELETE FROM budget_info WHERE budget_id=:budget_id");
			if($sql2->execute(array(
				':budget_id'=>$id
			))){
				$query1=$this->conn->prepare("SELECT SUM(total_amount) as misc_fee FROM budget_info");
				$query1->execute();
				$row1=$query1->fetch(PDO::FETCH_ASSOC);
				$prev_misc_fee=$row1['misc_fee'];
				
				$query7=$this->conn->prepare("SELECT ($prev_misc_fee2 - $prev_misc_fee) as difference FROM balance");
				$query7->execute();
				$row7=$query7->fetch(PDO::FETCH_ASSOC);
				$difference2=$row7['difference'];
				
				$query3=$this->conn->prepare("SELECT * FROM balance");
				$query3->execute();
				if($query3->rowCount() > 0){
					$query4=$this->conn->prepare("UPDATE balance SET misc_fee = $prev_misc_fee, bal_amt = (bal_amt - $difference2)");
					$query4->execute();
					$query13=$this->conn->prepare("SELECT * FROM balance");
					$query13->execute();
					$result13 = $query13->fetchAll();
					foreach ($result13 as $row13) {
						if($row13['bal_amt'] == 0){
							$query14=$this->conn->prepare("UPDATE balance SET bal_status='Cleared' WHERE bal_amt='0'");
							$query14->execute();
						}
					}
				}
				
				$query10 = $this->conn->prepare("SELECT * FROM payment");
				$query10->execute();
				if($query10->rowCount() > 0){
					$query11=$this->conn->prepare("SELECT max(pay_id) as pay_id from payment group by balb_id");
					$query11->execute();
					$result = $query11->fetchAll();
					foreach($result as $row) {
						$query12=$this->conn->prepare("UPDATE payment set remain_bal = (remain_bal -:difference) WHERE pay_id=:pay_id");
						$query12->execute(array(
							':difference' => $budget_amt,
							':pay_id' => $row['pay_id']
						)) or die ('failed');
					}
				}
				
				$log_event="Delete";
				$log_desc="Deleted the Fee Type ".$budget_name;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "Fee Type  $budget_name has been deleted.", "success", "admin-feetype");
			}else{	
				$this->alert("Error!", "Failed to delete Fee Type!", "error", "admin-feetype");
			}*/
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function showFeeType(){
		$sql = $this->conn->prepare("SELECT * FROM request join budget_info_temp on request_id=bd_request") or die ("failed!");
		$sql->execute();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}
	/**************** END FEE TYPE **************/

	/******** STUDENT PAYMENT STATUS ***********/
	public function getGradeAndSection(){
		$sql=$this->conn->prepare("SELECT sec_id, grade_lvl, sec_name, CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS gradesec 
			FROM section ORDER BY grade_lvl");
		$sql->execute();
		$option = '';
		while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
			$option .= '<option value="'.str_replace(' ', '', strtolower(('Grade'.$row['grade_lvl'].'-'.$row['sec_name']))).'" name="gradesec">'.$row["gradesec"].'</option>';
		}
		echo $option;
	}
	public function showPaymentStatus(){
		$sql=$this->conn->query("SELECT distinct(bal_id), stud_lrno, Name, year_level,  sec_name, pay_amt, remaining_balance, bal_status, date, stud_id
		FROM (SELECT DISTINCT (bal_id), stud_lrno, year_level, CONCAT(first_name, ' ', last_name) AS 'Name', bal_amt 'remaining_balance',
		bal_status,
		CASE
		WHEN bal.bal_id IN (SELECT balb_id from payment pm join balance bal on pm.balb_id = bal.bal_id) 
		THEN (SELECT DATE_FORMAT(MAX(pm.pay_date), '%M %e %Y') as 'date'
		FROM payment p
		INNER JOIN payment pm ON p.pay_id = pm.pay_id
		JOIN balpay bp ON bp.pay_ida = pm.pay_id
		JOIN balance bala on bp.bal_ida = bala.bal_id
		JOIN student st ON st.stud_id = bala.stud_idb
		WHERE bal.bal_id = bala.bal_id GROUP BY st.first_name ORDER by 1)
		ELSE
		'No payment yet'
		END
		AS 'date', stud_id, stud_status, sec.sec_name,
        CASE WHEN bal.bal_id IN (SELECT balb_id from payment pm join balance bal on pm.balb_id = bal.bal_id) 
        THEN (SELECT  SUM(pm.pay_amt) as 'pay_amt'
		FROM payment p
		INNER JOIN payment pm ON p.pay_id = pm.pay_id
		JOIN balpay bp ON bp.pay_ida = pm.pay_id
		JOIN balance bala on bp.bal_ida = bala.bal_id
		JOIN student st ON st.stud_id = bala.stud_idb
		WHERE bal.bal_id = bala.bal_id
		GROUP BY st.first_name ORDER by 1)
		ELSE
	    0 
		END AS 'pay_amt'
		FROM student st
		JOIN balance bal ON bal.stud_idb = st.stud_id
        JOIN  section sec ON sec.sec_id = st.secc_id
		UNION
		SELECT distinct(bal_id), stud_lrno, year_level, CONCAT(first_name, ' ', last_name) as 'Name', MIN(pm.remain_bal) as 'remaining_balance', bal_status, DATE_FORMAT(MAX(pm.pay_date), '%M %e %Y') as 'date', st.stud_id as 'stud_id', stud_status, sect.sec_name, sum(pm.pay_amt) 'pay_amt'
		FROM payment p
		INNER JOIN payment pm ON p.pay_id = pm.pay_id
		JOIN balpay bp ON bp.pay_ida = pm.pay_id
		JOIN balance bal on bp.bal_ida = bal.bal_id
		JOIN student st ON st.stud_id = bal.stud_idb
        JOIN section sect on sect.sec_id = st.secc_id
		GROUP BY st.first_name ORDER by 1) al
		WHERE stud_status IN ('Officially Enrolled','Temporarily Enrolled')
		GROUP BY Name") or die ("failed!");
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		}else{
			return $sql;
		}
		return $data;
	}
	/********* END STUDENT PAYMENT STATUS **********/
	
	/********* CURRICULUM SECTION *****************/
	
	public function getCurriculum() {
		$sql=$this->conn->prepare("SELECT cc_id, c_desc from curriculum_temp join request on request_id=curr_request");
		$sql->execute();
		if($sql->rowCount() > 0){
			while($row=$sql->fetch(PDO::FETCH_ASSOC)){
				$data[] = $row;
			}
			return $data;
		}
		return $sql;
		
	}

	public function createCurriculum($post) {
		$checkInputs = false;
		for($x = 0; $x < count($post['subj_level']); $x++) {
			if ($post['subj_level'][$x] !== '' && $post['subj_dept'][$x] !== '' && $post['subj_name'][$x] !== '') {
				$checkInputs = true;
				break;
			}
		}
		if ($checkInputs === true) {
			$today = date("Y-m-d");
			$subj_level = array();
			$subj_dept = array();
			$subj_name = array();
			for ($c = 0; $c < count($post['subj_level']); $c++) {
				if ($post['subj_level'][$c] !== '' && $post['subj_dept'][$c] !== '' && $post['subj_name'][$c] !== '') {
					$subj_level[] = $post['subj_level'][$c];
					$subj_dept[] = $post['subj_dept'][$c];
					$subj_name[] = $post['subj_name'][$c];
				} 
			}
			$request_desc='Add Curriculum '.$post['curr_name'];
			$this->addRequest($request_desc);
			$req_id=$this->getRequestID();
			$insert_curr = $this->conn->prepare('INSERT INTO curriculum_temp SET c_desc=:c_desc, curr_request=:curr_request');
			$insert_curr->execute(array(
				':c_desc' => $post['curr_name'],
				':curr_request' => $req_id
			)) or die($this-> alert("Error!", "Error inserting a curriculum.", "error", "admin-curriculum"));
			
			for ($c = 0; $c < count($subj_level); $c++) {
				$insert = 'INSERT INTO subject_temp (s_level, s_dept, s_name, curriculum_temp) VALUES (';
				$insert .= '\''.$subj_level[$c].'\',';
				$insert .= '\''.$subj_dept[$c].'\',\''.$subj_name[$c].'\',';
				$insert .= '\''.$req_id.'\')';
				var_dump($subj_level[$c]);
				var_dump($subj_dept[$c]);
				var_dump($subj_name[$c]);
				var_dump($req_id);
				
				$q3 = $this->conn->query($insert) or die($this-> alert("Error!", "Failed to add subjects to curriculum!", "error", "admin-curriculum"));
			}
			$this->alert("Success!", "You have successfully created a curriculum!", "success", "admin-subjects");
			
		} else{
			$this->alert("Error!", "You have not entered any subjects!", "error", "admin-subjects");
		}
		
	}
	/**************** END CURRICULUM SECTION *****/

	/**************** SUBJECT *******************/
	public function multipleDeleteSubject(){
		$checkbox = $_POST['check'];
		if($checkbox !== null){
			for($i=0;$i<count($checkbox);$i++){
				$del_id = $checkbox[$i]; 
				$sql1=$this->conn->prepare("SELECT * FROM subject WHERE subj_id=?");
				$sql1->bindParam(1, $del_id);				
				$sql1->execute(); 
				$row1=$sql1->fetch(PDO::FETCH_ASSOC);
				$subjNameToDel=$row1['subj_name'];
				
				$queryDel=$this->conn->prepare("DELETE FROM subject WHERE subj_id=:subj_id");
				if($queryDel->execute(array(
					':subj_id' => $del_id
				))){
					$log_event="Delete";
					$log_desc="Successfully deleted the subject: ".$subjNameToDel;
					$this->insertLogs($log_event, $log_desc);
					$this->alert("Success!", "The selected item/s has been successfully deleted", "success", "admin-subjects");
				}else{
					$this->alert("Error!", "You are not allowed to delete the selected item/s", "error", "admin-subjects");
				}
			}
		}else{
			$this->alert("Error!", "Please select atleast one item", "error", "admin-subjects");
		}
	}
	
	public function addSubject($subj_level, $subj_dept, $subj_name){
		try {
			$created=date('Y-m-d H:i:s');	
			$sql1=$this->conn->prepare("INSERT INTO Subject SET subj_level=:subj_level, subj_dept=:subj_dept, subj_name=:subj_name, timestamp_subj=:timestamp_subj");
			if($sql1->execute(array(
				':subj_level' => $subj_level,
				':subj_dept' => $subj_dept,
				':subj_name' => $subj_name,
				':timestamp_subj' => $created
			))){
				$sql2=$this->conn->prepare("SELECT * FROM subject ORDER BY 1 DESC LIMIT 1");
				$sql2->execute(); 
				$row=$sql2->fetch(PDO::FETCH_ASSOC);
				$subj_name=$row['subj_name'];
				$log_event="Insert";
				$log_desc="Added Subject ".$subj_name;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "A new subject has been created! Subject Department: $subj_dept, Subject Name: $subj_name", "success", "admin-subjects");
			}else{	
				$this->alert("Error!", "Failed to add subject!", "error", "admin-subjects");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function updateSubject($subj_id,$subj_level, $subj_dept, $subj_name){
		try {
			$sql1=$this->conn->prepare("SELECT * FROM subject WHERE subj_id=?");
			$sql1->bindParam(1, $subj_id);				
			$sql1->execute(); 
			$row1=$sql1->fetch(PDO::FETCH_ASSOC);
			$subjNameToDel=$row1['subj_name'];
			
			$sql2=$this->conn->prepare("UPDATE Subject 
			SET  subj_level=:subj_level,
				subj_dept=:subj_dept, 
				subj_name=:subj_name
			WHERE subj_id=:subj_id");	
			if($sql2->execute(array(
				':subj_level' => $subj_level,
				':subj_dept' => $subj_dept,
				':subj_name' => $subj_name,
				':subj_id' => $subj_id
			))){
				$sql3=$this->conn->prepare("SELECT * FROM subject WHERE subj_id=?");
				$sql3->bindParam(1, $subj_id);
				$sql3->execute(); 
				$row3=$sql3->fetch(PDO::FETCH_ASSOC);
				$subj_name=$row3['subj_name'];
				$log_event="Update";
				$log_desc="Updated the Subject ".$subjNameToDel." to ".$subj_name;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "Subject has been updated", "success", "admin-subjects");
			}else{
				$this->alert("Error!", "Subject has been updated", "error", "admin-subjects");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}	
	public function deleteSubject($subj_id){
		try {
			$sql1=$this->conn->prepare("SELECT * FROM subject WHERE subj_id=?");
			$sql1->bindParam(1, $subj_id);				
			$sql1->execute(); 
			$row1=$sql1->fetch(PDO::FETCH_ASSOC);
			$subjNameToDel=$row1['subj_name'];
			
			$sql2 = $this->conn->prepare("
				DELETE FROM Subject WHERE subj_id =:subj_id");
			if($sql2->execute(array(
				':subj_id'=>$subj_id
			))){
				$log_event="Delete";
				$log_desc="Deleted the Subject ".$subjNameToDel;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "The Subject has been deleted", "success", "admin-subjects");
			}else{	
				$this->alert("Error!", "Failed to delete the subject", "error", "admin-subjects");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	/**************** END SUBJECT ****************/
	
	/**************** SECTION *******************/
	public function multipleDeleteSection(){
		$checkbox = $_POST['check'];
		if($checkbox !== null){
			for($i=0;$i<count($checkbox);$i++){
				$del_id = $checkbox[$i]; 	
				$querySearch=$this->conn->prepare("SELECT * FROM section_temp WHERE sectionid=:sectionid");
				if($querySearch->execute(array(
					':sectionid' => $del_id
				))){
					$rowQuerySearch=$querySearch->fetch(PDO::FETCH_ASSOC);
					$req_id=$rowQuerySearch['sec_req'];
					$sec_name=$rowQuerySearch['s_name'];
					$request_desc='Delete Section '.$sec_name;
					$this->deleteRequest($req_id, $request_desc);
					$this->alert("Success!", "The selected item/s has been successfully deleted", "success", "admin-section");
				}else{
					$this->alert("Error!", "You are not allowed to delete the selected item/s, because there might be some student/s that has enrolled in this section", "error", "admin-section");
				}
				
				/*$sql = $this->conn->prepare("SELECT * FROM section WHERE sec_id=:sec_id");
				$sql->execute(array(
					':sec_id' => $del_id
				));
				$row=$sql->fetch(PDO::FETCH_ASSOC);
				$secToDel=$row['sec_name'];
				$queryDel=$this->conn->prepare("DELETE FROM Section WHERE sec_id=:sec_id");
				if($queryDel->execute(array(
					':sec_id' => $del_id
				))){
					$log_event="Delete";
					$log_desc="Deleted the Section ".$secToDel;
					$this->insertLogs($log_event, $log_desc);
					$this->alert("Success!", "The selected item/s has been successfully deleted", "success", "admin-section");
				}else{
					$this->alert("Error!", "You are not allowed to delete the selected item/s, because there might be some student/s that has enrolled in this section", "error", "admin-section");
				}*/
			}
		}else{
			$this->alert("Error!", "Please select atleast one item", "error", "admin-section");
		}
	}
	
	public function showSectionTable(){
		$sql = $this->conn->prepare("SELECT * FROM request join section_temp on request_id=sec_req") or die ("failed!");
		$sql->execute();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}
	
	public function showSection(){
		$sql=$this->conn->prepare("SELECT COUNT(grade_lvl) as countGLevel from section where grade_lvl='7'");
		$sql->execute();
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		$gLevel=$row['countGLevel'];
		var_dump($gLevel);
		$sql2=$this->conn->prepare("SELECT COUNT(grade_lvl) as countGLevel from section where grade_lvl='8'");
		$sql2->execute();
		$row2=$sql2->fetch(PDO::FETCH_ASSOC);
		$gLevel2=$row2['countGLevel'];
		var_dump($gLevel2);
		$sql3=$this->conn->prepare("SELECT COUNT(grade_lvl) as countGLevel from section where grade_lvl='9'");
		$sql3->execute();
		$row3=$sql3->fetch(PDO::FETCH_ASSOC);
		$gLevel3=$row3['countGLevel'];
		var_dump($gLevel3);
		$sql4=$this->conn->prepare("SELECT COUNT(grade_lvl) as countGLevel from section where grade_lvl='10'");
		$sql4->execute();
		$row4=$sql4->fetch(PDO::FETCH_ASSOC);
		$gLevel4=$row4['countGLevel'];
		var_dump($gLevel4);
		if($gLevel == '2'){
			echo "
			<option value='8'>8</option>
			<option value='9'>9</option>
			<option value='10'>10</option>
			";
		}else if($gLevel2 == '2'){
			echo "
			<option value='7'>7</option>
			<option value='9'>9</option>
			<option value='10'>10</option>
			";
		}else if($gLevel3 == '2'){
			echo "
			<option value='7'>7</option>
			<option value='8'>8</option>
			<option value='10'>10</option>
			";
		}else if($gLevel4 == '2'){
			echo "
			<option value='7'>7</option>
			<option value='8'>8</option>
			<option value='9'>9</option>
			";
		}
		
	}
	
	public function addSection($sec_name, $grade_lvl){
		try {
			$created=date('Y-m-d H:i:s');	
			$request_desc='Add Section Grade '.$grade_lvl. ' - '.$sec_name;
			$this->addRequest($request_desc);
			$request_id=$this->getRequestID();
			$sql1=$this->conn->prepare("INSERT INTO section_temp SET s_name=:s_name, gr_lvl=:gr_lvl, tt_sec=:tt_sec, sec_req=:sec_req");
			if($sql1->execute(array(
				':s_name' => $sec_name,
				':gr_lvl' => $grade_lvl,
				':tt_sec' => $created,
				':sec_req' => $request_id
			))){
				/*$sql2=$this->conn->prepare("SELECT * FROM section ORDER BY 1 DESC LIMIT 1");
				$sql2->execute(); 
				$row=$sql2->fetch(PDO::FETCH_ASSOC);
				$sec_name=$row['sec_name'];
				$log_event="Insert";
				$log_desc="Added Section ".$sec_name;
				$this->insertLogs($log_event, $log_desc);*/
				$this->alert("Success!", "A new section has been created! Class: $sec_name, Grade Level: $grade_lvl", "success", "admin-section");
			}else{
				$this->alert("Error!", "Failed to add section! This section already exist", "error", "admin-section");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function updateSection($id, $sec_name, $grade_lvl){
		$sql1=$this->conn->prepare("SELECT * FROM section_temp WHERE sectionid=:sectionid");
		$sql1->execute(array(
			':sectionid' => $id
		)); 
		$row1=$sql1->fetch(PDO::FETCH_ASSOC);
		$secToUpdate=$row1['s_name'];
		$req_id=$row1['sec_req'];
		$request_desc='Update Section Grade '.$grade_lvl. ' - '.$sec_name;
		$this->updateRequest($req_id, $request_desc);
		
		$sql2=$this->conn->prepare("UPDATE section_temp 
			SET  s_name=:s_name, 
			gr_lvl=:gr_lvl
			WHERE sectionid=:sectionid");	
		if($sql2->execute(array(
			':s_name'=> $sec_name, 
			':gr_lvl'=> $grade_lvl,
			':sectionid' => $id
		))){
			/*$sql3=$this->conn->prepare("SELECT * FROM section_temp WHERE sectionid=:sectionid");
			$sql3->execute(array(
				':sectionid' => $id
			)); 
			$row3=$sql3->fetch(PDO::FETCH_ASSOC);
			$sec_name=$row3['s_name'];
			$log_event="Update";
			$log_desc="Updated the Section ".$secToUpdate." to ".$sec_name;
			$this->insertLogs($log_event, $log_desc);*/
			$this->alert("Success!", "Section has been successfully updated", "success", "admin-section");
		}else{
			$this->alert("Error!", "Failed to update section", "error", "admin-section");
		}
		
	}	
	public function deleteSection($id){
		try {
			$querySearch=$this->conn->prepare("SELECT * FROM section_temp WHERE sectionid=:sectionid");
			if($querySearch->execute(array(
				':sectionid' => $id
			))){
				$rowQuerySearch=$querySearch->fetch(PDO::FETCH_ASSOC);
				$req_id=$rowQuerySearch['sec_req'];
				$sec_name=$rowQuerySearch['s_name'];
				$request_desc='Delete Section '.$sec_name;
				
				$this->deleteRequest($req_id, $request_desc);
			}else{
				$this->alert("Error!", "Failed to delete section!", "error", "admin-section");
			}
			/*$sql = $this->conn->prepare("SELECT * FROM section WHERE sec_id=:sec_id");
			$sql->execute(array(
				':sec_id' => $id
			));
			$row=$sql->fetch(PDO::FETCH_ASSOC);
			$secToDel=$row['sec_name'];
			$sql1 = $this->conn->prepare("
				DELETE FROM Section WHERE sec_id =:sec_id");
			if($sql1->execute(array(
				':sec_id'=>$id
			))){
				$log_event="Delete";
				$log_desc="Deleted the Section ".$secToDel;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "The section has been deleted", "success", "admin-section");
			}else{	
				$this->alert("Error!", "Failed to delete section!", "error", "admin-section");
			}*/
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function getSchoolYear(){
		$query = $this->conn->prepare("SELECT school_year 'sy' FROM student group by 1");
		$query->execute();
		$rowCount = $query->fetch();
		$rowCount1 = $rowCount['sy'] + 1;
		echo " " . $rowCount['sy'] . "-" . $rowCount1 . " ";
	}
	public function createSectionTable($row) {
		$fac_id = $row['fc_id'];
		$getFacInfo = $this->conn->query("SELECT * FROM faculty WHERE fac_id = '".$fac_id."'");
		$getSchedID = $this->conn->query("SELECT sched_id FROM schedule WHERE sched_yrlevel = '".$row['gr_lvl']."'");
		$fac_info = $getFacInfo->fetch();
		$sched_id = $getSchedID->fetch();
		$teachers = function($info) {
			$sql = $this->conn->prepare("SELECT * FROM faculty JOIN subject ON fac_dept = subj_dept WHERE  subj_level = :subj_level AND (fac_id NOT IN (SELECT fw_id FROM schedsubj WHERE time_start = :time_start OR sw_id=:sec_id) AND subj_id NOT IN (SELECT schedsubjb_id FROM schedsubj WHERE sw_id = :sec_id)) GROUP BY fac_id");
			$sql->execute(array(
				':subj_level' => $info['subj_level'],
				':time_start' => $info['time_start'],
				':sec_id' => $info['sec_id']
			));
			$result = $sql->fetchAll();
			$html = '';
			if(isset($info['fac_id'] )) {
				foreach($result as $row) {
					if ($info['fac_id'] === $row['fac_id']) {
						$html .= '<option value="'.$row['fac_id'].'" data-facdept="'.$row['fac_dept'].'" selected>'.$row['fac_fname'].' '.$row['fac_midname'][0].'. '.$row['fac_lname'].'</option>';
					} else {
						$html .= '<option value="'.$row['fac_id'].'" data-facdept="'.$row['fac_dept'].'">'.$row['fac_fname'].' '.$row['fac_midname'][0].'. '.$row['fac_lname'].'</option>';
					}
				}
			} else {
				foreach($result as $row) {
					$html .= '<option value="'.$row['fac_id'].'" data-facdept="'.$row['fac_dept'].'">'.$row['fac_fname'].' '.$row['fac_midname'][0].'. '.$row['fac_lname'].'</option>';
				}
			}
			return $html;
		};

		$subjects = function($info) {
			$sql = $this->conn->prepare("SELECT * FROM faculty JOIN subject ON fac_dept = subj_dept WHERE  subj_level = :subj_level AND (fac_id NOT IN (SELECT fw_id FROM schedsubj WHERE time_start = :time_start  OR sw_id=:sec_id) AND subj_id NOT IN (SELECT schedsubjb_id FROM schedsubj WHERE sw_id = :sec_id)) GROUP BY subj_name");
			$sql->execute(array(
				':subj_level' => $info['subj_level'],
				':time_start' => $info['time_start'],
				':sec_id' => $info['sec_id']
			));
			$result = $sql->fetchAll();
			$html = '';
			if(isset($info['fac_id'] )) {
				foreach($result as $row) {
					if ($info['subj_id'] === $row['subj_id']) {
						$html .= '<option value="'.$row['subj_id'].'" data-subdept="'.$row['subj_dept'].'" selected>'.$row['subj_name'].'</option>';
					} else {
						$html .= '<option value="'.$row['subj_id'].'" data-subdept="'.$row['subj_dept'].'">'.$row['subj_name'].'</option>';
					}
				}
			} else {
				foreach($result as $row) {
					$html .= '<option value="'.$row['subj_id'].'" data-subdept="'.$row['subj_dept'].'">'.$row['subj_name'].'</option>';
				}
			}
			return $html;
		};
		$time_start = array('07:40:00', '08:40:00', '10:00:00', '11:00:00', '13:00:00', '14:00:00', '15:00:00');
		$sched_1 = $this->getSchedInfo($sched_id['sched_id'], $time_start[0], $row['sectionid']);
		$sched_2 = $this->getSchedInfo($sched_id['sched_id'], $time_start[1], $row['sectionid']);
		$sched_3 = $this->getSchedInfo($sched_id['sched_id'], $time_start[2], $row['sectionid']);
		$sched_4 = $this->getSchedInfo($sched_id['sched_id'], $time_start[3], $row['sectionid']);
		$sched_5 = $this->getSchedInfo($sched_id['sched_id'], $time_start[4], $row['sectionid']);
		$sched_6 = $this->getSchedInfo($sched_id['sched_id'], $time_start[5], $row['sectionid']);
		$sched_7 = $this->getSchedInfo($sched_id['sched_id'], $time_start[6], $row['sectionid']);
		$remove = function($sched) {
			$html = '<form action="faculty-editclass"  method="POST">
			<input type="hidden" name="sec" value="'.$sched['sectionid'].'">
			<input type="hidden" name="sched" value="'.$sched['sched_id'].'">
			<input type="hidden" name="subj_id" value="'.$sched['subj_id'].'">
			<input type="hidden" name="timestart" value="'.$sched['time_start'].'">
			<input type="hidden" name="faculty_id" value="'.$sched['fac_id'].'">
			<button type="remove-class-schedule" class="edit-status-remove" name="remove-this-schedule"><span class="tooltip remove" title="Remove this schedule"><i class="far fa-trash-alt"></i></span></button>
			</form>';
			return $html;
		};
		echo '
		<div id="sec'.$row['sectionid'].'" class="classes-edit">
			<div class="sec-info">
				<div class ="cont fr">
					<div class="box2">
						<span>Adviser: '.$fac_info['fac_fname'].' '.$fac_info['fac_midname'][0].'. '.$fac_info['fac_lname'].'</span>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="table-wrap">
				<table id="classes-sched">
					<tr>
						<th>TIME</th>
						<th>MONDAY</th>
						<th>TUESDAY</th>
						<th>WEDNESDAY</th>
						<th>THURSDAY</th>
						<th>FRIDAY</th>
					</tr>
					<tr>
						<td>7:40 - 8:40</td>
						<td colspan="5" class="row-subj">
							<div class="sched-info">
								<p class="info">'.($sched_1['exist'] === true ? $sched_1['subj'].' - '.$sched_1['name'] : 'No data yet').'</p>
								<div name="dialog" title="Select a subject and teacher for ">
									<div class="container">
										<form action="faculty-editclass" method="POST" class="classes-sched">
											<input type="hidden" name="sec_id" '.($sched_1['exist'] === true ? 'value="'.$sched_1['sec_id'].'"
											' : 'value="'.$row['sectionid'].'"').'>
											<input type="hidden" name="sched_a" '.($sched_1['exist'] === true ? 'value="'.$sched_1['sched_id'].'"
											' : 'value="'.$sched_id['sched_id'].'"').'>
											<input type="hidden" name="subj_id" '.($sched_1['exist'] === true ? 'value="'.$sched_1['subj_id'].'"
											' : '').'>
											<input type="hidden" name="time_start" value="'.$time_start[0].'">
											'.($sched_1['exist'] === true ? '<input type="hidden" name="prev-teacher" value="'.$sched_1['fac_id'].'">' : '').'
											<label class="teacher">Teacher: </label>
											<br>
										</form>
									</div>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td>8:40 - 9:40</td>
						<td colspan="5" class="row-subj">
							<div class="sched-info">
								<p class="info">'.($sched_2['exist'] === true ? $sched_2['subj'].' - '.$sched_2['name']: 'No data yet').'</p>
							</div>
						</td>
					</tr>
					<tr>									
						<td>9:40 - 10:00</td>
						<td colspan="5">RECESS</td>
					</tr>
					<tr>
						<td>10:00 - 11:00</td>
						<td colspan="5" class="row-subj">
							<div class="sched-info">
								<p class="info">'.($sched_3['exist'] === true ? $sched_3['subj'].' - '.$sched_3['name']: 'No data yet').'</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>11:00 - 12:00</td>
						<td colspan="5" class="row-subj">
							<div class="sched-info">
								<p class="info">'.($sched_4['exist'] === true ? $sched_4['subj'].' - '.$sched_4['name']: 'No data yet').'</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>12:00 - 1:00</td>
						<td colspan="5">LUNCH</td>
					</tr>
					<tr>
						<td>1:00 - 2:00</td>
						<td colspan="5" class="row-subj">
							<div class="sched-info">
								<p class="info">'.($sched_5['exist'] === true ? $sched_5['subj'].' - '.$sched_5['name']: 'No data yet').'</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>2:00 - 3:00</td>
						<td colspan="5" class="row-subj">
							<div class="sched-info">
								<p class="info">'.($sched_6['exist'] === true ? $sched_6['subj'].' - '.$sched_6['name']: 'No data yet').'</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>3:00 - 4:00</td>
						<td colspan="5" class="row-subj">
							<div class="sched-info">
								<p class="info">'.($sched_7['exist'] === true ? $sched_7['subj'].' - '.$sched_7['name']: 'No data yet').'</p>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>';
	}
	public function showSections() {
		$sql = $this->conn->query("SELECT * FROM section_temp");
		$result = $sql->fetchAll();
		$option = '';
		foreach ($result as $row) {
			$option .= '<option value="sec'.$row['sectionid'].'">Grade '.$row['gr_lvl'].' - '.$row['s_name'].'</option>';
		}
		echo $option;
	}
	public function showTabledSections() {
		$sql = $this->conn->query("SELECT * FROM section_temp") or die("query failed!");
		$result = $sql->fetchAll();
		foreach($result as $row) {
			$this->createSectionTable($row);
		}
	}
	private function getSection($gender, $year_level) {
		$query = $this->conn->prepare("SELECT  CASE WHEN sec1.count < sec2.count THEN sec1.sec_id WHEN sec1.count > sec2.count THEN sec2.sec_id WHEN sec1.count = sec2.count THEN sec1.sec_id ELSE sec1.sec_id END AS sec_id FROM (SELECT  0 AS 'count', (SELECT  sec_id FROM section WHERE grade_lvl = :year_level ORDER BY 1 LIMIT 1) sec_id UNION SELECT  COUNT(gender) AS 'count', sec_id FROM student JOIN section ON secc_id = sec_id WHERE year_level = :year_level AND gender = :gender AND sec_id = (SELECT  sec_id FROM section WHERE grade_lvl = :year_level ORDER BY 1 ASC LIMIT 1) GROUP BY secc_id ORDER BY 1 DESC LIMIT 1) sec1 JOIN (SELECT  0 AS 'count', (SELECT  sec_id FROM section WHERE grade_lvl = :year_level ORDER BY 1 DESC LIMIT 1) sec_id UNION SELECT  COUNT(gender) AS 'count', sec_id FROM student JOIN section ON secc_id = sec_id WHERE year_level = :year_level AND gender = :gender AND sec_id = (SELECT  sec_id FROM section WHERE grade_lvl = :year_level ORDER BY 1 DESC LIMIT 1) GROUP BY secc_id ORDER BY 1 DESC LIMIT 1) sec2");
		$query->execute(array(
			':year_level' => $year_level,
			':gender' => $gender
		));
		$result = $query->fetch();
		return $result['sec_id'];
	}
	private function getSchedInfo($sched_id, $time_start, $sec_id) {
		$sql = $this->conn->prepare("SELECT * FROM schedsubj WHERE schedsubja_id = :sched_id AND time_start = :time_start AND sw_id = :sec_id");
		$sql->execute(array(
			':sched_id' => $sched_id,
			':time_start' => $time_start,
			':sec_id' => $sec_id
		));
		if ($sql->rowCount() > 0) {
			$row = $sql->fetch();
			$getSubj = $this->conn->query("SELECT * FROM subject WHERE subj_id='".$row['schedsubjb_id']."'");
			$getFact = $this->conn->query("SELECT * FROM faculty WHERE fac_id='".$row['fw_id']."'");
			$subj = $getSubj->fetch();
			$fact = $getFact->fetch();
			$data = array(
				'sec_id' => $sec_id,
				'sched_id' => $sched_id,
				'name' => ($fact['fac_fname'].' '.$fact['fac_midname'][0].'. '.$fact['fac_lname']),
				'subj_id' => $subj['subj_id'],
				'subj' => $subj['subj_name'],
				'fac_id' => $fact['fac_id'],
				'subj_dept' => $subj['subj_dept'],
				'subj_level' => $subj['subj_level'],
				'time_start' => $time_start,
				'exist' => true
			);
			return $data;
		} else {
			$sql = $this->conn->query("SELECT sec_id FROM section WHERE sec_id = '".$sec_id."'");
			$sec_info = $sql->fetch();
			$data = array(
				'sec_id' => $sec_id,
				'subj_level' => $sec_info['gr_lvl'],
				'sched_id' => $sched_id,
				'time_start' => $time_start,
				'exist' => false
			);
			return $data;
		}
	}
	/**************** END SECTION ***************
	
	/**************** TRANSFER STUDENT ***********/
	public function acceptRequest(){
		$checkbox = $_POST['check'];
		if($checkbox !== null){
			for($i=0;$i<count($checkbox);$i++){
				$del_id = $checkbox[$i]; 
				$query1 = $this->conn->prepare("SELECT * from student join section on secc_id=sec_id WHERE stud_id=:id");
				$query1->execute(array(
					':id' => $del_id
				));
				$row1=$query1->fetch(PDO::FETCH_ASSOC);
				$section_id=$row1['sec_id'];
				$student_id=$row1['stud_id'];
				$grade_level=$row1['grade_lvl'];
				$transfer_sec=$row1['transfer_sec'];
				
				$update = $this->conn->prepare("UPDATE student SET sec_stat = 'Permanent', transfer_sec=:transfer_sec, secc_id=:secc_id WHERE stud_id =:id ");
				if($update->execute(array(
					':id' => $del_id,
					':transfer_sec' => null,
					':secc_id' => $transfer_sec
				))){
					$sql3=$this->conn->prepare("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) as 'fullname', sec_name FROM student join section on secc_id=sec_id WHERE stud_id=:stud_id");
					$sql3->execute(array(
						':stud_id' => $del_id
					)); 
					$row3=$sql3->fetch(PDO::FETCH_ASSOC);
					$_SESSION['adminNotif'] = $sql3->rowCount();
					$fullname=$row3['fullname'];
					$sec_name=$row3['sec_name'];
					$log_event="Update";
					$log_desc="Student: ".$fullname." has been successfully transferred to ".$sec_name;
					$this->insertLogs($log_event, $log_desc);
					$this->alert('Success!', 'You have successfully transferred the student to a diffent section', "success", "admin-transfer");
				} else {
					$this->alert('Error!', "Failed to transfer the student to a different section", "error", "admin-transfer");
				}
			}
		}else{
			$this->alert("Error!", "Please select atleast one item", "error", "admin-transfer");
		}
	}
	public function acceptSingleRequest($stud_id){
		$query1 = $this->conn->prepare("SELECT * from student join section on secc_id=sec_id WHERE stud_id=:id");
		$query1->execute(array(
			':id' => $stud_id
		));
		$row1=$query1->fetch(PDO::FETCH_ASSOC);
		$section_id=$row1['sec_id'];
		$student_id=$row1['stud_id'];
		$grade_level=$row1['grade_lvl'];
		$transfer_sec=$row1['transfer_sec'];
		
		$update = $this->conn->prepare("UPDATE student SET sec_stat = 'Permanent', transfer_sec=:transfer_sec, secc_id=:secc_id WHERE stud_id =:id ");
		if($update->execute(array(
			':id' => $stud_id,
			':transfer_sec' => null,
			':secc_id' => $transfer_sec
		))){
			$sql3=$this->conn->prepare("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) as 'fullname', sec_name FROM student join section on secc_id=sec_id WHERE stud_id=:stud_id");
			$sql3->execute(array(
				':stud_id' => $stud_id
			)); 
			$row3=$sql3->fetch(PDO::FETCH_ASSOC);
			$fullname=$row3['fullname'];
			$sec_name=$row3['sec_name'];
			$log_event="Update";
			$log_desc="Student: ".$fullname." has been successfully transferred to ".$sec_name;
			$this->insertLogs($log_event, $log_desc);
			$this->alert('Success!', 'You have successfully transferred the student to a diffent section', "success", "admin-transfer");
		} else {
			$this->alert('Error!', "Failed to transfer the student to a different section", "error", "admin-transfer");
		}
		
	}
	public function rejectRequest(){
		$checkbox = $_POST['check'];
		if($checkbox !== null){
			for($i=0;$i<count($checkbox);$i++){
				$del_id = $checkbox[$i]; 
				$update = $this->conn->prepare("UPDATE student SET sec_stat = 'Permanent', transfer_sec=:transfer_sec WHERE stud_id =:id");
				if($update->execute(array(
					':id' => $del_id,
					':transfer_sec' => null
				))){
					$sql3=$this->conn->prepare("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) as 'fullname', sec_name FROM student join section on secc_id=sec_id WHERE stud_id=:stud_id");
					$sql3->execute(array(
						':stud_id' => $del_id
					)); 
					$row3=$sql3->fetch(PDO::FETCH_ASSOC);
					$fullname=$row3['fullname'];
					$sec_name=$row3['sec_name'];
					$log_event="Update";
					$log_desc="Successfully rejected the transferring of student(Name:".$fullname.") to ".$sec_name;
					$this->alert('Success!', 'Successfully rejected the transferring of student', "success", "admin-transfer");
				} else {
					$this->alert('Error!', "Failed to reject the transferring of student to a different section", "error", "admin-transfer");
				}
			}
		}else{
			$this->alert("Error!", "Please select atleast one item", "error", "admin-transfer");
		}
	}
	public function rejectSingleRequest($stud_id){
		$update = $this->conn->prepare("UPDATE student SET sec_stat = 'Permanent', transfer_sec=:transfer_sec WHERE stud_id =:id");
		if($update->execute(array(
			':id' => $stud_id,
			':transfer_sec' => null
		))){
			$sql3=$this->conn->prepare("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) as 'fullname', sec_name FROM student join section on secc_id=sec_id WHERE stud_id=:stud_id");
			$sql3->execute(array(
				':stud_id' => $stud_id
			)); 
			$row3=$sql3->fetch(PDO::FETCH_ASSOC);
			$fullname=$row3['fullname'];
			$sec_name=$row3['sec_name'];
			$log_event="Update";
			$log_desc="Successfully rejected the transferring of student(Name:".$fullname.") to ".$sec_name;
			$this->alert('Success!', 'Successfully rejected the transferring of student', "success", "admin-transfer");
		} else {
			$this->alert('Error!', "Failed to reject the transferring of student to a different section", "error", "admin-transfer");
		}
	}
	
	public function showOppoStudent() {
		$sql = $this->conn->prepare("SELECT *,CONCAT(stud.first_name, ' ', stud.middle_name, ' ', stud.last_name) as stud_fullname, CONCAT(fac_fname, ' ', fac_midname, ' ', fac_lname) as faculty_fullname, sec.sec_name as 'currentSection', sec2.sec_name as 'transferToSection' from student stud join section sec on secc_id=sec.sec_id join section sec2 on stud.transfer_sec=sec2.sec_id join faculty on sec.fac_idv=fac_id where stud.sec_stat='Temporary'");	
		$sql->execute();
		$_SESSION['adminNotif'] = $sql->rowCount();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}
	/**************** END TRANSFER STUDENT *******/

	/**************** CLASS **********************/
	
	public function showClasses(){
		$sql=$this->conn->prepare("SELECT *,fac_no, CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS fullname, s_name, gr_lvl, fac_id, sectionid FROM faculty JOIN section_temp ON fac_id=fc_id join request on request_id=sec_req WHERE fac_adviser='Yes'");
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
		$sql = $this->conn->prepare("SELECT sectionid, s_name, gr_lvl FROM section_temp WHERE fac_idv IS NULL");
		$sql->execute();
		while ($row = $sql->fetch()) {
			echo "<option value='" . $row['sectionid'] . "'>".$row['gr_lvl']." - " . $row['s_name'] . "</option>";
		}
	}
	public function facultylist(){
		$sql = $this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, fac_id FROM Faculty WHERE fac_adviser='Yes' and fac_id NOT IN (SELECT fc_id FROM section_temp JOIN faculty ON fac_id=fc_id) ");
		$sql->execute();
		while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
			echo "<option value='" . $row['fac_id'] . "'>" . $row['facultyname'] . "</option>";
		}
	}
	public function faculty_id() {
		$query = $this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, fac_id FROM Faculty WHERE fac_adviser='Yes'");
		$query->execute();
		$facultyname = array();
		while ($row = $query->fetch()) {
			$faculty_id[]=$row['fac_id'];
		}
		return $faculty_id;
	}
	public function facultyname() {
		$query = $this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, fac_id FROM Faculty WHERE fac_adviser='Yes'");
		$query->execute();
		$facultyname = array();
		while ($row = $query->fetch()) {
			$facultyname[] = $row['facultyname'];
		}
		return $facultyname;
	}
	public function addClass($sec_id, $fac_idv){	
		try {
			$querySearch = $this->conn->prepare("SELECT * FROM section where sec_id=:sec_id");
			$querySearch->execute(array(
				':sec_id' => $sec_id
			));
			$rowQuerySearch = $querySearch->fetch(PDO::FETCH_ASSOC);
			$request_id = $rowQuerySearch['sec_request'];
			$sql=$this->conn->prepare("UPDATE Section 
			SET  fac_idv=:fac_idv
			WHERE sec_id=:sec_id");
			if($sql->execute(array(
				':fac_idv'=> $fac_idv,
				':sec_id' => $sec_id
			))){
				$sql2=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, sec_name, fac_id, sec_id FROM section JOIN faculty on fac_id=fac_idv WHERE fac_idv=?");
				$sql2->bindParam(1, $fac_idv);
				$sql2->execute();
				$row1 = $sql2->fetch();
				$facultyName = $row1['facultyname'];
				$sec_name = $row1['sec_name'];
				$section_id = $row1['sec_id'];
				$faculty_id = $row1['fac_id'];
				
				$sql3=$this->conn->prepare("SELECT * FROM section JOIN schedule ON sched_yrlevel=grade_lvl WHERE fac_idv=:fac_idv");
				$sql3->execute(array(
					':fac_idv' => $fac_idv,
				));
				$row2=$sql3->fetch();
				$schedsubja_id = $row2['sched_id'];
				
				$sql4=$this->conn->prepare("SELECT * FROM section JOIN faculty ON fac_idv=fac_id JOIN subject ON fac_dept=subj_dept WHERE grade_lvl=subj_level and fac_idv=:fac_idv");
				$sql4->execute(array(
					':fac_idv' => $fac_idv,
				));
				$row3=$sql4->fetch();
				$schedsubjb_id = $row3['subj_id'];
			
				$created=date('Y-m-d H:i:s');
				$day='Monday,Tuesday,Wednesday,Thursday,Friday';
				$time_start='07:40:00';
				$time_end='08:40:00';
				$sql6=$this->conn->prepare("INSERT INTO schedsubj_temp SET ss_ida=:ss_ida, ss_idb=:ss_idb, ssb_day=:ssb_day,ssb_timestart=:ssb_timestart, ssb_timeend=:ssb_timeend, ss_fwid=:ss_fwid, ss_swid=:ss_swid, ss_timestamp=:ss_timestamp, status_ss=:status_ss");
				$sql6->execute(array(
					':ss_ida' => $schedsubja_id,
					':ss_idb' => $schedsubjb_id,
					':ssb_day' => $day,
					':ssb_timestart' =>$time_start,
					':ssb_timeend' =>$time_end,
					':ss_fwid' => $faculty_id,
					':ss_swid' => $section_id,
					':ss_timestamp' => $created,
					':status_ss' => 'Temporary'
				));
				/*include to superadmin*/
				/*$sql5=$this->conn->prepare("INSERT INTO facsec SET fac_idy=:fac_idy, sec_idy=:sec_idy");
				$sql5->execute(array(
					':fac_idy' => $faculty_id,
					':sec_idy' => $section_id
				));*/
				
				$sql7=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, sec_name, grade_lvl FROM section JOIN faculty on fac_id=fac_idv WHERE fac_idv=?");
				$sql7->bindParam(1, $fac_idv);				
				$sql7->execute(); 
				$row7=$sql7->fetch(PDO::FETCH_ASSOC);
				$sec_adviser=$row7['facultyname'];
				$sec_name =$row7['sec_name'];
				$grade_lvl=$row7['grade_lvl'];
				$log_event="Insert";
				
				$request_desc="Add ".$sec_adviser." as an adviser in Grade ".$grade_lvl." - ".$sec_name;
				$this->updateRequest($request_id, $request_desc);
				$this->alert("Success!", "A new class has been created! Class: $sec_name, Teacher-in-charge: $facultyName", "success", "admin-classes");
			
			}else{
				$this->alert("Error!", "Failed to add class!", "error", "admin-classes");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}	
	public function updateClass($sec_id, $fac_idv){
		try {
			$querySearch = $this->conn->prepare("SELECT * FROM section where sec_id=:sec_id");
			$querySearch->execute(array(
				':sec_id' => $sec_id
			));
			$rowQuerySearch = $querySearch->fetch(PDO::FETCH_ASSOC);
			$request_id = $rowQuerySearch['sec_request'];
			
			$getPrevID=$this->conn->prepare("SELECT * FROM section JOIN faculty on fac_id=fac_idv WHERE sec_id=?");
			$getPrevID->bindParam(1, $sec_id);
			$getPrevID->execute();
			$rowgetPrevID = $getPrevID->fetch();
			$prevSecID = $rowgetPrevID['sec_id'];
			$prevFacID = $rowgetPrevID['fac_id'];
			
			$sql=$this->conn->prepare("UPDATE Section 
			SET  fac_idv=:fac_idv
			WHERE sec_id=:sec_id");
			if($sql->execute(array(
				':fac_idv'=> $fac_idv,
				':sec_id' => $sec_id
			))){
				$sql2=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, sec_name, fac_id, sec_id FROM section JOIN faculty on fac_id=fac_idv WHERE fac_idv=?");
				$sql2->bindParam(1, $fac_idv);
				$sql2->execute();
				$row1 = $sql2->fetch();
				$facultyName = $row1['facultyname'];
				$sec_name = $row1['sec_name'];
				$section_id = $row1['sec_id'];
				$faculty_id = $row1['fac_id'];
				$sql3=$this->conn->prepare("SELECT * FROM section JOIN schedule ON sched_yrlevel=grade_lvl WHERE fac_idv=:fac_idv");
				$sql3->execute(array(
					':fac_idv' => $fac_idv,
				));
				$row2=$sql3->fetch();
				$schedsubja_id = $row2['sched_id'];
				$sql4=$this->conn->prepare("SELECT * FROM section JOIN faculty ON fac_idv=fac_id JOIN subject ON fac_dept=subj_dept WHERE grade_lvl=subj_level and fac_idv=:fac_idv");
				$sql4->execute(array(
					':fac_idv' => $fac_idv,
				));
				$row3=$sql4->fetch();
				$schedsubjb_id = $row3['subj_id'];
				
				$querySearch = $this->conn->prepare("SELECT * FROM schedsubj_temp WHERE ss_fwid=:faculty_id AND ss_swid=:sec_id");
				$querySearch->execute(array(
					':faculty_id' => $prevFacID,
					':sec_id' => $prevSecID
				));
				$day='Monday,Tuesday,Wednesday,Thursday,Friday';
				$time_start='07:40:00';
				$time_end='08:40:00';
				
				if($querySearch->rowCount()>0){
					$delete_schedsubj = $this->conn->prepare("DELETE FROM schedsubj_temp WHERE ss_fwid=:ss_fwid AND ss_swid=:ss_swid");
					$delete_schedsubj->execute(array(
						':ss_fwid' => $prevFacID,
						':ss_swid' => $prevSecID
					)) or die("FAILED");
					
					$sql6=$this->conn->prepare("INSERT INTO schedsubj_temp SET ss_ida=:ss_ida, ss_idb=:ss_idb, ssb_day=:ssb_day,ssb_timestart=:ssb_timestart, ssb_timeend=:ssb_timeend, ss_fwid=:ss_fwid, ss_swid=:ss_swid");
					$sql6->execute(array(
						':ss_ida' => $schedsubja_id,
						':ss_idb' => $schedsubjb_id,
						':ssb_day' => $day,
						':ssb_timestart' =>$time_start,
						':ssb_timeend' =>$time_end,
						':ss_fwid' => $fac_idv,
						':ss_swid' => $sec_id	
					));
/*					$delete_allfacsec = $this->conn->query("DELETE FROM facsec");
					$getFWSW = $this->conn->query("SELECT fw_id, sw_id FROM schedsubj");
					$result = $getFWSW->fetchAll();
					foreach ($result as $row) {
						$sql = $this->conn->prepare("INSERT INTO facsec (fac_idy, sec_idy) VALUES (:fw_id, :sw_id)");
						$sql->execute(array(
							':fw_id' => $row['fw_id'],
							':sw_id' => $row['sw_id']
						));
					}*/
				}else{
					$sql7=$this->conn->prepare("INSERT INTO schedsubj_temp SET ss_ida=:ss_ida, ss_idb=:ss_idb, ssb_day=:ssb_day,ssb_timestart=:ssb_timestart, ssb_timeend=:ssb_timeend, ss_fwid=:ss_fwid, ss_swid=:ss_swid");
					$sql7->execute(array(
						':ss_ida' => $schedsubja_id,
						':ss_idb' => $schedsubjb_id,
						':ssb_day' => $day,
						':ssb_timestart' =>$time_start,
						':ssb_timeend' =>$time_end,
						':ss_fwid' => $fac_idv,
						':ss_swid' => $sec_id	
					));
				
				}
				$sql8=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, sec_name, grade_lvl FROM section JOIN faculty on fac_id=fac_idv WHERE fac_idv=?");
				$sql8->bindParam(1, $fac_idv);				
				$sql8->execute(); 
				$row8=$sql8->fetch(PDO::FETCH_ASSOC);
				$sec_adviser=$row8['facultyname'];
				$sec_name =$row8['sec_name'];
				$grade_lvl=$row8['grade_lvl'];
				
				$request_desc="Update Adviser: ".$sec_adviser." as an adviser in Grade ".$grade_lvl." - ".$sec_name;
				$this->updateRequest($request_id, $request_desc);
				$this->alert("Success!", "Class has been updated", "success", "admin-classes");
			}else{
				$this->alert("Error!", "Failed to update class!", "error", "admin-classes");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	/**************** END CLASS *********************/
	
	/****************FACULTY ACCOUNT ****************/
	public function multipleDeleteFaculty(){
		$checkbox = $_POST['check'];
		if($checkbox !== null){
			for($i=0;$i<count($checkbox);$i++){
				$del_id = $checkbox[$i]; 
				$sql1=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname  FROM faculty JOIN accounts ON acc_idz=acc_id WHERE acc_idz=?");
				$sql1->bindParam(1, $del_id);
				$sql1->execute();
				$row1=$sql1->fetch(PDO::FETCH_ASSOC);
				$facultyname=$row1['facultyname'];
					
				$queryDel=$this->conn->prepare("DELETE a.*, b.* 
					FROM faculty a 
					LEFT JOIN accounts b 
					ON b.acc_id = a.acc_idz 
					WHERE a.acc_idz =:acc_idz ");
				if($queryDel->execute(array(
					':acc_idz' => $del_id
				))){
					$log_event="Delete";
					$log_desc="Deleted the account of ".$facultyname;
					$this->insertLogs($log_event, $log_desc);
					$this->alert("Success!", "The selected item/s has been successfully deleted", "success", "admin-faculty");
				}else{
					$this->alert("Error!", "You are not allowed to delete the selected item/s", "error", "admin-faculty");
				}
			}
		}else{
			$this->alert("Error!", "Please select atleast one item", "error", "admin-faculty");
		}
	}
	
	public function multipleResetFaculty(){
		$checkbox = $_POST['check'];
		if($checkbox !== null){
			for($i=0;$i<count($checkbox);$i++){
				$del_id = $checkbox[$i]; 

				$querySearch = $this->conn->prepare("SELECT acc_id FROM accounts WHERE acc_id=?");
				$querySearch->bindParam(1, $del_id);
				$querySearch->execute();
				$row = $querySearch->fetch();
				$getaccid = $row['acc_id'];
				
				$querySearch1 = $this->conn->prepare("SELECT fac_fname, fac_midname, fac_lname FROM faculty WHERE acc_idz=?");
				$querySearch1->bindParam(1, $del_id);
				$querySearch1->execute();
				$row1 = $querySearch1->fetch();
				$first_name = $row1['fac_fname'];
				$middle_name = $row1['fac_midname'];
				$last_name = $row1['fac_lname'];
				$password = str_replace(' ', ' ', ($first_name[0].$middle_name[0].$last_name));
				$newPass = password_hash($password, PASSWORD_DEFAULT);
				
				$queryUpdate = $this->conn->prepare("UPDATE accounts SET password=:password WHERE acc_id=:acc_id");
				if($queryUpdate->execute(array(
					':password' => $newPass,
					':acc_id' => $del_id))){
					$log_event="Reset";
					$log_desc="The account of ".$first_name." ".$middle_name." ".$last_name." has been successfully reset";
					$this->insertLogs($log_event, $log_desc);
					$this->alert("Success!", "The selected item/s has been been reset to its default password", "success", "admin-faculty");
				}else{
					$this->alert("Error!", "You are not allowed to reset the account of the selected item/s", "error", "admin-faculty");
				}
			}
		}else{
			$this->alert("Error!", "Please select atleast one item", "error", "admin-faculty");
		}
	}
	public function multipleUpdateAccountStatusToDeactive(){
		try {
			$checkbox = $_POST['check'];
			if($checkbox !== null){
				for($i=0;$i<count($checkbox);$i++){
					$del_id = $checkbox[$i]; 
					$acc_status="Deactivated";
					$sql2 = $this->conn->prepare("UPDATE accounts
					SET acc_status=:acc_status
					WHERE acc_id=:acc_id");
					if($sql2->execute(array(
						':acc_status'=>$acc_status,
						':acc_id'=>$del_id
					))){
						$sql3=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, acc_status FROM faculty JOIN accounts ON acc_idz=acc_id WHERE acc_id=?");
						$sql3->bindParam(1, $del_id);
						$sql3->execute();
						$row3=$sql3->fetch(PDO::FETCH_ASSOC);
						$facultyname=$row3['facultyname'];
						$acc_status_latest=$row3['acc_status'];
						$log_event="Update";
						$log_desc="Updated the account status of ".$facultyname." to ".$acc_status_latest;
						$this->insertLogs($log_event, $log_desc);
						$this->alert("Success!", "Successfully changed the account status", "success", "admin-faculty");	
					}else{	
						$this->alert("Error!", "Failed to change the account status", "error", "admin-faculty");
					}
				}	
			}else{
				$this->alert("Error!", "Please select atleast one item", "error", "admin-faculty");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function multipleUpdateAccountStatusToActive(){
		try {
			$checkbox = $_POST['check'];
			if($checkbox !== null){
				for($i=0;$i<count($checkbox);$i++){
					$del_id = $checkbox[$i]; 
					$acc_status="Active";
					$sql2 = $this->conn->prepare("UPDATE accounts
					SET acc_status=:acc_status
					WHERE acc_id=:acc_id");
					if($sql2->execute(array(
						':acc_status'=>$acc_status,
						':acc_id'=>$del_id
					))){
						$sql3=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, acc_status FROM faculty JOIN accounts ON acc_idz=acc_id WHERE acc_id=?");
						$sql3->bindParam(1, $del_id);
						$sql3->execute();
						$row3=$sql3->fetch(PDO::FETCH_ASSOC);
						$facultyname=$row3['facultyname'];
						$acc_status_latest=$row3['acc_status'];
						$log_event="Update";
						$log_desc="Updated the account status of ".$facultyname." to ".$acc_status_latest;
						$this->insertLogs($log_event, $log_desc);
						$this->alert("Success!", "Successfully changed the account status", "success", "admin-faculty");	
					}else{	
						$this->alert("Error!", "Failed to change the account status", "error", "admin-faculty");
					}
				}
			}else{
				$this->alert("Error!", "Please select atleast one item", "error", "admin-faculty");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function showFacList(){
		try {
			$sql=$this->conn->query("SELECT *, CASE WHEN fac_id IN (select fac_idv from section) THEN (SELECT sec_name FROM section join faculty f on section.fac_idv = f.fac_id where f.fac_id = faculty.fac_id) WHEN fac_id NOT IN (select fac_idv from section) THEN '' end as 'viewHandledSection' from faculty join accounts on acc_idz = acc_id") or die("failed!");
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
	
	public function priv(){
		$sql=$this->conn->prepare("SELECT * FROM faculty WHERE sec_privilege='Yes'");
		$sql->execute();
		return $sql->rowCount() > 0 ? true : false; 
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
	public function resetFacultyPassword($acc_id){
		$querySearch = $this->conn->prepare("SELECT acc_id FROM accounts WHERE acc_id=?");
		$querySearch->bindParam(1, $acc_id);
		$querySearch->execute();
		$row = $querySearch->fetch();
		$getaccid = $row['acc_id'];
		
		$querySearch1 = $this->conn->prepare("SELECT fac_fname, fac_midname, fac_lname FROM faculty WHERE acc_idz=?");
		$querySearch1->bindParam(1, $getaccid);
		$querySearch1->execute();
		$row1 = $querySearch1->fetch();
		$fname = $row1['fac_fname'];
		$fmidname = $row1['fac_midname'];
		$flname = $row1['fac_lname'];
		$password = str_replace(' ', ' ', ($fname[0].$fmidname[0].$flname));
		$newPass = password_hash($password, PASSWORD_DEFAULT);
		
		$queryUpdate = $this->conn->prepare("UPDATE accounts SET password=:password WHERE acc_id=:acc_id");
		if($queryUpdate->execute(array(
			':password' => $newPass,
			':acc_id' => $acc_id
		))){
			$sql2=$this->conn->prepare("SELECT username FROM accounts WHERE acc_id=:acc_id");
			$sql2->execute(array(
				':acc_id' => $acc_id
			));
			$row2=$sql2->fetch(PDO::FETCH_ASSOC);
			$username=$row2['username'];
			$log_event="Reset";
			$log_desc="The account of ".$fname." ".$fmidname." ".$flname." has been successfully reset";
			$this->insertLogs($log_event, $log_desc);
			$this->Prompt("Successfully reset account password! Username = <span class='prompt'>$username</span> Password: <span class='prompt'>$password</span>", "rgb(1, 58, 6)", "admin-faculty");
		}else{
			$this->alert("Error!", "Failed to reset account password!", "error", "admin-faculty");
		}
	}
	public function insertFacultyData($fac_no, $fac_fname, $fac_midname, $fac_lname, $fac_dept, $fac_adviser) {
		try {
			$created=date('Y-m-d H:i:s');
			$password = str_replace(' ', ' ', ($fac_fname[0].$fac_midname[0].$fac_lname));
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
				$sql2=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname FROM faculty ORDER BY fac_id DESC LIMIT 1");
				$sql2->execute();
				$row=$sql2->fetch(PDO::FETCH_ASSOC);
				$facultyname=$row['facultyname'];
				$log_event="Insert";
				$log_desc="Added an account of faculty member ".$facultyname;
				$this->insertLogs($log_event, $log_desc);
				$sql2=$this->conn->prepare("SELECT username FROM accounts ORDER BY acc_id DESC LIMIT 1");
				$sql2->execute();
				$row=$sql2->fetch(PDO::FETCH_ASSOC);
				$username=$row['username'];
				$this->Prompt("Account has been created! Username = <span class='prompt'>$username</span> Password: <span class='prompt'>$password</span>", "rgb(1, 58, 6)", "admin-faculty");
			}else{
				$this->alert("Error!", "Failed to insert faculty! This user already exist!", "error", "admin-faculty");
			}
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}	
	}
	public function updateFacultyData($id, $fac_no, $fac_fname, $fac_midname, $fac_lname, $fac_dept, $fac_adviser, $sec_privilege){
		try {
			$sql1 = $this->conn->prepare("UPDATE faculty
			SET 	fac_no=:fac_no,
				fac_fname=:fac_fname,
				fac_midname=:fac_midname,
				fac_lname=:fac_lname,
				fac_dept=:fac_dept,
				fac_adviser=:fac_adviser,
				sec_privilege=:sec_privilege
			WHERE fac_id=:fac_id");
			if($sql1->execute(array(
				':fac_no'=>$fac_no,
				':fac_fname'=>$fac_fname,
				':fac_midname'=>$fac_midname,
				':fac_lname'=>$fac_lname,
				':fac_dept'=>$fac_dept,
				':fac_adviser'=>$fac_adviser,
				':sec_privilege'=>$sec_privilege,
				':fac_id'=>$id
			))){
				$sql2=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname FROM faculty WHERE fac_id=?");
				$sql2->bindParam(1, $id);
				$sql2->execute();
				$row2=$sql2->fetch(PDO::FETCH_ASSOC);
				$facultyname=$row2['facultyname'];
				$log_event="Update";
				$log_desc="Updated the account details (Name:".$facultyname.", Employee ID:".$fac_no.", Department:".$fac_dept.", Adviser:".$fac_adviser.", Edit section privilege:".$sec_privilege.") of Employee ID: ".$fac_no;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "Account has been updated", "success", "admin-faculty");
			}else{
				$this->alert("Error!", "Failed to update account", "error", "admin-faculty");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function updateAccountStatus($id, $acc_status){
		try {
			$sql1=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, acc_status FROM faculty JOIN accounts ON acc_idz=acc_id WHERE acc_id=?");
			$sql1->bindParam(1, $id);
			$sql1->execute();
			$row1=$sql1->fetch(PDO::FETCH_ASSOC);
			$facultyname=$row1['facultyname'];
			$acc_status_prev=$row1['acc_status'];
			$sql2 = $this->conn->prepare("UPDATE accounts
			SET acc_status=:acc_status
			WHERE acc_id=:acc_id");
			if($sql2->execute(array(
				':acc_status'=>$acc_status,
				':acc_id'=>$id
			))){
				$sql3=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname, acc_status FROM faculty JOIN accounts ON acc_idz=acc_id WHERE acc_id=?");
				$sql3->bindParam(1, $id);
				$sql3->execute();
				$row3=$sql3->fetch(PDO::FETCH_ASSOC);
				$facultyname=$row3['facultyname'];
				$acc_status_latest=$row3['acc_status'];
				$log_event="Update";
				$log_desc="Updated the account status of ".$facultyname." to ".$acc_status_latest;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "Successfully changed the account status", "success", "admin-faculty");	
			}else{	
				$this->alert("Error!", "Failed to change the account status", "error", "admin-faculty");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function deleteFacultyData($id){
		try {
			$sql1=$this->conn->prepare("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) AS facultyname  FROM faculty JOIN accounts ON acc_idz=acc_id WHERE acc_idz=?");
			$sql1->bindParam(1, $id);
			$sql1->execute();
			$row1=$sql1->fetch(PDO::FETCH_ASSOC);
			$facultyname=$row1['facultyname'];
			
			$sql2 = $this->conn->prepare("
				DELETE a.*, b.* 
				FROM faculty a 
				LEFT JOIN accounts b 
				ON b.acc_id = a.acc_idz 
				WHERE a.acc_idz =:acc_idz");
			if($sql2->execute(array(
				':acc_idz'=>$id
			))){
				$log_event="Delete";
				$log_desc="Deleted the account of ".$facultyname;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "Account has been deleted", "success", "admin-faculty");
			}else{	
				$this->alert("Error!", "Failed to delete Faculty Data!", "error", "admin-faculty");
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
	public function multipleDeleteParent(){
		$checkbox = $_POST['check'];
		for($i=0;$i<count($checkbox);$i++){
			$del_id = $checkbox[$i]; 
			$sql1=$this->conn->prepare("SELECT CONCAT(tr_fname,' ',tr_midname,' ',tr_lname) AS treasurername FROM treasurer JOIN accounts ON acc_trid=acc_id WHERE acc_trid=:acc_trid");
			$sql1->execute(array(
				':acc_trid' => $del_id
			));
			$row1=$sql1->fetch(PDO::FETCH_ASSOC);
			$treasurername=$row1['treasurername'];	
			$queryDel=$this->conn->prepare("DELETE a.*, b.* 
				FROM treasurer a 
				LEFT JOIN accounts b 
				ON b.acc_id = a.acc_trid 
				WHERE a.acc_trid =:acc_trid ");
			if($queryDel->execute(array(
				':acc_trid' => $del_id
			))){
				$log_event="Deleted";
				$log_desc="Deleted the account of ".$treasurername;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "The selected item/s has been successfully deleted", "success", "admin-parent");
			}else{
				$this->alert("Error!", "You are not allowed to delete the selected item/s", "error", "admin-parent");
			}
		}
	}
	
	public function multipleResetParent(){
		$checkbox = $_POST['check'];
		for($i=0;$i<count($checkbox);$i++){
			$del_id = $checkbox[$i]; 
			
			$querySearch = $this->conn->prepare("SELECT acc_id FROM accounts WHERE acc_id=?");
			$querySearch->bindParam(1, $del_id);
			$querySearch->execute();
			$row = $querySearch->fetch();
			$getaccid = $row['acc_id'];
			
			$querySearch1 = $this->conn->prepare("SELECT tr_fname, tr_midname, tr_lname FROM treasurer WHERE acc_trid=?");
			$querySearch1->bindParam(1, $getaccid);
			$querySearch1->execute();
			$row1 = $querySearch1->fetch();
			$tr_fname = $row1['tr_fname'];
			$tr_midname = $row1['tr_midname'];
			$tr_lname = $row1['tr_lname'];
			$password = str_replace(' ', ' ', ($tr_fname[0].$tr_midname[0].$tr_lname));
			$newPass = password_hash($password, PASSWORD_DEFAULT);
			
			$queryUpdate = $this->conn->prepare("UPDATE accounts SET password=:password WHERE acc_id=:acc_id");
			if($queryUpdate->execute(array(
				':password' => $newPass,
				':acc_id' => $getaccid
			))){
				$sql2=$this->conn->prepare("SELECT username FROM accounts WHERE acc_id=:acc_id");
				$sql2->execute(array(
					':acc_id' => $getaccid
				));
				$row2=$sql2->fetch(PDO::FETCH_ASSOC);
				$username=$row2['username'];	
				$log_event="Reset";
				$log_desc="The account of ".$tr_fname." ".$tr_midname." ".$tr_lname." has been successfully reset";
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "The selected item/s has been successfully reset", "success", "admin-parent");
			}else{
				$this->alert("Error!", "You are not allowed to reset the selected item/s", "error", "admin-parent");
			}
		}
	}
	public function deactiveTreasurer(){
		try {
			$checkbox = $_POST['check'];
			if($checkbox !== null){
				for($i=0;$i<count($checkbox);$i++){
					$del_id = $checkbox[$i]; 
					$acc_status="Deactivated";
					$sql2 = $this->conn->prepare("UPDATE accounts
					SET acc_status=:acc_status
					WHERE acc_id=:acc_id");
					if($sql2->execute(array(
						':acc_status'=>$acc_status,
						':acc_id'=>$del_id
					))){
						$sql3=$this->conn->prepare("SELECT CONCAT(tr_fname,' ',tr_midname,' ',tr_lname) AS treasurername, acc_status FROM treasurer JOIN accounts ON acc_trid=acc_id WHERE acc_id=:acc_id");
						$sql3->execute(array(
							':acc_id' => $del_id
						));
						$row3=$sql3->fetch(PDO::FETCH_ASSOC);
						$treasurername=$row3['treasurername'];
						$acc_status_latest=$row3['acc_status'];
						$log_event="Update";
						$log_desc="Updated the account status of ".$treasurername." to ".$acc_status_latest;
						$this->insertLogs($log_event, $log_desc);
						$this->alert("Success!", "Successfully changed the account status", "success", "admin-parent");	
					}else{	
						$this->alert("Error!", "Failed to change the account status", "error", "admin-parent");
					}
				}	
			}else{
				$this->alert("Error!", "Please select atleast one item", "error", "admin-parent");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function activeTreasurer(){
		try {
			$checkbox = $_POST['check'];
			if($checkbox !== null){
				for($i=0;$i<count($checkbox);$i++){
					$del_id = $checkbox[$i]; 
					$acc_status="Active";
					$sql2 = $this->conn->prepare("UPDATE accounts
					SET acc_status=:acc_status
					WHERE acc_id=:acc_id");
					if($sql2->execute(array(
						':acc_status'=>$acc_status,
						':acc_id'=>$del_id
					))){
						$sql3=$this->conn->prepare("SELECT CONCAT(tr_fname,' ',tr_midname,' ',tr_lname) AS treasurername, acc_status FROM treasurer JOIN accounts ON acc_trid=acc_id WHERE acc_id=:acc_id");
						$sql3->execute(array(
							':acc_id' => $del_id
						));
						$row3=$sql3->fetch(PDO::FETCH_ASSOC);
						$treasurername=$row3['treasurername'];
						$acc_status_latest=$row3['acc_status'];
						$log_event="Update";
						$log_desc="Updated the account status of ".$treasurername." to ".$acc_status_latest;
						$this->insertLogs($log_event, $log_desc);
						$this->alert("Success!", "Successfully changed the account status", "success", "admin-parent");	
					}else{	
						$this->alert("Error!", "Failed to change the account status", "error", "admin-parent");
					}
				}
			}else{
				$this->alert("Error!", "Please select atleast one item", "error", "admin-parent");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function deactiveGuardian(){
		try {
			$checkbox = $_POST['check'];
			if($checkbox !== null){
				for($i=0;$i<count($checkbox);$i++){
					$del_id = $checkbox[$i]; 
					$acc_status="Deactivated";
					$sql2 = $this->conn->prepare("UPDATE accounts
					SET acc_status=:acc_status
					WHERE acc_id=:acc_id");
					if($sql2->execute(array(
						':acc_status'=>$acc_status,
						':acc_id'=>$del_id
					))){
						$sql3=$this->conn->prepare("SELECT CONCAT(guar_fname,' ',guar_midname,' ',guar_lname) AS guardianname, acc_status FROM guardian JOIN accounts ON acc_idx=acc_id WHERE acc_id=:acc_id");
						$sql3->execute(array(
							':acc_id' => $del_id
						));
						$row3=$sql3->fetch(PDO::FETCH_ASSOC);
						$guardianname=$row3['guardianname'];
						$log_event="Update";
						$log_desc="Updated the account status of ".$guardianname." to ".$acc_status;
						$this->insertLogs($log_event, $log_desc);
						$this->alert("Success!", "Successfully changed the account status", "success", "admin-parent");	
					}else{	
						$this->alert("Error!", "Failed to change the account status", "error", "admin-parent");
					}
				}	
			}else{
				$this->alert("Error!", "Please select atleast one item", "error", "admin-parent");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function activeGuardian(){
		try {
			$checkbox = $_POST['check'];
			if($checkbox !== null){
				for($i=0;$i<count($checkbox);$i++){
					$del_id = $checkbox[$i]; 
					$acc_status="Active";
					$sql2 = $this->conn->prepare("UPDATE accounts
					SET acc_status=:acc_status
					WHERE acc_id=:acc_id");
					if($sql2->execute(array(
						':acc_status'=>$acc_status,
						':acc_id'=>$del_id
					))){
						$sql3=$this->conn->prepare("SELECT CONCAT(guar_fname,' ',guar_midname,' ',guar_lname) AS guardianname, acc_status FROM guardian JOIN accounts ON acc_idx=acc_id WHERE acc_id=:acc_id");
						$sql3->execute(array(
							':acc_id' => $del_id
						));
						$row3=$sql3->fetch(PDO::FETCH_ASSOC);
						$guardianname=$row3['guardianname'];
						$log_event="Update";
						$log_desc="Updated the account status of ".$guardianname." to ".$acc_status;
						$this->insertLogs($log_event, $log_desc);
						$this->alert("Success!", "Successfully changed the account status", "success", "admin-parent");	
					}else{	
						$this->alert("Error!", "Failed to change the account status", "error", "admin-parent");
					}
				}
			}else{
				$this->alert("Error!", "Please select atleast one item", "error", "admin-parent");
			}
		} catch (PDOException $exception) {
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
	public function resetPTAPassword($acc_id){
		$querySearch = $this->conn->prepare("SELECT acc_id FROM accounts WHERE acc_id=?");
		$querySearch->bindParam(1, $acc_id);
		$querySearch->execute();
		$row = $querySearch->fetch();
		$getaccid = $row['acc_id'];
		
		$querySearch1 = $this->conn->prepare("SELECT tr_fname, tr_midname, tr_lname FROM treasurer WHERE acc_trid=?");
		$querySearch1->bindParam(1, $getaccid);
		$querySearch1->execute();
		$row1 = $querySearch1->fetch();
		$tr_fname = $row1['tr_fname'];
		$tr_midname = $row1['tr_midname'];
		$tr_lname = $row1['tr_lname'];
		$password = str_replace(' ', ' ', ($tr_fname[0].$tr_midname[0].$tr_lname));
		$newPass = password_hash($password, PASSWORD_DEFAULT);
		
		$queryUpdate = $this->conn->prepare("UPDATE accounts SET password=:password WHERE acc_id=:acc_id");
		if($queryUpdate->execute(array(
			':password' => $newPass,
			':acc_id' => $getaccid
		))){
			$sql2=$this->conn->prepare("SELECT username FROM accounts WHERE acc_id=:acc_id");
			$sql2->execute(array(
				':acc_id' => $getaccid
			));
			$row2=$sql2->fetch(PDO::FETCH_ASSOC);
			$username=$row2['username'];	
			$log_event="Reset";
			$log_desc="The account of ".$tr_fname." ".$tr_midname." ".$tr_lname." has been successfully reset";
			$this->insertLogs($log_event, $log_desc);
			$this->Prompt("Successfully reset account password! Username = <span class='prompt'>$username</span> Password: <span class='prompt'>$password</span>", "rgb(1, 58, 6)", "admin-parent");
		}else{
			$this->alert("Error!", "Failed to reset account password!", "error", "admin-parent");
		}
	}
	public function resetParentPassword($acc_id){
		$querySearch = $this->conn->prepare("SELECT acc_id FROM accounts WHERE acc_id=?");
		$querySearch->bindParam(1, $acc_id);
		$querySearch->execute();
		$row = $querySearch->fetch();
		$getaccid = $row['acc_id'];
		
		$querySearch1 = $this->conn->prepare("SELECT guar_fname, guar_midname, guar_lname FROM guardian WHERE acc_idx=?");
		$querySearch1->bindParam(1, $getaccid);
		$querySearch1->execute();
		$row1 = $querySearch1->fetch();
		$guar_fname = $row1['guar_fname'];
		$guar_midname = $row1['guar_midname'];
		$guar_lname = $row1['guar_lname'];
		$password = str_replace(' ', '', ($guar_fname[0].$guar_midname[0].$guar_lname));
		$newPass = password_hash($password, PASSWORD_DEFAULT);
		
		$queryUpdate = $this->conn->prepare("UPDATE accounts SET password=:password WHERE acc_id=:acc_id");
		if($queryUpdate->execute(array(
			':password' => $newPass,
			':acc_id' => $getaccid
		))){
			$sql2=$this->conn->prepare("SELECT username FROM accounts WHERE acc_id=:acc_id");
			$sql2->execute(array(
				':acc_id' => $acc_id
			));
			$row2=$sql2->fetch(PDO::FETCH_ASSOC);
			$username=$row2['username'];
			$log_event="Reset";
			$log_desc="The account of ".$guar_fname." ".$guar_midname." ".$guar_lname." has been successfully reset";
			$this->insertLogs($log_event, $log_desc);
			$this->Prompt("Successfully reset account password! Username = <span class='prompt'>$username</span> Password: <span class='prompt'>$password</span>", "rgb(1, 58, 6)", "admin-parent");
		}else{
			$this->alert("Error!", "Failed to reset account password!", "error", "admin-parent");
		}
	}
	public function multipleResetGuardian(){
		$checkbox = $_POST['check'];
		for($i=0;$i<count($checkbox);$i++){
			$del_id = $checkbox[$i]; 
			
			$querySearch = $this->conn->prepare("SELECT acc_id FROM accounts WHERE acc_id=?");
			$querySearch->bindParam(1, $del_id);
			$querySearch->execute();
			$row = $querySearch->fetch();
			$getaccid = $row['acc_id'];
			
			$querySearch1 = $this->conn->prepare("SELECT guar_fname, guar_midname, guar_lname FROM guardian WHERE acc_idx=?");
			$querySearch1->bindParam(1, $getaccid);
			$querySearch1->execute();
			$row1 = $querySearch1->fetch();
			$guar_fname = $row1['guar_fname'];
			$guar_midname = $row1['guar_midname'];
			$guar_lname = $row1['guar_lname'];
			$password = str_replace(' ', '', ($guar_fname[0].$guar_midname[0].$guar_lname));
			$newPass = password_hash($password, PASSWORD_DEFAULT);
			
			$queryUpdate = $this->conn->prepare("UPDATE accounts SET password=:password WHERE acc_id=:acc_id");
			if($queryUpdate->execute(array(
				':password' => $newPass,
				':acc_id' => $getaccid
			))){
				$sql2=$this->conn->prepare("SELECT username FROM accounts WHERE acc_id=:acc_id");
				$sql2->execute(array(
					':acc_id' => $del_id
				));
				$row2=$sql2->fetch(PDO::FETCH_ASSOC);
				$username=$row2['username'];
				$log_event="Reset";
				$log_desc="The account of ".$guar_fname." ".$guar_midname." ".$guar_lname." has been successfully reset";
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "The account of selected item/s has been successfully reset", "success", "admin-parent");
			}else{
				$this->alert("Error!", "Failed to reset the account/s of the selected item/s", "error", "admin-parent");
			}
		}
	}
	public function insertPTAData($tr_fname, $tr_midname, $tr_lname) {
		try {
			$tr_sy=date("Y");
			$password = str_replace(' ', ' ', ($tr_fname[0].$tr_midname[0].$tr_lname));
			$usernamePTA= str_replace(' ', ' ', ($tr_fname[0].$tr_midname[0].$tr_lname));
			$PTAAccid = $this->createPTAAccount($usernamePTA, $password, 'treasurer');
			$sql = $this->conn->prepare("INSERT INTO treasurer SET tr_fname=:tr_fname, tr_lname=:tr_lname, tr_midname=:tr_midname, tr_sy=:tr_sy, acc_trid=:acc_trid");
			if($sql->execute(array(
				':tr_fname' => $tr_fname,
				':tr_lname' => $tr_lname,  
				':tr_midname' => $tr_midname,
				':tr_sy' => $tr_sy,
				':acc_trid' => $PTAAccid
			))){
				$sql2=$this->conn->prepare("SELECT CONCAT(tr_fname,' ',tr_midname,' ',tr_lname) AS treasurername FROM treasurer ORDER BY tr_id DESC LIMIT 1");
				$sql2->bindParam(1, $id);
				$sql2->execute();
				$row2=$sql2->fetch(PDO::FETCH_ASSOC);
				$treasurername=$row2['treasurername'];
				$log_event="Insert";
				$log_desc="Added an account of treasurer member ".$treasurername;
				$this->insertLogs($log_event, $log_desc);
				$sql2=$this->conn->prepare("SELECT username FROM accounts ORDER BY acc_id DESC LIMIT 1");
				$sql2->execute();
				$row=$sql2->fetch(PDO::FETCH_ASSOC);
				$username=$row['username'];	
				$this->Prompt("Account has been created! Username = <span class='prompt'>$username</span> Password: <span class='prompt'>$password</span>", "rgb(1, 58, 6)", "admin-parent");
			}else{
				$this->alert("Error!", "Failed to add treasurer account", "error", "admin-parent");
			}
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}	
	}
	public function updatePTAData($tr_id, $tr_fname, $tr_midname, $tr_lname) {
		try {
			$sql1 = $this->conn->prepare("UPDATE treasurer SET tr_fname=:tr_fname, tr_lname=:tr_lname, tr_midname=:tr_midname WHERE tr_id=:tr_id");
			if($sql1->execute(array(
				':tr_fname' => $tr_fname,
				':tr_midname' => $tr_midname,
				':tr_lname' => $tr_lname,
				':tr_id' => $tr_id
			))){
				$sql2=$this->conn->prepare("SELECT CONCAT(tr_fname,' ',tr_midname,' ',tr_lname) AS treasurername FROM treasurer WHERE tr_id=:tr_id");
				$sql2->execute(array(
					':tr_id' => $tr_id
				));
				$row2=$sql2->fetch(PDO::FETCH_ASSOC);
				$treasurername=$row2['treasurername'];
				$log_event="Update";
				$log_desc="Updated account details of ".$treasurername;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "Successfully updated the account of $treasurername", "success", "admin-parent");
			}else{
				$this->alert("Error!", "Failed to update Treasurer data", "error", "admin-parent");
			}
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}	
	}
	public function deletePTAData($id){
		try {
			$sql1=$this->conn->prepare("SELECT CONCAT(tr_fname,' ',tr_midname,' ',tr_lname) AS treasurername FROM treasurer JOIN accounts ON acc_trid=acc_id WHERE acc_trid=:acc_trid");
			$sql1->execute(array(
				':acc_trid' => $id
			));
			$row1=$sql1->fetch(PDO::FETCH_ASSOC);
			$treasurername=$row1['treasurername'];
			
			$sql2 = $this->conn->prepare("
				DELETE a.*, b.* 
				FROM treasurer a 
				LEFT JOIN accounts b 
				ON b.acc_id = a.acc_trid 
				WHERE a.acc_trid =:acc_trid");
			if($sql2->execute(array(
				':acc_trid'=>$id
			))){
				$log_event="Deleted";
				$log_desc="Deleted the account of ".$treasurername;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "The account has been deleted!", "success", "admin-parent");
			}else{
				$this->alert("Error!", "Failed to delete Account Data!", "error", "admin-parent");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	/*public function showChildName(){
		$sql=$this->conn->query("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) as childName FROM section join student s on secc_id=sec_id JOIN guardian g ON s.guar_id=g.guar_id JOIN accounts ON acc_idx=acc_id");
		$sql->execute();
		$row=$sql->fetchAll();
		foreach ($row as $value) {
			$childName=$value['childName'];
			echo $childName;
		}
	}*/
	public function showParentList(){
		$sql=$this->conn->query("SELECT * FROM section join student s on secc_id=sec_id JOIN guardian g ON s.guar_id=g.guar_id JOIN accounts ON acc_idx=acc_id");
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
		$sql=$this->conn->query("SELECT * FROM treasurer JOIN accounts c ON acc_trid=acc_id WHERE c.acc_type='Treasurer'");
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
				$sql2=$this->conn->prepare("SELECT CONCAT(guar_fname,' ',guar_midname,' ',guar_lname) AS treasurername FROM guardian JOIN accounts ON acc_idx=acc_id WHERE guar_id=?");
				$sql2->bindParam(1, $guar_id);
				$sql2->execute();
				$row2=$sql2->fetch(PDO::FETCH_ASSOC);
				$username=$row['username'];
				$treasurername=$row2['treasurername'];
				$log_event="Update";
				$log_desc="Updated account details of ".$treasurername;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "Successfully updated the account of $treasurername", "success", "admin-parent");
			}else{
				$this->alert("Error!", "Failed to reset the account!", "error", "admin-parent");
			}
			
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}	
	}
	public function updatePTAAccountStatus($id, $acc_status){
		try {
			$sql2 = $this->conn->prepare("UPDATE accounts
			SET acc_status=:acc_status
			WHERE acc_id=:acc_id");
			if($sql2->execute(array(
				':acc_status'=>$acc_status,
				':acc_id'=>$id
			))){
				$sql3=$this->conn->prepare("SELECT CONCAT(tr_fname,' ',tr_midname,' ',tr_lname) AS treasurername, acc_status FROM treasurer JOIN accounts ON acc_trid=acc_id WHERE acc_id=:acc_id");
				$sql3->execute(array(
					':acc_id' => $id
				));
				$row3=$sql3->fetch(PDO::FETCH_ASSOC);
				$treasurername=$row3['treasurername'];
				$acc_status_latest=$row3['acc_status'];
				$log_event="Update";
				$log_desc="Updated the account status of ".$treasurername." to ".$acc_status_latest;
				$this->insertLogs($log_event, $log_desc);	
				$this->alert("Success!", "You have successfully changed the account status!", "success", "admin-parent");
			}else{	
				$this->alert("Error!", "Failed to change the account status!", "error", "admin-parent");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function updateParentAccountStatus($id, $acc_status){
		try {
			$sql2 = $this->conn->prepare("UPDATE accounts
			SET acc_status=:acc_status
			WHERE acc_id=:acc_id");
			if($sql2->execute(array(
				':acc_status'=>$acc_status,
				':acc_id'=>$id
			))){
				$sql3=$this->conn->prepare("SELECT CONCAT(guar_fname,' ',guar_midname,' ',guar_lname) AS guardianname, acc_status FROM guardian JOIN accounts ON acc_idx=acc_id WHERE acc_id=:acc_id");
				$sql3->execute(array(
					':acc_id' => $id
				));
				$row3=$sql3->fetch(PDO::FETCH_ASSOC);
				$guardianname=$row3['guardianname'];
				$log_event="Update";
				$log_desc="Updated the account status of ".$guardianname." to ".$acc_status;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "You have successfully changed the account status!", "success", "admin-parent");	
			}else{	
				$this->alert("Error!", "Failed to change the account status!", "error", "admin-parent");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	/**************** END PTA ACCOUNT ****************/
	
	/**************** STUDENT  ***********************/
	public function multipleResetStudent(){
		$checkbox = $_POST['check'];
		for($i=0;$i<count($checkbox);$i++){
			$del_id = $checkbox[$i]; 

			$querySearch = $this->conn->prepare("SELECT acc_id FROM accounts WHERE acc_id=?");
			$querySearch->bindParam(1, $del_id);
			$querySearch->execute();
			$row = $querySearch->fetch();
			$getaccid = $row['acc_id'];
			
			$querySearch1 = $this->conn->prepare("SELECT first_name, middle_name, last_name FROM student WHERE accc_id=?");
			$querySearch1->bindParam(1, $getaccid);
			$querySearch1->execute();
			$row1 = $querySearch1->fetch();
			$first_name = $row1['first_name'];
			$middle_name = $row1['middle_name'];
			$last_name = $row1['last_name'];
			$password = str_replace(' ', ' ', ($first_name[0].$middle_name[0].$last_name));
			$newPass = password_hash($password, PASSWORD_DEFAULT);
			
			$queryUpdate = $this->conn->prepare("UPDATE accounts SET password=:password WHERE acc_id=:acc_id");
			if($queryUpdate->execute(array(
				':password' => $newPass,
				':acc_id' => $getaccid
			))){
				$sql2=$this->conn->prepare("SELECT username FROM accounts WHERE acc_id=:acc_id");
				$sql2->execute(array(
					':acc_id' => $getaccid
				));
				$row2=$sql2->fetch(PDO::FETCH_ASSOC);
				$username=$row2['username'];
				$log_event="Reset";
				$log_desc="The account of ".$first_name." ".$middle_name." ".$last_name." has been successfully reset";
				$this->insertLogs($log_event, $log_desc);
				$this->Prompt("Successfully reset account password! Username = <span class='prompt'>$username</span> Password: <span class='prompt'>$password</span>", "rgb(1, 58, 6)", "admin-student");
			}else{
				$this->alert("Error!", "Failed to reset account password!", "error", "admin-student");
			}
		}
	}
	public function deactiveStudent(){
		try {
			$checkbox = $_POST['check'];
			if($checkbox !== null){
				for($i=0;$i<count($checkbox);$i++){
					$del_id = $checkbox[$i]; 
					$acc_status="Deactivated";
					$sql2 = $this->conn->prepare("UPDATE accounts
					SET acc_status=:acc_status
					WHERE acc_id=:acc_id");
					if($sql2->execute(array(
						':acc_status'=>$acc_status,
						':acc_id'=>$del_id
					))){
						$sql3=$this->conn->prepare("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) AS studentname, acc_status FROM student JOIN accounts ON accc_id=acc_id WHERE acc_id=:acc_id");
						$sql3->execute(array(
							':acc_id' => $del_id
						));
						$row3=$sql3->fetch(PDO::FETCH_ASSOC);
						$studentname=$row3['studentname'];
						$log_event="Update";
						$log_desc="Updated the account status of ".$studentname." to ".$acc_status;
						$this->insertLogs($log_event, $log_desc);
						$this->alert("Success!", "Successfully changed the account status", "success", "admin-student");	
					}else{	
						$this->alert("Error!", "Failed to change the account status", "error", "admin-student");
					}
				}	
			}else{
				$this->alert("Error!", "Please select atleast one item", "error", "admin-student");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function activeStudent(){
		try {
			$checkbox = $_POST['check'];
			if($checkbox !== null){
				for($i=0;$i<count($checkbox);$i++){
					$del_id = $checkbox[$i]; 
					$acc_status="Active";
					$sql2 = $this->conn->prepare("UPDATE accounts
					SET acc_status=:acc_status
					WHERE acc_id=:acc_id");
					if($sql2->execute(array(
						':acc_status'=>$acc_status,
						':acc_id'=>$del_id
					))){
						$sql3=$this->conn->prepare("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) AS studentname, acc_status FROM student JOIN accounts ON accc_id=acc_id WHERE acc_id=:acc_id");
						$sql3->execute(array(
							':acc_id' => $del_id
						));
						$row3=$sql3->fetch(PDO::FETCH_ASSOC);
						$studentname=$row3['studentname'];
						$log_event="Update";
						$log_desc="Updated the account status of ".$studentname." to ".$acc_status;
						$this->insertLogs($log_event, $log_desc);
						$this->alert("Success!", "Successfully changed the account status", "success", "admin-student");	
					}else{	
						$this->alert("Error!", "Failed to change the account status", "error", "admin-student");
					}
				}
			}else{
				$this->alert("Error!", "Please select atleast one item", "error", "admin-student");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	
	public function getGradeAndSection2(){
		$sql=$this->conn->prepare("SELECT sec_id, grade_lvl, sec_name, CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS gradesec 
			FROM section ORDER BY grade_lvl");
		$sql->execute();
		$option = '';
		while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
			$option .= '<option value="Grade '.$row['grade_lvl'].' - '.$row['sec_name'].'" name="gradesec">'.$row["gradesec"].'</option>';
		}
		echo $option;
	}
	
	public function showStudentList(){
		try {
			$sql=$this->conn->query("SELECT * FROM section join student on secc_id = sec_id JOIN accounts ON accc_id=acc_id") or die("failed!");
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
	public function resetStudentPassword($acc_id){
		$querySearch = $this->conn->prepare("SELECT acc_id FROM accounts WHERE acc_id=?");
		$querySearch->bindParam(1, $acc_id);
		$querySearch->execute();
		$row = $querySearch->fetch();
		$getaccid = $row['acc_id'];
		
		$querySearch1 = $this->conn->prepare("SELECT first_name, middle_name, last_name FROM student WHERE accc_id=?");
		$querySearch1->bindParam(1, $getaccid);
		$querySearch1->execute();
		$row1 = $querySearch1->fetch();
		$first_name = $row1['first_name'];
		$middle_name = $row1['middle_name'];
		$last_name = $row1['last_name'];
		$password = str_replace(' ', ' ', ($first_name[0].$middle_name[0].$last_name));
		$newPass = password_hash($password, PASSWORD_DEFAULT);
		
		$queryUpdate = $this->conn->prepare("UPDATE accounts SET password=:password WHERE acc_id=:acc_id");
		if($queryUpdate->execute(array(
			':password' => $newPass,
			':acc_id' => $getaccid
		))){
			$sql2=$this->conn->prepare("SELECT username FROM accounts WHERE acc_id=:acc_id");
			$sql2->execute(array(
				':acc_id' => $getaccid
			));
			$row2=$sql2->fetch(PDO::FETCH_ASSOC);
			$username=$row2['username'];
			$log_event="Reset";
			$log_desc="The account of ".$first_name." ".$middle_name." ".$last_name." has been successfully reset";
			$this->insertLogs($log_event, $log_desc);
			$this->Prompt("Successfully reset account password! Username = <span class='prompt'>$username</span> Password: <span class='prompt'>$password</span>", "rgb(1, 58, 6)", "admin-student");
		}else{
			$this->alert("Error!", "Failed to reset account password!", "error", "admin-student");
		}
	}
	public function updateStudentAccountStatus($id, $acc_status){
		try {
			$sql = $this->conn->prepare("UPDATE accounts
			SET acc_status=:acc_status
			WHERE acc_id=:acc_id");
			if($sql->execute(array(
				':acc_status'=>$acc_status,
				':acc_id'=>$id
			))){
				$sql3=$this->conn->prepare("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) AS studentname, acc_status FROM student JOIN accounts ON accc_id=acc_id WHERE acc_id=:acc_id");
				$sql3->execute(array(
					':acc_id' => $id
				));
				$row3=$sql3->fetch(PDO::FETCH_ASSOC);
				$studentname=$row3['studentname'];
				$log_event="Update";
				$log_desc="Updated the account status of ".$studentname." to ".$acc_status;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "You have successfully changed the account status!", "success", "admin-student");
			}else{	
				$this->alert("Error!", "Failed to change the account status!", "error", "admin-student");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	/**************** END STUDENT ****************/
	
	/**************** ANNOUNCEMENT **************/
	public function multipleDeleteEvents(){
		$checkbox = $_POST['check'];
		if($checkbox !== null){
			for($i=0;$i<count($checkbox);$i++){
				$del_id = $checkbox[$i]; 
				
				$sql1= $this->conn->prepare('SELECT attachment FROM announcements WHERE ann_id =:ann_id');
				$sql1->bindParam(':ann_id',$del_id);
				$sql1->execute();	
				$row=$sql1->fetch(PDO::FETCH_ASSOC);
				
				$sql2=$this->conn->prepare("SELECT * from announcements WHERE ann_id=:ann_id");
				$sql2->execute(array(
					':ann_id' => $del_id
				));
				$row2=$sql2->fetch(PDO::FETCH_ASSOC);
				$title2=$row2['title'];
				$post2=$row2['post'];
				$sql3 = $this->conn->prepare("DELETE FROM announcements WHERE ann_id =:ann_id");
				if($sql3->execute(array(
					':ann_id'=>$del_id
				))){
					$log_event="Delete";
					$log_desc="Deleted the event '".$title2."'";
					$this->insertLogs($log_event, $log_desc);
					$this->alert("Success!", "The event has been deleted", "success", "admin-events");
				}else{	
					$this->alert("Error!", "Failed to delete the selected event/s", "error", "admin-events");
				}
			}
		}else{
			$this->alert("Error!", "Please select atleast one item", "error", "admin-events");
		}
	}
	
	public function multipleDeleteAnnouncements(){
		$checkbox = $_POST['check'];
		if($checkbox !== null){
			for($i=0;$i<count($checkbox);$i++){
				$del_id = $checkbox[$i]; 
				
				$sql1= $this->conn->prepare('SELECT attachment FROM announcements WHERE ann_id =:ann_id');
				$sql1->bindParam(':ann_id',$del_id);
				$sql1->execute();	
				$row=$sql1->fetch(PDO::FETCH_ASSOC);
				$file = $row['attachment'];
				$dir = "public/attachment/".$file;
				chmod($dir, 0777);
				@unlink($dir);
				
				$sql2=$this->conn->prepare("SELECT * from announcements WHERE ann_id=:ann_id");
				$sql2->execute(array(
					':ann_id' => $del_id
				));
				$row2=$sql2->fetch(PDO::FETCH_ASSOC);
				$title2=$row2['title'];
				$post2=$row2['post'];
				$sql3 = $this->conn->prepare("DELETE FROM announcements WHERE ann_id =:ann_id");
				if($sql3->execute(array(
					':ann_id'=>$del_id
				))){
					$log_event="Delete";
					$log_desc="Deleted the announcement '".$post2."'";
					$this->insertLogs($log_event, $log_desc);
					$this->alert("Success!", "The selected announcement/s has been deleted", "success", "admin-events");
				}else{	
					$this->alert("Error!", "Failed to delete the selected announcement/s", "error", "admin-events");
				}
			}
		}else{
			$this->alert("Error!", "Please select atleast one item", "error", "admin-events");
		}
	}
	
	public function showEvents(){
		$admin_id = $_SESSION['accid'];
		$sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e, %Y') as date_start_1, DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, date_start, date_end, post, view_lim, attachment FROM announcements WHERE post_adminid=? AND title IS NOT NULL AND holiday='No'") or die ("failed!");
		$sql->bindParam(1, $admin_id);
		$sql->execute();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}
	public function showHolidays(){
		$admin_id = $_SESSION['accid'];
		$sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e') as date_start_1,  DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, DAY(CURDATE()), DAY(date_start) FROM announcements WHERE post_adminid=? AND title IS NOT NULL AND holiday='Yes' AND (date_start between now() and adddate(now(), +15))") or die ("failed!");
		$sql->bindParam(1, $admin_id);
		$sql->execute();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}	
	
	public function showEventsSection(){
		$admin_id = $_SESSION['accid'];
		$sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e, %Y') as date_start_1, DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, date_start, date_end, post, view_lim, attachment FROM announcements WHERE post_adminid=? AND title IS NOT NULL") or die ("failed!");
		$sql->bindParam(1, $admin_id);
		$sql->execute();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}
	
	public function showAnnouncementSection(){
		$admin_id = $_SESSION['accid'];
		$sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e, %Y') as date_start_1, DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, date_start, date_end, post, view_lim, attachment FROM announcements WHERE post_adminid=? and post IS NOT NULL") or die ("failed!");
		$sql->bindParam(1, $admin_id);
		$sql->execute();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}
	
	
	public function getAnnouncements() {
		$admin_id = $_SESSION['accid'];
		$sql = $this->conn->prepare("SELECT * FROM announcements WHERE post_adminid=? AND post IS NOT NULL") or die ("failed!");
		$sql->bindParam(1, $admin_id);
		$sql->execute();
		$result = $sql->fetchAll();
		foreach($result as $row) {
			$html = '<tr>';
			$html .= '<td class="tleft custPad2 longText">';
			$html .= '<h3 class="att_title">'.$row['post'].'</h3>';
			$html .= $row['attachment'] !== null ? '<p class="tright attachment"><a href="public/attachment/'.$row['attachment'].'" download">Download attachment</a></p>' : '';
			$html .= '</td>';
			$html .= '</tr>';
			echo $html;
		}
	}
	
	public function insertEvent($title, $date_start, $date_end, $view_lim){
		try{
			$admin_id = $_SESSION['accid'];
			$checkbox = $_POST['view_lim'];
			$sql = "INSERT INTO announcements SET title=:title, date_start=:date_start, date_end=:date_end, view_lim=('";
			for($i=0; $i<sizeof ($checkbox);$i++) {
				$sql .= $checkbox[$i];
				if ($i<sizeof ($checkbox) - 1) {
					$sql .= ",";
				}
			}
			$sql .= "'), post_adminid=:post_adminid";
			$sql=$this->conn->prepare($sql);
			if($sql->execute(array(
			':title'  => (empty($title) ? null : $title),
			':date_start' => $date_start,
			':date_end' => $date_end.' 23:59:59',
			':post_adminid' => $_SESSION['accid']))){
				$sql2=$this->conn->prepare("SELECT * from announcements WHERE post_adminid=? ORDER BY ann_id DESC LIMIT 1");
				$sql2->bindParam(1, $admin_id);
				$sql2->execute();
				$row2=$sql2->fetch(PDO::FETCH_ASSOC);
				$ann_id=$row2['ann_id'];
				$sql3=$this->conn->prepare("INSERT INTO admann SET adminn_id=:adminn_id, annn_id=:annn_id");
				$sql3->execute(array(
					':adminn_id' => $_SESSION['accid'],
					':annn_id' => $ann_id
				));
				$log_event="Insert";
				$log_desc="Added announcement with a Title: ".$title;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "An announcement has been created! Title: $title, Start Date: $date_start, End Date: $date_end", "success", "admin-events");
			}else{
				$this->alert("Error!", "Failed to post announcement", "error", "admin-events");
			}
			
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}
	}
	
	public function insertAnnouncement($post, $date_start, $date_end, $view_lim, $attachment){
		try{
			$admin_id=$_SESSION['accid'];
			$checkbox = $_POST['view_lim'];
			$sql = "INSERT INTO announcements SET date_start=:date_start, date_end=:date_end, post=:post, view_lim=('";
			for($i=0; $i<sizeof ($checkbox);$i++) {
				$sql .= $checkbox[$i];
				if ($i<sizeof ($checkbox) - 1) {
					$sql .= ",";
				}
			}
			$sql .= "'), attachment=:attachment, post_adminid=:post_adminid";
			$sql=$this->conn->prepare($sql);
			if($sql->execute(array(
			':date_start' => $date_start,
			':date_end' => $date_end,
			':post' => (empty($post) ? null : $post),
			':attachment' => (empty($attachment['name']) ? null : $attachment['name']),
			':post_adminid' => $_SESSION['accid']))){
				$sql2=$this->conn->prepare("SELECT * from announcements WHERE post_adminid=? ORDER BY ann_id DESC LIMIT 1");
				$sql2->bindParam(1, $admin_id);
				$sql2->execute();
				$row2=$sql2->fetch(PDO::FETCH_ASSOC);
				$ann_id=$row2['ann_id'];
				$sql3=$this->conn->prepare("INSERT INTO admann set adminn_id=:adminn_id, annn_id=:annn_id");
				$sql3->execute(array(
					':adminn_id' => $_SESSION['accid'],
					':annn_id' => $ann_id
				));
				$log_event="Insert";
				$log_desc="Added the announcement: ".$post;
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "An announcement has been created! Announcement: $post, Start Date: $date_start, End Date: $date_end", "success", "admin-events");
			}else{
				$this->alert("Error!", "Failed to post announcement", "error", "admin-events");
			}
			
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}
		$file = $attachment['name'];
		$size = $attachment['size'];
		$temp1 = $attachment['tmp_name'];
		$pathWithFile = "public/attachment/".$file; //set upload folder path
		
		$sql2=$this->conn->prepare("SELECT * FROM announcements ORDER BY 1 DESC LIMIT 1");
		$sql2->execute();
        	$row=$sql2->fetch(PDO::FETCH_ASSOC);	
		$id=$row['ann_id'];
		$fileToDel = trim(strval($row['attachment']));
		$new_path = realpath('public/attachment/'.$fileToDel);
		/*@unlink($new_path);*/
		
		$temp2 = $attachment['tmp_name'];
		$staticValue="attachment";
		$path = "public/attachment/";
		$underScore="_";
		$tmp = explode('.', $file);
		$ext = end($tmp);
		$filename = "$staticValue$underScore$id.".$ext;
        	$newname = $path.$filename;
		if(!empty($attachment['name'])){
			if(!file_exists($newname)){
				if($size < 20000000){ //check file size of 20mb
					/*move_uploaded_file($temp1, $pathWithFile);*/ //move temporary file to your folder
					move_uploaded_file($temp2, $newname);
			        	$sql3 = $this->conn->prepare("UPDATE announcements SET attachment=:attachment WHERE ann_id=:ann_id");
					$sql3->execute(array(
						':attachment' => $filename,
						':ann_id' => $id
					));
				}else{
					$this->alert("Error!", "Failed! Maximum file size 20 mb", "error", "admin-events");
				}
			}else{
				$this->alert("Success!", "Successfully updated the announcement Title: $title, Start Date: $date_start, End Date: $date_end, but the attachment already exist! Please change the filename and re-upload the file using the edit operator!", "success", "admin-events");
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
	
	public function updateEvent($ann_id, $title, $date_start, $date_end, $view_lim){
		$checkbox = $_POST['view_lim'];
		$sql1 = "UPDATE announcements SET title=:title, date_start=:date_start, date_end=:date_end, view_lim=('";
		for($i=0; $i<sizeof ($checkbox);$i++) {
			$sql1 .= $checkbox[$i];
			if ($i<sizeof ($checkbox) - 1) {
				$sql1 .= ",";
			}
		}
		$sql1 .= "') WHERE ann_id=:ann_id";
		$sql1=$this->conn->prepare($sql1);
		if($sql1->execute(array(
		':title'  => (empty($title) ? null : $title),
		':date_start' => $date_start,
		':date_end' => $date_end,
		':ann_id' => $ann_id))){
			$sql2=$this->conn->prepare("SELECT DATE_FORMAT(date(date_start), '%M %e, %Y') as date_start,  DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end from announcements WHERE ann_id=:ann_id");
			$sql2->execute(array(
				':ann_id' => $ann_id
			));
			$row2=$sql2->fetch(PDO::FETCH_ASSOC);
			$log_event="Update";
			$log_desc="Updated the announcement with the following details(Title: ".$title.", Date Start: ".$date_start.", Date End: ".$date_end.")";
			$this->insertLogs($log_event, $log_desc);
			$this->alert("Success!", "An announcement has been updated! Title: $title, Start Date: $date_start, End Date: $date_end", "success", "admin-events");
		}else{
			$this->alert("Error!", "Failed to post the announcement", "error", "admin-events");
		}
	}
	
	public function updateAnnouncement($ann_id, $post, $date_start, $date_end, $view_lim, $attachment){
		if(!empty($attachment['name'])) {			
			$file = $attachment['name'];
			$size = $attachment['size'];
			$temp = $attachment['tmp_name'];
			$path = "public/attachment/".$file; //set upload folder path
		
			if(!file_exists($path)){
				if($size < 20000000){
					$sql2= $this->conn->prepare("SELECT * FROM announcements WHERE ann_id =:ann_id");
					$sql2->execute(array(
						':ann_id' => $ann_id
					));	
					$row=$sql2->fetch(PDO::FETCH_ASSOC);
					$id=$row['ann_id'];
					$fileToDel = trim(strval($row['attachment']));
					$new_path = realpath('public/attachment/'.$fileToDel);
					@unlink($new_path);
					/*move_uploaded_file($temp, $path); */
					
					$temp2 = $attachment['tmp_name'];
					$staticValue="attachment";
					$path = "public/attachment/";
			        	
			        	$underScore="_";
			        	$tmp = explode('.', $file);
					$ext = end($tmp);
					$filename = "$staticValue$underScore$id.".$ext;
			        	$newname = $path.$filename;
			        	move_uploaded_file($temp2, $newname);
			        	$sql3 = $this->conn->prepare("UPDATE announcements SET attachment=:attachment WHERE ann_id=:ann_id");
					$sql3->execute(array(
						':attachment' => $filename,
						':ann_id' => $id
					));
				}else{
					$sql8=$this->conn->prepare("SELECT DATE_FORMAT(date(date_start), '%M %e, %Y'),  DATE_FORMAT(date(date_end), '%M %e, %Y'), attachment as attch from announcements WHERE ann_id=:ann_id");
					$sql8->execute(array(
						':ann_id' => $ann_id
					));
					$row8=$sql8->fetch(PDO::FETCH_ASSOC);
					$attch=$row8['attch'];
					$log_event="Update";
					$log_desc="Updated the announcement with the following details( Announcement: ".$post.", Date Start: ".$date_start.", Date End: ".$date_end.", Attachment: ".$attch.")";
					$this->insertLogs($log_event, $log_desc);
					$this->alert("Error!", "Failed! Maximum file size 20 mb", "error", "admin-events");
				}
			}else{
				$this->alert("Success!", "Successfully updated the announcement  Title: $title, Start Date: $date_start, End Date: $date_end, but the attachment already exist! Please change the filename and re-upload the file using the edit operator!", "success", "admin-events");
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
				':title'  => (empty($title) ? null : $title),
				':date_start' => $date_start,
				':date_end' => $date_end,
				':post' => (empty($post) ? null : $post),
				':attachment' => $filename,
				':ann_id' => $ann_id))){
					$sql2=$this->conn->prepare("SELECT DATE_FORMAT(date(date_start), '%M %e, %Y') as date_start,  DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end, attachment as attch from announcements WHERE ann_id=:ann_id");
					$sql2->execute(array(
						':ann_id' => $ann_id
					));
					$row2=$sql2->fetch(PDO::FETCH_ASSOC);
					$attch=$row2['attch'];
					$log_event="Update";
					$log_desc="Updated the announcement with the following details(Announcement: ".$post.", Date Start: ".$date_start.", Date End: ".$date_end.", Attachment: ".$attch.")";
					$this->insertLogs($log_event, $log_desc);
					$this->alert("Success!", "An announcement has been updated! Announcement: $post, Start Date: $date_start, End Date: $date_end", "success", "admin-events");
				}else{
					$this->alert("Error!", "Failed to post the announcement", "error", "admin-events");
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
				':title'  => (empty($title) ? null : $title),
				':post' => (empty($post) ? null : $post),
				':date_start' => $date_start,
				':date_end' => $date_end))){
					$sql2=$this->conn->prepare("SELECT DATE_FORMAT(date(date_start), '%M %e, %Y'),  DATE_FORMAT(date(date_end), '%M %e, %Y'), attachment as attch from announcements WHERE ann_id=:ann_id");
					$sql2->execute(array(
						':ann_id' => $ann_id
					));
					$row2=$sql2->fetch(PDO::FETCH_ASSOC);
					$attch=$row2['attch'];
					$log_event="Update";
					$log_desc="Updated the announcement with the following details( Announcement: ".$post.", Date Start: ".$date_start.", Date End: ".$date_end.", Attachment: ".$attch.")";
					$this->insertLogs($log_event, $log_desc);
					$this->alert("Success!", "An announcement has been updated! Announcement: $post, Start Date: $date_start, End Date: $date_end", "success", "admin-events");
				}else{
					$this->alert("Error!", "Failed to post the announcement", "error", "admin-events");
				}
			}
		} catch (PDOException $exception){
			die('ERROR: ' . $exception->getMessage());
		}
		
	}
	
	public function deleteEvent($ann_id){
		try {
			$sql1= $this->conn->prepare('SELECT attachment FROM announcements WHERE ann_id =:ann_id');
			$sql1->bindParam(':ann_id',$ann_id);
			$sql1->execute();	
			$row=$sql1->fetch(PDO::FETCH_ASSOC);
			$file = $row['attachment'];
			$dir = "public/attachment/".$file;
			chmod($dir, 0777);
			@unlink($dir);
			
			$sql2=$this->conn->prepare("SELECT * from announcements WHERE ann_id=:ann_id");
			$sql2->execute(array(
				':ann_id' => $ann_id
			));
			$row2=$sql2->fetch(PDO::FETCH_ASSOC);
			$title2=$row2['title'];
			$post2=$row2['post'];
			$sql3 = $this->conn->prepare("DELETE FROM announcements WHERE ann_id =:ann_id");
			if($sql3->execute(array(
				':ann_id'=>$ann_id
			))){
				$log_event="Delete";
				$log_desc="Deleted the event '".$title2. "'";
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "The event has been deleted", "success", "admin-events");
			}else{	
				$this->alert("Error!", "Failed to delete the event", "error", "admin-events");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	public function deleteAnnouncement($ann_id){
		try {
			$sql1= $this->conn->prepare('SELECT attachment FROM announcements WHERE ann_id =:ann_id');
			$sql1->bindParam(':ann_id',$ann_id);
			$sql1->execute();	
			$row=$sql1->fetch(PDO::FETCH_ASSOC);
			
			$sql2=$this->conn->prepare("SELECT * from announcements WHERE ann_id=:ann_id");
			$sql2->execute(array(
				':ann_id' => $ann_id
			));
			$row2=$sql2->fetch(PDO::FETCH_ASSOC);
			$title2=$row2['title'];
			$post2=$row2['post'];
			$sql3 = $this->conn->prepare("DELETE FROM announcements WHERE ann_id =:ann_id");
			if($sql3->execute(array(
				':ann_id'=>$ann_id
			))){
				$log_event="Delete";
				$log_desc="Deleted the announcement '".$post2. "'";
				$this->insertLogs($log_event, $log_desc);
				$this->alert("Success!", "The event has been deleted", "success", "admin-events");
			}else{	
				$this->alert("Error!", "Failed to delete the event", "error", "admin-events");
			}
		} catch (PDOException $exception) {
			die('ERROR: ' . $exception->getMessage());
		}
	}
	/**************** END ANNOUNCEMENT *****/
	
	/**************** REPORTS **************/
	public function showEnrolled(){
		$sql=$this->conn->query("SELECT *
				FROM student JOIN section ON section.sec_id = student.secc_id 
      			WHERE stud_status='Officially Enrolled' OR stud_status='Temporarily Enrolled'") or die ("failed!");
		if($sql->rowCount() > 0){
			while($row=$sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$row;
			}
			return $data;
		}
		return $sql;
	}
	public function getMiscFee(){
		$sql=$this->conn->prepare("SELECT SUM(tot_amt) as 'totalMiscFee' FROM request join budget_info_temp on request_id=bd_request where request_status='Permanent'");
		$sql->execute();
		$rowMiscFee=$sql->fetch(PDO::FETCH_ASSOC);
		echo " ". number_format($rowMiscFee['totalMiscFee'], 2) . " ";
		}
	public function getTotalTotalAmount(){
		$sql=$this->conn->prepare("SELECT sum(tot_amt) FROM budget_info_temp join request on request_id=bd_request WHERE request_status='Permanent'");
		$sql->execute();
		$rowCount=$sql->fetch();
		echo " ". number_format($rowCount['sum(tot_amt)'], 2) . " ";
	}
	public function showPaymentHistory($bal_id, $stud_lrno, $first_name, $middle_name, $last_name, $year_level, $sec_name, $orno, $pay_date, $pay_amt){
		$sql=$this->conn->query("SELECT bal_id, stud_lrno, CONCAT(first_name,' ', middle_name,' ', last_name) AS Name, year_level, sec_name, DATE_FORMAT(MAX(p.pay_date), '%M %e %Y - %H:%i:%S') AS 'payment_date', pm.orno, SUM(pm.pay_amt) AS pay_amount FROM payment p
			INNER JOIN (SELECT pay_id, orno, pay_amt, balb_id FROM payment
			GROUP BY 4 DESC ) pm ON (p.pay_id = pm.pay_id && p.orno = pm.orno && p.pay_amt = pm.pay_amt)
			JOIN balpay bp ON bp.pay_ida = pm.pay_id
			JOIN balance bal ON bp.bal_ida = bal.bal_id 
			JOIN student st ON st.stud_id = bal.stud_idb 
			JOIN section ON section.sec_id = st.secc_id
			WHERE st.stud_status='Officially Enrolled' 
			OR st.stud_status='Temporarily Enrolled' 
			GROUP BY st.first_name") or die ("failed!");
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		}else{
			return $sql;
		}
		return $data;
	}
	public function getStatistics($yr_level) {
		if($yr_level === "All") {
			$query = $this->conn->prepare("SELECT sum(pay_amt) as payments, year_level from payment join balance on balb_id = bal_id join student on stud_idb = stud_id group by year_level");
		} else {
			$query = $this->conn->prepare("SELECT sum(pay_amt) as payments, year_level from payment join balance on balb_id = bal_id join student on stud_idb = stud_id group by year_level");
		}
		
		$query->execute();
		$rowCount = $query->rowCount();
		if($rowCount > 0) {
			while($row = $query->fetch()){
				echo  "['Grade ".$row['year_level']."', " .$row['payments']."],"; 
			} 	
		}
		
	} 
	
	/**************** LOGS ********************/
	
	public function showAdminLogs(){
		$sql=$this->conn->query("SELECT CONCAT(adm_fname,' ',adm_midname,' ',adm_lname) as username, log_event, log_desc, DATE_FORMAT(log_date, '%M %e %Y - %H:%i:%S') AS logdate 
			FROM logs 
			JOIN accounts on acc_id = user_id 
			JOIN admin on acc_admid = acc_id") or die ("failed!");
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		}else{
			return $sql;
		}
		return $data;
	}
	public function showFacultyLogs(){
		$sql=$this->conn->query("SELECT CONCAT(fac_fname,' ',fac_midname,' ',fac_lname) as username, log_event, log_desc, DATE_FORMAT(log_date, '%M %e %Y - %H:%i:%S') AS logdate 
			FROM logs 
			JOIN accounts on acc_id = user_id 
			JOIN faculty on acc_idz = acc_id") or die ("failed!");
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		}else{
			return $sql;
		}
		return $data;
	}
	public function showTreasurerLogs(){
		$sql=$this->conn->query("SELECT CONCAT(tr_fname,' ',tr_midname,' ',tr_lname) as username, log_event, log_desc, DATE_FORMAT(log_date, '%M %e %Y - %H:%i:%S') AS logdate 
			FROM logs 
			JOIN accounts on acc_id = user_id 
			JOIN treasurer on acc_trid = acc_id") or die ("failed!");
		/*$sql=$this->conn->query("SELECT DATE_FORMAT(log_date, '%M %e %Y - %H:%i:%S') AS logdate, log_event, log_desc, acc_type 
			FROM logs join accounts ON user_id = acc_id") or die ("failed!");*/
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		}else{
			return $sql;
		}
		return $data;
	}
	/*************** END LOGS *************************/
	
	/*************** SYSTEM SETTING *******************/

	public function insertHolidays(){
		$query=$this->conn->prepare("SELECT * FROM announcements where holiday='Yes'");
		$query->execute();
		if($query->rowCount() > 0){
			$queryDelete=$this->conn->prepare("DELETE FROM announcements where holiday='Yes'");
			$queryDelete->execute();
		}
		$curYear = date('Y'); 
		$array_holiday = ['New Year', 'Chinese Lunar New Year', 'People Power Anniversary', 'The Day of Valor', 'Maundy Thursday', 'Good Friday', 'Black Saturday', 'Easter Sunday', 'Labor Day', 'Eidul-Fitar', 'Independence Day', 'Eid al-Adha (Feast of the Sacrifice)', 'Eid al-Adha Day 2', 'Ninoy Aquino Day', 'National Heroes Day', 'All Saints Day', 'All Souls Day', 'Bonifacio Day', 'Feast of the Immaculate Conception', 'Christmas Eve', 'Christmas Day', 'Rizal Day', 'New Years Eve'];
		$array_start_date = [$curYear.'-01-01 00:00:00', $curYear.'-02-05 00:00:00', $curYear.'-02-25 00:00:00', $curYear.'-04-09 00:00:00', $curYear.'-04-18 00:00:00', $curYear.'-04-19 00:00:00', $curYear.'-04-20 00:00:00', $curYear.'-04-21 00:00:00', $curYear.'-05-01 00:00:00', $curYear.'-06-06 00:00:00', $curYear.'-06-12 00:00:00', $curYear.'-08-12 00:00:00', $curYear.'-08-13 00:00:00', $curYear.'-08-21 00:00:00', $curYear.'-08-26 00:00:00', $curYear.'-11-01 00:00:00', $curYear.'-11-02 00:00:00', $curYear.'-11-30 00:00:00', $curYear.'-12-08 00:00:00', $curYear.'-12-24 00:00:00', $curYear.'-12-25 00:00:00', $curYear.'-12-30 00:00:00', $curYear.'-12-31 00:00:00'];
		$array_end_date = [$curYear.'-01-01 23:59:59', $curYear.'-02-05 23:59:59', $curYear.'-02-25 23:59:59', $curYear.'-04-09 23:59:59', $curYear.'-04-18 23:59:59', $curYear.'-04-19 23:59:59', $curYear.'-04-20 23:59:59', $curYear.'-04-21 23:59:59', $curYear.'-05-01 23:59:59', $curYear.'-06-06 23:59:59', $curYear.'-06-12 23:59:59', $curYear.'-08-12 23:59:59', $curYear.'-08-13 23:59:59', $curYear.'-08-21 23:59:59', $curYear.'-08-26 23:59:59', $curYear.'-11-01 23:59:59', $curYear.'-11-02 23:59:59', $curYear.'-11-30 23:59:59', $curYear.'-12-08 23:59:59', $curYear.'-12-24 23:59:59', $curYear.'-12-25 23:59:59', $curYear.'-12-30 23:59:59', $curYear.'-12-31 23:59:59'];
		$sql=$this->conn->prepare("INSERT INTO announcements SET title=:title, date_start=:date_start, date_end=:date_end, view_lim=:view_lim, holiday=:holiday, post_adminid=:post_adminid") or die ("failed");
		for($i=0; $i<sizeOf($array_holiday); $i++){
			$sql->execute(array(
				':title' => $array_holiday[$i],
				':date_start' => $array_start_date[$i],
				':date_end' => $array_end_date[$i],
				':view_lim' => '0',
				':holiday' => 'Yes',
				':post_adminid' => $_SESSION['accid']
			));
		}
		$this->alert("Success!", "You have successfully inserted the holidays", "success", "admin-system-settings");
	}
	public function showSystemSettings(){
		$sql=$this->conn->prepare("SELECT * FROM system_settings");
		$sql->execute();
		if($sql->rowCount() > 0){
			while($row=$sql->fetch(PDO::FETCH_ASSOC)){
				$data[] = $row;
			}
			return $data;
		}
		return $sql;
	}
	
	public function schoolYear($sy_start, $sy_end){
		$sql=$this->conn->prepare("INSERT INTO system_settings SET sy_start=:sy_start, sy_end=:sy_end");
		if($sql->execute(array(
			':sy_start' => $sy_start,
			':sy_end' => $sy_end
		))){
		$query1=$this->conn->prepare("SELECT * FROM system_settings");
		$query1->execute();
		while($row1=$query1->fetch(PDO::FETCH_ASSOC)){
			$sy_start=$row1['sy_start'];
			$sy_end=$row1['sy_end'];
		}
		$log_event="Insert";
		$log_desc="Added the start date: ".$sy_start.", and end date: ".$sy_end. " for system settings";
		$this->insertLogs($log_event, $log_desc);
		$this->alert("Success!", "Successfully created the start/end date for the school year", "success", "admin-system-settings");
		}else{
			$this->alert("Error!", "Failed to created the start/end date for the school year", "error", "admin-system-settings");
		}
	}

	public function syStatus($sy_status){
		$curDate = date('Y-m-d');
		$sql3=$this->conn->prepare("SELECT sy_end FROM system_settings");
		$sql3->execute();
		while($row3=$sql3->fetch(PDO::FETCH_ASSOC)){
			$school_end=$row3['sy_end'];
		}

		$sql1=$this->conn->prepare("SELECT * FROM student");
		$sql1->execute();
		$row1=$sql1->fetchAll();
		if($sy_status == 'Started'){
			if($sql1->rowCount() < 0){
				$sql2=$this->conn->prepare("UPDATE system_settings SET sy_status=:sy_status");
				if($sql2->execute(array(
					':sy_status' => $sy_status
				))){
					$logQuery=$this->conn->prepare("SELECT * FROM system_settings");
					$logQuery->execute();
					while($rowQuery=$logQuery->fetch(PDO::FETCH_ASSOC)){
						$status=$rowQuery['sy_status'];
					}
					$log_event="Update";
					$log_desc="Successfully updated the school year status to ".$status;
					$this->insertLogs($log_event, $log_desc);
					$this->alert("Success!", "Successfully started the school year", "success", "admin-system-settings");
				}
			}else if($curDate >= $school_end){
				//update school year status
				$sql4=$this->conn->prepare("UPDATE system_settings SET sy_status=:sy_status");
				$sql4->execute(array(
					':sy_status' => $sy_status
				));
				//update student status
				$sql5=$this->conn->prepare("UPDATE student SET stud_status=:stud_status, curr_stat=:curr_stat");
				$sql5->execute(array(
					':stud_status' => 'Not Enrolled',
					':curr_stat' => 'Old'
				));
				//check the balance status of students
				$sql6=$this->conn->prepare("SELECT * from student join balance ON stud_id=stud_idb WHERE bal_status='Not Cleared'");
				$sql6->execute();
				$row6=$sql6->fetchAll();
				if($sql6->rowCount() > 0){
					//archive those student who still have balances
					foreach ($row6 as $value) {
					$sql8=$this->conn->prepare("INSERT INTO balance_archive SET misc_fee=:misc_fee, bal_amt=:bal_amt, bal_status=:bal_status, stud_archive=:stud_archive");
					$sql8->execute(array(
						':misc_fee' => $value['misc_fee'],
						':bal_amt' => $value['bal_amt'],
						':bal_status' => $value['bal_status'],
						':stud_archive' => $value['stud_idb']
						));
					}
					//grade 10 to graduated
					$curYear = date('Y');
					$sql9=$this->conn->prepare("SELECT * from student");
					$sql9->execute();
					$row9=$sql9->fetchAll();
					foreach ($row9 as $value2) {
					$sql10=$this->conn->prepare("UPDATE student SET stud_status=:stud_status, year_out=:year_out WHERE stud_id=:stud_id");
					$sql10->execute(array(
						':stud_status' => (($value2['year_level'] == '10') ? 'Graduated' : $value2['stud_status']),
						':year_out' => (($value2['year_level'] == '10') ? $curYear : Null),
						':stud_id' => $value2['stud_id']
						));
					}
					$logQuery2=$this->conn->prepare("SELECT * FROM system_settings");
					$logQuery2->execute();
					while($rowQuery2=$logQuery2->fetch(PDO::FETCH_ASSOC)){
						$status2=$rowQuery2['sy_status'];
					}
					$log_event2="Update";
					$log_desc2="Successfully updated the school year status to ".$status;
					$this->insertLogs($log_event2, $log_desc2);
					echo "
						<div name='content'>
							 <button name='opener3' style='display:none'>
								<div class='tooltip'>
								</div>
							</button>
							<div name=dialog3 title='Successfully started the school year!'>
								<div class='cont2'>
									<p>The list of students who has not been cleared last School Year!</p>
									<table id='historyDataTable' class='display'>
										<thead>
											<tr>
												<th align='tleft custPad2'>Student Name</th>
												<th align='tleft custpad2'>Grade Level</th>
												<th align='tright'>Balance Amount</th>
											</tr>
										</thead>
										<tbody>";
										foreach ($row6 as $value3){
											echo"
											<tr>
												 <td align='tleft custPad2'>".$value3['first_name']." ".$value3['middle_name']." ".$value3['last_name']."</td>
												 <td align='tleft custPad2'>".$value3['year_level']."</td>
												 <td align='tright'>".$value3['bal_amt']."</td>
											</tr>";
										}
										echo"
										</tbody>
									</table>	
								</div>				
							</div>
						</div>
					";
				}else{
					$this->alert("Success!", "Successfully started the school year", "success", "admin-system-settings");
					$logQuery3=$this->conn->prepare("SELECT * FROM system_settings");
					$logQuery3->execute();
					while($rowQuery3=$logQuery3->fetch(PDO::FETCH_ASSOC)){
						$status3=$rowQuery3['sy_status'];
					}
					$log_event3="Update";
					$log_desc3="Successfully updated the school year status to ".$status;
					$this->insertLogs($log_event3, $log_desc3);
				}
			}else{
				//update school year status
				$sql4=$this->conn->prepare("UPDATE system_settings SET sy_status=:sy_status");
				if($sql4->execute(array(
					':sy_status' => $sy_status
				))){
					$logQuery4=$this->conn->prepare("SELECT * FROM system_settings");
					$logQuery4->execute();
					while($rowQuery4=$logQuery4->fetch(PDO::FETCH_ASSOC)){
						$status4=$rowQuery4['sy_status'];
					}
					$log_event4="Update";
					$log_desc4="Successfully updated the school year status to ".$status;
					$this->insertLogs($log_event4, $log_desc4);
					$this->alert("Success!", "Successfully started the school year", "success", "admin-system-settings");
				}
			}
			
			
		} else if($sy_status == 'Ended'){
			$curDate2 = date('Y-m-d');
			$query1=$this->conn->prepare("SELECT * FROM system_settings");
			$query1->execute();
			while($qrow1=$query1->fetch(PDO::FETCH_ASSOC)){
				$syEnd=$qrow1['sy_end'];
			}
			if($curDate2 >= $syEnd){
				$query2=$this->conn->prepare("DELETE FROM GRADES");
				$query2->execute();
				$query3=$this->conn->prepare("DELETE FROM announcements");
				$query2->execute();
				$query4=$this->conn->prepare("DELETE FROM attendance");
				$query4->execute();
				$query5=$this->conn->prepare("DELETE FROM behavior");
				$query5->execute();
				$query6=$this->conn->prepare("DELETE FROM logs");
				$query6->execute();
			}else{
				$logQuery5=$this->conn->prepare("SELECT * FROM system_settings");
				$logQuery5->execute();
				while($rowQuery5=$logQuery5->fetch(PDO::FETCH_ASSOC)){
					$status5=$rowQuery5['sy_status'];
				}
				$log_event5="Update";
				$log_desc5="Successfully updated the school year status to ".$status;
				$this->insertLogs($log_event5, $log_desc5);
				$this->alert("Error!", "You are not allowed to the end the school year, Because there might be some data that can be deleted. Try ending the school year after the specified date", "error", "admin-system-settings");
			}
		}
	}
	
	public function editClass($edit_class){
		$sql2=$this->conn->prepare("UPDATE system_settings SET edit_class=:edit_class");
		if($sql2->execute(array(
			':edit_class' => $edit_class
		))){
			$logQuery=$this->conn->prepare("SELECT * FROM system_settings");
			$logQuery->execute();
			while($rowQuery=$logQuery->fetch(PDO::FETCH_ASSOC)){
				$status=$rowQuery['edit_class'];
			}
			$log_event="Update";
			$log_desc="Successfully updated the edit class status to ".$status;
			$this->insertLogs($log_event, $log_desc);
			$this->alert("Success!", "Successfully changed the status of edit class", "success", "admin-system-settings");
		}else{
			$this->alert("Error!", "Failed to changed the status of of edit class", "error", "admin-system-settings");
		}
	}
	
	public function activeGrading($active_grading){
		$sql2=$this->conn->prepare("UPDATE system_settings SET active_grading=:active_grading");
		if($sql2->execute(array(
			':active_grading' => $active_grading
		))){
			$logQuery=$this->conn->prepare("SELECT * FROM system_settings");
			$logQuery->execute();
			while($rowQuery=$logQuery->fetch(PDO::FETCH_ASSOC)){
				$status=$rowQuery['edit_class'];
			}
			$log_event="Update";
			$log_desc="Successfully updated the grading status to ".$status;
			$this->insertLogs($log_event, $log_desc);
			$this->alert("Success!", "Successfully changed the status of grading", "success", "admin-system-settings");
		}else{
			$this->alert("Error!", "Failed to changed the status of grading", "error", "admin-system-settings");
		}
	}
	
	public function transferStudents($student_transfer){
		$sql2=$this->conn->prepare("UPDATE system_settings SET student_transfer=:student_transfer");
		if($sql2->execute(array(
			':student_transfer' => $student_transfer
		))){
			$logQuery=$this->conn->prepare("SELECT * FROM system_settings");
			$logQuery->execute();
			while($rowQuery=$logQuery->fetch(PDO::FETCH_ASSOC)){
				$status=$rowQuery['edit_class'];
			}
			$log_event="Update";
			$log_desc="Successfully updated the transfer status to ".$status;
			$this->insertLogs($log_event, $log_desc);
			$this->alert("Success!", "Successfully changed the status of transferring students", "success", "admin-system-settings");
		}else{
			$this->alert("Error!", "Failed to changed the status of transferring students", "error", "admin-system-settings");
		}
	}
	/*************** END SYSTEM SETTING  ***********/

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
	public function alert($title, $message, $type, $page) {
		$newUrl = URL.$page;
		echo "<script>
			swal({
				title: \"".$title."\",
				text: \"".$message."\",
				icon: \"".$type."\"
			}).then(function() {
				 window.location = '".$newUrl."';
			});
		</script>";
	}
	/**************** END PROMPT / MESSAGE ****************/
	
}
?>