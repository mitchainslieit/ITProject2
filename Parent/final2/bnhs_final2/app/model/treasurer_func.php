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

	public function getNumberOfFullyPaidStudents() {
		$query = $this->conn->prepare("SELECT * FROM student join balance on student.stud_id = balance.stud_idb join balpay bp on bp.bal_ida = balance.stud_idb join payment on payment.pay_id = bp.pay_ida where bal_status = 'Cleared' group by 1");
		$query->execute();
		$rowCount = $query->rowCount();
	      if($rowCount > 1){
	      		echo  "<u> 
	      		      ". $rowCount . "
	      		      </u> 
	      		      <span>students</span>";
	      }
	      else {
	      	if ($rowCount == 0) {
	      	    echo  "<u>
	      	    	  ". $rowCount . 
	      	    	  "</u> 
	      	    	  <span>student</span>";
	      	}
	      }
	  }
			
	public function getPercentageOfFullyPaidStudents() {
		$query = $this->conn->prepare("SELECT * FROM student join balance on student.stud_id = balance.stud_idb join balpay bp on bp.bal_ida = balance.stud_idb join payment on payment.pay_id = bp.pay_ida where bal_status = 'Cleared' group by 1");
		$query->execute();
		$rowCount = $query->rowCount();

		$query1 = $this->conn->prepare("SELECT * FROM student");
		$query1->execute();
		$rowCount1 = $query1->rowCount();

		$result = $rowCount/$rowCount1*100;

		echo " ". $result . " " ;
	}

	public function getNumberOfStudentsWBalance() {
		$query = $this->conn->prepare("SELECT * FROM student join balance on student.stud_id = balance.stud_idb join balpay bp on bp.bal_ida = balance.stud_idb join payment on payment.pay_id = bp.pay_ida where bal_status = 'Not Cleared' group by 1");
		$query->execute();
		$rowCount = $query->rowCount();
	      if($rowCount > 1){
	      		echo  "<u> 
	      		      ". $rowCount . "
	      		      </u> 
	      		      <span>students</span>";
	      }
	      else {
	      	if ($rowCount == 0) {
	      	    echo  "<u>
	      	    	  ". $rowCount . 
	      	    	  "</u> 
	      	    	  <span>student</span>";
	      	}
	      }
	  }

	  public function getPercentageOfStudentsWBalance() {
		$query = $this->conn->prepare("SELECT * FROM student join balance on student.stud_id = balance.stud_idb join balpay bp on bp.bal_ida = balance.stud_idb join payment on payment.pay_id = bp.pay_ida where bal_status = 'Not Cleared' group by 1");
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
		echo  " ". $rowCount['total_amt'] . " ";
	}

	public function getMiscellaneousFee() {
		$query = $this->conn->prepare("select * from balance");
		$query->execute();
		$rowCount = $query->fetch();
		echo  " ". $rowCount['misc_fee'] . " ";
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
		$query = $this->conn->prepare("");
		$query->execute();
		$rowCount = $query->rowCount();
		if($rowCount > 0){
			while($row = $query->fetch()) {
				echo " 
						<tr>
							<td> ".$row[0]." </td> 
							<td> ".$row[1]." </td>
							<td> ".$row[2]." </td>
							<td> ".$row[3]." </td>
							<td> <button> Update </button> </td>
						</tr>
								";	
		  }
		}else{
			echo "";
		}
	}

	public function getPaymentHistory() {
		$query = $this->conn->prepare("SELECT 
    stud_lrno,
    CONCAT(first_name,
            ' ',
            middle_name,
            ' ',
            last_name),
    misc_fee,
    init_bal,
    pay_amt ,
    DATE_FORMAT(DATE(pay_date), '%M %e %Y') 
FROM
    payment pm
        JOIN
    balance bal ON pm.balb_id = bal.bal_id
        JOIN
    student st ON st.stud_id = bal.stud_idb");
		$query->execute();
		$rowCount = $query->rowCount();
		if($rowCount > 0){
			while($row = $query->fetch()) {
				echo " 
						<tr>
							<td> ".$row[0]." </td> 
							<td> ".$row[1]." </td>
							<td> ".$row[2]." </td>
							<td> ".$row[3]." </td>
							<td> ".$row[4]." </td>
							<td> ".$row[5]." </td>
						</tr>
								";	
		  }
		}else{
			echo "No payments has been made yet.";
		}
		
	}



	






}
?>