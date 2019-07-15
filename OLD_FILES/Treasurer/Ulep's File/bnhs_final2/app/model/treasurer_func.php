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
		while($row = $query->fetch()){
			echo  "['" .$row['bal_status']."', " .$row[1]."],"; 
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

		$result = $rowCount/$rowCount1*100;

		echo " ". $result . " " ;
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

		$result = $rowCount/$rowCount1*100;

		echo " ". $result . " " ;
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

	public function getAnnouncements() {
		$query = $this->conn->prepare("SELECT DATE_FORMAT(date(date_start), '%M %e %Y'), post from announcements an join accounts ac on an.post_adminid = ac.acc_id");
		$query->execute();
		$rowCount = $query->rowCount();
		if($rowCount > 0){
			while($row = $query->fetch()) {
				echo " 
				<tr>
				<td> ".$row[0]." </td> 
				<td> ".$row['post']." </td>
				</tr>
				";	
			}
		}else{
			echo "No announcements yet.";
		}
		
	}

	public function getPaymentInfo() {
		$query = "SELECT 
		distinct(bal_id),
		stud_lrno,
		year_level,
		name,
		misc_fee , minbal, bal_status,
		date, stud_id
		FROM
		(SELECT DISTINCT
		(bal_id),
		stud_lrno,
		year_level,
		CONCAT(first_name, ' ', last_name) AS 'name',
		misc_fee,
		bal_amt 'minbal',
		bal_status,
		CASE
		WHEN bal.bal_id IN (SELECT balb_id from payment pm join balance bal on pm.balb_id = bal.bal_id) THEN (SELECT 
		DATE_FORMAT(MAX(pm.pay_date), '%M %e %Y') as 'date'
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
		misc_fee , MIN(pm.remain_bal) as 'minbal', bal_status,
		DATE_FORMAT(MAX(pm.pay_date), '%M %e %Y') as 'date', st.stud_id as 'stud_id', stud_status
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
		$query = "SELECT * from budget_info";
		$q = $this->conn->query($query) or die("failed!");
		while($r = $q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
		}

		return $data;

	}


	public function getBreakdownOfFees() {
		$query = "SELECT budget_id, budget_name, total_amount,acc_amount from budget_info";
		$q = $this->conn->query($query) or die("failed!");
		while($r = $q->fetch(PDO::FETCH_ASSOC)){
			$data[]=$r;
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
		while($r = $query->fetch(PDO::FETCH_ASSOC)) {
			$data[] = $r;
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


			public function updateFees($bal_id, $pay_date, $orno, $ptafund, $utility, $internetforstudents, $schoolpaper, $organizationsfee, $tlefee, $ssgfee, $sciencefee) {
				$date_created=date('Y-m-d H:i:s');
				/*pta fund*/
				$query1 = $this->conn->prepare("UPDATE budget_info JOIN (SELECT acc_amount FROM budget_info WHERE budget_id = '1') table2 SET budget_info.acc_amount = (:ptafund + table2.acc_amount) WHERE budget_id = '1'");
				$query1->execute(array( ':ptafund' => $ptafund ));
				$query2 = $this->conn->prepare("INSERT INTO payment (pay_amt,remain_bal,pay_date,orno,timestamp_pm, balb_id, budg_ida) VALUES (:ptafund,(SELECT 
					(MIN(pm.remain_bal) - :ptafund1) as 'minbal'
					FROM
					payment p
					INNER JOIN
					payment pm ON p.pay_id = pm.pay_id
					JOIN
					balance bal ON pm.balb_id = bal.bal_id
					JOIN
					student st ON st.stud_id = bal.stud_idb
					where bal_id = :bal_id), :pay_date, :orno, :date_created, :bal_id1, 1)");
				$query2->execute(array( 
					':ptafund' => $ptafund, 
					':ptafund1' => $ptafund,
					':bal_id' => $bal_id, 
					':pay_date' => $pay_date, 
					':orno' => $orno,
					':date_created' => $date_created,
					':bal_id1' => $bal_id));	
				$query3 = $this->conn->prepare("INSERT INTO balpay (bal_ida, pay_ida) VALUES (:bal_id, (SELECT MAX(pm.pay_id) from payment pm join payment p on pm.pay_id = p.pay_id join balance on pm.balb_id = balance.bal_id where bal_id = :bal_id))");
				$query3->execute(array(':bal_id' => $bal_id));

				/*utility fund*/
				$query4 = $this->conn->prepare("UPDATE budget_info JOIN (SELECT acc_amount FROM budget_info WHERE budget_id = '2') table2 SET budget_info.acc_amount = (:utility + table2.acc_amount) WHERE budget_id = '2'");
				$query4->execute(array( ':utility' => $utility ));
				$query5 = $this->conn->prepare("INSERT INTO payment (pay_amt,remain_bal,pay_date,orno,timestamp_pm, balb_id, budg_ida) VALUES (:utility,(SELECT 
					(MIN(pm.remain_bal) - :utility1) as 'minbal'
					FROM
					payment p
					INNER JOIN
					payment pm ON p.pay_id = pm.pay_id
					JOIN
					balance bal ON pm.balb_id = bal.bal_id
					JOIN
					student st ON st.stud_id = bal.stud_idb
					where bal_id = :bal_id), :pay_date, :orno, :date_created, :bal_id1, 2)");
				$query5->execute(array( 
					':utility' => $utility, 
					':utility1' => $utility,
					':bal_id' => $bal_id, 
					':pay_date' => $pay_date, 
					':orno' => $orno,
					':date_created' => $date_created,
					':bal_id1' => $bal_id));	
				$query6 = $this->conn->prepare("INSERT INTO balpay (bal_ida, pay_ida) VALUES (:bal_id, (SELECT MAX(pm.pay_id) from payment pm join payment p on pm.pay_id = p.pay_id join balance on pm.balb_id = balance.bal_id where bal_id = :bal_id))");
				$query6->execute(array(':bal_id' => $bal_id));

				/*internet for students*/
				$query7 = $this->conn->prepare("UPDATE budget_info JOIN (SELECT acc_amount FROM budget_info WHERE budget_id = '3') table2 SET budget_info.acc_amount = (:internetforstudents + table2.acc_amount) WHERE budget_id = '3'");
				$query7->execute(array( ':internetforstudents' => $internetforstudents ));
				$query8 = $this->conn->prepare("INSERT INTO payment (pay_amt,remain_bal,pay_date,orno,timestamp_pm, balb_id, budg_ida) VALUES (:internetforstudents,(SELECT 
					(MIN(pm.remain_bal) - :internetforstudents1) as 'minbal'
					FROM
					payment p
					INNER JOIN
					payment pm ON p.pay_id = pm.pay_id
					JOIN
					balance bal ON pm.balb_id = bal.bal_id
					JOIN
					student st ON st.stud_id = bal.stud_idb
					where bal_id = :bal_id), :pay_date, :orno, :date_created, :bal_id1, 3)");
				$query8->execute(array( 
					':internetforstudents' => $internetforstudents, 
					':internetforstudents' => $internetforstudents,
					':bal_id' => $bal_id, 
					':pay_date' => $pay_date, 
					':orno' => $orno,
					':date_created' => $date_created,
					':bal_id1' => $bal_id));	
				$query9 = $this->conn->prepare("INSERT INTO balpay (bal_ida, pay_ida) VALUES (:bal_id, (SELECT MAX(pm.pay_id) from payment pm join payment p on pm.pay_id = p.pay_id join balance on pm.balb_id = balance.bal_id where bal_id = :bal_id))");
				$query9->execute(array(':bal_id' => $bal_id));

				/*school paper*/
				$query10 = $this->conn->prepare("UPDATE budget_info JOIN (SELECT acc_amount FROM budget_info WHERE budget_id = '4') table2 SET budget_info.acc_amount = (:schoolpaper + table2.acc_amount) WHERE budget_id = '4'");
				$query10->execute(array( ':schoolpaper' => $schoolpaper ));
				$query11 = $this->conn->prepare("INSERT INTO payment (pay_amt,remain_bal,pay_date,orno,timestamp_pm, balb_id, budg_ida) VALUES (:schoolpaper,(SELECT 
					(MIN(pm.remain_bal) - :schoolpaper1) as 'minbal'
					FROM
					payment p
					INNER JOIN
					payment pm ON p.pay_id = pm.pay_id
					JOIN
					balance bal ON pm.balb_id = bal.bal_id
					JOIN
					student st ON st.stud_id = bal.stud_idb
					where bal_id = :bal_id), :pay_date, :orno, :date_created, :bal_id1, 4)");
				$query11->execute(array( 
					':schoolpaper' => $schoolpaper, 
					':schoolpaper1' => $schoolpaper,
					':bal_id' => $bal_id, 
					':pay_date' => $pay_date, 
					':orno' => $orno,
					':date_created' => $date_created,
					':bal_id1' => $bal_id));	
				$query12 = $this->conn->prepare("INSERT INTO balpay (bal_ida, pay_ida) VALUES (:bal_id, (SELECT MAX(pm.pay_id) from payment pm join payment p on pm.pay_id = p.pay_id join balance on pm.balb_id = balance.bal_id where bal_id = :bal_id))");
				$query12->execute(array(':bal_id' => $bal_id));

				/* organizationsfee */
				$query13 = $this->conn->prepare("UPDATE budget_info JOIN (SELECT acc_amount FROM budget_info WHERE budget_id = '5') table2 SET budget_info.acc_amount = (:organizationsfee + table2.acc_amount) WHERE budget_id = '5'");
				$query13->execute(array( ':organizationsfee' => $organizationsfee ));
				$query14 = $this->conn->prepare("INSERT INTO payment (pay_amt,remain_bal,pay_date,orno,timestamp_pm, balb_id, budg_ida) VALUES (:organizationsfee,(SELECT 
					(MIN(pm.remain_bal) - :organizationsfee1) as 'minbal'
					FROM
					payment p
					INNER JOIN
					payment pm ON p.pay_id = pm.pay_id
					JOIN
					balance bal ON pm.balb_id = bal.bal_id
					JOIN
					student st ON st.stud_id = bal.stud_idb
					where bal_id = :bal_id), :pay_date, :orno, :date_created, :bal_id1, 5)");
				$query14->execute(array( 
					':organizationsfee' => $organizationsfee, 
					':organizationsfee1' => $organizationsfee,
					':bal_id' => $bal_id, 
					':pay_date' => $pay_date, 
					':orno' => $orno,
					':date_created' => $date_created,
					':bal_id1' => $bal_id));	
				$query15 = $this->conn->prepare("INSERT INTO balpay (bal_ida, pay_ida) VALUES (:bal_id, (SELECT MAX(pm.pay_id) from payment pm join payment p on pm.pay_id = p.pay_id join balance on pm.balb_id = balance.bal_id where bal_id = :bal_id))");
				$query15->execute(array(':bal_id' => $bal_id));

				/* tlefee */
				$query16 = $this->conn->prepare("UPDATE budget_info JOIN (SELECT acc_amount FROM budget_info WHERE budget_id = '6') table2 SET budget_info.acc_amount = (:tlefee + table2.acc_amount) WHERE budget_id = '6'");
				$query16->execute(array( ':tlefee' => $tlefee ));
				$query17 = $this->conn->prepare("INSERT INTO payment (pay_amt,remain_bal,pay_date,orno,timestamp_pm, balb_id, budg_ida) VALUES (:tlefee,(SELECT 
					(MIN(pm.remain_bal) - :tlefee1) as 'minbal'
					FROM
					payment p
					INNER JOIN
					payment pm ON p.pay_id = pm.pay_id
					JOIN
					balance bal ON pm.balb_id = bal.bal_id
					JOIN
					student st ON st.stud_id = bal.stud_idb
					where bal_id = :bal_id), :pay_date, :orno, :date_created, :bal_id1, 6)");
				$query17->execute(array( 
					':tlefee' => $tlefee, 
					':tlefee1' => $tlefee,
					':bal_id' => $bal_id, 
					':pay_date' => $pay_date, 
					':orno' => $orno,
					':date_created' => $date_created,
					':bal_id1' => $bal_id));	
				$query18 = $this->conn->prepare("INSERT INTO balpay (bal_ida, pay_ida) VALUES (:bal_id, (SELECT MAX(pm.pay_id) from payment pm join payment p on pm.pay_id = p.pay_id join balance on pm.balb_id = balance.bal_id where bal_id = :bal_id))");
				$query18->execute(array(':bal_id' => $bal_id));

				/* ssgfee */
				$query19 = $this->conn->prepare("UPDATE budget_info JOIN (SELECT acc_amount FROM budget_info WHERE budget_id = '7') table2 SET budget_info.acc_amount = (:ssgfee + table2.acc_amount) WHERE budget_id = '7'");
				$query19->execute(array( ':ssgfee' => $ssgfee ));
				$query20 = $this->conn->prepare("INSERT INTO payment (pay_amt,remain_bal,pay_date,orno,timestamp_pm, balb_id, budg_ida) VALUES (:ssgfee,(SELECT 
					(MIN(pm.remain_bal) - :ssgfee1) as 'minbal'
					FROM
					payment p
					INNER JOIN
					payment pm ON p.pay_id = pm.pay_id
					JOIN
					balance bal ON pm.balb_id = bal.bal_id
					JOIN
					student st ON st.stud_id = bal.stud_idb
					where bal_id = :bal_id), :pay_date, :orno, :date_created, :bal_id1, 7)");
				$query20->execute(array( 
					':ssgfee' => $ssgfee, 
					':ssgfee1' => $ssgfee,
					':bal_id' => $bal_id, 
					':pay_date' => $pay_date, 
					':orno' => $orno,
					':date_created' => $date_created,
					':bal_id1' => $bal_id));	
				$query21 = $this->conn->prepare("INSERT INTO balpay (bal_ida, pay_ida) VALUES (:bal_id, (SELECT MAX(pm.pay_id) from payment pm join payment p on pm.pay_id = p.pay_id join balance on pm.balb_id = balance.bal_id where bal_id = :bal_id))");
				$query21->execute(array(':bal_id' => $bal_id));


				/* sciencefee */
				$query22 = $this->conn->prepare("UPDATE budget_info JOIN (SELECT acc_amount FROM budget_info WHERE budget_id = '8') table2 SET budget_info.acc_amount = (:sciencefee + table2.acc_amount) WHERE budget_id = '8'");
				$query22->execute(array( ':sciencefee' => $sciencefee ));
				$query23 = $this->conn->prepare("INSERT INTO payment (pay_amt,remain_bal,pay_date,orno,timestamp_pm, balb_id, budg_ida) VALUES (:sciencefee,(SELECT 
					(MIN(pm.remain_bal) - :sciencefee1) as 'minbal'
					FROM
					payment p
					INNER JOIN
					payment pm ON p.pay_id = pm.pay_id
					JOIN
					balance bal ON pm.balb_id = bal.bal_id
					JOIN
					student st ON st.stud_id = bal.stud_idb
					where bal_id = :bal_id), :pay_date, :orno, :date_created, :bal_id1, 8)");
				$query23->execute(array( 
					':sciencefee' => $sciencefee, 
					':sciencefee1' => $sciencefee,
					':bal_id' => $bal_id, 
					':pay_date' => $pay_date, 
					':orno' => $orno,
					':date_created' => $date_created,
					':bal_id1' => $bal_id));	
				$query24 = $this->conn->prepare("INSERT INTO balpay (bal_ida, pay_ida) VALUES (:bal_id, (SELECT MAX(pm.pay_id) from payment pm join payment p on pm.pay_id = p.pay_id join balance on pm.balb_id = balance.bal_id where bal_id = :bal_id))");
				$query24->execute(array(':bal_id' => $bal_id));		
			}

			public function getBudgetName() {
				$sql = $this->conn->query("SELECT budget_name FROM budget_info");
				$result = $sql->fetchAll();
				return $result;
			}

			public function getStats($yr_level) {
				if($yr_level === "All") {
					$query =$this->conn->prepare("SELECT 
						budget_name, sum(pay_amt) 'sum'
						FROM
						payment pm
						JOIN
						balance bal ON pm.balb_id = bal.bal_id
						JOIN
						budget_info bi ON pm.budg_ida = bi.budget_id
						JOIN
						student st ON st.stud_id = bal.stud_idb
						group by 1 order by 1") or die ("failed");
					$query->execute();
				} else {
					$query =$this->conn->prepare("SELECT 
						budget_name, sum(pay_amt) 'sum'
						FROM
						payment pm
						JOIN
						balance bal ON pm.balb_id = bal.bal_id
						JOIN
						budget_info bi ON pm.budg_ida = bi.budget_id
						JOIN
						student st ON st.stud_id = bal.stud_idb
						where year_level = :year_level
						group by 1 order by 1") or die ("failed");
					$query->execute(array(":year_level" => $yr_level));

				}
				$data = array();	
				while($r = $query->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				return $data;
			}

			public function getStatistics($yr_level) {
				$query = $this->conn->prepare("SELECT 
					budget_name, SUM(pay_amt) as 'total'
					FROM
					payment pm
					JOIN
					balance bal ON pm.balb_id = bal.bal_id
					JOIN
					budget_info bi ON pm.budg_ida = bi.budget_id
					JOIN
					student st ON st.stud_id = bal.stud_idb
					".($yr_level === 'All' ? '' : "WHERE year_level='".$yr_level."'")."
					GROUP BY 1
					ORDER BY 1");
				$query->execute();
				$rowCount = $query->rowCount();
				if($rowCount > 0) {
					while($row = $query->fetch()){
						echo  "['" .$row['budget_name']."', " .$row['total']."],"; 
					} 	
				} else {
					if($rowCount === 0) {
						echo  '["", 0],'; 
					}
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