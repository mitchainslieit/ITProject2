<?php
require 'app/model/connection.php';
class ParentFunct
{

	public function __construct(){
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getAnnouncements() {
		$admin_id = $_SESSION['accid'];
		$sql = $this->conn->prepare("SELECT * FROM announcements WHERE (view_lim like '%2%' or view_lim='0') AND post IS NOT NULL") or die ("failed!");
		$sql->bindParam(1, $admin_id);
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


	public function showEvents(){
		$admin_id = $_SESSION['accid'];
		$sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e, %Y') as date_start_1, DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, date_start, date_end, post, view_lim, attachment FROM announcements WHERE (view_lim like '%2%' or view_lim='0') AND title IS NOT NULL AND holiday='No'") or die ("failed!");
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
		$sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e') as date_start_1,  DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, DAY(CURDATE()), DAY(date_start) FROM announcements WHERE (view_lim like '%2%' or view_lim like '%0%') AND title IS NOT NULL AND holiday='Yes' AND (date_start between now() and adddate(now(), +15))") or die ("failed!");
		$sql->execute();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}
	public function getWholeName(){
		$query = $this->conn->prepare("SELECT CONCAT(guar_fname, ' ',guar_midname, ' ', guar_lname) as 'Name' FROM guardian WHERE acc_idx = " . $_SESSION['accid'] . "");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch()){
				echo " 
				<td> " . $row[0] . " </td> 
				";
			}
		}
	}

