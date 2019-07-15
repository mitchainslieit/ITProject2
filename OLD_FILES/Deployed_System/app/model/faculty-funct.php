<!-- 
	Enrollment should be closed if classes are not yet finished
	Enrollment is open to all faculty while Transfering of student is only accessible to advisers 
-->
<?php
require 'app/model/connection.php';
require 'app/model/other-funct.php';
class FacultyFunct {

	public function __construct() {
		$this->others = new OtherMethods;
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
		$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}

	/********************** START OF DASHBOARD **********************/

	public function getNoOfMaleStudent() {
		$query = $this->conn->prepare("SELECT * FROM student WHERE gender='Male'");
		$query->execute();
		$getRowCount = $query->rowCount();
		echo $getRowCount;
	}

	public function getNoOfFemaleStudent() {
		$query = $this->conn->prepare("SELECT * FROM student WHERE gender='Female'");
		$query->execute();
		$getRowCount = $query->rowCount();
		echo $getRowCount;
	}

	public function getNoOfNewStudent() {
		$query = $this->conn->prepare("SELECT * FROM student WHERE stud_status = 'Officially Enrolled' OR stud_status = 'Temporarily Enrolled'");
		$query->execute();
		$getRowCount = $query->rowCount();
		echo $getRowCount;
	}

