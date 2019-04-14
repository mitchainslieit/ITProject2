<?php
require 'app/model/connection.php';
class ParentFunct
{

	public function __construct(){
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getAnnouncements(){
		$query = $this->conn->prepare("SELECT DATE_FORMAT(date(date_start), '%M %e, %Y'), post from announcements an join accounts ac on an.post_adminid = ac.acc_id");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch()){
				echo " 
				<tr>
				<td> " . $row[0] . " </td> 
				<td> " . $row['post'] . " </td>
				</tr>
				";
			}
		}else{
			echo "No announcements yet.";
		}
	}

	public function getSchoolYear(){
		$query = $this->conn->prepare("SELECT school_year 'sy' FROM student group by 1");
		$query->execute();
		$rowCount = $query->fetch();
		$rowCount1 = $rowCount['sy'] + 1;
		echo " " . $rowCount['sy'] . "-" . $rowCount1 . " ";
	}

	public function getMiscellaneousFee(){
		$query = $this->conn->prepare("select FORMAT(misc_fee, 2) from balance");
		$query->execute();
		$rowCount = $query->fetch();
		echo " " . $rowCount[0] . " ";
	}

	public function getPaymentHistory($lrno){
		$query = $this->conn->prepare("SELECT 
			FORMAT(remain_bal, 2),
			FORMAT(pay_amt, 2),
			DATE_FORMAT(DATE(pay_date), '%M %e, %Y') 
			FROM
			payment pm
			JOIN
			balance bal ON pm.balb_id = bal.bal_id
			JOIN
			student st ON st.stud_id = bal.stud_idb
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			WHERE
			pr.acc_idx = '" . $_SESSION['accid'] . "' AND st.stud_lrno='".$lrno."'");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch()){
				echo "<tr>
				<td> &#x20B1;&nbsp;" . $row[0] . "</td>
				<td> &#x20B1;&nbsp;" . $row[1] . "</td>
				<td>" . $row[2] . "</td>
				</tr>";
			}
		}else{
			echo "No payments has been made yet.";
		}
	}

	public function getNameOfStud(){
		$query = $this->conn->prepare("SELECT stud_lrno, CONCAT(first_name,
			' ',
			middle_name,
			' ',
			last_name) as 'name', CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec'
			FROM
			student st
			JOIN
			section ON secc_id = sec_id
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
            JOIN 
            accounts ac on ac.acc_id = pr.acc_idx
			WHERE
			pr.acc_idx = " . $_SESSION['accid'] . "");
		$query->execute();
		while($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getLRNOfStud(){
		$query = $this->conn->prepare("SELECT  
			stud_lrno
			FROM
			student st
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
            JOIN 
            accounts ac on ac.acc_id = pr.acc_idx
			WHERE
			pr.acc_idx = " . $_SESSION['accid'] . "");
		$query->execute();
		$rowCount = $query->fetch();
		return " " . $rowCount[0] . " ";
	}

	public function getBreakdownOfFees(){
		$query = $this->conn->prepare("SELECT budget_name, FORMAT(total_amount, 2) FROM budget_info");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0) while ($row = $query->fetch()){
			echo "<tr>
			<td> " . $row[0] . "</td>
			<td> &#x20B1;&nbsp;" . $row[1] . "</td>
			</tr>";
		}
	}

	public function getChildName(){
		$query = $this->conn->prepare("SELECT CONCAT(first_name,
			' ',
			middle_name,
			' ',
			last_name)
			FROM
			student st
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
            JOIN 
            accounts ac on ac.acc_id = pr.acc_idx
			WHERE
			pr.acc_idx = " . $_SESSION['accid'] . "");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch())
			{
				echo " " . $row[0] . " ";
			}
		}
	}

	public function getChildLevelSection(){
		$query = $this->conn->prepare("SELECT 
			CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec'
			FROM
			student st
			JOIN
			section ON secc_id = sec_id
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
            JOIN 
            accounts ac on ac.acc_id = pr.acc_idx
            WHERE
            pr.acc_idx = " . $_SESSION['accid'] . "");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch()){
				echo " " . $row[0] . " ";
			}
		}
	}

	public function getNoOfDaysPresent(){
		$query = $this->conn->prepare("SELECT count(remarks) from attendance att 
			JOIN 
			student st on att.stud_ida = st.stud_id 
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			JOIN
			accounts ac on ac.acc_id = pr.acc_idx where 
			pr.acc_idx = " . $_SESSION['accid'] . " and remarks = 'Present' ");
		$query->execute();
		$rowCount = $query->fetch();
		echo " " . $rowCount[0] . " ";
	}

	public function getNoOfDaysAbsent(){
		$query = $this->conn->prepare("SELECT count(remarks) from attendance att 
			JOIN 
			student st on att.stud_ida = st.stud_id  
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
            JOIN 
            accounts ac on ac.acc_id = pr.acc_idx
			WHERE
			pr.acc_idx = " . $_SESSION['accid'] . " and remarks = 'Late' & remarks = 'Absent'");
		$query->execute();
		$rowCount = $query->fetch();
		echo " " . $rowCount[0] . " ";
	}

	public function getAttDateRemarks(){
		$query = $this->conn->prepare("SELECT DATE_FORMAT(date(att_date), '%M %e, %Y'), remarks from attendance att JOIN student st on att.stud_ida = st.stud_id JOIN
			guardian pr ON st.guar_id = pr.guar_id
			JOIN
			accounts ac on ac.acc_id = pr.acc_idx where 
			pr.acc_idx = " . $_SESSION['accid'] . " and remarks = 'Late' & remarks = 'Absent'");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch())
			{
				echo "<tr>
				<td> " . $row[0] . "</td>
				<td> " . $row[1] . "</td>
				</tr>";
				}
		}
	}

	public function getTotalBDOF(){
		$query = $this->conn->prepare("SELECT FORMAT(sum(total_amount), 2) from budget_info");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0) while ($row = $query->fetch())
		{
			echo "&#x20B1;&nbsp;" . $row[0] . "";
		}
	}

	public function getTotalPayment($lrno){
		$query = $this->conn->prepare("SELECT FORMAT(sum(pay_amt), 2) FROM
			payment pm
			JOIN
			balance bal ON pm.balb_id = bal.bal_id
			JOIN
			student st ON st.stud_id = bal.stud_idb
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			WHERE
			pr.acc_idx = '" . $_SESSION['accid'] . "' AND st.stud_lrno = '".$lrno."'");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0) while ($row = $query->fetch())
		{
			echo "&#x20B1;&nbsp;" . $row[0] . "";
		}
	}

	public function getChildGrade(){
		/*******************Get subject name*******************/
		$query = $this->conn->prepare("SELECT 
			subj_name
			FROM
			grades
			JOIN
			student ON grades.studd_id = student.stud_id
			JOIN
			facsec fs ON grades.secd_id = fs.sec_idy
			JOIN
			schedsubj ss ON (grades.facd_id = ss.fw_id
			&& grades.secd_id = ss.sw_id)
			JOIN
			subject ON (ss.schedsubjb_id = subject.subj_id && grades.subj_ide = subject.subj_id)
            JOIN
            guardian ON student.guar_id = guardian.guar_id 
            JOIN 
            accounts ac on ac.acc_id = guardian.acc_idx
			WHERE
			guardian.acc_idx = :acc_id
			group by 1 ORDER BY 1");
		$query->execute(array(":acc_id" => $_SESSION['accid']));
		$subjects = $query->fetchAll();
        $stud_id = 1; //sample

        /*******************Get student grade*******************/
        for ($c = 0;$c < count($subjects);$c++){
        	$subject_name = $subjects[$c]['subj_name'];
        	$first = $this->getGrade($stud_id, $subject_name, '1st');
        	$second = $this->getGrade($stud_id, $subject_name, '2nd');
        	$third = $this->getGrade($stud_id, $subject_name, '3rd');
        	$fourth = $this->getGrade($stud_id, $subject_name, '4th');
        	$average = ($first + $second + $third + $fourth) / 4;
        	$remarks = $this->getRemarks($average);
        	echo '<tr>';
        	echo '<td>' . $subject_name . '</td>';
        	echo $first === 0 ? '<td></td>' : '<td>' . $first . '</td>';
        	echo $second === 0 ? '<td></td>' : '<td>' . $second . '</td>';
        	echo $third === 0 ? '<td></td>' : '<td>' . $third . '</td>';
        	echo $fourth === 0 ? '<td></td>' : '<td>' . $fourth . '</td>';
        	// echo $average === 0 ? '<td></td>' : '<td>' . $average . '</td>';
        	if($first === 0 || $second === 0 || $third === 0 || $fourth === 0){
        		echo '<td></td>';
        	}else{
        		echo '<td>' . $average . '</td>';
        	}

        	if ($average != 0){
        		echo '<td></td>';
        	}else{
        		echo '<td>' . $remarks . '</td>';
        	}  	
   
        	// echo $remarks === 0 ? '<td></td>' : '<td>' . $remarks . '</td>';
        	if ($remarks === 'Failed' || $remarks === 'Passed' || $remarks === 0){
        		echo '<td></td>';
        	}else{
        		if($remarks === '<font color="green">Passed</font>'){
        			echo '<td> <font color="green">Passed</font> </td>';
        		} else {
        			if($remarks === '<font color="red">Failed</font>') {
        				echo '
        				<td>
							
        				</td>';
        			}else{
        				if ($remarks === 0){
			        		echo '<td></td>';
			        	}
        			}
        		}
        	}
        	echo '</tr>';
        }  		
    }

    private function getRemarks($average){
    	if ($average >= 75){
		    		return $remarks ='<font color="green">Passed</font>';
		    	}else{
		    		if ($average < 75){
		    			return $remarks = '<font color="red">Failed</font>';
    		}
		}
	}
	

    private function getGrade($stud_id, $subject, $grading){
    	$query = $this->conn->prepare("SELECT  CONCAT(first_name, ' ', last_name) 'Student', grade, subj_name 'subject', grading FROM grades JOIN student ON grades.studd_id = student.stud_id JOIN facsec fs ON grades.secd_id = fs.sec_idy JOIN schedsubj ss ON (grades.facd_id = ss.fw_id && grades.secd_id = ss.sw_id) JOIN subject ON (ss.schedsubjb_id = subject.subj_id && grades.subj_ide = subject.subj_id) WHERE student.stud_id = :stud_id AND subj_name = :subject AND grading = :grading GROUP BY 2 ORDER BY 3");
    	$query->execute(array(
    		':stud_id' => $stud_id,
    		':subject' => $subject,
    		':grading' => $grading
    	));
    	$result = $query->fetch();
    	return $query->rowCount() > 0 ? $result['grade'] : 0;
    }

    public function getChildSchedule(){
    	$query = $this->conn->prepare("SELECT 
			CONCAT(time_start, '-', time_end), subj_name, day
			FROM
			grades
			JOIN
			student ON grades.studd_id = student.stud_id
			JOIN
			facsec fs ON grades.secd_id = fs.sec_idy
			JOIN
			schedsubj ss ON (grades.facd_id = ss.fw_id
			&& grades.secd_id = ss.sw_id)
			JOIN
			subject ON (ss.schedsubjb_id = subject.subj_id && grades.subj_ide = subject.subj_id)
			WHERE
			student.stud_id = 1
            group by 1 order by 1 DESC");
    	$query->execute();
    	$rowCount = $query->rowCount();
    	if ($rowCount > 0) while ($row = $query->fetch()){
    		echo "<tr>    
    		<td>" . $row[0] . "</td>
    		<td>" . $row[1] . "</td>
    		<td>" . $row[2] . "</td>
    		</tr>";
    	}
    }	
    
    /*END OF CODE*/
}

?>
