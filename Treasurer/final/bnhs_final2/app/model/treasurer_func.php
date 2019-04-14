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
		$query = $this->conn->prepare("SELECT bal_status,count(*) from balance group by 1");
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
    bal_status = 'Cleared'
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
    bal_status = 'Cleared'
GROUP BY 1
");
		$query->execute();
		$rowCount = $query->rowCount();

		$query1 = $this->conn->prepare("SELECT * FROM student");
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
									    bal_status = 'Not Cleared'
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
    bal_status = 'Not Cleared'
GROUP BY 1
");
		$query->execute();
		$rowCount = $query->rowCount();

		$query1 = $this->conn->prepare("SELECT * FROM student");
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
		$query = $this->conn->prepare("SELECT sum(pay_amt) as 'total_amt' FROM payment");
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

	public function getPaymentInfo($grade) {
		$query = '';
		if ($grade === 'All') {
			$query = "SELECT 
				bal_id,
				stud_lrno,
				CONCAT(first_name, ' ', last_name) as 'name',
				misc_fee , MIN(pm.remain_bal) as 'minbal', bal_status,
				DATE_FORMAT(MAX(pm.pay_date), '%M %e %Y') as 'date', st.stud_id as 'studentid'
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
				GROUP BY st.first_name ORDER by 6 DESC";
		} else {
			$query = "SELECT 
				bal_id,
				stud_lrno,
				CONCAT(first_name, ' ', last_name) as 'name',
				misc_fee , MIN(pm.remain_bal) as 'minbal', bal_status,
				DATE_FORMAT(MAX(pm.pay_date), '%M %e %Y') as 'date', st.stud_id as 'studentid'
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
				WHERE year_level = '".$grade."'
				GROUP BY st.first_name ORDER by 6 DESC";
		}
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
			$query = $this->conn->prepare("SELECT sum(acc_amount) from budget_info");
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
					where bal_id = :bal_id), :pay_date, :orno, :date_created, :bal_id1, 1)");
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
				
						
			}

			public function getStats() {
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
			while($r = $query->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}

			return $data;
		}

			public function getStatistics() {
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
				GROUP BY 1
				ORDER BY 1");
		$query->execute();
		$rowCount = $query->rowCount();
		while($row = $query->fetch()){
			echo  "['" .$row['budget_name']."', " .$row['total']."],"; 
		}   
	} 
}

		?>