	/*0- all, 1- faculty, 2- parent, 3- student, 4- treasurer*/
	public function showEvents(){
		$admin_id = $_SESSION['accid'];
		$sql = $this->conn->prepare("SELECT  *, DATE_FORMAT(DATE(date_start), '%M %e, %Y') AS 'event_start', DATE_FORMAT(DATE(date_start), '%M %e, %Y') AS 'event_end' FROM announcements WHERE holiday = 'No' AND (title IS NOT NULL) AND (view_lim LIKE '%0%' OR view_lim LIKE '%1%') AND (date_start BETWEEN NOW() AND ADDDATE(NOW(), +364))") or die ("failed!");
		$sql->execute();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				echo '<tr style="text-align: left;">
					<td>'.$r['title'].'</td>
					<td>'.$r['event_start'].' - '.$r['event_end'].'</td>
				</tr>';
			}
		}
	}
	
	public function showHolidays(){
		$sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e') as date_start_1,  DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, DAY(CURDATE()), DAY(date_start) FROM announcements WHERE (view_lim like '%1%' or view_lim like '%0%') AND title IS NOT NULL AND holiday='Yes' AND (date_start between now() and adddate(now(), +15))") or die ("failed!");
		$sql->bindParam(1, $admin_id);
		$sql->execute();
		if($sql->rowCount() > 0){
			foreach ($sql->fetchAll() as $row) {
				echo '<tr>
					<td>'.$row['title'].'</td>
					<td>'.$row[2].'</td>
				</tr>';
			}
		}
	}
	
	public function getAnnouncements() {
		$admin_id = $_SESSION['accid'];
		$sql = $this->conn->prepare("SELECT * FROM announcements WHERE title IS NULL AND post IS NOT NULL AND (view_lim LIKE '%0%' OR view_lim LIKE '%1%');") or die ("failed!");
		$sql->execute();
		$result = $sql->fetchAll();
		foreach($result as $row) {
			$html = '<tr>';
			$html .= '<td class="tleft custPad2 longText">';
			$html .= '<h3 class="att_title">'.$row['post'].'</h3>';
			$html .= $row['attachment'] !== null ? '<p class="tright attachment text-right"><a href="public/attachment/'.$row['attachment'].'" download">Download attachment</a></p>' : '';
			$html .= '</td>';
			$html .= '</tr>';
			echo $html;
		}
	}

		/********************** START OF ASSESSMENT **********************/

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

	public function getTotalBDOF(){
		$query = $this->conn->prepare("SELECT FORMAT(sum(total_amount), 2) from budget_info");
		$query->execute();
		$rowCount = $query->rowCount();
		if ($rowCount > 0) while ($row = $query->fetch())
		{
			echo "&#x20B1;&nbsp;" . $row[0] . "";
		}
	}

	public function getDate(){
		$current_time = date("F j, Y");
		echo $current_time;
	}

	public function getName(){
		$query = $this->conn->prepare("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) as 'Name', stud_id FROM student WHERE stud_id IN (SELECT stud_id FROM student WHERE timestamp_stud = (SELECT MAX(timestamp_stud) FROM student)) ORDER BY stud_id DESC LIMIT 1");
		$query->execute();
		$result = $query->fetchAll();
		foreach($result as $row) {
			echo '<span value="'.$row['stud_id'].'">'.$row['Name'].'</span>';
		}
	}

	public function getLRN(){
		$query = $this->conn->prepare("SELECT stud_lrno, stud_id FROM student WHERE stud_id IN (SELECT stud_id FROM student WHERE timestamp_stud = (SELECT MAX(timestamp_stud) FROM student)) ORDER BY stud_id DESC LIMIT 1");
		$query->execute();
		$result = $query->fetchAll();
		foreach($result as $row) {
			echo '<span value="'.$row['stud_id'].'">'.$row['stud_lrno'].'</span>';
		}
	}

	public function getGradeLevel(){
		$query = $this->conn->prepare("SELECT CONCAT('GRADE ', year_level) AS 'stud_sec', stud_id FROM student WHERE stud_id IN (SELECT stud_id FROM student WHERE timestamp_stud = (SELECT MAX(timestamp_stud) FROM student)) ORDER BY stud_id DESC LIMIT 1");
		$query->execute();
		$result = $query->fetchAll();
		foreach($result as $row) {
			echo '<span value="'.$row['stud_id'].'">'.$row['stud_sec'].'</span>';
		}
	}

	/********************** END OF ASSESSMENT **********************/

	public function getSchoolYear() {
		$query = $this->conn->prepare("SELECT * FROM system_settings where sy_status ='Current'");
		$query->execute();
		$rowCount = $query->fetch();
		$sy_start1 = $rowCount['sy_start'];
		$sy_end1 = $rowCount['sy_end'];
		$sy_start = date('Y', strtotime($sy_start1));
		$sy_end = date('Y', strtotime($sy_end1));
		echo  " ".$sy_start. " - " .$sy_end. " ";
	}

	/********************** END OF DASHBOARD **********************/

	/********************** START OF ENROLLMENT **********************/

	public function oldStud() {
		$query = $this->conn->query("SELECT *, CONCAT(first_name,' ',middle_name,' ',last_name) as 'Name', CONCAT(guar_fname,' ', guar_midname,' ', guar_lname) as 'guar_name', guar_mobno FROM student st JOIN guardian gr ON st.guar_id = gr.guar_id WHERE stud_status = 'Transferred' OR (curr_stat = 'Old' AND stud_status = 'Not Enrolled' AND stud_status <> 'Graduated') ORDER BY year_level");
		$result = $query->fetchAll();
		foreach($result as $row) {
			$options = $this->createOption(array('Officially Enrolled', 'Temporarily Enrolled', 'Transfer'), $row['stud_status']);
			echo '<tr>';
			echo '<td>'.$row['stud_lrno'].'</td>';
			echo '<td>'.$row['Name'].'</td>';
			echo '<td>'.$row['stud_status'].'</td>';
			echo '<td><div class="btn-grp">';
			echo $this->editStatusMessage($row['Name'], $options, $row['stud_lrno']);	
			echo '</td></div>';
			echo '<td>'.$row['year_level'].'</td>';
			echo '</tr>';
		}
	}

	public function oldStud_prom() {
		$query = $this->conn->query("SELECT name, curr_yr_level 'Previous Year level', promote_yr_level 'Promoted Year Level', remarks 'Remarks' from promote_list join student on prom_studid = stud_id GROUP by prom_studid");
		$result = $query->fetchAll();
		foreach($result as $row) {
			echo '<tr>';
			echo '<td>'.$row['name'].'</td>';
			echo '<td>'.$row['Remarks'].'</td>';
			echo '</tr>';
		}
	}

	public function numOfStud() {
		$query = $this->conn->query("SELECT CAST(year_level AS SIGNED), CONCAT('Grade', ' - ', year_level) as 'Year Level', COUNT(CASE WHEN gender = 'Male' THEN 1 END) AS 'Male Students', COUNT(CASE WHEN gender = 'Female' THEN 1 END) AS 'Female Students', COUNT(year_level) AS 'Total Student Count' FROM student GROUP BY year_level ORDER BY 1");
		$result = $query->fetchAll();
		foreach ($result as $row) {
			echo '<tr>';
			echo '<td>'.$row['Year Level'].'</td>';
			echo '<td>'.$row['Male Students'].'</td>';
			echo '<td>'.$row['Female Students'].'</td>';
			echo '<td>'.$row['Total Student Count'].'</td>';
			echo '</tr>';
		}
	}

	public function enrollNewStudent($post) {
		if((strlen($post['stud_lrno']) < 13 || strlen($post['stud_lrno']) > 13) && (strlen($post['guar_mobno']) < 11 || strlen($post['guar_mobno']) > 11)) {
			$this->others->Message('Error!', 'You\'ve entered a wrong learner refence number and wrong guadian mobile number', 'error', 'faculty-enroll');
		} else if (strlen($post['stud_lrno']) < 13 || strlen($post['stud_lrno']) > 13) {
			$this->others->Message('Error!', 'You\'ve entered a wrong learner refence number', 'error', 'faculty-enroll');
		} else {
			$post['new_address'] = $post['address'].', '.$post['barangay'].', '.$post['city'].' '.$post['zipcode'];
			if ($this->checkIfExist($post['stud_lrno']) === 0) {
				$school_year = date('Y');
				$stud_username = str_replace(' ', '', ($post['first_name'][0].$post['middle_name'][0].$post['last_name']));
				if (isset($post['guar_id'])) {
					$add = $this->getGuarParInfo($post['guar_id']);
					$mother_name = $add['mother_name'];
					$father_name = $add['father_name'];
					$guar_id = $post['guar_id'];
				} else {
					$guar_id = $this->forGuarAcc($post);
					$mother_name = (!empty($post['mothername_first']) ? ($post['mothername_first'].' '.$post['mothername_middle_name'][0].'. '.$post['mothername_last']) : null);
					$father_name = (!empty($post['fathername_first']) ? ($post['fathername_first'].' '.$post['fathername_middle_name'][0].'. '.$post['fathername_last']) : null);
				}
				$stud_id = $this->createAccount($stud_username, 'password', 'Student');
				$getSecID = $this->getSection($post['gender'], $post['year_level']);
				$query = ("INSERT INTO student (stud_lrno, last_name, first_name, middle_name, gender, year_level, school_year, stud_address, stud_bday, mother_name, father_name, nationality, ethnicity, year_in, year_out, blood_type, medical_stat, stud_status, curr_stat, accc_id, secc_id, guar_id").(") VALUES (:stud_lrno, :last_name, :first_name, :middle_name, :gender, :year_level, :school_year, :stud_address, :stud_bday, :mother_name, :father_name, :nationality, :ethnicity, :year_in, :year_out, :blood_type, :medical_stat, :stud_status, 'New', :accc_id, :secc_id, :guar_id)");
				$insert_stud = $this->conn->prepare($query);
				$insert_stud->execute(array(
					':stud_lrno' => $post['stud_lrno'],
					':last_name' => ucfirst($post['last_name']),
					':first_name' => ucfirst($post['first_name']),
					':middle_name' => ucfirst($post['middle_name']),
					':gender' => $post['gender'],
					':year_level' => $post['year_level'],
					':school_year' => $school_year,
					':stud_address' => $post['new_address'],
					':stud_bday' =>	$post['stud_bday'],
					':mother_name' => $mother_name,
					':father_name' => $father_name,
					':nationality' => $post['nationality'],
					':ethnicity' => $post['ethnicity'],
					':year_in' => $school_year,
					':year_out' => null,
					':blood_type' => $post['blood_type'],
					':medical_stat' => (empty($post['medical_stat']) ? null : $post['medical_stat']),
					':stud_status' => $post['stud_status'],
					':accc_id' => $stud_id,
					':secc_id' => $getSecID,
					':guar_id' => $guar_id
				));
				$_SESSION['student_lrno_assess'] = $post['stud_lrno'];
				$getStudentID = $this->conn->prepare("SELECT stud_id FROM student WHERE stud_lrno = :lrno");
				$getStudentID->execute(array(':lrno' => $post['stud_lrno']));
				$_SESSION['latest_enrolled'] = $post['stud_lrno'];
				$result = $getStudentID->fetch();
				$stud_id = $result['stud_id'];
				$addtoBal = $this->conn->query("INSERT INTO balance (misc_fee, bal_amt, bal_status, stud_idb) VALUES ((SELECT SUM(total_amount) FROM budget_info), (SELECT SUM(total_amount) FROM budget_info), 'Not Cleared', '".$stud_id."')");
				
				$this->createLog('Insert', 'Enrolled '.$post['first_name'].' '.$post['middle_name'][0].'. '.$post['last_name']);
				$this->others->Message('Success!', $post['first_name'].' '.$post['middle_name'][0].'. '.$post['last_name'].' has successfully enrolled!', 'success', 'faculty-assess');
			} else {
				$this->others->Message('Error!', 'That student is already enrolled!', 'error', 'faculty-enroll');
			}
		}
	}

	public function updateStudentDetails($post) {
		$curr_stat = $this->conn->query("SELECT *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as 'name' FROM student WHERE stud_lrno = '".$post['lrn']."'");
		$result = $curr_stat->fetch();
		date_default_timezone_set('Asia/Manila');
		$year_out = date('Y');
		if ($post['curr-status'] === 'Transfer') {
			$change_stat = $this->conn->prepare("UPDATE student SET stud_status = 'Transferred', year_out = :year_out WHERE stud_lrno = :stud_lrno");
			$change_stat->execute(array(
				':year_out' => $year_out,
				':stud_lrno' => $post['lrn']
			));
			$this->createLog('Update', 'Transferred a student.');
			$this->others->Message('Success!', "The student has been transferred!", "success", "faculty-enroll");
		} else {
			$getCurrent_yrlvl_system_settings = $this->conn->query("SELECT *, DATE_FORMAT(sy_start, '%Y') as 'year_start' FROM system_settings WHERE sy_status = 'Current'");
			$resultSY = $getCurrent_yrlvl_system_settings->fetch();
			$change_stat = $this->conn->prepare("UPDATE student SET school_year = :sy, year_out = NULL, stud_status = :stat WHERE stud_lrno = :lrno");
			$change_stat->execute(array(
				':sy' => $resultSY['year_start'],
				':stat' => $post['curr-status'],
				':lrno' => $post['lrn']
			));
			if ($result['stud_status'] === 'Not Enrolled') {
				$getCurrent_year_level = $this->conn->query("SELECT stud_id, year_level, gender, CONCAT(first_name, ' ', middle_name, ' ', last_name) as 'name', year_level FROM student WHERE stud_lrno='".$post['lrn']."'");
				$result = $getCurrent_year_level->fetch();
				if (isset($post['promote'])) {
					if ($result['year_level'] <= '7') {
						$result['year_level'] = (int) $result['year_level'];	
					} else {
						$result['year_level'] = (int) $result['year_level'] - 1;
					}
					$this->conn->query("UPDATE student SET sec_stat = 'Permanent', year_level = '".$result['year_level']."' WHERE stud_lrno='".$post['lrn']."'");
				}
				$newSec = $this->getSection($result['gender'], $result['year_level']);
				$this->conn->query("UPDATE student SET sec_stat = 'Permanent', secc_id='".$newSec."' WHERE stud_lrno='".$post['lrn']."'");
				$update_balance = $this->conn->prepare("UPDATE balance SET misc_fee = (SELECT SUM(total_amount) FROM budget_info), bal_amt = (SELECT SUM(total_amount) FROM budget_info), bal_status = 'Not Cleared' WHERE stud_idb = :stud_id");
				$update_balance->execute(array(
					':stud_id' => $result['stud_id']
				));
				$_SESSION['latest_enrolled'] = $post['lrn'];
				$this->createLog('Update', $result['name'].' has been enrolled.');
				$this->others->Message('Success!', $result['name'].' has been enrolled', "success", "faculty-assess");
			} else {
				$this->createLog('Update', 'Change the '.$result['name'].'\'s status.');
				$this->others->Message('Success!,', "The status of the student has been changed successfully!", "success", "faculty-enroll");
			}
		}
	}

	public function getGuardians() {
		$sql = $this->conn->query("SELECT * FROM student st JOIN guardian gr ON st.guar_id = gr.guar_id GROUP BY gr.guar_id") or die("There is an error in your query");
		$result = $sql->fetchAll();
		if ($result > 0) {
			foreach($result as $row) {
				echo '<option value="'.$row['guar_id'].'">'.$row['guar_fname'].' '.$row['guar_midname'].' '.$row['guar_lname'].'</option>';
			}
		} else {
			echo '<option value="">No data yet!</option>';
		}
	}

	private function getGuarParInfo($guar_id) {
		$sql = $this->conn->query("SELECT * FROM student st JOIN guardian gr ON st.guar_id = gr.guar_id WHERE st.guar_id = '".$guar_id."' GROUP BY st.guar_id LIMIT 1");
		return $sql->fetch();
	}

	private function checkStatus($lrn, $new_stat) {
		$sql = $this->conn->query("SELECT * FROM student WHERE stud_lrno = '".$lrn."'");
		$result = $sql->fetch();
		return $result['stud_status'] === $new_stat ? true : false;
	}

	private function forGuarAcc($post) {
		$guarAccID = $this->createAccount($post['guar_last'], 'password', 'Parent');
		$insert_par = $this->conn->prepare("INSERT INTO guardian (guar_fname, guar_lname, guar_midname, guar_address, guar_mobno, guar_telno, acc_idx) VALUES (:guar_fname, :guar_lname, :guar_midname, :guar_address, :guar_mobno, :guar_telno, :acc_idx)");
		$array = array(
			':guar_fname' => ucfirst($post['guar_first']),
			':guar_lname' => ucfirst($post['guar_last']),
			':guar_midname' => ucfirst($post['guar_middle_name']),
			':guar_address' => $post['new_address'],
			':guar_mobno' => $post['guar_mobno'],
			':guar_telno' => (empty($post['guar_telno']) ? $post['guar_telno'] : null),
			':acc_idx' => $guarAccID
		);
		$insert_par->execute($array) or die('Not Working!');
		$getID = $this->conn->query("SELECT guar_id FROM guardian WHERE acc_idx=".$guarAccID."");
		$result = $getID->fetch();
		$this->createLog('Insert', 'Created an account for guardian');
		return $result['guar_id'];
	}

	/********************** END OF ENROLLMENT **********************/

	/********************** START OF STUDENT LIST **********************/

	public function checkIfEnabledTransfer() {
		$query = $this->conn->query("SELECT * FROM system_settings WHERE sy_status = 'Current'");
		$fetchResult = $query->fetch();
		return $fetchResult['student_transfer'] === 'Yes' ? true : false;
	}

	public function showAdvStudent_stud($fac_id) {
		$sql = $this->conn->prepare("SELECT  *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as stud_fullname FROM guardian gr JOIN student st ON gr.guar_id = st.guar_id JOIN section ON secc_id = sec_id JOIN faculty ON fac_id = fac_idv WHERE fac_id = (SELECT fac_id FROM faculty join accounts ON acc_id = acc_idz WHERE acc_id=:fac_id) AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated' AND sec_stat <> 'Temporary')");
		$sql->execute(array(':fac_id' => $fac_id));
		$result = $sql->fetchAll();
		if ($sql->rowCount() > 0) {
			foreach ($result as $row) {
				echo '<tr>';
				echo '<td width="100%">'.$row['stud_fullname'].'</td>';
				echo '</tr>';
			}
		} else {
			echo '<tr><td colspan="3">There are no student in this section yet!</td></tr>';
		}
	}

	public function displayAllStudentHandledInDifferentSubjects(){
		 $querySchedule = $this->conn->prepare("SELECT CASE WHEN subj_name LIKE ('%Music%') OR subj_name LIKE ('%(PE)%') OR subj_name LIKE ('%Physical Education%') OR subj_name LIKE ('%Health%') OR subj_name LIKE ('%Arts%') THEN (CASE WHEN subj_level = '7' THEN 'MAPEH 1' WHEN subj_level = '8' THEN 'MAPEH 2' WHEN subj_level = '9' THEN 'MAPEH 3' WHEN subj_level = '10' THEN 'MAPEH 4' ELSE 'MAPEH' END) ELSE subj_name END AS subject, fac_id, time_start, time_end, subj_name, CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS 'stud_sec', sec_id, subj_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN accounts ON acc_idz = acc_id WHERE acc_id = :accid  GROUP BY time_start ORDER BY time_start") or die("FAILED");
        $querySchedule->execute(array(
        	':accid' => $_SESSION['accid']
        ));
        $result = $querySchedule->fetchAll();
        foreach($result as $row) {
        	$time_start = date('h:i A', strtotime($row['time_start']));
        	$time_end = date('h:i A', strtotime($row['time_end']));
        	echo '<tr>';
        	echo '<td>'.$row['stud_sec'].'</td>';
        	echo '<td>'.$row['subject'].'</td>';
        	echo '<td>'.$time_start.' - '.$time_end.' Daily</td>';
        	echo '<td>
				<div name="dialog" title="'.$row['stud_sec'].' Students">
					<div class="container">
						<div class="modal-cont">
				        		<div class="date-subj">
									<div class="subject d-flex justify-content-between">
										<label>
											<span>Gender:&nbsp;</span>
											<select id="filter_by_gender">
												<option value="">All</option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>
										</label>
										<p>Subject: <span>'.$row['subject'].'</span><input type="hidden" name="subject-code" value="'.$row['subj_id'].'" readonly=""></p>
									</div>
				        		</div>
								<div class="table-cont">
									<table class="table" id="students_handled_faculty_only">
										<thead>
											<th>Student Name</th>
											<th>Gender</th>
										</thead>
										<tbody>';
			$getStudents = $this->conn->prepare("SELECT *, CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name' FROM student WHERE secc_id = :sec_id ORDER BY gender, last_name");
			$getStudents->execute(array(
				':sec_id' => $row['sec_id']
			));
			$student = $getStudents->fetchAll();
			foreach ($student as $stud) {
				echo '<tr>';
				echo '<td>'.$stud['Name'].'</td>';
				echo '<td>'.$stud['gender'].'</td>';
				echo '</tr>';
			}
			echo '					</tbody>
								</table>
							</div>
					</div>
					</div>
				</div>
				<button type="button" name="opener" data-type="open-dialog" class="btn btn-primary"><i class="far fa-eye"></i></button>
        	</td>';
        	echo '</tr>';
        }
	}

	public function showAdvStudent($fac_id) {
		$sql = $this->conn->prepare("SELECT  *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as stud_fullname FROM guardian gr JOIN student st ON gr.guar_id = st.guar_id JOIN section ON secc_id = sec_id JOIN faculty ON fac_id = fac_idv WHERE fac_id = (SELECT fac_id FROM faculty join accounts ON acc_id = acc_idz WHERE acc_id=:fac_id) AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated' AND sec_stat <> 'Temporary') ORDER BY gender, last_name");
		$sql->execute(array(':fac_id' => $fac_id));
		$result = $sql->fetchAll();
		if ($sql->rowCount() > 0) {
			foreach ($result as $row) {
				echo '<tr>';
				echo '<td width="65%">'.$row['stud_fullname'].'</td>';
				if ($this->checkIfEnabledTransfer() === true) {
					echo '<td width="5%"><input type="checkbox" name="students[]" value="'.$row['stud_id'].'"></td>';
				}
				echo '</tr>';
			}
		} else {
			echo '<tr><td colspan="3">There are no student in this section yet!</td></tr>';
		}
	}

	public function showAdvStudentEdit($fac_id) {
		$sql = $this->conn->prepare("SELECT  *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as stud_fullname FROM guardian gr JOIN student st ON gr.guar_id = st.guar_id JOIN section ON secc_id = sec_id JOIN faculty ON fac_id = fac_idv WHERE fac_id = (SELECT fac_id FROM faculty join accounts ON acc_id = acc_idz WHERE acc_id=:fac_id) AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated' AND sec_stat <> 'Temporary')");
		$sql->execute(array(':fac_id' => $fac_id));
		$result = $sql->fetchAll();
		if ($sql->rowCount() > 0) {
			foreach ($result as $row) {
				echo '<tr>';
				echo '<td width="65%">'.$row['stud_fullname'].'</td>';
				echo '<td width="20%">'.$row['gender'].'</td>';
				echo '<td width="15%">'.$this->editDetailsMessage($row).'</td>';
				echo '</tr>';
			}
		} else {
			echo '<tr><td colspan="3">There are no student in this section yet!</td></tr>';
		}
	}

	public function showAdvStudents_attendance($fac_id) {
		$sql = $this->conn->prepare("SELECT  *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as stud_fullname FROM guardian gr JOIN student st ON gr.guar_id = st.guar_id JOIN section ON secc_id = sec_id JOIN faculty ON fac_id = fac_idv WHERE fac_id = (SELECT fac_id FROM faculty join accounts ON acc_id = acc_idz WHERE acc_id=:fac_id) AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated' AND sec_stat <> 'Temporary')");
		$sql->execute(array(':fac_id' => $fac_id));
		$result = $sql->fetchAll();
		if ($sql->rowCount() > 0) {
			foreach ($result as $row) {
				echo '<tr>';
				echo '<td width="85%">'.$row['stud_fullname'].'</td>';
				echo '<td width="15%">'.$this->checkStudentAttendancePerStudent($row).'</td>';
				echo '</tr>';
			}
		} else {
			echo '<tr><td colspan="2">There are no student in this section yet!</td></tr>';
		}
	}

	public function showReqStudent($fac_id) {
		$sql = $this->conn->prepare("SELECT  *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as stud_fullname FROM guardian gr JOIN student st ON gr.guar_id = st.guar_id JOIN section ON secc_id = sec_id JOIN faculty ON fac_id = fac_idv WHERE fac_id = (SELECT fac_id FROM faculty join accounts ON acc_id = acc_idz WHERE acc_id=:fac_id) AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated' AND sec_stat <> 'Permanent')");
		$sql->execute(array(':fac_id' => $fac_id));
		$result = $sql->fetchAll();
		if ($sql->rowCount() > 0) {
			foreach ($result as $row) {
				echo '<tr>';
				echo '<td width="95%">'.$row['stud_fullname'].'</td>';
				echo '<td width="5%"><input type="checkbox" name="students[]" value="'.$row['stud_id'].'"></td>';
				echo '</tr>';
			}
		} else {
			echo '<tr><td colspan="2">You don\'t have any pending request.</td></tr>';
		}
	}

	public function requestChange($post){
		if(isset($post['students'])) {
			foreach($post['students'] as $stud) {
				$update = $this->conn->prepare("UPDATE student SET sec_stat = 'Temporary', transfer_sec = :temp_sec WHERE stud_id =:id");
				$update->execute(array(
					':temp_sec' => $post['transfer-sec'],
					':id' => $stud
				));
			}
			$sql = $this->conn->prepare("SELECT  CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS section_handled FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id");
			$sql->execute(array(':acc_id' => $_SESSION['accid']));
			$result = $sql->fetch();
			$this->createLog('Update', 'Created a request to transfer students from '.$result['section_handled']);
			$this->others->Message('Success!,', 'Your request has been sent', "success", "faculty-student-transfer");
		} else {
			$this->others->Message('Error!,', "You haven't choose any student!", "error", "faculty-student-transfer");
		}
	}

	public function cancelRequest($post){
		if(isset($post['students'])) {
			foreach($post['students'] as $stud) {
				$update = $this->conn->prepare("UPDATE student SET sec_stat = 'Permanent', transfer_sec = :temp_sec WHERE stud_id =:id");
				$update->execute(array(
					':temp_sec' => null,
					':id' => $stud
				));
			}
			$sql = $this->conn->prepare("SELECT  CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS section_handled FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id");
			$sql->execute(array(':acc_id' => $_SESSION['accid']));
			$result = $sql->fetch();
			$this->createLog('Update', 'Some request for '.$result['section_handled'].' has been cancelled');
			$this->others->Message('Success!,', 'You\'ve successfully cancelled some of your request', "success", "faculty-student-transfer");
		} else {
			$this->others->Message('Error!,', "You haven't choose any student!", "error", "faculty-student-transfer");
		}
	}

	public function updateStudentInfo($post) {
		$sql = $this->conn->prepare("SELECT * FROM student WHERE stud_lrno = :stud_lrno");
		$sql->execute(array(
			':stud_lrno' => $post['stud_lrno']
		));
		$exist = $sql->rowCount();
		$stud_det = $sql->fetch();
		if (!($exist > 0) || $stud_det['stud_lrno'] === $post['stud_lrno']) {
			$getStudInfo = $this->conn->prepare("SELECT *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as 'stud_fullname' FROM student WHERE stud_id = :student_id");
			$getStudInfo->execute(array(
				':student_id' => $post['student_id']
			));
			$result = $getStudInfo->fetch();
			$update_info = $this->conn->prepare("UPDATE student SET stud_lrno = :stud_lrno, last_name = :last_name, first_name = :first_name, middle_name =:middle_name, gender = :gender, stud_address = :address, stud_bday = :stud_bday, mother_name = :mother_name, father_name = :father_name, nationality = :nationality, ethnicity = :ethnicity, blood_type = :blood_type, medical_stat = :medical_stat  WHERE stud_id = :student_id");
			$update_info->execute(array(
				':stud_lrno' => $post['stud_lrno'],
				':last_name' => $post['last_name'],
				':first_name' => $post['first_name'],
				':middle_name' => $post['middle_name'],
				':gender' => $post['gender'],
				':address' => $post['address'],
				':stud_bday' => $post['stud_bday'],
				':mother_name' => $post['mother_name'],
				':father_name' => $post['father_name'],
				':nationality' => $post['nationality'],
				':ethnicity' => $post['ethnicity'],
				':blood_type' => $post['blood_type'],
				':medical_stat' => ($post['medical_stat'] !== null ? $post['medical_stat'] : null),
				':student_id' => $post['student_id']
			));
			$this->createLog('Update', 'Updated the details of '.$result['stud_fullname']);
			$this->others->Message('Success!,', 'The details of '.$result['stud_fullname'].' has been changed', "success", "faculty-student");
		} else {
			$this->others->Message('Error!,', "You can't use that LRN No. because it already exist!", "error", "faculty-student");
		}
	}

	public function getNumberofSec($acc_id) {
		$query = $this->conn->prepare("SELECT grade_lvl FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id");
		$query->execute(array(
			':acc_id' => $acc_id
		));
		$result = $query->fetch();
		$check = $this->conn->prepare("SELECT COUNT(*) 'count' FROM section WHERE grade_lvl = :lvl");
		$check->execute(array(
			':lvl' => $result['grade_lvl']
		));
		$resultCheck = $check->fetch();
		return $resultCheck['count'] > 1 ? true : false;
	}

	public function getAdvSection($acc_id) {
		$sql = $this->conn->prepare("SELECT  CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS section_handled FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id");
		$sql->execute(array(':acc_id' => $acc_id));
		$result = $sql->fetch();
		echo $result['section_handled'];
	}	

	public function getOppoSection($acc_id) {
		$getAdvSection = $this->conn->prepare("SELECT  CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS section_handled, grade_lvl FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id");
		$getAdvSection->execute(array(':acc_id' => $acc_id));
		$resultAdv = $getAdvSection->fetch();
		$grade_lvl =$resultAdv['grade_lvl'];
		$sql = $this->conn->prepare("SELECT  sec_id, CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS oppo_section FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id <> :acc_id AND grade_lvl = :grade_lvl");
		$sql->execute(array(':acc_id' => $acc_id, ':grade_lvl' => $grade_lvl));
		$result = $sql->fetchAll();
		$html = '';
		foreach($result as $row) {
			$html .= '<option value="'.$row['sec_id'].'">'.$row['oppo_section'].'</option>';
		}
		echo $html;
	}

	public function showOppoStudent($acc_id) {
		$getAdvSection = $this->conn->prepare("SELECT  CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS section_handled, grade_lvl FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id");
		$getAdvSection->execute(array(':acc_id' => $acc_id));
		$resultAdv = $getAdvSection->fetch();
		$grade_lvl =$resultAdv['grade_lvl'];
		$sql = $this->conn->prepare("SELECT  *, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS stud_fullname FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv JOIN student ON sec_id = secc_id WHERE (sec_stat = 'Permanent' OR sec_stat = 'Temporary') AND grade_lvl = (SELECT  grade_lvl FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id) AND acc_id <> :acc_id AND grade_lvl = :grade_lvl AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated') ORDER BY gender, last_name");
		$sql->execute(array(':acc_id' => $acc_id, ':grade_lvl' => $grade_lvl));
		$result = $sql->fetchAll();
		if($sql->rowCount() > 0) {
			foreach ($result as $row) {
				echo '<tr>';
				echo '<td>'.$row['stud_fullname'].'</td>';
				echo '<td>'.$row['sec_id'].'</td>';
				echo '</tr>';
			}
		}
	}

	/********************** END OF STUDENT LIST **********************/

	/********************** START OF CLASSES HANDLED **********************/

	public function postAnnc($details, $attachment) {
		$getFacID = $this->conn->query("SELECT fac_id FROM faculty JOIN accounts ON acc_idz = acc_id WHERE acc_id = '".$_SESSION['accid']."'");
		$result = $getFacID->fetch();
		$facid = $result['fac_id'];
		if (empty($attachment['name'])) {
			$query = $this->conn->prepare("INSERT INTO announcements (post, view_lim, post_facid, gr_sec) VALUES (:post, :view_lim, :post_facid, :sec_id)");
			$query->execute(array(
				':post' => $details['post'],
				':view_lim' => '3',
				':post_facid' => $facid,
				':sec_id' => $details['grade_sec']
			));
			$getAnnouncementID = $this->conn->query("SELECT ann_id FROM announcements WHERE post_facid = '".$facid."' ORDER BY ann_id DESC LIMIT 1");
			$result = $getAnnouncementID->fetch();
			$ann_id = $result['ann_id'];
			$insert_facann = $this->conn->prepare("INSERT INTO facann (fac_idb, ann_ida) VALUES (:fac_id, :ann_ida)");
			$insert_facann->execute(array(
				':fac_id' => $facid,
				':ann_ida' => $ann_id
			));
			$this->createLog('Insert', 'Posted a new announcement for students');
			$this->others->Message('Success!,', 'The announcement has been posted', "success", "faculty-classes-postannouncements");
		} else {
			if ($attachment['size'] < 20000000) {
				$query = $this->conn->prepare("INSERT INTO announcements (post, view_lim, post_facid, gr_sec) VALUES (:post, :view_lim, :post_facid, :sec_id)");
				$query->execute(array(
					':post' => $details['post'],
					':view_lim' => '3',
					':post_facid' => $facid,
					':sec_id' => $details['grade_sec']
				));
				$getAnnouncementID = $this->conn->query("SELECT ann_id FROM announcements WHERE post_facid = '".$facid."' ORDER BY ann_id DESC LIMIT 1");
				$result = $getAnnouncementID->fetch();
				$ann_id = $result['ann_id'];
				$temp = explode('.', $attachment['name']);
				$new_name = 'attachment_'.$ann_id.'.'.$temp[1];
				move_uploaded_file($attachment['tmp_name'], 'public/attachment/'.$new_name);
				$updateDB = $this->conn->prepare("UPDATE announcements SET attachment = :new_name WHERE ann_id=:ann_id");
				$updateDB->execute(array(
					':new_name' => $new_name,
					':ann_id' => $ann_id
				));
				$insert_facann = $this->conn->prepare("INSERT INTO facann (fac_idb, ann_ida) VALUES (:fac_id, :ann_ida)");
				$insert_facann->execute(array(
					':fac_id' => $facid,
					':ann_ida' => $ann_id
				));
				$this->createLog('Insert', 'Posted a new announcement for students');
				$this->others->Message('Success!,', 'The announcement has been posted', "success", "faculty-classes-postannouncements");
			} else {
				$this->others->Message('Error!,', "You're file is too large!", "error", "faculty-classes-postannouncements");
			}
		}
	}

	public function setSchedule($post) {
		$time_start = array('07:40:00', '08:40:00', '10:00:00', '11:00:00', '13:00:00', '14:00:00', '15:00:00');
		$time_end = array('08:40:00', '09:40:00', '11:00:00', '12:00:00', '14:00:00', '15:00:00', '16:00:00');
		for($c = 0; $c < count($time_start); $c++ ) {
			echo $this->checkExisitingSched($time_start[$c], $post['sec_id']);
		}
	}

	private function checkExisitingSched($time_start, $sec_id) {
		$sql = $this->conn->query("SELECT  * FROM schedsubj WHERE time_start = '".$time_start."' AND sw_id = '".$sec_id."'");
		$rc = $sql->rowCount();
		return $rc == 0 ? false : true;
	}

	public function getSchedule() {
        $querySchedule = $this->conn->prepare("SELECT  '09:40:00' AS 'time_start', '10:00:00' AS 'time_end', 'RECESS' AS subject, '' AS 'stud_sec' UNION SELECT  '12:00:00' AS 'time_start', '13:00:00' AS 'time_end', 'LUNCH' AS subject, '' AS 'stud_sec' UNION SELECT  time_start, time_end, CASE WHEN subj_name LIKE ('%Music%') OR subj_name LIKE ('%(PE)%') OR subj_name LIKE ('%Physical Education%') OR subj_name LIKE ('%Health%') OR subj_name LIKE ('%Arts%') THEN (CASE WHEN subj_level = '7' THEN 'MAPEH 1' WHEN subj_level = '8' THEN 'MAPEH 2' WHEN subj_level = '9' THEN 'MAPEH 3' WHEN subj_level = '10' THEN 'MAPEH 4' ELSE 'MAPEH' END) ELSE subj_name END AS subject, CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS 'stud_sec' FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id  JOIN accounts ON acc_idz = acc_id WHERE acc_id = ? GROUP BY time_start ORDER BY 1") or die("FAILED");
        $querySchedule->bindParam(1, $_SESSION['accid']);
        $querySchedule->execute();
        $result = $querySchedule->fetchAll();
        $time_start = array('07:40:00', '08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00');
        $time_end = array('08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00');
        echo '<div class="widgetcontent">
        <table>
        <tr>
	        <td>Schedule</td>
	        <td>Subject</td>	
	        <td>Section</td>
        </tr>';
        for ($c = 0; $c < count($time_start); $c++) {
        	echo '<tr>';
        	$subj_name = '';
        	$section = '';
        	$new_time_start = date('h:i A', strtotime($time_start[$c]));
        	$new_time_end = date('h:i A', strtotime($time_end[$c]));
        	foreach($result as $row) {
        		if ($time_start[$c] == $row['time_start']) {
        			$subj_name = $row['subject'];
        			$section = $row['stud_sec'];
        		}
        	}
        	echo '<td>'.$new_time_start.' - '.$new_time_end.' Daily</td>';
        	if ($subj_name === 'RECESS' || $subj_name === 'LUNCH') {
        		echo '<td colspan="2">'.($subj_name  !== '' ? '<div>'.$subj_name.'</div>' : 'Unassigned').'</td>';
        	} else if ($subj_name  === '') {
        		echo '<td colspan="2">Unassigned</td>';
        	} else {
	        	echo '<td>'.($subj_name  !== '' ? '<div>'.$subj_name.'</div>' : 'Unassigned').'</td>';
	        	echo '<td>'.($subj_name  !== '' ? '<div>'.$section.'</div>' : 'Unassigned').'</td>';
        	}
        	echo '</tr>';
        }
        
    }

    public function createSectionOptions() {
    	$sql = $this->conn->prepare("SELECT *, CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS 'stud_sec' FROM accounts JOIN faculty ON acc_id = acc_idz JOIN schedsubj ON fac_id = fw_id JOIN section ON sw_id = sec_id WHERE acc_id = :accid GROUP BY sec_id ORDER BY grade_lvl, sec_name");
    	$sql->execute(array(
    		':accid' => $_SESSION['accid']
    	));
    	$checkAdv = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :accid");
    	$checkAdv->execute(array(
    		':accid' => $_SESSION['accid']
    	));
    	$result = $sql->fetchAll();
    	if ($checkAdv->rowCount() > 0) {
	    	foreach($result as $row) {
	    		echo '<option value="'.$row['sec_id'].'">'.$row['stud_sec'].' '.($row['fac_id'] === $row['fac_idv'] ? '(Advisory Class)' : '').'</option>';
	    	}
    	} else {
    		foreach($result as $row) {
	    		echo '<option value="'.$row['sec_id'].'">'.$row['stud_sec'].'</option>';
	    	}
    	}
    }

    public function getScheduleAdvisory() {
        $querySchedule = $this->conn->prepare("SELECT  '09:40:00' AS 'time_start', '10:00:00' AS 'time_end', 'RECESS' AS subject, '' AS 'stud_sec', '' AS 'facultyname' UNION SELECT  '12:00:00' AS 'time_start', '13:00:00' AS 'time_end', 'LUNCH' AS subject, '' AS 'stud_sec', '' AS 'facultyname' UNION SELECT  time_start, time_end, CASE WHEN subj_name LIKE ('%Music%') OR subj_name LIKE ('%(PE)%') OR subj_name LIKE ('%Physical Education%') OR subj_name LIKE ('%Health%') OR subj_name LIKE ('%Arts%') THEN (CASE WHEN subj_level = '7' THEN 'MAPEH 1' WHEN subj_level = '8' THEN 'MAPEH 2' WHEN subj_level = '9' THEN 'MAPEH 3' WHEN subj_level = '10' THEN 'MAPEH 4' ELSE 'MAPEH' END) ELSE subj_name END AS subject, CONCAT('G', grade_lvl, ' - ', sec_name) AS 'stud_sec', CONCAT(fac_fname, ' ', fac_midname, ' ', fac_lname) AS 'facultyname' FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN accounts ON acc_idz = acc_id WHERE sec_id = (SELECT  sec_id FROM section JOIN faculty ON section.fac_idv = faculty.fac_id JOIN schedsubj ss ON ss.fw_id = faculty.fac_id JOIN subject ON subject.subj_id = ss.schedsubjb_id JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE (fac_adviser = 'Yes' AND acc_id = ?) GROUP BY 1) GROUP BY time_start ORDER BY 1") or die ("FAILED");
        $querySchedule->bindParam(1, $_SESSION['accid']);
        $querySchedule->execute();
        $result = $querySchedule->fetchAll();
        $time_start = array('07:40:00', '08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00');
        $time_end = array('08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00');
        echo '
        <tr>
        	<td>Schedule</td>	
        	<td>Subject</td>
        	<td>Teacher</td>
        </tr>';

        for ($c = 0; $c < count($time_start); $c++) {
        	echo '<tr>';
        	$subj_name = '';
        	$faculty = '';
        	$new_time_start = date('h:i A', strtotime($time_start[$c]));
        	$new_time_end = date('h:i A', strtotime($time_end[$c]));
        	foreach($result as $row) {
        		if ($time_start[$c] == $row['time_start']) {
        			$subj_name = $row['subject'];
        			$faculty = $row['facultyname'];
        		}
        	}
        	echo '<td>'.$new_time_start.' - '.$new_time_end.' Daily</td>';
        	if ($subj_name === 'RECESS' || $subj_name === 'LUNCH') {
        		echo '<td colspan="2">'.($subj_name  !== '' ? '<div>'.$subj_name.'</div>' : 'Unassigned').'</td>';
        	} else {
	        	echo '<td>'.($subj_name  !== '' ? '<div>'.$subj_name.'</div>' : 'Unassigned').'</td>';
	        	echo '<td'.($subj_name  !== '' ? '><div>'.$faculty.'</div>' : 'Unassigned').'</td>';
        	}
        	echo '</tr>';
        }
        
    }

    public function isAdviser($acc_id) {
    	$sql = $this->conn->query("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz WHERE acc_id = '".$acc_id."' AND fac_adviser = 'Yes'");
    	return $sql->rowCount() != 0 ? true : false;
    }

    public function getAdviserSection($acc_id) {
    	$sql = $this->conn->prepare("SELECT * FROM section JOIN faculty ON fac_idv = fac_id JOIN accounts ON acc_idz = acc_id WHERE acc_id = :accid");
    	$sql->execute(array(
    		':accid' => $acc_id
    	));
    	$result = $sql->fetch();
    	echo $result['sec_id'];
    }

    public function getAnnouncementsFaculty($acc_id) {
		$sql = $this->conn->prepare("SELECT fac_id FROM faculty JOIN accounts ON acc_idz = acc_id WHERE acc_id = :accid");
		$sql->execute(array(
			':accid' => $acc_id
		));
		$result = $sql->fetch();
		$fac_id = $result['fac_id'];
		$getAnnc = $this->conn->prepare("SELECT * FROM announcements WHERE post_facid = :fac_id");
		$getAnnc->execute(array(
			':fac_id' => $fac_id
		));
		$getOwnAdvisory = $this->conn->prepare("SELECT * FROM faculty JOIN section ON fac_id = fac_idv WHERE fac_id = :fac_id");
		$getOwnAdvisory->execute(array(
			':fac_id' => $fac_id
		));
		$advsec = $getOwnAdvisory->fetch();
		$result = $getAnnc->fetchAll();
		$sql = $this->conn->prepare("SELECT *, CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS 'stud_sec' FROM accounts JOIN faculty ON acc_id = acc_idz JOIN schedsubj ON fac_id = fw_id JOIN section ON sw_id = sec_id WHERE acc_id = :accid GROUP BY sec_id ORDER BY grade_lvl, sec_name");
    	$sql->execute(array(
    		':accid' => $_SESSION['accid']
    	));
    	$sections = $sql->fetchAll();
    	$option = '';
		foreach($sections as $secs) {
			$option .= '<option value="'.$secs['sec_id'].'">'.$secs['stud_sec'].'</option>';
		}
		if($getAnnc->rowCount() > 0) {
			foreach ($result as $row) {
				echo '<tr>';
				echo '<td>'.$row['post'].'</td>';
				echo '<td width="15%">
					<div name="dialog" title="Edit an announcement">
						<div class="container">
							<div class="modal-cont">
								<form action="faculty-classes-postannouncements" method="POST" enctype="multipart/form-data">
									<input type="hidden" name="announcement_id" value="'.$row['ann_id'].'">
									<textarea class="d-block mb-3" placeholder="Announcement Description" name="post" rows="5" cols="33" value="'.$row['post'].'" required></textarea>';
									if ($row['gr_sec'] === $advsec['sec_id']) {
										echo '<input type="hidden" name="gr_sec" value="'.$row['gr_sec'].'">';
									} else {
										echo '<select class="form-control mb-3" name="gr_sec">';
										echo $option;
										echo '</select>';
									}
				echo 			'<div class="file-upload-wrapper" data-text="Upload a file/note">
									<input name="file" type="file" class="file-upload-field" value="">
								</div>
								<p class="text-left mb-4 mt-2">Uploading a file is optional</p>
								<button type="submit" class="btn btn-info" name="update-announcements">Submit</button>
								</form>
							</div>
						</div>
					</div>
					<button type="button" name="opener" data-type="open-dialog" class="btn btn-primary d-inline-block"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
					<form action="faculty-classes-postannouncements" method="POST" class="d-inline-block">
						<input type="hidden" name="announcement_id" value="'.$row['ann_id'].'">
						<button type="submit" name="delete-announcement" class="btn btn-info"><span class="tooltip remove" title="Remove this announcement"><i class="far fa-trash-alt"></i></span></button>
					</form>
				</td>';
				echo '</tr>';
			}
		} else {
			echo '<tr><td colspan="2">You didn\'t post any announcements yet.</td></tr>';
		}
	}

	public function deleteCreatedAnnouncement($post) {
		$sql = $this->conn->prepare("SELECT * FROM announcements WHERE ann_id=:announcement_id");
		$sql->execute(array(
			':announcement_id' => $post['announcement_id']
		));
		$result = $sql->fetch();
		if ($result['attachment'] === null) {
			$deleteAnn = $this->conn->prepare("DELETE FROM announcements WHERE ann_id=:announcement_id");
			$deleteAnn->execute(array(
				':announcement_id' => $post['announcement_id']
			));
			$this->createLog('Delete', 'Delete an announcement');
			$this->others->Message('Success!,', 'The announcement has been deleted', "success", "faculty-classes-postannouncements");
		} else {
			$path = 'public/attachment/'.$result['attachment'];
			if (file_exists($path)) {
				$deleteAnn = $this->conn->prepare("DELETE FROM announcements WHERE ann_id=:announcement_id");
				$deleteAnn->execute(array(
					':announcement_id' => $post['announcement_id']
				));
				unlink($path);
				$this->createLog('Delete', 'Delete an announcement');
				$this->others->Message('Success!,', 'The announcement has been deleted', "success", "faculty-classes-postannouncements");
			}
		}
	}

	public function updateCreatedAnnouncement($post, $attachment) {
		$sql = $this->conn->prepare("SELECT * FROM announcements WHERE ann_id=:announcement_id");
		$sql->execute(array(
			':announcement_id' => $post['announcement_id']
		));
		$result = $sql->fetch();
		if ($result['attachment'] === null) {
			if (!empty($attachment['name'])) {
				if ($attachment['size'] < 20000000) {
					$ext = explode('.', $attachment['name']);
					$new_name = 'attachment_'.$result['ann_id'].'.'.$ext[1];
					$updateDB = $this->conn->prepare("UPDATE announcements SET post = :post, attachment = :new_name, gr_sec = :gr_sec WHERE ann_id = :ann_id");
					$updateDB->execute(array(
						':post' => $post['post'],
						':new_name' => $new_name,
						':gr_sec' => $post['gr_sec'],
						':ann_id' => $post['announcement_id']
					));
					move_uploaded_file($attachment['tmp_name'], 'public/attachment/'.$new_name);
					$this->createLog('Update', 'Update an announcement');
					$this->others->Message('Success!,', 'The announcement has been updated', "success", "faculty-classes");
				} else {
					$this->others->Message('Error!,', 'The file is  too large', "error", "faculty-classes");
				}
			} else {
				$updateDB = $this->conn->prepare("UPDATE announcements SET post = :post, gr_sec = :gr_sec WHERE ann_id = :ann_id");
				$updateDB->execute(array(
					':post' => $post['post'],
					':gr_sec' => $post['gr_sec'],
					':ann_id' => $post['announcement_id']
				));
				$this->createLog('Update', 'Update an announcement');
				$this->others->Message('Success!', 'The announcement has been updated', "success", "faculty-classes");
			}
		} else {
			if (!empty($attachment['name'])) {
				$path = 'public/attachment/'.$result['attachment'];
				unlink($path);
				if ($attachment['size'] < 20000000) {
					$ext = explode('.', $attachment['name']);
					$new_name = 'attachment_'.$result['ann_id'].'.'.$ext[1];
					$updateDB = $this->conn->prepare("UPDATE announcements SET post = :post, attachment = :new_name, gr_sec = :gr_sec WHERE ann_id = :ann_id");
					$updateDB->execute(array(
						':post' => $post['post'],
						':new_name' => $new_name,
						':gr_sec' => $post['gr_sec'],
						':ann_id' => $post['announcement_id']
					));
					move_uploaded_file($attachment['tmp_name'], 'public/attachment/'.$new_name);
					$this->createLog('Update', 'Update an announcement');
					$this->others->Message('Success!,', 'The announcement has been updated', "success", "faculty-classes");
				} else {
					$this->others->Message('Error!,', 'The file is  too large', "error", "faculty-classes");
				}
			} else {
				$path = 'public/attachment/'.$result['attachment'];
				unlink($path);
				$updateDB = $this->conn->prepare("UPDATE announcements SET post = :post, attachment = :attachment, gr_sec = :gr_sec WHERE ann_id = :ann_id");
				$updateDB->execute(array(
					':post' => $post['post'],
					':attachment' => null,
					':gr_sec' => $post['gr_sec'],
					':ann_id' => $post['announcement_id']
				));
				$this->createLog('Update', 'Update an announcement');
				$this->others->Message('Success!,', 'The announcement has been updated', "success", "faculty-classes");
			}
		}
	}

	/********************** DIVISION FOR CLASSES (BELOW EDIT CLASSES) **********************/

	public function showSections() {
		$sql = $this->conn->query("SELECT * FROM section ORDER BY grade_lvl, sec_name");
		$result = $sql->fetchAll();
		$option = '';
		foreach ($result as $row) {
			$option .= '<option value="sec'.$row['sec_id'].'">Grade '.$row['grade_lvl'].' - '.$row['sec_name'].'</option>';
		}
		echo $option;
	}

	public function showSections_temp() {
		$sql = $this->conn->query("SELECT * FROM section ORDER BY grade_lvl, sec_name");
		$result = $sql->fetchAll();
		$option = '';
		foreach ($result as $row) {
			$option .= '<option value="sec'.$row['sec_id'].'">Grade '.$row['grade_lvl'].' - '.$row['sec_name'].'</option>';
		}
		echo $option;
	}

	public function showTabledSections() {
		$sql = $this->conn->query("SELECT * FROM section") or die("query failed!");
		$result = $sql->fetchAll();
		foreach($result as $row) {
			$this->createSectionTable($row);
		}
	}

	public function displayTeachers($subject) {
		$sql = $this->conn->query("SELECT * FROM faculty WHERE fac_dept LIKE '%".$subject."%'");
		$option = '<option value="">Select a teacher</option>';
		$result = $sql->fetchAll();
		foreach($result as $row) {
			$option .= '<option value="'.$row['fac_id'].'">'.$row['fac_fname'].' '.$row['fac_midname'][0].'. '.$row['fac_lname'].'</option>';
		}
		echo $option;
	}

	public function getStatusofCurrentEdittingSession() {
		$temporary = $this->conn->query("SELECT * FROM schedsubj_temp WHERE status_ss = 'Temporary'");
		$permanent = $this->conn->query("SELECT * FROM schedsubj_temp WHERE status_ss = 'Permanent'");
		$requested = $this->conn->query("SELECT * FROM schedsubj_temp WHERE status_ss = 'Requested'");
		$reject = $this->conn->query("SELECT count(ss_remarks) as 'number', ss_remarks FROM schedsubj_temp");
		$resReject = $reject->fetch();
		if ($resReject['number'] > 0) {
			echo '<label>STATUS: <span>Rejected, '.$resReject['ss_remarks'].'</span></label>';
			echo '<button type="submit" name="request-sched" class="btn btn-primary">Submit Schedule</button>';
		} else if ($temporary->rowCount() > 0) {
			echo '<label>STATUS: <span class="editting">Currently Editting</span></label>';
			echo '<button type="submit" name="request-sched" class="btn btn-primary">Submit Schedule</button>';
		} else if ($permanent->rowCount() > 0) {
			echo '<label>STATUS: <span>Confirmed</span></label>';
		} else if ($requested->rowCount() > 0) {
			echo '<label>STATUS: <span class="editting">Pending</span></label>';
			echo '<button type="submit" name="cancel-sched" class="btn-info btn">Cancel Request</button>';
		}
	}

	public function sendRequestToAdminForSched() {
		$getAllSec = $this->conn->query("SELECT *, CONCAT('Grade ',' ',grade_lvl,' - ',sec_name) as 'section_name' FROM section");
		$resSec = $getAllSec->fetchAll();
		$time_start = array('07:40:00', '08:40:00', '10:00:00', '11:00:00', '13:00:00', '14:00:00', '15:00:00');
		$data = '';
		foreach($resSec as $row) {
			$checker = false;
			foreach($time_start as $time) {
				$query = $this->conn->prepare("SELECT * FROM schedsubj_temp WHERE ssb_timestart = :time_start AND ss_swid = :section");
				$query->execute(array(
					':time_start' => $time,
					':section' => $row['sec_id']
				));
				if(!($query->rowCount() > 0)) {
					$checker = true;
				}
			}
			if ($checker === true) {
				$data .= $row['section_name'].', ';
				$check = false;
			}
		}
		if (!empty($data)) {
			$data = rtrim($data,', ');
        	$this->others->Message('Incomplete schedule for:', $data, 'error', 'faculty-editclass');
		} else {
			$updateDB = $this->conn->query("UPDATE schedsubj_temp SET status_ss = 'Requested', ss_remarks = NULL");
			$this->createLog('Update', 'Requested for a change in schedule.');
        	$this->others->Message('Success!', 'You\'ve successfully sent a request', 'success', 'faculty-editclass');
		}
	}

	public function cancelRequestToAdminForSched() {
		$updateDB = $this->conn->query("UPDATE schedsubj_temp SET status_ss = 'Temporary'");
		$this->createLog('Update', 'Cancelled requested schedule.');
    	$this->others->Message('Success!', 'You\'ve cancelled your request', 'success', 'faculty-editclass');
	}

	public function insertUpdateGetSubj($post) {
		$time_start = array('07:40:00', '08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00');
        $time_end = array('08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00');
		$index = array_search($post['time_start'], $time_start);
		$getCur = $this->conn->query("SELECT current_curriculum as 'cur' FROM system_settings WHERE sy_status = 'Current'");
		$resultCur = $getCur->fetch();
		$cur = $resultCur['cur'];
        if (isset($post['prev-teacher'])) {
        	if ($post['time_start'] == '07:40:00') {
        		/*$this->conn->prepare("UPDATE SET ");*/
        	}
        	$checkifMapeh = $this->conn->prepare("SELECT * FROM schedsubj_temp WHERE ss_fwid = :prev AND ss_swid = :sec_id");
        	$checkifMapeh->execute(array(
        		':prev' => $post['prev-teacher'],
        		':sec_id' => $post['sec_id']
        	));
        	$ifExistisMapeh = ($checkifMapeh->rowCount() > 1 ? true : false);
        	if ($ifExistisMapeh === false) {
        		$getCurrent = $this->conn->prepare("SELECT * FROM faculty WHERE acc_idz = :accid");
	        	$getCurrent->execute(array(
	        		':accid' => $_SESSION['accid']
	        	));
	        	$resCurrent = $getCurrent->fetch();
	        	$fac_id = $resCurrent['fac_id'];
	        	if ($post['subject'] !== '-2') {
		        	$update_schedsubj = $this->conn->prepare("UPDATE schedsubj_temp SET ss_idb = :subject, ss_fwid = :teacher WHERE ss_fwid=:prev_teacher AND ss_swid = :sec_id");
		        	$update_schedsubj->execute(array(
		        		':subject' => $post['subject'],
		        		':teacher' => $post['teacher'],
		        		':prev_teacher' => $post['prev-teacher'],
		        		':sec_id' => $post['sec_id']
		        	));
	        	} else {
	        		$deleteTupple = $this->conn->prepare("DELETE FROM schedsubj_temp WHERE ss_fwid = :prev AND ss_swid = :sec");
	        		$deleteTupple->execute(array(
	        			':prev' => $post['prev-teacher'],
	        			':sec' => $post['sec_id']
	        		));
	        		$getGradeLevel = $this->conn->prepare("SELECT * FROM schedule WHERE sched_id = :sched_id");
	        		$getGradeLevel->execute(array(
	        			':sched_id' => $post['sched_a']
	        		));
	        		$resultGradeLevel = $getGradeLevel->fetch();
	        		$getAllMAPEH = $this->conn->prepare("SELECT * FROM subject WHERE subj_dept = 'MAPEH' AND curriculum=:cur AND subj_level = :level");
	        		$getAllMAPEH->execute(array(
	        			':cur' => $cur,
	        			':level' => $resultGradeLevel['sched_yrlevel']
	        		));
	        		$resultSubjs = $getAllMAPEH->fetchAll();
	        		foreach($resultSubjs as $row) {
	        			$insert_schedsubj = $this->conn->prepare("INSERT INTO schedsubj_temp (ss_ida, ss_idb, ssb_day, ssb_timestart, ssb_timeend, ss_fwid, ss_swid, fac_assigned) VALUES (:sched_a, :subject, 'Monday,Tuesday,Wednesday,Thursday,Friday', :time_start, :time_end, :teacher, :sec_id, :fac_id)");
			        	$insert_schedsubj->execute(array(
			        		':sched_a' => $post['sched_a'],
			        		':subject' => $row['subj_id'],
			        		':time_start' => $time_start[$index],
			        		':time_end' => $time_end[$index],
			        		':teacher' => $post['teacher'],
			        		':sec_id' => $post['sec_id'],
			        		':fac_id' => $fac_id
			        	));
	        		}
	        	}
        	} else {
        		$getCurrent = $this->conn->prepare("SELECT * FROM faculty WHERE acc_idz = :accid");
	        	$getCurrent->execute(array(
	        		':accid' => $_SESSION['accid']
	        	));
	        	$resCurrent = $getCurrent->fetch();
	        	$fac_id = $resCurrent['fac_id'];
        		$deleteTupple = $this->conn->prepare("DELETE FROM schedsubj_temp WHERE ss_fwid = :prev AND ss_swid = :sec");
        		$deleteTupple->execute(array(
        			':prev' => $post['prev-teacher'],
        			':sec' => $post['sec_id']
        		));
        		$insert_schedsubj = $this->conn->prepare("INSERT INTO schedsubj_temp (ss_ida, ss_idb, ssb_day, ssb_timestart, ssb_timeend, ss_fwid, ss_swid, fac_assigned) VALUES (:sched_a, :subject, 'Monday,Tuesday,Wednesday,Thursday,Friday', :time_start, :time_end, :teacher, :sec_id, :fac_id)");
	        	$insert_schedsubj->execute(array(
	        		':sched_a' => $post['sched_a'],
	        		':subject' => $post['subject'],
	        		':time_start' => $time_start[$index],
	        		':time_end' => $time_end[$index],
	        		':teacher' => $post['teacher'],
	        		':sec_id' => $post['sec_id'],
	        		':fac_id' => $fac_id
	        	));
        	}
        	$this->createLog('Update', 'Updated a schedule.');
        	$this->others->Message('Success!', 'The schedule has been updated!', 'success', 'faculty-editclass');
        } else {
        	$getCurrent = $this->conn->prepare("SELECT * FROM faculty WHERE acc_idz = :accid");
        	$getCurrent->execute(array(
        		':accid' => $_SESSION['accid']
        	));
        	$resCurrent = $getCurrent->fetch();
        	$fac_id = $resCurrent['fac_id'];
        	if ($post['subject'] !== '-2') {
	        	$insert_schedsubj = $this->conn->prepare("INSERT INTO schedsubj_temp (ss_ida, ss_idb, ssb_day, ssb_timestart, ssb_timeend, ss_fwid, ss_swid, fac_assigned) VALUES (:sched_a, :subject, 'Monday,Tuesday,Wednesday,Thursday,Friday', :time_start, :time_end, :teacher, :sec_id, :fac_id)");
	        	$insert_schedsubj->execute(array(
	        		':sched_a' => $post['sched_a'],
	        		':subject' => $post['subject'],
	        		':time_start' => $time_start[$index],
	        		':time_end' => $time_end[$index],
	        		':teacher' => $post['teacher'],
	        		':sec_id' => $post['sec_id'],
	        		':fac_id' => $fac_id
	        	));
        	} else {
        		$getGradeLevel = $this->conn->prepare("SELECT * FROM schedule WHERE sched_id = :sched_id");
        		$getGradeLevel->execute(array(
        			':sched_id' => $post['sched_a']
        		));
        		$resultGradeLevel = $getGradeLevel->fetch();
        		$getAllMAPEH = $this->conn->prepare("SELECT * FROM subject WHERE subj_dept = 'MAPEH' AND curriculum=:cur AND subj_level = :level");
        		$getAllMAPEH->execute(array(
        			':cur' => $cur,
        			':level' => $resultGradeLevel['sched_yrlevel']
        		));
        		$resultSubjs = $getAllMAPEH->fetchAll();
        		foreach($resultSubjs as $row) {
        			$insert_schedsubj = $this->conn->prepare("INSERT INTO schedsubj_temp (ss_ida, ss_idb, ssb_day, ssb_timestart, ssb_timeend, ss_fwid, ss_swid, fac_assigned) VALUES (:sched_a, :subject, 'Monday,Tuesday,Wednesday,Thursday,Friday', :time_start, :time_end, :teacher, :sec_id, :fac_id)");
		        	$insert_schedsubj->execute(array(
		        		':sched_a' => $post['sched_a'],
		        		':subject' => $row['subj_id'],
		        		':time_start' => $time_start[$index],
		        		':time_end' => $time_end[$index],
		        		':teacher' => $post['teacher'],
		        		':sec_id' => $post['sec_id'],
		        		':fac_id' => $fac_id
		        	));
        		}
        	}
        	$this->createLog('Insert', 'Added a schedule.');
        	$this->others->Message('Success!', 'The schedule has been added!', 'success', 'faculty-editclass');
        }
	}

	public function deleteSched($post) {
		$time_start = array('07:40:00', '08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00');
        $time_end = array('08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00');
		$index = array_search($post['time_start'], $time_start);
		$delete_schedsubj = $this->conn->prepare("DELETE FROM schedsubj_temp WHERE ss_fwid=:faculty_id AND ss_swid=:sec_id");
		$delete_schedsubj->execute(array(
			':faculty_id' => $post['faculty_id'],
			':sec_id' => $post['sec']
		));
		$update_temp = $this->conn->query("UPDATE schedsubj_temp SET status_ss = 'Temporary', ss_remarks = NULL");
		$this->createLog('Delete', 'Deleted a schedule.');
		$this->others->Message('Success!', 'The schedule has been deleted!', 'success', 'faculty-editclass');
	}

	/********************** END OF CLASSES HANDLED **********************/

	/********************** START OF GRADES **********************/

	public function getScheduleGrades() {
    	$querySchedule = $this->conn->prepare("SELECT  fac_id, time_start, time_end, subj_name, CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS 'stud_sec', sec_id, subj_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id  JOIN accounts ON acc_idz = acc_id WHERE acc_id = :accid ORDER BY grade_lvl, time_start") or die("FAILED");
    	$querySchedule->execute(array(
    		':accid' => $_SESSION['accid']
    	));
    	$result = $querySchedule->fetchAll();
    	foreach($result as $row) {
    		$disable_input = $this->CanInputGrade();
    		$getCurrentGrading = $this->conn->prepare("SELECT * FROM system_settings WHERE sy_status = 'Current'");
    		$getCurrentGrading->execute();
    		$queryResult = $getCurrentGrading->fetch();
    		$active_grading = $queryResult['active_grading'];
    		$time_start = date('h:i A', strtotime($row['time_start']));
    		$time_end = date('h:i A', strtotime($row['time_end']));
    		$getActive = function($act) {
    			$disable_input = $this->CanInputGrade();
    			if ($act == 'Disabled') {
    				return '<p>You can\'t add or update any grades at of this moment.</p>';
    			} else if ($disable_input[0] == false) {
    				return '<p>'.$disable_input[1].'</p>';
    			} else {
    				return '<p> Input grades for '.$act.' Grading </p>';
    			}
    		};
    		echo '<tr>';
    		echo '<td>'.$row['stud_sec'].'</td>';
    		echo '<td>'.$time_start.' - '.$time_end.' Daily</td>';
    		echo '<td>'.$row['subj_name'].'</td>';
    		echo '<td>
    		<div name="dialog" title="Update Student Grades for '.$row['stud_sec'].'" class="upload-file-dialog">
    		<div class="container">
    		<div class="modal-cont">
    		<form action="faculty-grades" method="post" class="faculty-grades-form" autocomplete="off">
    		<div class="date-subj">
    		<div class="subject">
    		<p>Subject: <span>'.$row['subj_name'].'</span><input type="hidden" name="subject-code" value="'.$row['subj_id'].'" readonly=""></p>
    		'.$getActive($active_grading).'
    		<input type="hidden" name="faculty-id" value="'.$row['fac_id'].'">
    		<input type="hidden" name="sec_id" value="'.$row['sec_id'].'">
    		<input type="hidden" name="section" value="'.$row['stud_sec'].'">
    		</div>
    		</div>
    		<div class="table-cont">
    		<table>
    		<thead>
    		<th>Student Name</th>
    		<th>1st Grading</th>
    		<th>2nd Grading</th>
    		<th>3rd Grading</th>
    		<th>4th Grading</th>';
    		if($active_grading === '4th'){
    			echo '<th> Remarks </td>';
    		}

    		echo '</thead>
    		<tbody>';
    		$student = $this->displayGradeStudAtt($row['sec_id'], $row['subj_id']);
    		$c = 0;
    		$checkifDisabledInput = $this->conn->query("SELECT * FROM system_settings WHERE sy_status = 'Current'");
    		$resDisInp = $checkifDisabledInput->fetch();
    		if ($resDisInp['active_grading'] == 'Disabled') {
    			echo '<tr><td colspan="5" class="text-center">Temporarily Disabled</td></tr>';
    		}
    		foreach ($student as $stud) {
    			echo '<input type="hidden" name="stud_id[]" value="'.$stud['stud_id'].'">
    			<input type="hidden" name="stud_name[]" value="'.$stud['Name'].'">';
    			$grade_1st = $this->getStudentGrades('1st', $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
    			$grade_2nd = $this->getStudentGrades('2nd', $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
    			$grade_3rd = $this->getStudentGrades('3rd', $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
    			$grade_4th = $this->getStudentGrades('4th', $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
    			$grade_active = $this->getStudentGrades($active_grading, $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
    			$remarks_active = $this->getStudentRemarks($active_grading, $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
    			echo '<tr>';
    			if($active_grading != '4th'){
    				$disable_field = '';
    				if($disable_input[0] === false) {
    					$disable_field = 'disabled=""';
    				}
    				if($active_grading === '1st'){
    					echo '<td>'.$stud['Name'].'</td>';
    					if($grade_1st === '') {
    						echo '<td class="first_td"><input type="text" name="first[]" '.$disable_field.'></td>';
    					} else {
    						echo '<td class="first_td"><input type="text" name="first[]" '.(!empty($grade_active) ? 'value="'.$grade_1st.'"' : '').' '.$disable_field.'>
    					</td>';
    					}
    					echo '<td></td>';
    					echo '<td></td>';
    					echo '<td></td>';
    				} else
    				if($active_grading === '2nd'){
    					echo '<td>'.$stud['Name'].'</td>';
				 		if($grade_2nd === ''){
							echo '
							<td class="first_td"><input type="text" name="first[]" '.(!empty($grade_active) ? '' : 'value="'.$grade_1st.'"').' '.$disable_field.'></td>
							<td class="second_td"><input type="text" name="second[]" '.(!empty($grade_active) ? 'value="'.$grade_active.'"' : '').' '.$disable_field.'></td>';
					}else {
						echo '<td class="first_td"> <input type="text" name="first[]" '.(!empty($grade_active) ? 'value="'.$grade_1st.'"' : '').' '.$disable_field.'>
							</td>
								<td class="second_td"> <input type="text" name="second[]" '.(!empty($grade_active) ? 'value="'.$grade_2nd.'"' : '').' '.$disable_field.'>
							</td>';
					}
						echo '<td></td>';
						echo '<td></td>';	
    				} else
    				if($active_grading === '3rd') {
    					echo '<td>'.$stud['Name'].'</td>';
				 		if($grade_3rd === ''){
							echo '
							<td class="first_td"><input type="text" name="first[]" '.(!empty($grade_active) ? '' : 'value="'.$grade_1st.'"').' '.$disable_field.'></td>
							<td class="second_td"><input type="text" name="second[]" '.(!empty($grade_active) ? '' : 'value="'.$grade_2nd.'"').' '.$disable_field.'></td>
							<td class="third_td"><input type="text" name="third[]" '.(!empty($grade_active) ? 'value="'.$grade_active.'"' : '').' '.$disable_field.'></td>';
					}else {
						echo '<td class="first_td"><input type="text" name="first[]" '.(!empty($grade_active) ? 'value="'.$grade_1st.'"' : '').' '.$disable_field.'>
							</td>
							<td class="second_td"><input type="text" name="second[]" '.(!empty($grade_active) ? 'value="'.$grade_2nd.'"' : '').' '.$disable_field.'>
							</td>
							<td class="third_td"><input type="text" name="third[]" '.(!empty($grade_active) ? 'value="'.$grade_3rd.'"' : '').' '.$disable_field.'>
							</td>';
					}
						echo '<td></td>';	
    				}
    			} else {
    				echo '<td>'.$stud['Name'].'</td>';
    				if($grade_4th === ''){
    					echo '
							<td class="first_td"><input type="text" name="first[]" '.(!empty($grade_active) ? '' : 'value="'.$grade_1st.'"').' '.$disable_field.'></td>
							<td class="second_td"><input type="text" name="second[]" '.(!empty($grade_active) ? '' : 'value="'.$grade_2nd.'"').' '.$disable_field.'></td>
							<td class="third_td"><input type="text" name="third[]" '.(!empty($grade_active) ? '' : 'value="'.$grade_3rd.'"').' '.$disable_field.'></td>
							<td class="fourth_td"><input class="fourth_qtr" type="text"  name="fourth[]" '.(!empty($grade_active) ? 'value="'.$grade_active.'"' : '').' '.$disable_field.'></td>
								<td><input type="text" name="remarks[]" class="remarks" '.(!empty($remarks_active) ? 'value="'.$remarks_active.'"' : '').' '.$disable_field.'>	
    								</td>';
    				} else{
    					echo '
							<td class="first_td"><input type="text" name="first[]" '.(!empty($grade_active) ? 'value="'.$grade_1st.'"' : 'value="'.$grade_1st.'"').' '.$disable_field.'></td>
							<td  class="second_td"><input type="text" name="second[]" '.(!empty($grade_active) ? 'value="'.$grade_2nd.'"' : 'value="'.$grade_2nd.'"').' '.$disable_field.'></td>
							<td class="third_td"><input type="text" name="third[]" '.(!empty($grade_active) ? 'value="'.$grade_3rd.'"' : 'value="'.$grade_3rd.'"').' '.$disable_field.'></td>
							<td class="fourth_td"><input class="fourth_qtr" type="text"  name="fourth[]" '.(!empty($grade_active) ? 'value="'.$grade_4th.'"' : (!empty($remarks_active) ? 'value="INC"' : '')).' '.$disable_field.'></td>
							<td><input type="text" name="remarks[]" class="remarks" '.(!empty($remarks_active) ? 'value="'.$remarks_active.'"' : '').' readonly>	
    							</td>';	
    				}
    			}

    			echo '</tr>';
    			$c++;
    		}

    		echo '						
    		</tbody>
    		</table>
    		</div>
    		<button type="submit" name="submit-grades" class="btn btn-info">SAVE</button>
    		</form>
    		</div>
    		</div>
    		</div>
    		<button type="button" name="opener" data-type="open-dialog" class="btn btn-primary"><i class="fas fa-pen"></i></button>
    		</td>';
    		echo '</tr>';
    	}
    }

    /********** DIVISION FOR GRADES TO CORE VALUE ***********/

    public function getCoreVal() {
    	$getfacid = $this->conn->prepare("SELECT fac_id FROM faculty WHERE acc_idz = :accid");
    	$getfacid->execute(array(
    		':accid' => $_SESSION['accid']
    	));
    	$getResult = $getfacid->fetch();
    	$querySchedule = $this->conn->prepare("SELECT  fac_id, time_start, time_end, subj_name, CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS 'stud_sec', sec_id, subj_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN accounts ON acc_idz = acc_id WHERE fac_idv = :fac_id and time_start ='07:40:00' GROUP BY stud_sec ORDER BY time_start") or die("FAILED");
    	$querySchedule->execute(array(
    		':fac_id' => $getResult['fac_id']
    	));
    	$result = $querySchedule->fetchAll();
    	foreach($result as $row) {
    		$getCurrentGrading = $this->conn->prepare("SELECT * FROM system_settings WHERE sy_status = 'Current'");
    		$getCurrentGrading->execute();
    		$queryResult = $getCurrentGrading->fetch();
    		$active_grading = $queryResult['active_grading'];
    		echo '<tr>';
    		echo '<td>'.$row['stud_sec'].'</td>';;
    		echo '<td>
    		<div name="dialog" title="Update Student Behavior for '.$row['stud_sec'].'" class="upload-file-dialog">
    		<div class="container">
    		<div class="modal-cont">
    		<form action="faculty-grades" method="post" class="faculty-grades-form">
    		<div class="date-subj">
    		<div class="subject">
    		<input type="hidden" name="faculty-id" value="'.$row['fac_id'].'">
    		<input type="hidden" name="active_grading" value="'.$active_grading.'">
    		<input type="hidden" name="sec_id" value="'.$row['sec_id'].'">
    		<input type="hidden" name="section" value="'.$row['stud_sec'].'">
    		</div>
    		<div>Quarter: '.$active_grading.'</div>
    		</div>
    		<div class="table-cont">
    		<table>
    		<thead>
    		<th>Student Name</th>';
    		$core_values = $this->getCoreValues();
    		foreach ($core_values as $core) {
    			echo '<th>'.$core['cv_name'].'
    			<input type="hidden" name="core[]" value="'.$core['cv_id'].'">
    			</th>';
    		}
    		echo '</thead>
    		<tbody>';
    		$student = $this->displaySectionStudAtt($row['sec_id'], $row['subj_id']);
    		$c = 0;
    		foreach ($student as $stud) {
    			echo '<tr>';
    			echo '<td>'.$stud['Name'].'</td>';
    			$x = 0;
    			$core_values_id = 1;
    			foreach($core_values as $core) {
    				$core_active = $this->getIfExistCoreValue($active_grading, $stud['stud_id'], $core_values_id);
    				echo '<td>';
    				echo '<select name="cv['.$c.']['.$x.']">';
    				echo '<option value="AO" '.($core_active === 'AO' ? 'selected' : '').'>Always observed</option>';
    				echo '<option value="SO" '.($core_active === 'SO' ? 'selected' : '').'>Sometimes observed</option>';
    				echo '<option value="RO" '.($core_active === 'RO' ? 'selected' : '').'>Rarely observed</option>';
    				echo '<option value="NO" '.($core_active === 'NO' ? 'selected' : '').'>Not observed</option>';
    				echo '</select>';
    				echo '</td>';
    				$core_values_id++;
    				$x++;
    			}
    			echo '<input type="hidden" name="student[]" value="'.$stud['stud_id'].'">';
    			echo '</tr>';
    			$c++;
    		}
    		echo '						</tbody>
    		</table>
    		</div>
    		<button type="submit" name="submit-core-values" class="btn btn-info">SAVE</button>
    		</form>
    		</div>
    		</div>
    		</div>
    		<button type="button" name="opener" data-type="open-dialog" class="btn btn-primary"><i class="fas fa-pen"></i></button>
    		</td>';
    		echo '</tr>';
    	}
    }

    private function getIfExistCoreValue($grading, $stud_id, $core) {
    	$check = $this->conn->prepare("SELECT * FROM behavior WHERE bhv_grading = :bhv_grading AND core_values =:core AND stud_idy = :stud_id");
    	$check->execute(array(
    		':bhv_grading' => $grading,
    		':stud_id' => $stud_id,
    		':core' => $core
     	));
     	$result = $check->fetch();
     	return $result !== false ? $result['bhv_remarks'] : '';
    }

    public function submitCoreValues($post) {
    	$checkIfCoreExist = $this->conn->prepare("SELECT * FROM behavior WHERE bhv_grading = :grading AND fac_idx = :fac_id AND sec_idx = :sec_id");
    	$checkIfCoreExist->execute(array(
    		':grading' => $post['active_grading'],
    		':fac_id' => $post['faculty-id'],
    		':sec_id' => $post['sec_id']
    	)) or die('Error!');
    	if ($checkIfCoreExist->rowCount() > 0) {
    		$c = 0;
    		foreach($post['student'] as $stud) {
				$x = 0;
    			foreach($post['core'] as $cv) {
    				$bhv_remarks = $post['cv'][$c][$x];
    				$update = "UPDATE behavior SET bhv_remarks = :remarks WHERE core_values = :core_value AND stud_idy = :stud_id AND fac_idx = :fac_id AND sec_idx = :sec_idx";
    				$updateBeh = $this->conn->prepare($update);
    				$updateBeh->execute(array(
    					':remarks' => $bhv_remarks,
    					':core_value' => $cv,
    					':stud_id' => $stud,
    					':fac_id' => $post['faculty-id'],
    					':sec_idx' => $post['sec_id']
    				));
    				$x++;
    			}
    			$c++;
    		}
    		$this->createLog('update', 'Updated student behaviors for '.$post['section']);
			$this->others->Message('Success!', 'The behaviors has been changed!', 'success', 'faculty-grades');
    	} else {
			$c = 0;
    		foreach($post['student'] as $stud) {
				$x = 0;
    			foreach($post['core'] as $cv) {
    				$bhv_remarks = $post['cv'][$c][$x];
    				$insert = "INSERT INTO behavior (bhv_grading, bhv_remarks, core_values, stud_idy, fac_idx, sec_idx) VALUES (:active_grading, :remarks, :core_value, :stud_id, :fac_id, :sec_idx)";
    				$insertToBehavior = $this->conn->prepare($insert);
    				$insertToBehavior->execute(array(
    					':active_grading' => $post['active_grading'],
    					':remarks' => $bhv_remarks,
    					':core_value' => $cv,
    					':stud_id' => $stud,
    					':fac_id' => $post['faculty-id'],
    					':sec_idx' => $post['sec_id']
    				));
    				$x++;
    			}
    			$c++;
    		}
    		$this->createLog('Insert', 'Inserted behaviors for '.$post['section']);
			$this->others->Message('Success!', 'The behaviors has been submitted!', 'success', 'faculty-grades');
    	}
    }

    private function getCoreValues() {
    	$sql = $this->conn->query("SELECT * FROM core_values ORDER BY cv_id	");
    	return $sql->fetchAll();
    }

    private function getStudentGrades($grading, $stud_id, $fac_id, $sec_id, $subj_id) {
    	$sql = $this->conn->prepare("SELECT * FROM grades WHERE grading = :grading AND studd_id = :stud_id AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id");
    	$sql->execute(array(
    		':grading' => $grading,
    		':stud_id' => $stud_id,
    		':fac_id' => $fac_id,
    		':sec_id' => $sec_id,
    		':subj_id' => $subj_id
    	)) or die('Error!');
    	$result = $sql->fetch();
    	return $sql->rowCount() !== 0 ?  $result['grade'] : '';
    }

    private function getStudentRemarks($grading, $stud_id, $fac_id, $sec_id, $subj_id) {
    	$sql = $this->conn->prepare("SELECT * FROM grades WHERE grading = :grading AND studd_id = :stud_id AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id");
    	$sql->execute(array(
    		':grading' => $grading,
    		':stud_id' => $stud_id,
    		':fac_id' => $fac_id,
    		':sec_id' => $sec_id,
    		':subj_id' => $subj_id
    	)) or die('Error!');
    	$result = $sql->fetch();
    	return $sql->rowCount() !== 0 ?  $result['remarks'] : '';
    }

    public function submitGrades($post) {
    	$goSignal13 = function($grading) {
    		foreach($grading as $grade) {
    			if ((!(empty($grade)) && ((int) $grade < 65) ) || (!(empty($grade)) && ((int) $grade > 99))) {
    				return false;
    			}
    		}
    		return true;
    	};
    	$goSignal4 = function($grading) {
    		foreach($grading as $grade) {
    			if ((!(empty($grade)) && ((int) $grade < 65) && ($grade !== 'INC')) || (!(empty($grade)) && ((int) $grade > 99) && ($grade !== 'INC'))) {
    				return false;
    			}
    		}
    		return true;	
    	};
    	if (isset($post['first'])) {
	    	if($goSignal13($post['first']) === true) {
	    		foreach($post['stud_id'] as $stud_ida) {
		    		$post['active_grading'] = '1st';
		    		$checkIfGradesExist = $this->conn->prepare("SELECT * FROM grades WHERE grading = :grading AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id and studd_id = :stud_id");
		    		$checkIfGradesExist->execute(array(
		    			':grading' => $post['active_grading'],
		    			':fac_id' => $post['faculty-id'],
		    			':sec_id' => $post['sec_id'],
		    			':subj_id' => $post['subject-code'],
		    			':stud_id' => $stud_ida
		    		)) or die('Error!');
		    		if ($checkIfGradesExist->rowCount() > 0) {
		    			$c = 0;
		    			foreach($post['stud_id'] as $stud_id) {
		    				if (empty($post['first'][$c])) {
		    					$post['first'][$c] = null;
		    				}
		    				$insertStudentGrade = $this->conn->prepare("UPDATE grades SET grade = :grade WHERE grading = :grading AND studd_id = :stud_id AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id");
		    				$insertStudentGrade->execute(array(
		    					':grade' => $post['first'][$c],
		    					':grading' => $post['active_grading'],
		    					':stud_id' => $stud_id,
		    					':fac_id' => $post['faculty-id'],
		    					':sec_id' => $post['sec_id'],
		    					':subj_id' => $post['subject-code']
		    				));;
		    				$this->createLog('Update', 'Updated grades for '.$post['stud_name'][$c].' in '.$post['section']);
		    				$c++;
		    			}
		    			$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');
		    		} else {
		    			$c = 0;
		    			foreach($post['stud_id'] as $stud_id) {
		    				if (empty($post['first'][$c])) {
		    					$post['first'][$c] = null;
		    				}
		    				$insertStudentGrade = $this->conn->prepare("INSERT INTO grades (grade, grading, studd_id, facd_id, secd_id, subj_ide) VALUES (:grade, :grading, :stud_id, :fac_id, :sec_id, :subj_id)");
		    				$insertStudentGrade->execute(array(
		    					':grade' => $post['first'][$c],
		    					':grading' => $post['active_grading'],
		    					':stud_id' => $stud_id,
		    					':fac_id' => $post['faculty-id'],
		    					':sec_id' => $post['sec_id'],
		    					':subj_id' => $post['subject-code']
		    				));
		    				$this->createLog('Insert', 'Inserted grades for '.$post['stud_name'][$c].' in '.$post['section']);
		    				$c++;
		    			}
		    			$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');
		    		}
	    		}
	    	} else {
	    		$this->others->Message('Error!', 'There\'s something wrong in your input', 'error', 'faculty-grades');
	    	}
    	}
    	if (isset($post['second'])) {
	    	if($goSignal13($post['first']) === true && $goSignal13($post['second']) === true){
	    		foreach($post['stud_id'] as $stud_ida) {
		    		$post['active_grading'] = '2nd';
		    		$checkIfGradesExist = $this->conn->prepare("SELECT * FROM grades WHERE grading = :grading AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id and studd_id = :stud_id");
		    		$checkIfGradesExist->execute(array(
		    			':grading' => $post['active_grading'],
		    			':fac_id' => $post['faculty-id'],
		    			':sec_id' => $post['sec_id'],
		    			':subj_id' => $post['subject-code'],
		    			':stud_id' => $stud_ida
		    		)) or die('Error!');
		    		if ($checkIfGradesExist->rowCount() > 0) {
		    			$c = 0;
		    			foreach($post['stud_id'] as $stud_id) {
		    				if (empty($post['second'][$c])) {
		    					$post['second'][$c] = null;
		    				}
		    				$insertStudentGrade = $this->conn->prepare("UPDATE grades SET grade = :grade WHERE grading = :grading AND studd_id = :stud_id AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id");
		    				$insertStudentGrade->execute(array(
		    					':grade' => $post['second'][$c],
		    					':grading' => $post['active_grading'],
		    					':stud_id' => $stud_id,
		    					':fac_id' => $post['faculty-id'],
		    					':sec_id' => $post['sec_id'],
		    					':subj_id' => $post['subject-code']
		    				));
		    				$this->createLog('Updated', 'Updated grades for '.$post['stud_name'][$c].' in '.$post['section']);
		    				$c++;
		    			}
		    			$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');
		    		} else {
		    			$c = 0;
		    			foreach($post['stud_id'] as $stud_id) {
		    				if (empty($post['second'][$c])) {
		    					$post['second'][$c] = null;
		    				}
		    				$insertStudentGrade = $this->conn->prepare("INSERT INTO grades (grade, grading, studd_id, facd_id, secd_id, subj_ide) VALUES (:grade, :grading, :stud_id, :fac_id, :sec_id, :subj_id)");
		    				$insertStudentGrade->execute(array(
		    					':grade' => $post['second'][$c],
		    					':grading' => $post['active_grading'],
		    					':stud_id' => $stud_id,
		    					':fac_id' => $post['faculty-id'],
		    					':sec_id' => $post['sec_id'],
		    					':subj_id' => $post['subject-code']
		    				));
		    				$this->createLog('Insert', 'Inserted grades for '.$post['stud_name'][$c].' in '.$post['section']);
		    				$c++;
		    			}

		    			$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');
		    		}
	    		}
	    	} else {
	    		$this->others->Message('Error!', 'There\'s something wrong in your input', 'error', 'faculty-grades');
	    	}
    	}
    	if(isset($post['third'])) {
	    	if($goSignal13($post['first']) === true && $goSignal13($post['second']) === true && $goSignal13($post['third']) === true){
	    		foreach($post['stud_id'] as $stud_ida) {
		    		$post['active_grading'] = '3rd';
		    		$checkIfGradesExist = $this->conn->prepare("SELECT * FROM grades WHERE grading = :grading AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id and studd_id = :stud_id");
		    		$checkIfGradesExist->execute(array(
		    			':grading' => $post['active_grading'],
		    			':fac_id' => $post['faculty-id'],
		    			':sec_id' => $post['sec_id'],
		    			':subj_id' => $post['subject-code'],
		    			':stud_id' => $stud_ida
		    		)) or die('Error!');
		    		if ($checkIfGradesExist->rowCount() > 0) {
		    			$c = 0;
		    			foreach($post['stud_id'] as $stud_id) {
		    				if (empty($post['third'][$c])) {
		    					$post['third'][$c] = null;
		    				}
		    				$insertStudentGrade = $this->conn->prepare("UPDATE grades SET grade = :grade WHERE grading = :grading AND studd_id = :stud_id AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id");
		    				$insertStudentGrade->execute(array(
		    					':grade' => $post['third'][$c],
		    					':grading' => $post['active_grading'],
		    					':stud_id' => $stud_id,
		    					':fac_id' => $post['faculty-id'],
		    					':sec_id' => $post['sec_id'],
		    					':subj_id' => $post['subject-code']
		    				));
		    				$this->createLog('Updated', 'Updated grades for '.$post['stud_name'][$c].' in '.$post['section']);
		    				$c++;
		    			}
		    			$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');
		    		} else {
		    			$c = 0;
		    			foreach($post['stud_id'] as $stud_id) {
		    				if (empty($post['third'][$c])) {
		    					$post['third'][$c] = null;
		    				}
		    				$insertStudentGrade = $this->conn->prepare("INSERT INTO grades (grade, grading, studd_id, facd_id, secd_id, subj_ide) VALUES (:grade, :grading, :stud_id, :fac_id, :sec_id, :subj_id)");
		    				$insertStudentGrade->execute(array(
		    					':grade' => $post['third'][$c],
		    					':grading' => $post['active_grading'],
		    					':stud_id' => $stud_id,
		    					':fac_id' => $post['faculty-id'],
		    					':sec_id' => $post['sec_id'],
		    					':subj_id' => $post['subject-code']
		    				));
		    				$this->createLog('Insert', 'Inserted grades for '.$post['stud_name'][$c].' in '.$post['section']);
		    				$c++;
		    			}

		    			$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');
		    		}
	    		}
			} else {
	    		$this->others->Message('Error!', 'There\'s something wrong in your input', 'error', 'faculty-grades');
	    	}
    	}
    	if(isset($post['fourth'])) {
			if($goSignal13($post['first']) === true && $goSignal13($post['second']) === true && $goSignal13($post['third']) === true  && $goSignal4($post['fourth']) === true){
	    		foreach($post['stud_id'] as $stud_ida) {
		    		$post['active_grading'] = '4th';
		    		$checkIfGradesExist = $this->conn->prepare("SELECT * FROM grades WHERE grading = :grading AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id and studd_id = :stud_id");
		    		$checkIfGradesExist->execute(array(
		    			':grading' => $post['active_grading'],
		    			':fac_id' => $post['faculty-id'],
		    			':sec_id' => $post['sec_id'],
		    			':subj_id' => $post['subject-code'],
		    			':stud_id' => $stud_ida
		    		)) or die('Error!');
		    		if ($checkIfGradesExist->rowCount() > 0) {
		    			$c = 0;
		    			foreach($post['stud_id'] as $stud_id) {
		    				if (empty($post['fourth'][$c])) {
		    					$post['fourth'][$c] = null;
		    					$post['remarks'][$c] = null;
		    				}
		    				$insertStudentGrade = $this->conn->prepare("UPDATE grades SET grade = :grade, remarks = :remarks WHERE grading = :grading AND studd_id = :stud_id AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id");
		    				$insertStudentGrade->execute(array(
		    					':grade' => ($post['fourth'][$c] === 'INC' ? NULL : $post['fourth'][$c]),
		    					':remarks' => $post['remarks'][$c],
		    					':grading' => $post['active_grading'],
		    					':stud_id' => $stud_id,
		    					':fac_id' => $post['faculty-id'],
		    					':sec_id' => $post['sec_id'],
		    					':subj_id' => $post['subject-code']
		    				));
		    				$this->createLog('Updated', 'Updated grades for '.$post['stud_name'][$c].' in '.$post['section']);
		    				$c++;
		    			}
		    			$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');

		    		} else {
		    			$c = 0;
		    			foreach($post['stud_id'] as $stud_id) {
		    				if (empty($post['fourth'][$c])) {
		    					$post['fourth'][$c] = null;
		    					$post['remarks'][$c] = null;
		    				}
		    				$insertStudentGrade = $this->conn->prepare("INSERT INTO grades (grade, grading, remarks, studd_id, facd_id, secd_id, subj_ide) VALUES (:grade, :grading,:remarks, :stud_id, :fac_id, :sec_id, :subj_id)");
		    				$insertStudentGrade->execute(array(
		    					':grade' => ($post['fourth'][$c] === 'INC' ? NULL : $post['fourth'][$c]),
		    					':grading' => $post['active_grading'],
		    					':remarks' => $post['remarks'][$c],
		    					':stud_id' => $stud_id,
		    					':fac_id' => $post['faculty-id'],
		    					':sec_id' => $post['sec_id'],
		    					':subj_id' => $post['subject-code']
		    				));
		    				$this->createLog('Insert', 'Inserted grades for '.$post['stud_name'][$c].' in '.$post['section']);
		    				$c++;
		    			}

		    			$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');
		    		}
	    		}
	 		} else {
	    		$this->others->Message('Error!', 'There\'s something wrong in your input', 'error', 'faculty-grades');
	    	}
    	}
    }

	/********************** END OF GRADES **********************/

	/********************** START OF ATTENDANCE **********************/
	public function getScheduleAttendance() {
        $querySchedule = $this->conn->prepare("SELECT CASE WHEN subj_name LIKE ('%Music%') OR subj_name LIKE ('%(PE)%') OR subj_name LIKE ('%Physical Education%') OR subj_name LIKE ('%Health%') OR subj_name LIKE ('%Arts%') THEN (CASE WHEN subj_level = '7' THEN 'MAPEH 1' WHEN subj_level = '8' THEN 'MAPEH 2' WHEN subj_level = '9' THEN 'MAPEH 3' WHEN subj_level = '10' THEN 'MAPEH 4' ELSE 'MAPEH' END) ELSE subj_name END AS subject, fac_id, time_start, time_end, subj_name, CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS 'stud_sec', sec_id, subj_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN accounts ON acc_idz = acc_id WHERE acc_id = :accid  GROUP BY time_start ORDER BY time_start") or die("FAILED");
        $querySchedule->execute(array(
        	':accid' => $_SESSION['accid']
        ));
        $result = $querySchedule->fetchAll();
        foreach($result as $row) {
        	$time_start = date('h:i A', strtotime($row['time_start']));
        	$time_end = date('h:i A', strtotime($row['time_end']));
        	echo '<tr>';
        	echo '<td>'.$row['stud_sec'].'</td>';
        	echo '<td>'.$row['subject'].'</td>';
        	echo '<td>'.$time_start.' - '.$time_end.' Daily</td>';
        	echo '<td>
				<div name="dialog" title="Update attendance for '.$row['stud_sec'].'" class="upload-file-dialog">
					<div class="container">
						<div class="modal-cont">
				        	<form action="faculty-attendance" method="post" class="faculty-attendance-form">
				        		<div class="date-subj">
									<div class="date"><p>Date: <input name="attDate" data-section="'.$row['sec_id'].'" type="text" placeholder="YYYY-MM-DD" class="datepicker-attendance" readonly=""></p></div>
									<div class="subject">
										<p>Subject: <span>'.$row['subject'].'</span><input type="hidden" name="subject-code" value="'.$row['subj_id'].'" readonly=""></p>
										<input type="hidden" name="faculty-id" value="'.$row['fac_id'].'">
										<input type="hidden" name="section" value="'.$row['sec_id'].'">
										<input type="hidden" name="section-name" value="'.$row['stud_sec'].'">
									</div>
				        		</div>
								<div class="table-cont">
									<table>
										<thead>
											<th>Student Name</th>
											<th>Attendance</th>
										</thead>
										<tbody>';
			/*$student = $this->displaySectionStudAtt($row['sec_id']);*/
			$getStudents = $this->conn->prepare("SELECT *, CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name' FROM student WHERE secc_id = :sec_id AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated')");
			$getStudents->execute(array(
				':sec_id' => $row['sec_id']
			));
			$student = $getStudents->fetchAll();
			$c = 0;
			date_default_timezone_set('Asia/Manila');
			$att_date = date('Y-m-d');
			$day = date('l');
			if ($day !== 'Saturday' && $day !== 'Sunday') {
				foreach ($student as $stud) {
					$checkAttendance = $this->conn->prepare("SELECT * FROM attendance WHERE att_date = :att AND stud_ida = :stud AND fac_idb = :fac AND subjatt_id = :subj AND sec_ide = :sec");
					$checkAttendance->execute(array(
						':att' => $att_date,
						':stud' => $stud['stud_id'],
						':fac' => $row['fac_id'],
						':subj' => $row['subj_id'],
						':sec' => $row['sec_id']
					));
					$studentAtt = $checkAttendance->fetch();
					$option = '';
					if ($studentAtt['type'] == NULL) {
						$option = '<input type="text" name="student['.$c.'][attendance]" value="Present" class="present" readonly="">';
					} else if ($studentAtt['type'] == 'Late') {
						$option = '<input type="text" name="student['.$c.'][attendance]" value="Late" class="late" readonly="">';
					} else if ($studentAtt['type'] == 'Absent') {
						$option = '<input type="text" name="student['.$c.'][attendance]" value="Absent" class="absent" readonly="">';
					}
					$input = '
					<label>'.$option.'</label>
					<input type="hidden" name="student['.$c.'][student_id]" value="'.$stud['stud_id'].'">
					';
					echo '<tr>';
					echo '<td>'.$stud['Name'].'</td>';
					echo '<td>'.$input.'</td>';
					echo '</tr>';
					$c++;
				}
			} else {
				echo '<tr><td colspan="2" style="text-align: center;">It\'s '.$day.', you\'re not allowed to check attendance on this day.</td></tr>';
			}
			echo '						</tbody>
									</table>
								</div>
								<button type="submit" name="submit-attendance" class="btn btn-info">SAVE</button>
				        	</form>
						</div>
					</div>
				</div>
				<button type="button" name="opener" data-type="open-dialog" class="btn btn-primary"><i class="fas fa-pen"></i></button>
        	</td>';
        	echo '</tr>';
        }
    }

     public function displayGradeStudAtt($sec_id, $subj_id) {
    	date_default_timezone_set('Asia/Manila');
    	$att_date = date('Y-m-d');
    	$getStuds = $this->conn->prepare("SELECT 
    		CONCAT(last_name,
    		', ',
    		first_name,
    		' ',
    		middle_name) AS 'Name',
    		CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec',
    		CASE
    		WHEN
    		s.stud_id NOT IN (SELECT 
    		stud_ida
    		FROM
    		attendance
    		WHERE
    		attendance.att_date = :att_date
    		GROUP BY 1)
    		THEN
    		'No remarks yet'
    		WHEN
    		s.stud_id IN (SELECT 
    		stud_ida
    		FROM
    		attendance
    		GROUP BY 1)
    		THEN
    		(SELECT 
    		type
    		FROM
    		attendance att
    		JOIN
    		schedsubj ss ON att.fac_idb = ss.fw_id
    		&& att.sec_ide = ss.sw_id
    		&& att.subjatt_id = ss.schedsubjb_id
    		JOIN
    		subject ON subject.subj_id = att.subjatt_id
    		JOIN
    		student st ON st.stud_id = att.stud_ida
    		JOIN
    		faculty ON att.fac_idb = faculty.fac_id
    		JOIN
    		section sec ON sec.sec_id = att.sec_ide
    		JOIN
    		accounts ON accounts.acc_id = faculty.acc_idz
    		WHERE
    		acc_id = :accid AND sec_ide = :sec_id
    		AND att_date = :att_date
    		AND subj_id = :subj_id
    		AND s.stud_id = st.stud_id
    		AND (stud_status <> 'Transferred'
    		AND stud_status <> 'Not Enrolled'
    		AND stud_status <> 'Graduated'))
    		END 'type',
    		subj_name,
    		stud_id,
    		sec_id
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
    		student s ON secc_id = sec_id
    		JOIN
    		accounts ON acc_idz = acc_id
    		WHERE
    		sec_id = :sec_id and subj_id = :subj_id
    		UNION SELECT 
    		CONCAT(last_name,
    		', ',
    		first_name,
    		' ',
    		middle_name) AS 'Name',
    		CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec',
    		type,
    		subj_name,
    		stud_id,
    		sec_id
    		FROM
    		attendance att
    		JOIN
    		schedsubj ss ON att.fac_idb = ss.fw_id
    		&& att.sec_ide = ss.sw_id
    		&& att.subjatt_id = ss.schedsubjb_id
    		JOIN
    		subject ON subject.subj_id = att.subjatt_id
    		JOIN
    		student sst ON sst.stud_id = att.stud_ida
    		JOIN
    		faculty ON att.fac_idb = faculty.fac_id
    		JOIN
    		section sec ON sec.sec_id = att.sec_ide
    		JOIN
    		accounts ON accounts.acc_id = faculty.acc_idz
    		WHERE
    		acc_id = :accid
    		AND (stud_status <> 'Transferred'
    		AND stud_status <> 'Not Enrolled'
    		AND stud_status <> 'Graduated')
    		AND sec_ide = :sec_id
    		AND att_date = :att_date
    		AND subj_id = :subj_id
    		GROUP BY 1
    		ORDER BY 1");
    	$getStuds ->execute(array(
    		':accid' => $_SESSION['accid'],
    		':sec_id' => $sec_id,
    		':att_date' => $att_date,
    		':subj_id' => $subj_id
    	));
    	$studResult = $getStuds->fetchAll();
    	return $studResult;
    }
	public function displaySectionStudAtt($sec_id) {
		date_default_timezone_set('Asia/Manila');
		$att_date = date('Y-m-d');
		$getStuds = $this->conn->prepare("SELECT  CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name', CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec', CASE WHEN s.stud_id NOT IN (SELECT  stud_ida FROM attendance where attendance.att_date = :att_date GROUP BY 1) THEN 'No remarks yet' WHEN s.stud_id IN (SELECT  stud_ida FROM attendance GROUP BY 1) THEN (SELECT type FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student st ON st.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND sec_ide = :sec_id AND att_date = :att_date AND s.stud_id = st.stud_id AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated')) END 'type', subj_name, stud_id, sec_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN student s ON secc_id = sec_id JOIN accounts ON acc_idz = :accid WHERE sec_id = :sec_id  UNION SELECT  CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name', CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec', type, subj_name, stud_id, sec_id FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student sst ON sst.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated') AND sec_ide = :sec_id AND att_date = :att_date GROUP BY 1 ORDER BY 1");
		$getStuds ->execute(array(
			':accid' => $_SESSION['accid'],
			':sec_id' => $sec_id,
			':att_date' => $att_date
		));
		$studResult = $getStuds->fetchAll();
		return $studResult;
	}

	public function submitAttendance($post) {
		$checkExisting = $this->conn->prepare("SELECT * FROM attendance WHERE att_date = :attDate AND fac_idb = :fac_id AND subjatt_id = :sub_code AND sec_ide = :sec_id");
		$checkExisting->execute(array(
			':attDate' => $post['attDate'],
			':fac_id' => $post['faculty-id'],
			':sub_code' => $post['subject-code'],
			':sec_id' => $post['section']
		));
		if ($checkExisting->rowCount() > 0) {
			for($c = 0; $c < count($post['student']); $c++) {
				if ($post['student'][$c]['attendance'] === 'Present') {
					$checkIfLateOrAbsent = $this->conn->prepare("SELECT att_id FROM attendance WHERE att_date = :attDate AND stud_ida = :stud_id AND fac_idb = :fac_id AND subjatt_id = :sub_id AND sec_ide = :sec_id");
					$checkIfLateOrAbsent->execute(array(
						':attDate' => $post['attDate'],
						':stud_id' => $post['student'][$c]['student_id'],
						':fac_id' => $post['faculty-id'],
						':sub_id' => $post['subject-code'],
						':sec_id' => $post['section']
					));
					$result = $checkIfLateOrAbsent->fetch();
					if ($checkIfLateOrAbsent->rowCount() > 0) {
						$deleteFromAtt = $this->conn->prepare("DELETE FROM attendance WHERE att_id = :att_id");
						$deleteFromAtt->execute(array(
							':att_id' => $result['att_id']
						));
					}
				} else {
					$checkIfLateOrAbsent = $this->conn->prepare("SELECT att_id FROM attendance WHERE att_date = :attDate AND stud_ida = :stud_id AND fac_idb = :fac_id AND subjatt_id = :sub_id AND sec_ide = :sec_id");
					$checkIfLateOrAbsent->execute(array(
						':attDate' => $post['attDate'],
						':stud_id' => $post['student'][$c]['student_id'],
						':fac_id' => $post['faculty-id'],
						':sub_id' => $post['subject-code'],
						':sec_id' => $post['section']
					)) or die($this->others->Message('Error!', 'Query Error', 'error', 'faculty-attendance'));
					if ($checkIfLateOrAbsent->rowCount() > 0) {
						$result = $checkIfLateOrAbsent->fetch();
						$updateNewAtt = $this->conn->prepare("UPDATE attendance SET type = :remarks WHERE att_id = :att_id");
						$updateNewAtt->execute(array(
							':remarks' => $post['student'][$c]['attendance'],
							':att_id' => $result['att_id']
						)) or die($this->others->Message('Error!', 'Query Error', 'error', 'faculty-attendance'));
					} else {
						$insert = $this->conn->prepare("INSERT INTO attendance (att_date, type, stud_ida, fac_idb, subjatt_id, sec_ide) VALUES (:attDate, :remarks, :stud_id, :fac_id, :sub_id, :sec_id)");
						$insert->execute(array(
							':attDate' => $post['attDate'],
							':remarks' => $post['student'][$c]['attendance'],
							':stud_id' => $post['student'][$c]['student_id'],
							':fac_id' => $post['faculty-id'],
							':sub_id' => $post['subject-code'],
							':sec_id' => $post['section']
						));
					}
				}
			}
			$this->createLog('Update', 'Updated the attendance for '.$post['section-name'].' on '.$post['attDate']);
			$this->others->Message('Success!', 'The attendance has been updated', 'success', 'faculty-attendance');
		} else {
			for($c = 0; $c < count($post['student']); $c++) {
				if ($post['student'][$c]['attendance'] === 'Late' || $post['student'][$c]['attendance'] === 'Absent') {
					$insert = $this->conn->prepare("INSERT INTO attendance (att_date, type, stud_ida, fac_idb, subjatt_id, sec_ide) VALUES (:attDate, :remarks, :stud_id, :fac_id, :sub_id, :sec_id)");
					$insert->execute(array(
						':attDate' => $post['attDate'],
						':remarks' => $post['student'][$c]['attendance'],
						':stud_id' => $post['student'][$c]['student_id'],
						':fac_id' => $post['faculty-id'],
						':sub_id' => $post['subject-code'],
						':sec_id' => $post['section']
					));
				}
			}
			$this->createLog('Insert', 'Inserted students who are absent on '.$post['attDate']);
			$this->others->Message('Success!', 'The attendance has been submitted', 'success', 'faculty-attendance');
		}
	}

	public function getScheduleReason() {
        $querySchedule = $this->conn->prepare("SELECT CASE WHEN subj_name LIKE ('%Music%') OR subj_name LIKE ('%(PE)%') OR subj_name LIKE ('%Physical Education%') OR subj_name LIKE ('%Health%') OR subj_name LIKE ('%Arts%') THEN (CASE WHEN subj_level = '7' THEN 'MAPEH 1' WHEN subj_level = '8' THEN 'MAPEH 2' WHEN subj_level = '9' THEN 'MAPEH 3' WHEN subj_level = '10' THEN 'MAPEH 4' ELSE 'MAPEH' END) ELSE subj_name END AS subject, fac_id, time_start, time_end, subj_name, CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS 'stud_sec', sec_id, subj_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN accounts ON acc_idz = acc_id WHERE acc_id = :accid  GROUP BY time_start ORDER BY time_start") or die("FAILED");

        $querySchedule->execute(array(
        	':accid' => $_SESSION['accid']
        ));
        $result = $querySchedule->fetchAll();
        date_default_timezone_set('Asia/Manila');
		$att_date = date('Y-m-d');
        foreach($result as $row) {
        	$time_start = date('h:i A', strtotime($row['time_start']));
        	$time_end = date('h:i A', strtotime($row['time_end']));
        	echo '<tr>';
        	echo '<td>'.$row['stud_sec'].'</td>';
        	echo '<td>'.$row['subj_name'].'</td>';
        	echo '<td>'.$time_start.' - '.$time_end.' Daily</td>';
        	echo '<td>
				<div name="dialog" title="Update reason for '.$row['stud_sec'].'" class="upload-file-dialog">
					<div class="container">
						<div class="modal-cont">
				        	<form action="faculty-attendance" method="post" class="faculty-attendance-form">
				        		<div class="date-subj">
									<div class="date"><p>Date: <input name="attDate" data-section="'.$row['sec_id'].'" type="text" placeholder="YYYY-MM-DD" class="datepicker-attendance1" readonly=""></p></div>
									<div class="subject">
										<p>Subject: <span>'.$row['subj_name'].'</span><input type="hidden" name="subject-code" value="'.$row['subj_id'].'" readonly=""></p>
										<input type="hidden" name="faculty-id" value="'.$row['fac_id'].'">
										<input type="hidden" name="section" value="'.$row['sec_id'].'">
										<input type="hidden" name="section-name" value="'.$row['stud_sec'].'">
									</div>
				        		</div>
								<div class="table-cont1">
									<table>
										<thead>
											<th>Student Name</th>
											<th>Attendance Type</th>
											<th>Attachment</th>
											<th>Reason</th>
											<th>Excused/Unexcused</th>
										</thead>
										<tbody>';
			$student = $this->displaySectionStudReason($row['sec_id'], $row['subj_id']);
			$c = 0;
			$checkFirst = false;
			$checkCount = 0;
			foreach($student as $stud) {
				if ($stud['att_remarks'] === 'No remarks yet') {
					$checkCount++;
				}
			}
			if (count($student) === $checkCount) $checkFirst = false; else $checkFirst = true;;
			if($checkFirst === true) {
				foreach ($student as $stud) {
					if ($stud['type'] !== '') {
						if ($stud['att_remarks'] !== 'No remarks yet') {
							if (strpos($stud['subj_name'],'Arts') !== 0 && strpos($stud['subj_name'],'(PE)') !== 0 && strpos($stud['subj_name'],'Health') !== 0 && strpos($stud['subj_name'],'Physical Education') !== 0) {
								$option = '';
								if ($stud['att_remarks'] == 'No remarks yet') {
									$option = '<input type="text" name="student['.$c.'][attendance]" value="Present" class="present" readonly="">';
								} else if ($stud['att_remarks'] == 'Excused') {
									$option = '<input type="text" name="student['.$c.'][attendance]" value="Excused" class="excused" readonly="">';
								} else if ($stud['att_remarks'] == 'Unexcused') {
									$option = '<input type="text" name="student['.$c.'][attendance]" value="Unexcused" class="unexcused" readonly="">';
								}
								$input = '
								<label>'.$option.'</label>
								<input type="hidden" name="student['.$c.'][student_id]" value="'.$stud['stud_id'].'">
								';
								echo '<tr>';
								echo '<td>'.$stud['Name'].'</td>';
								echo '<td>'.$stud['type'].'</td>';
								echo '<td><span> '.($stud['att_attachment'] !== null ? '<p class="tright attachment" style="font-size: 12px;"><a href="public/letter/'.$stud['att_attachment'].'" download>Download attachment</a></p>' : '').'</span></td>';
								echo '<td>'.$stud['remarks'].'</td>';
								echo '<td>'.$input.'</td>';
								echo '</tr>';
								$c++;
							}
						}
					}
				}
			} else {
				echo '<tr><td colspan="5" style="text-align:center;">There are no student who are absent or late this day!</td></tr>';
			}
			echo '						</tbody>
									</table>
								</div>
								<button type="submit" name="submit-reason" class="btn btn-info">SAVE</button>
				        	</form>
						</div>
					</div>
				</div>
				<button type="button" name="opener" data-type="open-dialog" class="btn btn-primary"><i class="fas fa-pen"></i></button>
        	</td>';
        	echo '</tr>';
        }
    }

	public function displaySectionStudReason($sec_id, $subj_id) {
		date_default_timezone_set('Asia/Manila');
		$att_date = date('Y-m-d');
		$getStuds = $this->conn->prepare("SELECT CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name', CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec', CASE WHEN s.stud_id NOT IN (SELECT  stud_ida FROM attendance WHERE attendance.att_date = :att_date GROUP BY 1) THEN 'No remarks yet' WHEN s.stud_id IN (SELECT stud_ida FROM attendance GROUP BY 1) THEN (SELECT att_remarks FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student st ON st.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND sec_ide = :sec_id AND att_date = :att_date AND subj_id = :subj_id AND s.stud_id = st.stud_id AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated')) END 'att_remarks', '' as type, CASE WHEN s.stud_id NOT IN (SELECT stud_ida FROM attendance WHERE attendance.att_date = :att_date GROUP BY 1) THEN 'Present' WHEN s.stud_id IN (SELECT stud_ida FROM attendance GROUP BY 1) THEN (SELECT  remarks FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student st ON st.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND sec_ide = :sec_id AND att_date = :att_date AND subj_id = :subj_id AND s.stud_id = st.stud_id AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated')) END 'remarks', CASE WHEN s.stud_id NOT IN (SELECT stud_ida FROM attendance WHERE attendance.att_date = :att_date GROUP BY 1) THEN 'No attachment' WHEN s.stud_id IN (SELECT stud_ida FROM attendance GROUP BY 1) THEN (SELECT  att_attachment FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student st ON st.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND sec_ide = :sec_id AND att_date = :att_date AND subj_id = :subj_id AND s.stud_id = st.stud_id AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated')) END 'att_attachment', subj_name, stud_id, sec_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN student s ON secc_id = sec_id JOIN accounts ON acc_idz = :accid WHERE sec_id = :sec_id AND subj_id = :subj_id UNION SELECT CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name', CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec', att_remarks, type, remarks, att_attachment, subj_name, stud_id, sec_id FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student sst ON sst.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated') AND sec_ide = :sec_id AND att_date = :att_date AND subj_id = :subj_id GROUP BY 1 ORDER BY 1");
		$getStuds ->execute(array(
			':accid' => $_SESSION['accid'],
			':sec_id' => $sec_id,
			':att_date' => $att_date,
			':subj_id' => $subj_id
		));
		$studResult = $getStuds->fetchAll();
		return $studResult;
	}

	public function submitReason($post) {
		$checkExisting = $this->conn->prepare("SELECT * FROM attendance WHERE att_date = :attDate AND fac_idb = :fac_id AND subjatt_id = :sub_code AND sec_ide = :sec_id");
		$checkExisting->execute(array(
			':attDate' => $post['attDate'],
			':fac_id' => $post['faculty-id'],
			':sub_code' => $post['subject-code'],
			':sec_id' => $post['section']
		));
		if ($checkExisting->rowCount() > 0) {
			for ($c = 0; $c < count($post['student']); $c++) {
				$updateStudentRemarks = $this->conn->prepare("UPDATE attendance SET att_remarks = :rem WHERE att_date = :att_date AND stud_ida = :stud AND fac_idb = :fac AND subjatt_id = :subj AND sec_ide = :sec");
				$updateStudentRemarks->execute(array(
					':rem' => $post['student'][$c]['attendance'],
					':att_date' => $post['attDate'],
					':stud' => $post['student'][$c]['student_id'],
					':fac' => $post['faculty-id'],
					':subj' => $post['subject-code'],
					':sec' => $post['section']
				));
			}
			$this->createLog('Update', 'Updated the remarks of students who are absent or late on '.$post['attDate']);
			$this->others->Message('Success!', 'The remarks has been submitted', 'success', 'faculty-attendance');
		}
	}

	/********************** END OF ATTENDANCE **********************/

	/********************** START OF HISTORY OF GRADES **********************/
	public function checkIfOldAdviser() {
		$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = adv_id WHERE acc_id = :accid");
		$query->execute(array(
			':accid' => $_SESSION['accid']
		));
		return $query->rowCount() > 0 ? true : false;
	}

	public function getAllHandledSubject_subject() {
		$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = gg_fid WHERE acc_id = :accid GROUP BY subject_name ORDER BY subject_name");
		$query->execute(array(
			':accid' => $_SESSION['accid']
		));
		echo '<option value="">All</option>';
		foreach($query->fetchAll() as $row) {
			echo '<option value="'.$row['subject_name'].'">'.$row['subject_name'].'</option>';
		}
	}

	public function getAllHandledSubject_section() {
		$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = gg_fid WHERE acc_id = :accid GROUP BY gr_sec ORDER BY gr_level, gr_sec");
		$query->execute(array(
			':accid' => $_SESSION['accid']
		));
		echo '<option value="">All</option>';
		foreach($query->fetchAll() as $row) {
			echo '<option value="Grade '.$row['gr_level'].' - '.$row['gr_sec'].'">Grade '.$row['gr_level'].' - '.$row['gr_sec'].'</option>';
		}
	}

	public function getAllHandledSubject_year() {
		$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = gg_fid WHERE acc_id = :accid GROUP BY gg_sy");
		$query->execute(array(
			':accid' => $_SESSION['accid']
		));
		echo '<option value="">All</option>';
		foreach($query->fetchAll() as $row) {
			echo '<option value="'.$row['gg_sy'].'">'.$row['gg_sy'].'</option>';
		}
	}

	public function getAllHandledSubject() {
		$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = gg_fid WHERE acc_id = :accid");
		$query->execute(array(
			':accid' => $_SESSION['accid']
		));
		foreach($query->fetchAll() as $row) {
			$getStudDet = $this->conn->prepare("SELECT * FROM student WHERE stud_id = :stud");
			$getStudDet->execute(array(
				':stud' => $row['std_id']
			));
			$stud = $getStudDet->fetch();
			echo '<tr>';
			echo '<td>'.$stud['first_name'].' '.$stud['middle_name'][0].'. '.$stud['last_name'].'</td>';
			echo '<td>'.$row['gg_first'].'</td>';
			echo '<td>'.$row['gg_second'].'</td>';
			echo '<td>'.$row['gg_third'].'</td>';
			echo '<td>'.$row['gg_fourth'].'</td>';
			echo '<td>'.$row['subject_name'].'</td>';
			echo '<td>Grade '.$row['gr_level'].' - '.$row['gr_sec'].'</td>';
			echo '<td>'.$row['gg_sy'].'</td>';
			echo '</tr>';
		}
	}

	public function getAllHandledClasses_subject() {
		$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = adv_id WHERE acc_id = :accid GROUP BY subject_name ORDER BY subject_name");
		$query->execute(array(
			':accid' => $_SESSION['accid']
		));
		echo '<option value="">All</option>';
		foreach($query->fetchAll() as $row) {
			echo '<option value="'.$row['subject_name'].'">'.$row['subject_name'].'</option>';
		}
	}

	public function getAllHandledClasses_section() {
		$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = adv_id WHERE acc_id = :accid GROUP BY gr_sec ORDER BY gr_level, gr_sec");
		$query->execute(array(
			':accid' => $_SESSION['accid']
		));
		echo '<option value="">All</option>';
		foreach($query->fetchAll() as $row) {
			echo '<option value="Grade '.$row['gr_level'].' - '.$row['gr_sec'].'">Grade '.$row['gr_level'].' - '.$row['gr_sec'].'</option>';
		}
	}

	public function getAllHandledClasses_year() {
		$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = adv_id WHERE acc_id = :accid GROUP BY gg_sy");
		$query->execute(array(
			':accid' => $_SESSION['accid']
		));
		echo '<option value="">All</option>';
		foreach($query->fetchAll() as $row) {
			echo '<option value="'.$row['gg_sy'].'">'.$row['gg_sy'].'</option>';
		}
	}

	public function getAllHandledClasses_teacher() {
		$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = adv_id WHERE acc_id = :accid GROUP BY gg_fid");
		$query->execute(array(
			':accid' => $_SESSION['accid']
		));
		echo '<option value="">All</option>';
		foreach($query->fetchAll() as $row) {
			$getFacDet = $this->conn->prepare("SELECT * FROM faculty WHERE fac_id = :fac");
			$getFacDet->execute(array(
				':fac' => $row['gg_fid']
			));
			$fac = $getFacDet->fetch();
			echo '<option value="'.$fac['fac_fname'].' '.$fac['fac_midname'][0].'. '.$fac['fac_lname'].'">'.$fac['fac_fname'].' '.$fac['fac_midname'][0].'. '.$fac['fac_lname'].'</option>';
		}
	}

	public function getAllHandledClasses() {
		$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = adv_id WHERE acc_id = :accid");
		$query->execute(array(
			':accid' => $_SESSION['accid']
		));
		foreach($query->fetchAll() as $row) {
			$getStudDet = $this->conn->prepare("SELECT * FROM student WHERE stud_id = :stud");
			$getStudDet->execute(array(
				':stud' => $row['std_id']
			));
			$stud = $getStudDet->fetch();
			$getFacDet = $this->conn->prepare("SELECT * FROM faculty WHERE fac_id = :fac");
			$getFacDet->execute(array(
				':fac' => $row['gg_fid']
			));
			$fac = $getFacDet->fetch();
			echo '<tr>';
			echo '<td>'.$stud['first_name'].' '.$stud['middle_name'][0].'. '.$stud['last_name'].'</td>';
			echo '<td>'.$row['gg_first'].'</td>';
			echo '<td>'.$row['gg_second'].'</td>';
			echo '<td>'.$row['gg_third'].'</td>';
			echo '<td>'.$row['gg_fourth'].'</td>';
			echo '<td>'.$row['subject_name'].'</td>';
			echo '<td>'.$fac['fac_fname'].' '.$fac['fac_midname'][0].'. '.$fac['fac_lname'].'</td>';
			echo '<td>Grade '.$row['gr_level'].' - '.$row['gr_sec'].'</td>';
			echo '<td>'.$row['gg_sy'].'</td>';
			echo '</tr>';
		}
	}

	/********************** END OF HISTORY OF GRADES **********************/

	public function getLatestEnrolled($lrno) {
		$query = $this->conn->prepare("SELECT * FROM student s JOIN guardian g ON s.guar_id = g.guar_id WHERE stud_lrno = :lrno");
		$query->execute(array(':lrno' => $lrno));
		return $query->fetch();
	}

	public function accLatestEnrolled($lrno) {
		$query1 = $this->conn->prepare("SELECT username FROM accounts JOIN guardian g ON acc_id = acc_idx JOIN student s ON g.guar_id = s.guar_id WHERE stud_lrno = :lrno");
		$query1->execute(array(':lrno' => $lrno));
		$res1 = $query1->fetch();
		$query2 = $this->conn->prepare("SELECT username FROM accounts JOIN student on acc_id = accc_id WHERE stud_lrno = :lrno");
		$query2->execute(array(':lrno' => $lrno));
		$res2 = $query2->fetch();
		return $res1['username'].' (Guardian), '.$res2['username'].' (Student)';
	}

	/********************** START OF PRIVATE METHODS **********************/
	private function createAccount($username, $password, $acctype) {
		$newPass = password_hash($password, PASSWORD_DEFAULT);
		$queryInsert = $this->conn->prepare("INSERT INTO accounts (username, password, acc_status, acc_type) VALUES (?, ?, 'Active', ?)");
		$queryInsert->bindParam(1, $username);
		$queryInsert->bindParam(2, $newPass);
		$queryInsert->bindParam(3, $acctype);
		$queryInsert->execute();
		$querySearch = $this->conn->prepare("SELECT acc_id FROM accounts WHERE username=?");
		$querySearch->bindParam(1, $username);
		$querySearch->execute();
		$row = $querySearch->fetch();
		$newUsername = $username.$row['acc_id'];
		$newPass = password_hash($newUsername, PASSWORD_DEFAULT);
		$getaccid = $row['acc_id'];
		$queryUpdate = $this->conn->prepare("UPDATE accounts SET username=?, password=? WHERE username=?");
		$queryUpdate->bindParam(1, $newUsername);
		$queryUpdate->bindParam(2, $newPass);
		$queryUpdate->bindParam(3, $username);
		$queryUpdate->execute();
		$this->createLog('Insert', 'Created an account for a student.');
		return $getaccid;
	}

	private function createOption() {
		$args = func_get_args();
		$numArgs = func_num_args();
		$generateOptions = function($arr, $main) {
			if (!is_array($arr)) {
				return 'Error!';
			} else {
				$html = '';
				foreach ($arr as $row) {
					$html .= ($row === $main ? '<option value="'.$row.'" selected>'.$row.'</option>' : '<option value="'.$row.'">'.$row.'</option>');
				}
				return $html;
			}
		};
		return $numArgs == 0 ? '<option value="">Invalid Parameters</option>' : ($numArgs == 1 ? '<option>'.$args[0].'</option>' : $generateOptions($args[0], $args[1]));
	}

	private function checkIfExist($lrn) {
		$query = $this->conn->prepare("SELECT stud_lrno FROM student WHERE stud_lrno = ?");
		$query->bindParam(1, $lrn);
		$query->execute();
		return $query->rowCount();		
	}

	private function getSection($gender, $year_level) {
		$getAllSec = $this->conn->prepare("SELECT * FROM section WHERE grade_lvl = :grade_lvl");
		$getAllSec->execute(array(
			':grade_lvl' => $year_level
		));
		$tempCount = -1;
		$tempSec = '-1';
		$result = $getAllSec->fetchAll();
		foreach($result as $row) {
			$getSecCount = $this->conn->prepare("SELECT * FROM student WHERE gender=:gender AND year_level=:year_level AND secc_id=:secc_id");
			$getSecCount->execute(array(
				':gender' => $gender,
				':year_level' => $year_level,
				':secc_id' => $row['sec_id']
			));
			if ($getSecCount->rowCount() < $tempCount || $tempCount === -1) {
				$tempCount = $getSecCount->rowCount();
				$tempSec = $row['sec_id'];
			}
		}
		return $tempSec === '-1' ? $result[0]['sec_id'] : $tempSec;
	}

	/*For long echo messages add them here and set them as private to avoid being used and showing long echos between methods*/
	private function editStatusMessage($name, $options, $lrno) {
		return '<div class="edit-status-cont">
				<div name="dialog" title="Edit status for '.$name.'">
						<div class="container">
							<div class="modal-cont">
								<form action="faculty-enroll" method="POST" class="text-left">
									<input type="hidden" value="'.$lrno.'" name="lrn">
									<label>Status: </label>
									<select name="curr-status" class="form-control d-inline-block w-75">
										'.$options.'
									</select>
									<label class="text-left mt-3"><span class="d-inline-block mr-2">Don\'t Promote</span><input class="d-inline-block" type="checkbox" name="promote" value="no"></label>
									<button type="submit" class="btn btn-primary d-block ml-auto mr-auto mt-4" name="change-stud-status">Change</button>
								</form>
							</div>
						</div>
					</div>
				<button type="button" name="opener" class="edit-status btn btn-info" data-type="open-dialog">STATUS</button>
				</div>';
	}

	private function checkStudentAttendancePerStudent($row) {
		$queryLate = $this->conn->prepare("SELECT count(*) as 'count' FROM attendance WHERE type = 'Late' AND stud_ida=:id");
		$queryLate->execute(array(':id' => $row['stud_id']));
		$resultLate = $queryLate->fetch();
		$queryAbsent = $this->conn->prepare("SELECT count(*) as 'count' FROM attendance WHERE type = 'Absent' AND stud_ida=:id");
		$queryAbsent->execute(array(':id' => $row['stud_id']));
		$resultAbsent = $queryAbsent->fetch();
		$queryTable = $this->conn->prepare("SELECT DATE_FORMAT(att_date, '%b %d, %Y') as 'date', subj_name, CONCAT(fac_fname,' ',SUBSTRING(fac_midname, 1, 1),'. ',fac_lname) as 'teacher', type, remarks, att_attachment FROM attendance JOIN student ON stud_ida = stud_id JOIN faculty ON fac_idb = fac_id JOIN subject ON subjatt_id = subj_id WHERE stud_id = :id ORDER BY 1");
		$queryTable->execute(array(
			':id' => $row['stud_id']
		));
		$table = '';
		if ($queryTable->rowCount() > 0) {
			foreach($queryTable->fetchAll() as $res) {
				$table .= '<tr>';
				$table .= '<td>'.$res['date'].'</td>';
				$table .= '<td>'.$res['subj_name'].'</td>';
				$table .= '<td>'.$res['teacher'].'</td>';
				$table .= '<td>'.$res['type'].'</td>';
				$table .= '<td>'.$res['remarks'].'</td>';
				if($res['att_attachment'] === NULL) {
					$table .= '<td>No attachment</td>';
				} else {
					$table .= '<td><a href="public/letter/'.$res['att_attachment'].'" download">Download attachment</a></td>';
				}
				$table .= '</tr>';
			}
		}
		return '<div class="edit-status-cont">
					<div name="dialog" title="Edit status for '.$row['stud_fullname'].'">
						<div class="container">
							<div class="modal-cont">
								<table class="attendance_student_summary">
									<thead>
										<tr>
											<th>Date</th>
											<th>Subject</th>
											<th>Teacher</th>
											<th>Remarks</th>
											<th>Reason</th>
											<th>Attachment</th>
										</tr>
									</thead>
									<tbody>'.$table.'</tbody>
									<tfoot>
										<tr>
											<td colspan="5">Number of days absent:</td>
											<td>'.$resultAbsent['count'].'</td>
										</tr>
										<tr>
											<td colspan="5">Number of days late:</td>
											<td>'.$resultLate['count'].'</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				<button type="button" name="opener" class="edit-status btn btn-primary" data-type="open-dialog">STATUS</button>
				</div>';
	}

	private function editDetailsMessage($row) {
		$radio = $row['gender'] === 'Male' ? '<input type="radio" name="gender" value="Male" checked="checked" required/>MALE&nbsp;&nbsp;<input type="radio" name="gender" value="Female"/>FEMALE' : '<input type="radio" name="gender" value="Male" required/>MALE&nbsp;&nbsp;<input type="radio" name="gender" checked="checked" value="Female"/>FEMALE';
		$options2 =  $this->createOption(array('O', 'A', 'B', 'AB'), $row['blood_type']);
		return '<div class="edit-details-cont">
				<div name="dialog" title="Edit student information">
							<form action="faculty-student" method="POST" class="edit-stud-detail" class="Student-Details-All">
					<div class="container">
						<div class="modal-cont">
								<input type="hidden" name="student_id" value="'.$row['stud_id'].'">
								<div class="tabs">
									<div class="Student-Details">
										<label>
											<span>LEARNER REFERENCE No. (LRN):<span class="required">&nbsp;*</span></span>
											<input type="text" value="'.$row['stud_lrno'].'" name="stud_lrno" data-validation="length" data-validation="number" data-validation-length="13" data-validation-error-msg="Your input is an invalid LRN Number" required>
										</label>
										<label>
											<span>LAST NAME:<span class="required">&nbsp;*</span> </span>
											<input value="'.$row['last_name'].'" type="text" name="last_name" required>
										</label>
										<label>
											<span>FIRST NAME:<span class="required">&nbsp;*</span> </span>
											<input value="'.$row['first_name'].'" type="text" name="first_name" required>
										</label>
										<label>
											<span>MIDDLE NAME:<span class="required">&nbsp;*</span> </span>
											<input value="'.$row['middle_name'].'" type="text" name="middle_name" required>
										</label>
										<div class="date-sex">
											<label>
												<span>DATE OF BIRTH:<span class="required">&nbsp;*</span> </span>
												<input value="'.$row['stud_bday'].'" type="text" class="datepicker" name="stud_bday" required>
											</label>
											<label>
												<span>SEX:<span class="required">&nbsp;*</span> </span>
												<span>'.$radio.'</span>
											</label>
										</div>
										<label>
											<span>BLOOD TYPE:<span class="required">&nbsp;*</span> </span>
											<select name="blood_type">
												'.$options2.'
											</select>
										</label>
										<label>
											<span>NATIONALITY:<span class="required">&nbsp;*</span> </span>
											<input type="text" value="'.$row['nationality'].'" name="nationality" required>
										</label>
										<label>
											<span>ETHNICITY:<span class="required">&nbsp;*</span> </span>
											<input type="text" value="'.$row['ethnicity'].'" name="ethnicity" required>
										</label>
										<label>
											<span>MEDICAL CONDITIONS:</span>
											<input type="text" value="'.$row['medical_stat'].'" name="medical_stat">
										</label>
										<label>
											<span>Address:<span class="required">&nbsp;*</span> </span>
											<input value="'.$row['stud_address'].'" type="text" name="address" required>
										</label>
										<label>
											<span>MOTHER\'S NAME:</span>
											<input type="text" value="'.$row['mother_name'].'" name="mother_name">
										</label>
										<label>
											<span>FATHER\'S NAME</span>
											<input type="text" value="'.$row['father_name'].'" name="father_name">
										</label>
									</div>
								</div>
								<div class="bot-cont">
									<p>All with <span class="required">*</span> is required.</p>
									<button name="modify-stud-details" type="submit">SAVE</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<button type="button" name="opener" class="edit-details btn btn-info" data-type="open-dialog">Edit Student Details</button>
			</div>';
	}

	private function createSectionTable($row) {
		$time_start = array('07:40:00', '08:40:00', '10:00:00', '11:00:00', '13:00:00', '14:00:00', '15:00:00');
        $time_end = array('08:40:00', '09:40:00', '11:00:00', '12:00:00', '14:00:00', '15:00:00', '16:00:00');
		$fac_id = $row['fac_idv'];
		$getFacInfo = $this->conn->query("SELECT * FROM faculty WHERE fac_id = '".$fac_id."'");
		$getSchedID = $this->conn->query("SELECT sched_id FROM schedule WHERE sched_yrlevel = '".$row['grade_lvl']."'");
		$fac_info = $getFacInfo->fetch();
		$sched_id = $getSchedID->fetch();
		$getSchedInfo = function($time_start, $sec_id) {
			$query = $this->conn->prepare("SELECT * FROM schedsubj_temp WHERE ssb_timestart = :time_start AND ss_swid = :sec_id");
			$query->execute(array(
				':time_start' => $time_start,
				':sec_id' => $sec_id
			));
			$getSchedResult = $query->fetch();
			$queryTeacher = $this->conn->prepare("SELECT CONCAT(fac_fname,' ',LEFT(fac_midname, 1),'. ',fac_lname) as 'teacher', fac_id FROM faculty WHERE fac_id = :fw_id");
			$querySubject = $this->conn->prepare("SELECT  CASE WHEN subj_name LIKE ('%Music%') OR subj_name LIKE ('%(PE)%') OR subj_name LIKE ('%Physical Education%') OR subj_name LIKE ('%Health%') OR subj_name LIKE ('%Arts%') THEN (CASE WHEN subj_level = '7' THEN 'MAPEH 1' WHEN subj_level = '8' THEN 'MAPEH 2' WHEN subj_level = '9' THEN 'MAPEH 3' WHEN subj_level = '10' THEN 'MAPEH 4' ELSE 'MAPEH' END) ELSE subj_name END AS subject FROM subject WHERE subj_id = :subj_id");
			$queryTeacher->execute(array(
				':fw_id' => $getSchedResult['ss_fwid']
			));
			$querySubject->execute(array(
				':subj_id' => $getSchedResult['ss_idb']
			));
			$fetchTeacher = $queryTeacher->fetch();
			$fetchSubject = $querySubject->fetch();
			$info = array(
				'sched_id' => ($getSchedResult['ss_ida'] !== null ? $getSchedResult['ss_ida'] : '-1'),
				'subj_id' => ($getSchedResult['ss_idb'] !== null ? $getSchedResult['ss_idb'] : '-1'), 
				'fac_id' => ($fetchTeacher['fac_id'] !== null ? $fetchTeacher['fac_id'] : '-1'),
				'teacher' => ($fetchTeacher['teacher'] !== null ? $fetchTeacher['teacher'] : 'Unassigned'),
				'subject' => ($fetchSubject['subject'] !== null ? $fetchSubject['subject'] : 'Unassigned'),
				'status' => ($query->rowCount() > 0 ? $getSchedResult['status_ss'] : 'Not Available')
			);
			return $info;
		};
		$schedInfo1 = $getSchedInfo($time_start[0], $row['sec_id']);
		$schedInfo2 = $getSchedInfo($time_start[1], $row['sec_id']);
		$schedInfo3 = $getSchedInfo($time_start[2], $row['sec_id']);
		$schedInfo4 = $getSchedInfo($time_start[3], $row['sec_id']);
		$schedInfo5 = $getSchedInfo($time_start[4], $row['sec_id']);
		$schedInfo6 = $getSchedInfo($time_start[5], $row['sec_id']);
		$schedInfo7 = $getSchedInfo($time_start[6], $row['sec_id']);
		$remove = function($sched) {
			$html = '<form action="faculty-editclass"  method="POST">
			<input type="hidden" name="sec" value="'.$sched['sec_id'].'">
			<input type="hidden" name="sched" value="'.$sched['sched_id'].'">
			<input type="hidden" name="subj_id" value="'.$sched['subj_id'].'">
			<input type="hidden" name="time_start" value="'.$sched['time_start'].'">
			<input type="hidden" name="faculty_id" value="'.$sched['fac_id'].'">
			<button type="remove-class-schedule" class="edit-status-remove btn btn-info" name="remove-this-schedule"><span class="tooltip remove" title="Remove this schedule"><i class="far fa-trash-alt"></i></span></button>
			</form>';
			return $html;
		};
		$createSchedData = function($sec_id, $sched_id, $subj_id, $time_start, $fac_id) {
			return array(
				'sec_id' => $sec_id,
				'sched_id' => $sched_id,
				'subj_id' => $subj_id,
				'time_start' => $time_start,
				'fac_id' => $fac_id
			);
		};
		$createForm = function($details, $time_start) {
			$getLvl = $this->conn->prepare("SELECT grade_lvl FROM section WHERE sec_id = :sec_id");
			$getLvl->execute(array(
				':sec_id' => $details['sec_id']
			));
			$resultLvl = $getLvl->fetch();
			$grade = $resultLvl['grade_lvl'];
			$getCur = $this->conn->query("SELECT current_curriculum as 'cur' FROM system_settings WHERE sy_status = 'Current'");
			$resultCur = $getCur->fetch();
			$cur = $resultCur['cur'];
			$teacher = $this->conn->prepare("SELECT  *, CASE WHEN subj_name LIKE ('%Music%') OR subj_name LIKE ('%(PE)%') OR subj_name LIKE ('%Physical Education%') OR subj_name LIKE ('%Health%') OR subj_name LIKE ('%Arts%') THEN (CASE WHEN subj_level = '7' THEN 'MAPEH 1' WHEN subj_level = '8' THEN 'MAPEH 2' WHEN subj_level = '9' THEN 'MAPEH 3' WHEN subj_level = '10' THEN 'MAPEH 4' ELSE 'MAPEH' END) ELSE subj_name END AS subject FROM faculty JOIN subject ON fac_dept = subj_dept WHERE curriculum = :cur AND subj_level = :subj_level AND (fac_id NOT IN (SELECT ss_fwid FROM schedsubj_temp WHERE ssb_timestart = :time_start OR ss_swid = :sec_id) AND subj_id NOT IN (SELECT ss_idb FROM schedsubj_temp WHERE ss_swid = :sec_id)) GROUP BY fac_id");
			$teacher->execute(array(
				':cur' => $cur,
				':subj_level' => $grade,
				':time_start' => $time_start,
				':sec_id' => $details['sec_id']
			));
			$allTeacher = $teacher->fetchAll();
			$subject = $this->conn->prepare("SELECT  *, CASE WHEN subj_name LIKE ('%Music%') OR subj_name LIKE ('%(PE)%') OR subj_name LIKE ('%Physical Education%') OR subj_name LIKE ('%Health%') OR subj_name LIKE ('%Arts%') THEN (CASE WHEN subj_level = '7' THEN 'MAPEH 1' WHEN subj_level = '8' THEN 'MAPEH 2' WHEN subj_level = '9' THEN 'MAPEH 3' WHEN subj_level = '10' THEN 'MAPEH 4' ELSE 'MAPEH' END) ELSE subj_name END AS subject FROM faculty JOIN subject ON fac_dept = subj_dept WHERE curriculum = :cur AND subj_level = :subj_level AND (fac_id NOT IN (SELECT ss_fwid FROM schedsubj_temp WHERE ssb_timestart = :time_start OR ss_swid = :sec_id) AND subj_id NOT IN (SELECT ss_idb FROM schedsubj_temp WHERE ss_swid = :sec_id)) GROUP BY subj_dept");
			$subject->execute(array(
				':cur' => $cur,
				':subj_level' => $grade,
				':time_start' => $time_start,
				':sec_id' => $details['sec_id']
			));
			$allSubject = $subject->fetchAll();
			$checkExist = ( $details['fac_id'] === '-1' ? false : true);
			$getSched_ID = $this->conn->prepare("SELECT sched_id FROM schedule WHERE sched_yrlevel = :grade");
			$getSched_ID->execute(array(':grade' => $grade));
			$resSched_ID = $getSched_ID->fetch();
			$sched_id = $resSched_ID['sched_id'];
			$teacher = '';
			foreach($allTeacher as $row) {
				if ($details['fac_id'] === $row['fac_id']) {
					$teacher .= '<option value="'.$row['fac_id'].'" data-facdept="'.$row['fac_dept'].'" selected>'.$row['fac_fname'].' '.$row['fac_midname'][0].'. '.$row['fac_lname'].'</option>';
				} else {
					$teacher .= '<option value="'.$row['fac_id'].'" data-facdept="'.$row['fac_dept'].'">'.$row['fac_fname'].' '.$row['fac_midname'][0].'. '.$row['fac_lname'].'</option>';
				}
			}
			$subject = '';
			foreach($allSubject as $row) {
				if ($cur === '1') {
					if ($details['subj_id'] === $row['subj_id']) {
						$subject .= '<option value="'.$row['subj_id'].'" data-subdept="'.$row['subj_dept'].'" selected>'.$row['subject'].'</option>';
					} else {
						$subject .= '<option value="'.$row['subj_id'].'" data-subdept="'.$row['subj_dept'].'">'.$row['subject'].'</option>';
					}
				} else {
					if ($row['subj_dept'] === 'MAPEH') {
						if ($details['subj_id'] === $row['subj_id']) {
							$subject .= '<option value="-2" data-subdept="'.$row['subj_dept'].'" selected>'.$row['subject'].'</option>';
						} else {
							$subject .= '<option value="-2" data-subdept="'.$row['subj_dept'].'">'.$row['subject'].'</option>';
						}
					} else {
						if ($details['subj_id'] === $row['subj_id']) {
							$subject .= '<option value="'.$row['subj_id'].'" data-subdept="'.$row['subj_dept'].'" selected>'.$row['subject'].'</option>';
						} else {
							$subject .= '<option value="'.$row['subj_id'].'" data-subdept="'.$row['subj_dept'].'">'.$row['subject'].'</option>';
						}
					}
				}
			}
			return '<form action="faculty-editclass" method="POST" class="classes-sched">
					<input type="hidden" name="sec_id" '.'value="'.$details['sec_id'].'"'.'>
					<input type="hidden" name="sched_a" '.'value="'.$sched_id.'"'.'>
					<input type="hidden" name="subj_id" '.($checkExist === true ? 'value="'.$details['subj_id'].'"
					' : '').'>
					<input type="hidden" name="time_start" value="'.$time_start.'">
					'.($checkExist === true ? '<input type="hidden" name="prev-teacher" value="'.$details['fac_id'].'">' : '').'
					<label class="teacher">Teacher: </label>
					<select name="teacher" class="editclass-teacher" required>
						<option value="">Select a Teacher</option>'.$teacher.'
					</select><br>
					<br><label class="subject">Subject: </label>
					<select name="subject" class="editclass-subjects" required>
						<option value="">Select a Subject</option>'.$subject.'
					</select>
					<div class="forms-btn">
						<button type="submit" name="submit-edit-class" class="btn btn-primary">Submit</button>
						<button type="reset" class="reset btn btn-info">Reset</button>
					</div>
				</form>';
		};
		echo '
		<div id="sec'.$row['sec_id'].'" class="classes-edit">
			<div class="sec-info">
				<div class ="cont fr">
					<div class="box2">
						<span>Adviser: '.$fac_info['fac_fname'].' '.$fac_info['fac_midname'][0].'. '.$fac_info['fac_lname'].'</span>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="table-wrap">
				<table class="classes-sched">
					<thead>
						<tr>
							<td width="10%">Schedule</td>
							<td width="35%">Subject</td>
							<td width="40%">Teacher</td>
							<td width="10%">Actions</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td width="10%">'.date('h:i A', strtotime($time_start[0])).' - '.date('h:i A', strtotime($time_end[0])).' Daily</td>
							<td width="35%">'.$schedInfo1['subject'].'</td>
							<td width="40%">'.$schedInfo1['teacher'].'</td>
							<td width="10%" class="buttons">'.($schedInfo1['subject'] !== 'Unassigned' ? $remove($createSchedData($row['sec_id'], $schedInfo1['sched_id'], $schedInfo1['subj_id'], $time_start[0], $schedInfo1['fac_id'])) : '').' 
								<div name="dialog" title="Edit Schedule">
									<div class="container">
										'.$createForm($createSchedData($row['sec_id'], $schedInfo1['sched_id'], $schedInfo1['subj_id'], $time_start[0], $schedInfo1['fac_id']), $time_start[0]).'
									</div>
								</div>
								<button type="button" name="opener" class="edit-status btn-primary btn" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
							</td>
						</tr>
						<tr>
							<td width="10%">'.date('h:i A', strtotime($time_start[1])).' - '.date('h:i A', strtotime($time_end[1])).' Daily</td>
							<td width="35%">'.$schedInfo2['subject'].'</td>
							<td width="40%">'.$schedInfo2['teacher'].'</td>
							<td width="10%" class="buttons">'.($schedInfo2['subject'] !== 'Unassigned' ? $remove($createSchedData($row['sec_id'], $schedInfo2['sched_id'], $schedInfo2['subj_id'], $time_start[1], $schedInfo2['fac_id'])) : '').' 
								<div name="dialog" title="Edit Schedule">
									<div class="container">
										'.$createForm($createSchedData($row['sec_id'], $schedInfo2['sched_id'], $schedInfo2['subj_id'], $time_start[1], $schedInfo2['fac_id']), $time_start[1]).'
									</div>
								</div>
								<button type="button" name="opener" class="edit-status btn-primary btn" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
							</td>
						</tr>
						<tr>
							<td width="10%">'.date('h:i A', strtotime($time_start[2])).' - '.date('h:i A', strtotime($time_end[2])).' Daily</td>
							<td width="35%">'.$schedInfo3['subject'].'</td>
							<td width="40%">'.$schedInfo3['teacher'].'</td>
							<td width="10%" class="buttons">'.($schedInfo3['subject'] !== 'Unassigned' ? $remove($createSchedData($row['sec_id'], $schedInfo3['sched_id'], $schedInfo3['subj_id'], $time_start[2], $schedInfo3['fac_id'])) : '').' 
								<div name="dialog" title="Edit Schedule">
									<div class="container">
										'.$createForm($createSchedData($row['sec_id'], $schedInfo3['sched_id'], $schedInfo3['subj_id'], $time_start[2], $schedInfo3['fac_id']), $time_start[2]).'
									</div>
								</div>
								<button type="button" name="opener" class="edit-status btn-primary btn" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
							</td>
						</tr>
						<tr>
							<td width="10%">'.date('h:i A', strtotime($time_start[3])).' - '.date('h:i A', strtotime($time_end[3])).' Daily</td>
							<td width="35%">'.$schedInfo4['subject'].'</td>
							<td width="40%">'.$schedInfo4['teacher'].'</td>
							<td width="10%" class="buttons">'.($schedInfo4['subject'] !== 'Unassigned' ? $remove($createSchedData($row['sec_id'], $schedInfo4['sched_id'], $schedInfo4['subj_id'], $time_start[3], $schedInfo4['fac_id'])) : '').' 
								<div name="dialog" title="Edit Schedule">
									<div class="container">
										'.$createForm($createSchedData($row['sec_id'], $schedInfo4['sched_id'], $schedInfo4['subj_id'], $time_start[3], $schedInfo4['fac_id']), $time_start[3]).'
									</div>
								</div>
								<button type="button" name="opener" class="edit-status btn-primary btn" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
							</td>
						</tr>
						<tr>
							<td width="10%">'.date('h:i A', strtotime($time_start[4])).' - '.date('h:i A', strtotime($time_end[4])).' Daily</td>
							<td width="35%">'.$schedInfo5['subject'].'</td>
							<td width="40%">'.$schedInfo5['teacher'].'</td>
							<td width="10%" class="buttons">'.($schedInfo5['subject'] !== 'Unassigned' ? $remove($createSchedData($row['sec_id'], $schedInfo5['sched_id'], $schedInfo5['subj_id'], $time_start[4], $schedInfo5['fac_id'])) : '').' 
								<div name="dialog" title="Edit Schedule">
									<div class="container">
										'.$createForm($createSchedData($row['sec_id'], $schedInfo5['sched_id'], $schedInfo5['subj_id'], $time_start[4], $schedInfo5['fac_id']), $time_start[4]).'
									</div>
								</div>
								<button type="button" name="opener" class="edit-status btn-primary btn" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
							</td>
						</tr>
						<tr>
							<td width="10%">'.date('h:i A', strtotime($time_start[5])).' - '.date('h:i A', strtotime($time_end[5])).' Daily</td>
							<td width="35%">'.$schedInfo6['subject'].'</td>
							<td width="40%">'.$schedInfo6['teacher'].'</td>
							<td width="10%" class="buttons">'.($schedInfo6['subject'] !== 'Unassigned' ? $remove($createSchedData($row['sec_id'], $schedInfo6['sched_id'], $schedInfo6['subj_id'], $time_start[5], $schedInfo6['fac_id'])) : '').' 
								<div name="dialog" title="Edit Schedule">
									<div class="container">
										'.$createForm($createSchedData($row['sec_id'], $schedInfo6['sched_id'], $schedInfo6['subj_id'], $time_start[5], $schedInfo6['fac_id']), $time_start[5]).'
									</div>
								</div>
								<button type="button" name="opener" class="edit-status btn-primary btn" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
							</td>
						</tr>
						<tr>
							<td width="10%">'.date('h:i A', strtotime($time_start[6])).' - '.date('h:i A', strtotime($time_end[6])).' Daily</td>
							<td width="35%">'.$schedInfo7['subject'].'</td>
							<td width="40%">'.$schedInfo7['teacher'].'</td>
							<td width="10%" class="buttons">'.($schedInfo7['subject'] !== 'Unassigned' ? $remove($createSchedData($row['sec_id'], $schedInfo7['sched_id'], $schedInfo7['subj_id'], $time_start[6], $schedInfo7['fac_id'])) : '').' 
								<div name="dialog" title="Edit Schedule">
									<div class="container">
										'.$createForm($createSchedData($row['sec_id'], $schedInfo7['sched_id'], $schedInfo7['subj_id'], $time_start[6], $schedInfo7['fac_id']), $time_start[6]).'
									</div>
								</div>
								<button type="button" name="opener" class="edit-status btn-primary btn" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		';
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
			$sql = $this->conn->query("SELECT grade_lvl FROM section WHERE sec_id = '".$sec_id."'");
			$sec_info = $sql->fetch();
			$data = array(
				'sec_id' => $sec_id,
				'subj_level' => $sec_info['grade_lvl'],
				'sched_id' => $sched_id,
				'time_start' => $time_start,
				'exist' => false
			);
			return $data;
		}
	}

	private function createLog($event, $desc) {
		$current_datetime = date('Y-m-d G:i:s');
		$user_id = $_SESSION['accid'];
		$sql = $this->conn->prepare("INSERT INTO logs (log_date, log_event, log_desc, user_id) VALUES (:log_date, :log_event, :log_desc, :user_id)");
		$sql->execute(array(
			':log_date' => $current_datetime,
			':log_event' => $event,
			':log_desc' => $desc,
			':user_id' => $_SESSION['accid']
		));
	}
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
						$this->alert("Success!", "You have successfully changed your profile picture", "success", "faculty-profile");
					}else{
						$this->alert("Success!", "You have successfully changed your profile picture", "success", "faculty-profile");
					}
				}else{
					$this->alert("Error!", "Your file is too large! Please Upload 5MB Size", "error", "faculty-profile");
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
					$this->alert("Success!", "You have successfully changed your profile picture", "success", "faculty-profile");
				}else{
					$this->alert("Success!", "You have successfully changed your profile picture", "success", "faculty-profile");
				}
			}
		}else{
			$this->alert("Error!", "Upload JPG , JPEG , PNG & GIF File Formate.....CHECK FILE EXTENSION", "error", "faculty-profile");
		}
	}

	public function facultyDetails(){
		$queryAdminDetails=$this->conn->prepare("SELECT *, CONCAT(fac_fname,' ',fac_midname,' ',fac_midname) as 'facultyName' FROM faculty join accounts on acc_idz=acc_id WHERE acc_idz=:acc_idz");
		$queryAdminDetails->execute(array(
			':acc_idz' => $_SESSION['accid']
		));
		if($queryAdminDetails->rowCount() > 0){
			while($row=$queryAdminDetails->fetch(PDO::FETCH_ASSOC)){
				$data[]=$row;
			}
			return $data;
		}
		return $queryAdminDetails;
	}

	public function getStudentAllSubjects($lrno) {
		$query = $this->conn->prepare("SELECT * FROM student JOIN subject ON year_level = subj_level JOIN system_settings ON curriculum = current_curriculum JOIN schedsubj ON sw_id = secc_id && subj_id = schedsubjb_id WHERE sy_status = 'Current' AND stud_lrno = :lrno ORDER BY subj_dept, subj_name");
		$query->execute(array(
			':lrno' => $lrno
		));
		$result = $query->fetchAll();
		foreach($result as $row) {
			echo '<tr>';
			echo '<td>'.$row['subj_name'].'</td>';
			echo '<td>Daily</td>';
			echo '</tr>';
		}
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
					$this->alert("Success!", "You have successfully changed your password", "success", "faculty-profile");
				} else {
					$this->alert('Error!',"Invalid password. Password length must be 8 characters and above",'error','faculty-profile');
				} 
			} else {
				$this->alert('Error!',"Password doesn't match",'error','faculty-profile');
			}
		}else {
			$this->alert('Error!',"Old Password doesn't match",'error','faculty-profile');
		}
	}
	/*end profile*/

	public function CanInputGrade() {
		date_default_timezone_set('Asia/Manila');
		$query = $this->conn->query("SELECT * FROM system_settings WHERE sy_status = 'Current'");
		$res = $query->fetch();
		$sys_datetime = date('Y-m-d H:i:s', strtotime($res['g_end_date']));
		$att_datetime = date('Y-m-d H:i:s');
		if ($res['active_grading'] !== 'Disabled') {
			if ($sys_datetime >= $att_datetime) {
				return array(true, '');
			} else {
				return array(false, '');
			}
		} else {
			return array(false, '');
		}
	}
	/********************** END OF PRIVATE METHODS **********************/

	/***** Other functionalities for the website  *****/

}
?>