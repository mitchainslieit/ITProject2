<?php
require 'app/model/connection.php';
class TreasurerFunc {

	/*profile*/
	public function updateProfile($prof_pic){		
		$file = $prof_pic['name'];
		$size = $prof_pic['size'];
		$temp = $prof_pic['tmp_name'];
		$type = $prof_pic['type'];
		$pathWithFile = "public/images/common/profpic/".$file; //set upload folder path
		$acc_id=$_SESSION['accid'];
		
		if($type=='image/jpg' || $type=='image/jpeg' || $type=='image/png' || $type=='image/gif') {	
			if(!file_exists($pathWithFile)){
				if($size < 5000000){
					$sql1= $this->conn->prepare("SELECT * FROM accounts WHERE acc_id=:acc_id");
					$sql1->execute(array(
						':acc_id' => $acc_id
					));	
					$row=$sql1->fetch(PDO::FETCH_ASSOC);
					$id=$row['acc_id'];
					$fileToDel = trim(strval($row['prof_pic']));
					$new_path = realpath('public/images/common/profpic/'.$fileToDel);
					@unlink($new_path);
					
					$tmp = explode('.', $file);
					$ext = end($tmp);
					$filename = $acc_id.".".$ext;
					$path = "public/images/common/profpic/";
			        	$newname = $path.$filename;
			        	move_uploaded_file($temp, $newname);
					$sql3 = $this->conn->prepare("UPDATE accounts SET prof_pic=:prof_pic WHERE acc_id=:acc_id");
					if($sql3->execute(array(
						':prof_pic' => $filename,
						':acc_id' => $acc_id
					))){
						$this->Message("Success!", "You have successfully changed your profile picture", "success", "treasurer-profile");
					}else{
						$this->Message("Success!", "You have successfully changed your profile picture", "success", "treasurer-profile");
					}
				}else{
					$this->Message("Error!", "Your file is too large! Please Upload 5MB Size", "error", "treasurer-profile");
				}
			}else{	
				$sql2= $this->conn->prepare("SELECT * FROM accounts WHERE acc_id=:acc_id");
				$sql2->execute(array(
					':acc_id' => $acc_id
				));	
				$row=$sql2->fetch(PDO::FETCH_ASSOC);
				$id=$row['acc_id'];
				$fileToDel = trim(strval($row['prof_pic']));
				$new_path = realpath('public/images/common/profpic/'.$fileToDel);
				@unlink($new_path);
				
				$tmp = explode('.', $file);
				$ext = end($tmp);
				$filename = $acc_id.".".$ext;
				$path = "public/profile/";
		        	$newname = $path.$filename;
		        	move_uploaded_file($temp, $newname);
				$sql3 = $this->conn->prepare("UPDATE accounts SET prof_pic=:prof_pic WHERE acc_id=:acc_id");
				if($sql3->execute(array(
					':prof_pic' => $filename,
					':acc_id' => $acc_id
				))){
					$this->Message("Success!", "You have successfully changed your profile picture", "success", "treasurer-profile");
				}else{
					$this->Message("Success!", "You have successfully changed your profile picture", "success", "treasurer-profile");
				}
			}
		}else{
			$this->Message("Error!", "Upload JPG , JPEG , PNG & GIF File Formate.....CHECK FILE EXTENSION", "error", "treasurer-profile");
		}
	}

	public function tresDetails(){
		$queryTresDetails=$this->conn->prepare("SELECT *, CONCAT(tr_fname,' ',tr_midname,' ',tr_lname) as 'tresName' FROM treasurer join accounts on acc_trid=acc_id WHERE acc_trid=:acc_trid");
		$queryTresDetails->execute(array(
			':acc_trid' => $_SESSION['accid']
		));
		if($queryTresDetails->rowCount() > 0){
			while($row=$queryTresDetails->fetch(PDO::FETCH_ASSOC)){
				$data[]=$row;
			}
			return $data;
		}
		return $queryTresDetails;
	}

