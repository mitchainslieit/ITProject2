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
			echo "<td colspan=3>No payments yet.</td>";
		}
	}

	public function getNameOfStud(){
		$query = $this->conn->prepare("SELECT stud_lrno, CONCAT(first_name,
			' ',
			middle_name,
			' ',
			last_name) as 'name', 	CONCAT('Grade ', year_level, '-', sec_name) 'section'
			FROM
			student st
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			JOIN 
			accounts ac on ac.acc_id = pr.acc_idx
			JOIN 
			section on section.sec_id = st.secc_id
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
			st.stud_id = 1");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch()){
				echo " " . $row[0] . " ";
			}
		}
	}

	public function getNoOfDaysLate($lrno){
		$query = $this->conn->prepare("SELECT count(remarks) from attendance att 
			JOIN 
			student st on att.stud_ida = st.stud_id 
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			JOIN
			accounts ac on ac.acc_id = pr.acc_idx where 
			pr.acc_idx = " . $_SESSION['accid'] . " and remarks = 'Late' AND st.stud_lrno='".$lrno."'");
		$query->execute();
		$rowCount = $query->fetch();
		echo " " . $rowCount[0] . " ";
	}

	public function getNoOfDaysAbsent($lrno){
		$query = $this->conn->prepare("SELECT count(remarks) from attendance att 
			JOIN 
			student st on att.stud_ida = st.stud_id  
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			JOIN 
			accounts ac on ac.acc_id = pr.acc_idx
			WHERE
			pr.acc_idx = " . $_SESSION['accid'] . " and remarks = 'Absent' AND st.stud_lrno='".$lrno."'");
		$query->execute();
		$rowCount = $query->fetch();
		echo " " . $rowCount[0] . " ";
	}

	public function getAttDateRemarks($lrno){
		$query = $this->conn->prepare("SELECT 
			DATE_FORMAT(DATE(att_date), '%M %e, %Y'), subj_name, remarks
			FROM
			attendance att
			JOIN
			student st ON att.stud_ida = st.stud_id
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			JOIN
			accounts ac ON ac.acc_id = pr.acc_idx
			JOIN
			subject ON att.subjatt_id = subject.subj_id
			WHERE
			(pr.acc_idx = '" . $_SESSION['accid'] . "' AND remarks = 'Late'
			|| remarks = 'Absent')
			AND st.stud_lrno = '".$lrno."'");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch())
			{
				echo "<tr>
				<td> " . $row[0] . "</td>
				<td> " . $row[1] . "</td>
				<td> " . $row[2] . "</td>
				</tr>
				";
			}
		} else {
			echo "<tr><td colspan=\"3\">THERE ARE NO ABSENCES YET. </td></tr>";
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

	public function getChildGrade($lrno){
		/*******************Get subject name*******************/
		$query = $this->conn->prepare("SELECT subj_name from schedsubj ss join section sec on ss.sw_id = sec.sec_id join student st on st.secc_id = sec.sec_id join subject sub on sub.subj_id = ss.schedsubjb_id join guardian g on st.guar_id = g.guar_id join accounts ac on ac.acc_id = g.acc_idx where acc_idx = :acc_id and stud_lrno = :stud_lrno");
		$query->execute(array(":acc_id" => $_SESSION['accid'], ":stud_lrno" => $lrno));
		$subjects = $query->fetchAll();

		/*******************Get student grade*******************/
		for ($c = 0;$c < count($subjects);$c++){
			$subject_name = $subjects[$c]['subj_name'];
			$first = (float) $this->getGrade($lrno, $subject_name, '1st');
			$second = (float) $this->getGrade($lrno, $subject_name, '2nd');
			$third = (float) $this->getGrade($lrno, $subject_name, '3rd');
			$fourth = (float) $this->getGrade($lrno, $subject_name, '4th');
			$average = ($first + $second + $third + $fourth) / 4.0;
			$remarks = $this->getRemarks($average);
			echo '<tr>';
			echo '<td>' . $subject_name . '</td>';
			echo $first === 0.0 ? '<td></td>' : '<td>' . $first . '</td>';
			echo $second === 0.0 ? '<td></td>' : '<td>' . $second . '</td>';
			echo $third === 0.0 ? '<td></td>' : '<td>' . $third . '</td>';
			echo $fourth === 0.0 ? '<td></td>' : '<td>' . $fourth . '</td>';
			if($first === 0.0 || $second === 0.0 || $third === 0.0 || $fourth === 0.0){
				echo '<td></td>';
			}else{
				echo '<td>' . $average . '</td>';
			}

			/*GET REMARKS*/
			if ($first === 0.0 || $second === 0.0 || $third === 0.0 || $fourth === 0.0) {
				echo '<td></td>';
			} else if($average < 75.0) {
				echo '<td><font color="red">Failed</font></td>';
				echo '<td>
				<button class="customButton" name="opener">View details</button>
				<div name="dialog" title="Detail(s) of Failing Mark/ Non-conformance">
				<form action="treasurer-accounts" method="POST">
				<center><span><font color="red" size="5">Incomplete Requirements</font><span></center>
				</form>
				</div>
				</td>';
			}else{
				echo '<td>'.$this->getRemarks($average).'</td>';
			}

			/*GET DETAILS*/
			if($average === 0.0){
				echo '<td></td>';
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
	

	private function getGrade($lrno, $subject, $grading){
		$query = $this->conn->prepare("SELECT  CONCAT(first_name, ' ', last_name) 'Student', grade, subj_name 'subject', grading FROM grades JOIN student ON grades.studd_id = student.stud_id JOIN facsec fs ON grades.secd_id = fs.sec_idy JOIN schedsubj ss ON (grades.facd_id = ss.fw_id && grades.secd_id = ss.sw_id) JOIN subject ON (ss.schedsubjb_id = subject.subj_id && grades.subj_ide = subject.subj_id) WHERE student.stud_lrno = :stud_lrno AND subj_name = :subject AND grading = :grading GROUP BY 2 ORDER BY 3");
		$query->execute(array(
			':stud_lrno' => $lrno,
			':subject' => $subject,
			':grading' => $grading
		));
		$result = $query->fetch();
		return $query->rowCount() > 0 ? $result['grade'] : 0;
	}

	 public function getChildSchedule($lrno){
    	$querySchedule = $this->conn->query("SELECT 
    		'09:40:00' AS 'time_start',
    		'10:00:00' AS 'time_end',
    		'RECESS' AS subj_name,
    		'' AS 'stud_sec',
    		'' AS 'facultyname'

    		UNION SELECT 
    		'12:00:00' AS 'time_start',
    		'13:00:00' AS 'time_end',
    		'LUNCH' AS subj_name,
    		'' AS 'stud_sec',
    		'' AS 'facultyname'

    		UNION SELECT 
    		time_start,
    		time_end,
    		subj_name,
    		CONCAT('G', year_level, ' - ', sec_name) AS 'stud_sec',
    		CONCAT('Teacher ',fac_fname,
    		' ',
    		fac_midname,
    		'. ',
    		fac_lname) AS 'facultyname'
    		FROM
    		schedsubj ss
    		JOIN
    		subject ON ss.schedsubjb_id = subject.subj_id
    		JOIN
    		facsec fs ON (fs.fac_idy = ss.fw_id
    		&& fs.sec_idy = ss.sw_id)
    		JOIN
    		faculty ON fac_idy = fac_id
    		JOIN
    		section ON fs.sec_idy = section.sec_id
    		JOIN
    		student ON secc_id = sec_id
    		JOIN
    		accounts ON acc_idz = acc_id
    		WHERE
    		sec_id = (SELECT 
    		sec_id
    		FROM
    		section
    		JOIN
    		faculty ON section.fac_idv = faculty.fac_id
    		JOIN
    		schedsubj ss ON ss.fw_id = faculty.fac_id
    		JOIN
    		subject ON subject.subj_id = ss.schedsubjb_id
    		JOIN
    		student st ON section.sec_id = st.secc_id
    		JOIN
    		guardian gd ON gd.guar_id = st.guar_id
    		JOIN
    		accounts acc ON acc.acc_id = gd.acc_idx
    		WHERE
    		(stud_lrno = '".$lrno."' AND acc_id = '" . $_SESSION['accid'] . "') GROUP by 1)
    		GROUP BY time_start
    		ORDER BY 1")
    	or die ("FAILED");
    	$result = $querySchedule->fetchAll();
    	$time_start = array('07:40:00', '08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00');
    	$time_end = array('08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00');

    	echo '<div class="widgetcontent">
    	<table>
    	<tr><td>Time/Day</td>
    	<td>Monday</td>
    	<td>Tuesday</td> 
    	<td>Wednesday</td>
    	<td>Thursday</td>
    	<td>Friday</td>
    	</tr>';

    	for ($c = 0; $c < count($time_start); $c++) {
    		echo '<tr>';
    		$subj_name = $result[$c]['subj_name'];
    		$faculty = isset($result[$c]['facultyname']) ? ($result[$c]['facultyname']) : '';
    		$new_time_start = date('h:i A', strtotime($time_start[$c]));
    		$new_time_end = date('h:i A', strtotime($time_end[$c]));
    		echo '<td>'.$new_time_start.' - '.$new_time_end.'</td>';
    		echo '<td colspan="5">'.'<div>'.$subj_name.'<br>'.$faculty.'</div>'.'</td>';
    		echo '</tr>';
    	}

    }

	/*END OF CODE*/
}

?>