	public function getUsername(){
		$query = $this->conn->prepare("SELECT username FROM accounts WHERE acc_id = " . $_SESSION['accid'] . "");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch()){
				echo " 
				<td> " . $row[0] . " </td> 
				";
			}
		}
	}

	public function getPosition(){
		$query = $this->conn->prepare("SELECT acc_type FROM accounts WHERE acc_id = " . $_SESSION['accid'] . "");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch()){
				echo " 
				<td> " . $row[0] . " </td> 
				";
			}
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
		$query = $this->conn->prepare("SELECT FORMAT(sum(total_amount), 2) from budget_info");
		$query->execute();
		$rowCount = $query->fetch();
		echo " " . $rowCount[0] . " ";
	}

	public function getBalance() {
		$query = $this->conn->prepare("SELECT bal_amt, stud_lrno
			FROM
			balance
			JOIN
			payment ON payment.balb_id = balance.bal_id
			JOIN
			student st ON balance.stud_idb = st.stud_id
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			JOIN 
			accounts ac on ac.acc_id = pr.acc_idx
			WHERE
			pr.acc_idx = '" . $_SESSION['accid'] . "' 
			GROUP BY 1");
		$query->execute();
		$rowCount = $query->rowCount();	
		$today = date("F d, Y");
		if ($rowCount > 0) {
			while($row = $query->fetch()) {
				echo "<span class=\"wlrno\"data-lrno=\"".$row['stud_lrno']."\">&#x20B1; ".number_format($row['bal_amt'], 2)." as of ".$today."</span>";
			}
		}else{
			echo '<td>ZERO BALANCE</td>';
		}
	}

	public function getYears($lrno) {
		$query = $this->conn->prepare("SELECT 
			DATE_FORMAT(DATE(pay_date), '%Y')
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

	}

	public function filterPaymentYear() {
		$query = $this->conn->prepare("SELECT
			DISTINCT(DATE_FORMAT(DATE(pay_date), '%Y'))
			FROM
			payment pm
			JOIN
			balance bal ON pm.balb_id = bal.bal_id
			JOIN
			student st ON st.stud_id = bal.stud_idb
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			WHERE
			pr.acc_idx = '" . $_SESSION['accid'] . "' GROUP by pm.orno");
		$query->execute();
		$rowCount = $query->rowCount();
		foreach($query->fetchAll() as $row) {
			echo '<option value="'.$row[0].'">'.$row[0].'</option>';
		}
	}

	public function getPaymentHistory(){
		$query = $this->conn->prepare("SELECT 
			DATE_FORMAT(DATE(pay_date), '%M %e, %Y'), 
			FORMAT(sum(pay_amt), 2),
			stud_lrno,
			DATE_FORMAT(DATE(pay_date), '%Y')
			FROM
			payment pm
			JOIN
			balance bal ON pm.balb_id = bal.bal_id
			JOIN
			student st ON st.stud_id = bal.stud_idb
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			WHERE
			pr.acc_idx = '" . $_SESSION['accid'] . "' GROUP by pm.orno");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch()){
				echo "<tr>
				<td>" . $row[0] . "</td>
				<td>" . $row[1] . "</td>
				<td>" . $row[2] . "</td>
				<td>" . $row[3] . "</td>
				</tr>";
			}
		}else{
			echo "<td colspan=3>NO PAYMENTS YET.</td>";
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
			pr.acc_idx = " . $_SESSION['accid'] . "" );
		$query->execute();
		if ($query->rowCount() > 0) {
			foreach ($query->fetchAll() as $result) {
				echo '<span class="wlrno" data-lrno="'.$result['stud_lrno'].'">'.$result['stud_lrno'].'</span>';
			}
		} else {
			echo 'wala kang anak';
		}
	}

	public function getLRNOfStud2(){
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
			<td> " . $row[1] . "</td>
			</tr>";
		}
	}

	public function getNoOfDaysLate(){
		$query = $this->conn->prepare("SELECT count(remarks), stud_lrno from attendance att 
			JOIN 
			student st on att.stud_ida = st.stud_id 
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			JOIN
			accounts ac on ac.acc_id = pr.acc_idx where 
			pr.acc_idx = " . $_SESSION['accid'] . " and remarks = 'Late' group by stud_id");
		$query->execute();
		$rowCount = $query->fetch();
		echo "<span class=\"wlrno\" data-lrno=\"".$rowCount[1]."\">" . $rowCount[0] . "</span> ";
	}

	public function getNoOfDaysAbsent(){
		$query = $this->conn->prepare("SELECT count(remarks), stud_lrno from attendance att 
			JOIN 
			student st on att.stud_ida = st.stud_id  
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			JOIN 
			accounts ac on ac.acc_id = pr.acc_idx
			WHERE
			pr.acc_idx = " . $_SESSION['accid'] . " and remarks = 'Absent' group by stud_id");
		$query->execute();
		$rowCount = $query->fetch();
		echo "<span class=\"wlrno\" data-lrno=\"".$rowCount[1]."\">" . $rowCount[0] . "</span> ";
	}

	public function getAttDateRemarks(){
		$query = $this->conn->prepare("SELECT 
			DATE_FORMAT(DATE(att_date), '%M %e, %Y'), subj_name, remarks, stud_lrno
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
			|| remarks = 'Absent')");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0){
			while ($row = $query->fetch())
			{
				echo "
				<tr>
				<td> " . $row[0] . "</td>
				<td> " . $row[1] . "</td>
				<td> " . $row[2] . "</td>
				<td> " . $row[3] . "</td>
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

	public function getTotalPayment(){
		$query = $this->conn->prepare("SELECT FORMAT(sum(pay_amt), 2), stud_lrno FROM
			payment pm
			JOIN
			balance bal ON pm.balb_id = bal.bal_id
			JOIN
			student st ON st.stud_id = bal.stud_idb
			JOIN
			guardian pr ON st.guar_id = pr.guar_id
			WHERE
			pr.acc_idx = '" . $_SESSION['accid'] . "' GROUP by stud_id");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0) 
			while ($row = $query->fetch()){
				echo "<span class=\"wlrno\" data-lrno=\"".$row[1]."\">&#x20B1;&nbsp;" . $row[0] . "</span>";
			}
		}

		public function getCV($lrno)
		{
			$query = $this->conn->prepare("SELECT cv_name FROM core_values 
				JOIN 
				behavior on cv_id = core_values
				JOIN
				student st on stud_id = stud_idy
				JOIN 
				guardian g on st.guar_id = g.guar_id 
				JOIN 
				accounts ac on ac.acc_id = g.acc_idx 
				WHERE acc_idx = :acc_id and stud_lrno = :stud_lrno
				group by 1");
			$query->execute(array(":acc_id" => $_SESSION['accid'], ":stud_lrno" => $lrno));
			$cv_name = $query->fetchAll();
			$acc_id  = $_SESSION['accid'];
			for ($c = 0; $c < count($cv_name); $c++) {
				$cvname = $cv_name[$c]['cv_name'];
				$first        = $this->getCVGrade($lrno, $cvname,'1st');
				$second       = $this->getCVGrade($lrno, $cvname,'2nd');
				$third        = $this->getCVGrade($lrno, $cvname,'3rd');
				$fourth       = $this->getCVGrade($lrno, $cvname,'4th');
				echo '<tr>';
				echo '<td>' . $cvname . '</td>';
				echo $first === 0 ? '<td></td>' : '<td>' . $first . '</td>';
				echo $second === 0 ? '<td></td>' : '<td>' . $second . '</td>';
				echo $third === 0 ? '<td></td>' : '<td>' . $third . '</td>';
				echo $fourth === 0 ? '<td></td>' : '<td>' . $fourth . '</td>';

			// if ($first === 0 || $second === 0 || $third === 0 || $fourth === 0) {
			// 	// echo '<td></td>';
			// }
				echo '</tr>';
			}
		}

		private function getCVGrade($lrno, $cvname, $bhv_grading)
		{
			$query = $this->conn->prepare("SELECT 
				bhv_remarks, core_values.cv_name, bhv_grading, behavior.bhv_id
				FROM
				behavior
				JOIN
				student st ON behavior.stud_idy = st.stud_id
				JOIN
				core_values ON behavior.bhv_id = core_values.cv_id
				JOIN 
				guardian g on st.guar_id = g.guar_id 
				JOIN 
				accounts ac on ac.acc_id = g.acc_idx 
				WHERE
				stud_lrno = :stud_lrno 
				AND
				acc_idx = :acc_id 
				AND 
				bhv_grading = :bhv_grading 
				AND 
				cv_name = :cv_name
				ORDER BY 3");
			$query->execute(array(
				':stud_lrno' => $lrno,
				':acc_id' => $_SESSION['accid'],
				':bhv_grading' => $bhv_grading,
				':cv_name' => $cvname
			));
			$result = $query->fetch();
			return $query->rowCount() > 0 ? $result['bhv_remarks'] : 0;
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
			//$remarks = $this->getRemarks($average);
				echo '<tr>';
				echo '<td>' . $subject_name . '</td>';
				echo $first === 0.0 ? '<td></td>' : '<td>' . $first . '</td>';
				echo $second === 0.0 ? '<td></td>' : '<td>' . $second . '</td>';
				echo $third === 0.0 ? '<td></td>' : '<td>' . $third . '</td>';
				echo $fourth === 0.0 ? '<td></td>' : '<td>' . $fourth . '</td>';
				if($first === 0.0 || $second === 0.00 || $third === 0.0 || $fourth === 0.0){
					echo '<td></td>';
				}else{
					echo '<td>' . $average . '</td>';
				}


				/*GET REMARKS*/
				if ($average === 0.0 ) {
					echo '<td></td>';
				}else if($fourth === null || $average === null) {
					echo '<td>'.$remarks.'</td>';
					// echo '
					// <td class="details">
					// <div name="content">	
					// <button class="customButton" name="opener" onclick="">
					// <div class="tooltip">
					// <i class="fas fa-edit"></i>
					// <span class="tooltiptext">View Details</span>
					// </div>
					// </button>
					// <div name="dialog" title="Detail(s) of Failing Mark/ Non-conformance">
					// <form action="parent-grades" method="POST">
					// <center><span><font color="red" size="5">Incomplete Requirements</font><span></center>
					// </form>
					// </div>  
					// </div>	
					// </td>
					// ';
				}else if($average <= 74.0 && $fourth === 0) {
					echo '<td>123444</td>';
				}else if($average >= 75.0){
					echo '<td><font color="green">Passed</font></td>'; 
				}else if($fourth === 0.0){
					echo '<td></td>';
				}else{
					echo '<td><font color="red">Failed</font></td>';
				}

				echo '<td></td>';
				echo '</tr>';
			}			
		}

		// private function getRemarks($average, $fourth){
		// 	$query = $this->conn->prepare("SELECT 
		// 		remarks, subj_id, grading
		// 		FROM
		// 		grades
		// 		JOIN
		// 		student ON grades.studd_id = student.stud_id
		// 		JOIN
		// 		facsec fs ON grades.secd_id = fs.sec_idy
		// 		JOIN
		// 		schedsubj ss ON (grades.facd_id = ss.fw_id
		// 		&& grades.secd_id = ss.sw_id)
		// 		JOIN
		// 		subject ON (ss.schedsubjb_id = subject.subj_id
		// 		&& grades.subj_ide = subject.subj_id)
		// 		WHERE
		// 		student.stud_lrno = :stud_lrno
		// 		GROUP BY 1 ORDER BY 1;");
		// 	$query->execute(array(
		// 		':stud_lrno' => $lrno
		// 	));
		// 	$result = $query->fetch();
		// 	return $query->rowCount() > 0 ? $result['remarks'] : 0;
		// }

		private function getGrade($lrno, $subject, $grading){
			$query = $this->conn->prepare("SELECT  CONCAT(first_name, ' ', last_name) 'Student', grade, subj_name 'subject', grading, remarks FROM grades JOIN student ON grades.studd_id = student.stud_id JOIN facsec fs ON grades.secd_id = fs.sec_idy JOIN schedsubj ss ON (grades.facd_id = ss.fw_id && grades.secd_id = ss.sw_id) JOIN subject ON (ss.schedsubjb_id = subject.subj_id && grades.subj_ide = subject.subj_id) WHERE student.stud_lrno = :stud_lrno AND subj_name = :subject AND grading = :grading GROUP BY 2 ORDER BY 3");
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
				'<b>RECESS</b>' AS subj_name,
				'' AS 'stud_sec',
				'' AS 'facultyname'

				UNION SELECT 
				'12:00:00' AS 'time_start',
				'13:00:00' AS 'time_end',
				'<b>LUNCH</b>' AS subj_name,
				'' AS 'stud_sec',
				'' AS 'facultyname'

				UNION SELECT 
				time_start,
				time_end,
				subj_name,
				CONCAT('G', year_level, ' - ', sec_name) AS 'stud_sec',
				CONCAT('Teacher: ',fac_fname,
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
				$subj_name = '';
				$faculty = isset($result[$c]['facultyname']) ? ($result[$c]['facultyname']) : '';
				$new_time_start = date('h:i A', strtotime($time_start[$c]));
				$new_time_end = date('h:i A', strtotime($time_end[$c]));
				foreach($result as $row) {
					if ($time_start[$c] == $row['time_start']) {
						$subj_name = $row['subj_name'];
						$section = $row['stud_sec'];
					}
				}
				echo '<td>'.$new_time_start.' - '.$new_time_end.'</td>';
				echo '<td colspan="5">'.($subj_name  !== '' ? '<div>'.$subj_name.'<br>'.$faculty.'</div>' : 'Unassigned').'</td>';
				echo '</tr>';
			}

		}

		/*END OF CODE*/
	}

	?>