	public function newPassword($oldPassword, $password, $repassword) {
		$query = $this->conn->prepare("SELECT * FROM accounts WHERE acc_id=?");
		$query->bindParam(1, $_SESSION['accid']);
		$query->execute();
		$user = $query->fetch();
		if ( password_verify($oldPassword, $user['password']) ) {
			if ($password === $repassword) {
				if (strlen($password) >= 8) {
					$hashed = password_hash($password, PASSWORD_DEFAULT);
					$update = $this->conn->prepare("UPDATE accounts SET password = :hashed, acc_details = 'Old' WHERE acc_id = :accid");
					$update->execute(array(
						':hashed' => $hashed,
						':accid' => $_SESSION['accid']
					));
					$_SESSION['acc_details'] = 'Old';
					$this->Message("Success!", "You have successfully changed your password", "success", "treasurer-profile");
				} else {
					$this->Message('Error!',"Invalid password. Password length must be 8 characters and above",'error','treasurer-profile');
				} 
			} else {
				$this->Message('Error!',"Password doesn't match",'error','treasurer-profile');
			}
		}else {
			$this->Message('Error!',"Old Password doesn't match",'error','treasurer-profile');
		}
	}

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
		$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}

	public function getNoOfSevenYrLevelOfStudent() {
		$query = $this->conn->prepare("SELECT * FROM student where year_level='7'");
		$query->execute();
		$rowCount = $query->rowCount();
		echo  " ". $rowCount . " ";
	}

	public function getNoOfEightYrLevelOfStudent() {
		$query = $this->conn->prepare("SELECT * FROM student where year_level='8'");
		$query->execute();
		$rowCount = $query->rowCount();
		echo  " ". $rowCount . " ";
	}

	public function getNoOfNineYrLevelOfStudent() {
		$query = $this->conn->prepare("SELECT * FROM student where year_level='9'");
		$query->execute();
		$rowCount = $query->rowCount();
		echo  " ". $rowCount . " ";
	}

	public function getNoOfTenYrLevelOfStudent() {
		$query = $this->conn->prepare("SELECT * FROM student where year_level='10'");
		$query->execute();
		$rowCount = $query->rowCount();
		echo  " ". $rowCount . " ";
	}

	public function getTotalNoOfStudents() {
		$query = $this->conn->prepare("SELECT * FROM student");
		$query->execute();
		$rowCount = $query->rowCount();
		echo  " ". $rowCount . "";
		
	}

	public function getData() {
		$query = $this->conn->prepare("SELECT bal_status,count(*) from balance join student on balance.stud_idb = student.stud_id where stud_status in ('Officially Enrolled', 'Temporarily Enrolled') group by 1");
		$query->execute();
		$rowCount = $query->rowCount();
		if($rowCount > 0) {
		while($row = $query->fetch()){
			echo  "['" .$row['bal_status']."', " .$row[1]."],"; 
		}   
		} else {
			echo  "No data yet!";
		}
	}    

	public function getNumberOfFullyPaidStudents() {
		$query = $this->conn->prepare("SELECT 
    *
			FROM
			student
			JOIN
			balance ON student.stud_id = balance.stud_idb
			WHERE
			bal_status = 'Cleared' and stud_status IN ('Officially Enrolled','Temporarily Enrolled')
			GROUP BY 1
			");
		$query->execute();
		$rowCount = $query->rowCount();
		if($rowCount > 1){
			echo  "<u> 
			". $rowCount . "
			</u> 
			<span>students</span>";
		}
		else {
			if ($rowCount == 0 || $rowCount == 1) {
				echo  "<u>
				". $rowCount . 
				"</u> 
				<span>student</span>";
			}
		}
	}

	public function getPercentageOfFullyPaidStudents() {
		$query = $this->conn->prepare("SELECT 
    *
			FROM
			student
			JOIN
			balance ON student.stud_id = balance.stud_idb
			WHERE
			bal_status = 'Cleared' and stud_status IN ('Officially Enrolled','Temporarily Enrolled')
			GROUP BY 1
			");
		$query->execute();
		$rowCount = $query->rowCount();

		$query1 = $this->conn->prepare("SELECT * FROM student where stud_status IN ('Officially Enrolled','Temporarily Enrolled')");
		$query1->execute();
		$rowCount1 = $query1->rowCount();
  			if($rowCount1 > 0){
  				$result = $rowCount/$rowCount1*100;
  				echo " ". round(number_format($result, 2)) . " " ;
  			}
  			else {
  				echo " ". number_format(0, 2) . " " ;
  			}
		

		
	}

	public function getNumberOfStudentsWBalance() {
		$query = $this->conn->prepare("SELECT 
									    *
			FROM
			student
			JOIN
			balance ON student.stud_id = balance.stud_idb
			WHERE
			bal_status = 'Not Cleared' and stud_status IN ('Officially Enrolled','Temporarily Enrolled')
			GROUP BY 1");
		$query->execute();
		$rowCount = $query->rowCount();
		if($rowCount > 1){
			echo  "<u> 
			". $rowCount . "
			</u> 
			<span>students</span>";
		}
		else {
			if ($rowCount == 0 || $rowCount == 1) {
				echo  "<u>
				". $rowCount . 
				"</u> 
				<span>student</span>";
			}
		}
	}

	public function getPercentageOfStudentsWBalance() {
		$query = $this->conn->prepare("SELECT 
			*
			FROM
			student
			JOIN
			balance ON student.stud_id = balance.stud_idb
			WHERE
			bal_status = 'Not Cleared' and stud_status IN ('Officially Enrolled','Temporarily Enrolled')
			GROUP BY 1");
		$query->execute();
		$rowCount = $query->rowCount();

		$query1 = $this->conn->prepare("SELECT * FROM student where stud_status IN ('Officially Enrolled','Temporarily Enrolled')");
		$query1->execute();
		$rowCount1 = $query1->rowCount();

		if($rowCount1 > 0) {
		$result = $rowCount/$rowCount1*100;
		echo " ". round(number_format($result, 2)) . " " ;
		}
		else {
			echo " ". number_format(0, 2) . " " ;
		}
	}

	public function getSchoolYear() {
		$query = $this->conn->prepare("SELECT * FROM system_settings where sy_status ='Current'");
		$query->execute();
		$rowCount = $query->fetch();
		$sy_start1 = $rowCount['sy_start'];
		$sy_end1 = $rowCount['sy_end'];
		$sy_start = date('Y', strtotime($sy_start1));
		$sy_end = date('Y', strtotime($sy_end1));
		echo  " ".$sy_start. "-" .$sy_end. " ";
	}

	public function getTotalPayment() {
		$query = $this->conn->prepare("SELECT 
    SUM(pay_amt) AS 'total_amt'
FROM
    payment
        JOIN
    balance ON payment.balb_id = balance.bal_id
        JOIN
    student ON balance.stud_idb = student.stud_id
    WHERE
    stud_status IN ('Officially Enrolled', 'Temporarily Enrolled')");
		$query->execute();
		$rowCount = $query->fetch();
		echo  " ". number_format($rowCount['total_amt'],2) . " ";
	}

	public function getMiscellaneousFee() {
		$query = $this->conn->prepare("SELECT * FROM balance");
		$query->execute();
		$rowCount = $query->fetch();
		echo  " ". number_format($rowCount['misc_fee'],2) . " ";
	}

	public function getSectionAccount(){
		$query = $this->conn->prepare("SELECT * FROM section ORDER BY grade_lvl, sec_name");
		$query->execute();
		$rowCount = $query->rowCount();
		if($rowCount > 0){
			while($row = $query->fetch()) {
				$data[] = $row;
			}	
		} else {
			echo '<option> There are no sections yet. </option>';
		}
		return $data;	
	}

	public function getStatusInfo() {
		$query = "SELECT 
		 bal_status,
		stud_status
		FROM
		(SELECT
		bal_status,
		stud_status
		FROM
		student st
		JOIN
		balance bal ON bal.stud_idb = st.stud_id
        JOIN
        section on st.secc_id = section.sec_id
        GROUP by 1
		UNION
		SELECT 
		bal_status, stud_status
		FROM
		payment p
		INNER JOIN
		payment pm ON p.pay_id = pm.pay_id
		JOIN
		balpay bp ON bp.pay_ida = pm.pay_id
		JOIN
		balance bal on bp.bal_ida = bal.bal_id
		JOIN
		student st ON st.stud_id = bal.stud_idb
        JOIN
        section on st.secc_id = section.sec_id
		GROUP BY 1) al
		where stud_status IN ('Officially Enrolled','Temporarily Enrolled') 
		GROUP BY 1
        ORDER BY 1 desc";
		$q = $this->conn->query($query) or die("failed!");
		if($q->rowCount() > 0) {
			while($r = $q->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		} else {
			return $q;
		}
		return $data;
	}

	public function getPaymentInfo() {
		$query = "SELECT 
		distinct(bal_id) 'bal_id',
		stud_lrno,
		year_level,
		name,
		misc_fee , minbal, bal_status,
		date, stud_id, bal_amt, full_secname
		FROM
		(SELECT DISTINCT
		(bal_id),
		stud_lrno,
		concat(grade_lvl,'-',sec_name) 'year_level',
		CONCAT(first_name, ' ', last_name) AS 'name',
		misc_fee,
		bal_amt 'minbal',
		bal_status, bal_amt, CONCAT('Grade ',grade_lvl,' - ',sec_name) 'full_secname',
		CASE
		WHEN bal.bal_id IN (SELECT balb_id from payment pm join balance bal on pm.balb_id = bal.bal_id) THEN (SELECT 
		DATE_FORMAT(MAX(pm.pay_date), '%M %e, %Y') as 'date'
		FROM
		payment p
		INNER JOIN
		payment pm ON p.pay_id = pm.pay_id
		JOIN
		balpay bp ON bp.pay_ida = pm.pay_id
		JOIN
		balance bala on bp.bal_ida = bala.bal_id
		JOIN
		student st ON st.stud_id = bala.stud_idb
        JOIN
        section on st.secc_id = section.sec_id
		where bal.bal_id = bala.bal_id
		GROUP BY st.first_name
		ORDER by 1)
		ELSE
		'No payment yet'
		END
		AS 'date',
		stud_id,
		stud_status
		FROM
		student st
		JOIN
		balance bal ON bal.stud_idb = st.stud_id
        JOIN
        section on st.secc_id = section.sec_id
		UNION
		SELECT 
		distinct(bal_id),
		stud_lrno,
		concat(grade_lvl,'-',sec_name) 'year_level',
		CONCAT(first_name, ' ', last_name) as 'name',
		misc_fee , MIN(pm.remain_bal) as 'minbal', bal_status, bal_amt, CONCAT('Grade ',grade_lvl,' - ',sec_name) 'full_secname',
		DATE_FORMAT(MAX(pm.pay_date), '%M %e, %Y') as 'date', st.stud_id as 'stud_id', stud_status
		FROM
		payment p
		INNER JOIN
		payment pm ON p.pay_id = pm.pay_id
		JOIN
		balpay bp ON bp.pay_ida = pm.pay_id
		JOIN
		balance bal on bp.bal_ida = bal.bal_id
		JOIN
		student st ON st.stud_id = bal.stud_idb
        JOIN
        section on st.secc_id = section.sec_id
		GROUP BY st.first_name
		ORDER by 1) al
		where stud_status IN ('Officially Enrolled','Temporarily Enrolled') 
		GROUP BY name
		ORDER by 1";
		$q = $this->conn->query($query) or die("failed!");
		if($q->rowCount() > 0) {
			while($r = $q->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		} else {
			return $q;
		}
		return $data;
	}

	public function getBreakdown() {
		$query = $this->conn->prepare("SELECT * from budget_info") or die("failed!");
		$query->execute();
		if($query->rowCount() > 0) {
			while($r = $query->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		} else {
			return $query;
		}
		return $data;
		}

		public function getBreakdownOfFees() {
		$query = $this->conn->prepare("SELECT 
					bii.budget_id,
					total_amount,
					budget_name,
					CASE
					WHEN
					bii.budget_id IN (SELECT 
					budg_ida
					FROM
					payment
					GROUP BY 1)
					THEN
					pm.acc_amount
					WHEN
					bii.budget_id NOT IN (SELECT 
					budg_ida
					FROM
					payment
					GROUP BY 1)
					THEN
					0
					ELSE 0
					END AS 'acc_amount'
					FROM
					budget_info bii
					JOIN
					(SELECT 
					bi.budget_id, SUM(pm.pay_amt) 'acc_amount'
					FROM
					payment pym
					JOIN payment pm ON pym.pay_id = pm.pay_id
					JOIN balance bal ON bal.bal_id = pm.balb_id
					JOIN budget_info bi ON bi.budget_id = pm.budg_ida
					JOIN student st ON st.stud_id = bal.stud_idb
					WHERE
					pym.budg_ida = pm.budg_ida
					AND st.stud_status IN ('Officially Enrolled' , 'Temporarily Enrolled')
					GROUP BY pm.budg_ida) pm ON bii.budget_id = pm.budget_id 
					UNION SELECT 
					budget_id, total_amount, budget_name, acc_amount
					FROM
					budget_info
					WHERE
					budget_id NOT IN (SELECT 
					budg_ida
					FROM
					payment)
					GROUP BY budget_id");
		$query->execute();
		if($query->rowCount() > 0) {
			while($r = $query->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		}
		else{

			return $query;
		}

		return $data;

			
	}

	public function getBreakdownOfFee() {
		$query = $this->conn->prepare("SELECT 
						budget_name,
						CASE
						WHEN
						budget_id NOT IN (SELECT 
						budg_ida
						FROM
						payment
						JOIN
						balance ON payment.balb_id = balance.bal_id
						JOIN
						student ON student.stud_id = balance.stud_idb
						GROUP BY 1)
						THEN
						0
						WHEN
						bii.budget_id IN (SELECT 
						budg_ida
						FROM
						payment
						JOIN
						balance ON payment.balb_id = balance.bal_id
						JOIN
						student ON student.stud_id = balance.stud_idb
						GROUP BY 1)
						THEN
						(SELECT 
						SUM(pay_amt)
						FROM
						budget_info bi
						JOIN
						payment p ON bi.budget_id = p.budg_ida
						JOIN
						balance bal ON bal.bal_id = p.balb_id
						JOIN
						student st ON st.stud_id = bal.stud_idb
						WHERE
						bii.budget_id = bi.budget_id)
						END AS 'total'
						FROM
						budget_info bii
						GROUP by budget_id");
		$query->execute();
		if($query->rowCount() > 0) {
			while($r = $query->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		}
		else{

			return $query;
		}

		return $data;

			
	}

	public function getRange($bal_id) {
		$query = $this->conn->prepare("SELECT 
			budget_id, (total_amount - SUM(pm.pay_amt)) 'max', budget_name
			FROM
			payment p
			INNER JOIN
			payment pm ON p.pay_id = pm.pay_id
			JOIN
			balpay bp ON bp.pay_ida = pm.pay_id
			JOIN
			balance bal on bp.bal_ida = bal.bal_id
			JOIN
			student st ON st.stud_id = bal.stud_idb
			JOIN
			budget_info bi on bi.budget_id = p.budg_ida
			where bal_id = :bal_id group by budget_name") or die("failed!");
		$query->execute(array(":bal_id" => $bal_id)) ;
		$noOfRows = $query->rowCount();
		$data = array();
		 if ($noOfRows > 0) {
			while($r = $query->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $r;
			}

		} else {
			$sql = $this->conn->query("SELECT 
				budget_id, total_amount as 'max', budget_name
				FROM budget_info");
			$sql->execute();
			while($r = $sql->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $r;
			}
		}
		
		return $data;
	}

	public function getTotalFund() {
		$query = $this->conn->prepare("SELECT 
    SUM(pay_amt) AS 'total_amt'
FROM
    payment
        JOIN
    balance ON payment.balb_id = balance.bal_id
        JOIN
    student ON balance.stud_idb = student.stud_id
    WHERE
    stud_status IN ('Officially Enrolled', 'Temporarily Enrolled')");
		$query->execute();
		$rowCount = $query->rowCount();
		if($rowCount > 0)
			while($row = $query->fetch()) {
				echo "&#x20B1;" .number_format($row[0],2). "";
			}

		}

		public function getTotalBDOF() {
			$query = $this->conn->prepare("SELECT sum(total_amount) from budget_info");
			$query->execute();
			$rowCount = $query->rowCount();
			if($rowCount > 0)
				while($row = $query->fetch()) {
					echo "&#x20B1;" .number_format($row[0],2). "";
				}

			}


			public function updateFees($post) {
				$checkInputs = false;
				for($x = 0; $x < count($post['payment']); $x++) {
					if ($post['payment'][$x] !== '0' && $post['payment'][$x] !== 'Cleared') {
						$checkInputs = true;
						break;
					}
				}
				if ($checkInputs === true) {
					$today = date("Y-m-d");
					$input_values = array();
					$name = $post['name'];
					$budget_id = array();
					$query = $this->conn->query("SELECT budget_id, budget_name FROM budget_info ORDER BY budget_id");
					$result = $query->fetchAll();
					for ($c = 0; $c < count($post['payment']); $c++) {
						if ($post['payment'][$c] != 0 && $post['payment'][$c] !== 'Cleared') {
							$input_values[] = $post['payment'][$c];
							$budget_id[] = $post['budget_id'][$c];
						} 
					}
					for ($c = 0; $c < count($input_values); $c++) {
					$update_am = 'UPDATE budget_info JOIN (SELECT acc_amount FROM budget_info WHERE budget_id = '.$budget_id[$c].') table2 SET budget_info.acc_amount = ('.$input_values[$c].' + table2.acc_amount) WHERE budget_id = '.$budget_id[$c].';';
						$insert = 'INSERT INTO payment (pay_amt, remain_bal, pay_date, orno, balb_id, budg_ida) VALUES (';
						$insert .= $input_values[$c];
						$insert .= ', (SELECT min_bal - '.$input_values[$c].' from (SELECT bal_id, CASE
										    WHEN
										    bal_id NOT IN (SELECT 
										                balb_id
										            FROM
										                    payment
										                GROUP BY 1)
										        THEN
										            (SELECT 
										                    bal_amt
										                FROM
										                    balance bal
										                        JOIN
										                    student st ON bal.stud_idb = st.stud_id
										                WHERE
										                    bal_id = '.$post['bal_id'].'
										                        AND stud_status IN (\'Officially Enrolled\' , \'Temporarily Enrolled\'))
										        WHEN
										            bal_id IN (SELECT 
										                    balb_id
										                FROM
										                    payment
										                GROUP BY 1)
										        THEN
										            (SELECT 
										                    MIN(pm.remain_bal)
										                FROM
										                    payment p
										                        INNER JOIN
										                    payment pm ON p.pay_id = pm.pay_id
										                        JOIN
										                    balance bal ON pm.balb_id = bal.bal_id
										                        JOIN
										                    student st ON st.stud_id = bal.stud_idb
										                WHERE
										                    bal_id = '.$post['bal_id'].'
										                        AND stud_status IN (\'Officially Enrolled\' , \'Temporarily Enrolled\'))
										    END as \'min_bal\'
										    from balance
										    UNION
										    SELECT 
										                    bal_id, MIN(pm.remain_bal)
										                FROM
										                    payment p
										                        INNER JOIN
										                    payment pm ON p.pay_id = pm.pay_id
										                        JOIN
										                    balance bal ON pm.balb_id = bal.bal_id
										                        JOIN
										                    student st ON st.stud_id = bal.stud_idb
										                WHERE
										                    bal_id = '.$post['bal_id'].'
										                        AND stud_status IN (\'Officially Enrolled\' , \'Temporarily Enrolled\')) pm
										                        where bal_id ='.$post['bal_id'].'
										                        GROUP by 1 desc limit 1)';
						$insert .= ', \''.$post['pay_date'].'\'';
						$insert .= ', \''.$post['orno'].'\'';
						$insert .= ', '.$post['bal_id'].'';
						$insert .= ', '.$budget_id[$c].'';
						$insert .= ');';
						$insert_bp = 'INSERT INTO balpay (bal_ida, pay_ida) VALUES ('.$post['bal_id'].', (SELECT MAX(pm.pay_id) from payment pm join payment p on pm.pay_id = p.pay_id join balance on pm.balb_id = balance.bal_id where bal_id = '.$post['bal_id'].'));';

							$q1 = $this->conn->query($update_am) or die($this-> prompt("red", "Error adding payment1.", "treasurer-accounts"));
							$q2 = $this->conn->query($insert) or die($this-> prompt("red", "Error adding payment2.", "treasurer-accounts"));
							$q3 = $this->conn->query($insert_bp) or die($this-> prompt("red", "Error adding payment3.", "treasurer-accounts"));
						}
						$update_bf = 'UPDATE balance join (SELECT SUM(pm.pay_amt) \'total\', bal_amt FROM payment pm JOIN payment p ON pm.pay_id = p.pay_id JOIN balance ON pm.balb_id = balance.bal_id WHERE pm.balb_id = '.$post['bal_id'].' GROUP by pm.orno ORDER BY MAX(pm.timestamp_pm) desc limit 1) t2 SET balance.bal_amt
								= (t2.bal_amt - t2.total) where bal_id = '.$post['bal_id'].';';
							$check_bal = 'SELECT bal_amt FROM payment pm JOIN payment p ON pm.pay_id = p.pay_id JOIN balance ON pm.balb_id = balance.bal_id WHERE pm.balb_id = '.$post['bal_id'].' GROUP by pm.orno ORDER BY MAX(pm.pay_date) desc limit 1';
							$insert_logs ='INSERT INTO logs (log_date, log_event, log_desc, user_id) VALUES(\''.$today.'\',\'Insert\', 	
						\'Added payment for '.$name.'\', '.$_SESSION['accid'].')';
						$update_ba = 'UPDATE balance SET bal_status = \'Cleared\' where bal_id ='.$post['bal_id'].';';
							$q4 = $this->conn->query($update_bf) or die($this-> prompt("red", "Error adding payment4.", "treasurer-accounts"));
							$q5 = $this->conn->query($insert_logs) or die  ($this->prompt("red", "Error adding payment5.", "treasurer-accounts"));

							$q6 = $this->conn->prepare($check_bal) or die('failed!');
							$q6->execute();
							$result = $q6->fetch();
							$balance = $result['bal_amt'];
							if($balance === "0") {
								$q7 = $this->conn->query($update_ba) or die($this->prompt("red", "Error adding payment6.", "treasurer-accounts"));
							}

						$this->Message('Success!', 'Added payment for '.$name.'', 'success', 'treasurer-accounts');
					} else {
						$this->Message('Error!', 'You did not input any payment!', 'error', 'treasurer-accounts');
					}
				}
				
			public function getBudgetName() {
				$sql = $this->conn->query("SELECT budget_name FROM budget_info");
				$result = $sql->fetchAll();
				return $result;
			}

			public function getStats($yr_level) {
				if($yr_level === "All") {
					$query = $this->conn->prepare("SELECT 
						budget_name,
						CASE
						WHEN
						budget_id NOT IN (SELECT 
						budg_ida
						FROM
						payment
						JOIN
						balance ON payment.balb_id = balance.bal_id
						JOIN
						student ON student.stud_id = balance.stud_idb
						GROUP BY 1)
						THEN
						0
						WHEN
						bii.budget_id IN (SELECT 
						budg_ida
						FROM
						payment
						JOIN
						balance ON payment.balb_id = balance.bal_id
						JOIN
						student ON student.stud_id = balance.stud_idb
						GROUP BY 1)
						THEN
						(SELECT 
						SUM(pay_amt)
						FROM
						budget_info bi
						JOIN
						payment p ON bi.budget_id = p.budg_ida
						JOIN
						balance bal ON bal.bal_id = p.balb_id
						JOIN
						student st ON st.stud_id = bal.stud_idb
						WHERE
						bii.budget_id = bi.budget_id)
						END AS 'total'
						FROM
						budget_info bii
						");
				} else {
					$query = $this->conn->prepare("SELECT 
					budget_name,
					CASE
					WHEN
					budget_id NOT IN (SELECT 
					budg_ida
					FROM
					payment
					JOIN
					balance ON payment.balb_id = balance.bal_id
					JOIN
					student ON student.stud_id = balance.stud_idb
					WHERE
					year_level = '".$yr_level."' and stud_status IN ('Officially Enrolled', 'Temporarily Enrolled')
					GROUP BY 1)
					THEN
					0
					WHEN
					bii.budget_id IN (SELECT 
					budg_ida
					FROM
					payment
					JOIN
					balance ON payment.balb_id = balance.bal_id
					JOIN
					student ON student.stud_id = balance.stud_idb
					WHERE
					year_level = '".$yr_level."'  and stud_status IN ('Officially Enrolled', 'Temporarily Enrolled')
					GROUP BY 1)
					THEN
					(SELECT 
					SUM(pay_amt)
					FROM
					budget_info bi
					JOIN
					payment p ON bi.budget_id = p.budg_ida
					JOIN
					balance bal ON bal.bal_id = p.balb_id
					JOIN
					student st ON st.stud_id = bal.stud_idb
					WHERE
					bii.budget_id = bi.budget_id
					AND year_level = '".$yr_level."' and stud_status IN ('Officially Enrolled', 'Temporarily Enrolled'))
					END AS 'total'
					FROM
					budget_info bii");
				}
				$query->execute();
				$data = array();	
				while($r = $query->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				return $data;
			}

			public function getStatistics($yr_level) {
				if($yr_level === "All") {
					$query = $this->conn->prepare("SELECT 
						budget_name,
						CASE
						WHEN
						budget_id NOT IN (SELECT 
						budg_ida
						FROM
						payment
						JOIN
						balance ON payment.balb_id = balance.bal_id
						JOIN
						student ON student.stud_id = balance.stud_idb
						GROUP BY 1)
						THEN
						0
						WHEN
						bii.budget_id IN (SELECT 
						budg_ida
						FROM
						payment
						JOIN
						balance ON payment.balb_id = balance.bal_id
						JOIN
						student ON student.stud_id = balance.stud_idb
						GROUP BY 1)
						THEN
						(SELECT 
						SUM(pay_amt)
						FROM
						budget_info bi
						JOIN
						payment p ON bi.budget_id = p.budg_ida
						JOIN
						balance bal ON bal.bal_id = p.balb_id
						JOIN
						student st ON st.stud_id = bal.stud_idb
						WHERE
						bii.budget_id = bi.budget_id)
						END AS 'total'
						FROM
						budget_info bii
						");
				} else {
					$query = $this->conn->prepare("SELECT 
					budget_name,
					CASE
					WHEN
					budget_id NOT IN (SELECT 
					budg_ida
					FROM
					payment
					JOIN
					balance ON payment.balb_id = balance.bal_id
					JOIN
					student ON student.stud_id = balance.stud_idb
					WHERE
					year_level = '".$yr_level."' and stud_status IN ('Officially Enrolled', 'Temporarily Enrolled')
					GROUP BY 1)
					THEN
					0
					WHEN
					bii.budget_id IN (SELECT 
					budg_ida
					FROM
					payment
					JOIN
					balance ON payment.balb_id = balance.bal_id
					JOIN
					student ON student.stud_id = balance.stud_idb
					WHERE
					year_level = '".$yr_level."'  and stud_status IN ('Officially Enrolled', 'Temporarily Enrolled')
					GROUP BY 1)
					THEN
					(SELECT 
					SUM(pay_amt)
					FROM
					budget_info bi
					JOIN
					payment p ON bi.budget_id = p.budg_ida
					JOIN
					balance bal ON bal.bal_id = p.balb_id
					JOIN
					student st ON st.stud_id = bal.stud_idb
					WHERE
					bii.budget_id = bi.budget_id
					AND year_level = '".$yr_level."' and stud_status IN ('Officially Enrolled', 'Temporarily Enrolled'))
					END AS 'total'
					FROM
					budget_info bii");
				}
				
				$query->execute();
				$rowCount = $query->rowCount();
				$script = '';
				if($rowCount > 0) {
					while($row = $query->fetch()){
						$script .=  "['" .$row['budget_name']."', " .$row['total'].', \'#008080\''."],"; 
					} 	
				} else {
					$script .=  "";
				}
				return $script;
			} 

			public function getYearLevel() {
				$query =$this->conn->prepare("SELECT sched_yrlevel FROM schedule") or die ("failed");
				$query->execute();
				while($r = $query->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				return $data;
			}

			private function prompt($color, $message, $newUrl){

				echo "<div data-type='message' style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999999; overflow: hidden;'>
				<div style='width:100%; padding: 17px 0; background: ".$color."; color: #fff;'>
				<div class='modal-box' style='width: 100%;'>
				<p style='margin: 0; font-size: 16px;'>".$message." Wait <span class='count'>5</span> seconds or <a style='color: #4b4bff; text-decoration: underline;' href='".$newUrl."'>Click here</a></p>
				</div>
				</div>
				</div>
				<script>
				$('div[data-type=message]').appendTo('body');
				$('div[id*=\"_home\"]').addClass('modal-enabled');
				var sec = 4;
				var timer = setInterval(function() {
					$('.modal-box .count').text(sec--);
					if (sec == -1 ) {
						clearInterval(timer);
					}
					}, 1000);
					setTimeout(function(){
						window.location = '".$newUrl."';
						}, 5000);
						</script>";
						
			}

			public function Message($title, $message, $type, $page) {
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

			public function showEvents(){
		$sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e, %Y') as date_start_1, DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, date_start, date_end, post, view_lim, attachment FROM announcements WHERE (view_lim like '%0%' or view_lim like '%4%') AND title IS NOT NULL AND holiday='No'") or die ("failed!");
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
		$sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e') as date_start_1,  DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, DAY(CURDATE()), DAY(date_start) FROM announcements WHERE (view_lim like '%0%' or view_lim like '%4%') AND title IS NOT NULL AND holiday='Yes' AND (date_start between now() and adddate(now(), +15))") or die ("failed!");
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
		$sql = $this->conn->prepare("SELECT * FROM announcements WHERE (view_lim like '%0%' or view_lim like '%4%') AND post IS NOT NULL") or die ("failed!");
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

	//STUDENTS WITH BALANCE
	public function getPrevMiscFee() {
	$query = $this->conn->prepare("SELECT misc_fee, prev_sy FROM balance_archive GROUP by 2");
	$query->execute();
	foreach($query->fetchAll() as $rowCount){
	echo  "<span class=\"wmiscfee\" data-miscfee=".$rowCount['prev_sy'].">&#x20B1;". number_format($rowCount['misc_fee'],2) . "</span>";	
	}
	}


	public function getStudWBalance() {
	$sql = $this->conn->prepare("SELECT CONCAT(first_name,' ', last_name) 'name', bal_amt 'minbal', CASE WHEN bal_date = '0000-00-00 00:00:00' THEN 'No payment yet' ELSE DATE_FORMAT((bal_date), '%M %e, %Y') END 'date',bal_or 'orno', CONCAT(balance_archive.year_level,'-', section) 'year_level', stud_archive 'stud_id', bal_status, prev_sy from balance_archive join student on stud_archive = stud_id where stud_status !='Transferred'") or die ("failed!");
	$sql->execute();
	if($sql->rowCount()>0){
		while($r = $sql->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}
		return $data;
	}
	return $sql;
	}

	public function updateBalance($post) {
		$getStudInfo = $this->conn->prepare("SELECT CONCAT(first_name, ' ', middle_name, ' ', last_name) as stud_fullname FROM student WHERE stud_id = :id");
		$getStudInfo->execute(array(
			':id' => $post['stud_id']
		));
		$student = $getStudInfo->fetch();
		$bd = $this->getArchivedBreakDown($post['stud_id']);
		$pay = array_map('intval', $post['payment']);
		$temp_name = array();
		$temp_pay = array();
		$checker = false;
		foreach($pay as $test) {
			if ($test !== 0) {
				$checker = true;
			}
		}
		if ($checker === true) {
			for($c = 0; $c < count($post['payment']); $c++) {
				if ($pay[$c] > 0) {
					$fund_type = '%'.$bd[$c]['fee_type'].'%';
					$getPrevAmmt = $this->conn->prepare("SELECT bd_accamount FROM payment_collected WHERE bd_name LIKE :name");
					$getPrevAmmt->execute(array(
						':name' => $fund_type
					));
					$res = $getPrevAmmt->fetch();
					$oldAmt = (int) $res['bd_accamount'];
					if (($pay[$c] - $bd[$c]['fee_bal']) !== 0) {
						$newValue = $bd[$c]['fee_bal'] - $pay[$c];
						$temp_name[] = $bd[$c]['fee_type'];
						$temp_pay[] = $newValue;
						$addToCollected = $this->conn->prepare("UPDATE payment_collected SET bd_accamount = :am WHERE bd_name LIKE :name");
						$addToCollected->execute(array(
							':am' => ($oldAmt + $pay[$c]),
							':name' => $fund_type
						));
						$this->createLog('Update', 'A total of '.$pay[$c].' was added to '.$bd[$c]['fee_type'].'.');
					} else {
						$addToCollected = $this->conn->prepare("UPDATE payment_collected SET bd_accamount = :am WHERE bd_name LIKE :name");
						$addToCollected->execute(array(
							':am' => ($oldAmt + $pay[$c]),
							':name' => $fund_type
						));
						$this->createLog('Update', 'A total of '.$pay[$c].' was added to '.$bd[$c]['fee_type'].'.');
					}
				} else {
					$temp_name[] = $bd[$c]['fee_type'];
					$temp_pay[] = $bd[$c]['fee_bal'];
				}
			}
			if(!empty($temp_name)) {
				$ar = array();
				$ar['name'] = implode(',',$temp_name);
				$ar['n_pay'] = implode(',',$temp_pay);
				$new_bal = implode(';',$ar);
				$partial = $this->conn->prepare("UPDATE balance_archive SET bal_or = :orno, fund_bal = :new, bal_amt = :new_baltot WHERE stud_archive = :id");
				$partial->execute(array(
					':orno' => $post['orno'],
					':new' => $new_bal,
					':new_baltot' => array_sum($temp_pay),
					':id' => $post['stud_id']
				));
				$this->createLog('Update', 'A total of '.array_sum($pay).' was paid for '.$student['stud_fullname'].'.');
				$this->Message('Success!', 'Added payment for '.$student['stud_fullname'], 'success', 'treasurer-balance');
			} else {
				$full = $this->conn->prepare("UPDATE balance_archive SET bal_status = 'Cleared', bal_or = :orno, fund_bal = NULL, bal_amt = 0 WHERE stud_archive = :id");
				$full->execute(array(
					':orno' => $post['orno'],
					':id' => $post['stud_id']
				));
				$this->createLog('Update', 'A total of '.array_sum($pay).' was paid for '.$student['stud_fullname'].'.');
				$this->Message('Success!', 'Added payment for '.$student['stud_fullname'], 'success', 'treasurer-balance');
			}
		} else {
			$this->Message('Error!', 'Please add any payment.', 'error', 'treasurer-balance');
		}
	}

	private function createLog($type, $desc) {
		$query = $this->conn->prepare("INSERT INTO logs (log_event, log_desc, user_id) VALUES (:ev, :des, :id)");
		$query->execute(array(
			':ev' => $type,
			':des' => $desc,
			':id' => $_SESSION['accid']
		)) or ('error');
	}

	private function getArchivedBreakDown($stud_id) {
		$query = $this->conn->prepare("SELECT fund_bal FROM balance_archive WHERE stud_archive = :id");
		$query->execute(array(
			':id' => $stud_id
		));
		$result = $query->fetch();
		$sample_fee = $result['fund_bal'];
		$explode_fee = explode(';',$sample_fee);
		$explode_type = explode(',',$explode_fee[0]);
		$explode_bal = array_map('intval', explode(',', $explode_fee[1]));
		$new = array();
		for($c = 0; $c < count($explode_type); $c++) {
			$new[] = array(
				'fee_type' => $explode_type[$c],
				'fee_bal' => $explode_bal[$c]
			);
		}
		return $new;
	}

			public function getBDOFYear(){
				$query =$this->conn->prepare("SELECT bd_prevsy from payment_collected GROUP by 1 ORDER BY 1 desc") or die ("failed");
				$query->execute();
				if($query->rowCount() > 0){
					while($r = $query->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
			} else {
				 echo '<option> There are no previous school year. </option>';
			}
				
				return $data;
			}

			public function getPrevBDOF(){
				$query =$this->conn->prepare("SELECT bd_name, bd_amountalloc, bd_accamount, bd_prevsy from payment_collected") or die ("failed");
				$query->execute();
				if($query->rowCount() >0){
					while($r = $query->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
			} else {
				return $query;
			}
				
				return $data;
			}

			public function getPrevBDOFYear($year){
				$query =$this->conn->prepare("SELECT bd_name, bd_amountalloc, bd_accamount, bd_prevsy from payment_collected where bd_prevsy ='".$year."' GROUP by 1") or die ("failed");
				$query->execute();
				$script = '';
				$rowCount = $query->rowCount();
				if($rowCount > 0) {
					while($row = $query->fetch()){
						$script .=  "['" .$row['bd_name']."', " .$row['bd_accamount'].', \'#008080\''."],"; 
					} 	
				} else {
					$script .=  "";
				}
				return $script;
			}

			public function getPrevBDOFYearOnly(){
				$query =$this->conn->prepare("SELECT bd_prevsy from payment_collected GROUP by 1 ORDER BY 1 desc") or die ("failed");
				$query->execute();
				if($query->rowCount() >0) {
					return $query->fetchAll();
				} else {
					return $query;
				}
			}

			public function getBalYear(){
				$query =$this->conn->prepare("SELECT prev_sy, misc_fee from balance_archive GROUP by 1 ORDER by 1 desc") or die ("failed");
				$query->execute();
				if($query->rowCount() > 0){
					while($r = $query->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
			} else {
				echo '<option> There are no previous school year. </option>';
			}
				
				return $data;
			}

			public function getHistoStats(){
				$query =$this->conn->prepare("SELECT bd_name, bd_accamount, bd_prevsy from payment_collected GROUP by 1;") or die ("failed");
				$query->execute();
				$rowCount = $query->rowCount();
				if($rowCount > 0) {
					while($row = $query->fetch()){
						echo  "['" .$row['bd_name']."', " .$row['bd_accamount']."],"; 
					} 	
				} else {
					return $query;
					echo  "['0', '0']";
				}
			}

			public function getBDOF(){

				$query =$this->conn->prepare("SELECT bd_name, bd_accamount, bd_prevsy from payment_collected GROUP by 1") or die ("failed");
				$query->execute();
				if($query->rowCount() > 0){
					while($r = $query->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
			} else {
				return $query;
				return $bd_name ='No result yet.';
			}
				
				return $data;
			}

			public function getBDOFCount(){

				$query =$this->conn->prepare("SELECT bd_name, bd_accamount, bd_prevsy from payment_collected GROUP by 1") or die ("failed");
				$query->execute();
				if($query->rowCount() > 0){
					$rowCount = $query->rowCount();
					return $rowCount;
				}
				 else {
				return $query && 0;
			}
				
			
			}

			public function getPrevBalStat() {
		$query = "SELECT bal_status from balance_archive GROUP by 1";
		$q = $this->conn->query($query) or die("failed!");
		if($q->rowCount() > 0) {
			while($r = $q->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		} else {
			return $q;
		}
		return $data;
	}

		public function getTotalBudgetAmount() {
		$query = $this->conn->prepare("SELECT SUM(acc_amount) 'total' from budget_info");
		$query->execute();
		$rowCount = $query->rowCount();
		if($rowCount > 0) {
		while($row = $query->fetch()){
			echo  "<span> &#x20B1;".number_format($row['total'],2)."</span>"; 
		}   
		} else {
			echo  "No data yet!";
		}
	}    

	public function getTotalBDOFAmount() {
		$query = $this->conn->prepare("SELECT SUM(bd_accamount) 'total', bd_prevsy from payment_collected GROUP by 2");
		$query->execute();
		foreach($query->fetchAll() as $rowCount){
		echo  "<span class=\"wtotal\" data-wtotal=".$rowCount['bd_prevsy'].">&#x20B1;". number_format($rowCount['total'],2) . "</span>";	
		}
	}  

	public function getFundBal($stud_id){
		$query =$this->conn->prepare("SELECT fund_bal from balance_archive where stud_archive = ".$stud_id."") or die ("failed");
		$query->execute();
		if($query->rowCount() >0){
			while($r = $query->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
		} else {
			return $query;
		}
		return $data;
	} 

}

?>