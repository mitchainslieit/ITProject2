<?php
require 'app/model/connection.php';
class TreasurerFunc {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
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
  				echo " ". number_format($result, 2) . " " ;
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
		echo " ". number_format($result, 2) . " " ;
		}
		else {
			echo " ". number_format(0, 2) . " " ;
		}
	}

	public function getSchoolYear() {
		$query = $this->conn->prepare("SELECT school_year 'sy' FROM student group by 1");
		$query->execute();
		$rowCount = $query->fetch();
		$rowCount1 = $rowCount['sy'] + 1;
		echo  " ". $rowCount['sy'] . "-" . $rowCount1 . " ";
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

	public function getPaymentInfo() {
		$query = "SELECT 
		distinct(bal_id) 'bal_id',
		stud_lrno,
		year_level,
		name,
		misc_fee , minbal, bal_status,
		date, stud_id, bal_amt
		FROM
		(SELECT DISTINCT
		(bal_id),
		stud_lrno,
		year_level,
		CONCAT(first_name, ' ', last_name) AS 'name',
		misc_fee,
		bal_amt 'minbal',
		bal_status, bal_amt,
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
		UNION
		SELECT 
		distinct(bal_id),
		stud_lrno,
		year_level,
		CONCAT(first_name, ' ', last_name) as 'name',
		misc_fee , MIN(pm.remain_bal) as 'minbal', bal_status, bal_amt,
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
		GROUP BY st.first_name
		ORDER by 1) al
		where stud_status IN ('Officially Enrolled','Temporarily Enrolled') and bal_status ='Not Cleared'
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
					payment
					GROUP BY 1)
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
						$update_bf = 'UPDATE BALANCE join (SELECT SUM(pm.pay_amt) \'total\', bal_amt FROM payment pm JOIN payment p ON pm.pay_id = p.pay_id JOIN balance ON pm.balb_id = balance.bal_id WHERE pm.balb_id = '.$post['bal_id'].' GROUP by pm.orno ORDER BY MAX(pm.pay_date) desc limit 1) t2 SET balance.bal_amt
								= (t2.bal_amt - t2.total) where bal_id = '.$post['bal_id'].';';
							$check_bal = 'SELECT bal_amt FROM payment pm JOIN payment p ON pm.pay_id = p.pay_id JOIN balance ON pm.balb_id = balance.bal_id WHERE pm.balb_id = '.$post['bal_id'].' GROUP by pm.orno ORDER BY MAX(pm.pay_date) desc limit 1';
							$insert_logs ='INSERT INTO logs (log_date, log_event, log_desc, user_id) VALUES(\''.$today.'\',\'Insert\', 	
						\'Added payment for '.$name.'\', '.$_SESSION['accid'].')';
						$update_ba = 'UPDATE BALANCE SET bal_status = \'Cleared\' where bal_id ='.$post['bal_id'].';';
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
				if($rowCount > 0) {
					while($row = $query->fetch()){
						echo  "['" .$row['budget_name']."', " .$row['total']."],"; 
					} 	
				} else {
					return $query;
					echo  "['0', '0']";
				}
				
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
			$html .= $row['attachment'] !== null ? '<p class="tright attachment"><a href="public/attachment/'.$row['attachment'].'" download">Download attachemt</a></p>' : '';
			$html .= '</td>';
			$html .= '</tr>';
			echo $html;
		}
	}
	}

						?>