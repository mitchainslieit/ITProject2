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

	public function getNoOfStudent() {
		$query = $this->conn->prepare("SELECT * FROM student");
		$query->execute();
		$getRowCount = $query->rowCount();
		echo $getRowCount;
	}

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
		$query = $this->conn->prepare("SELECT * FROM student WHERE curr_stat='New'");
		$query->execute();
		$getRowCount = $query->rowCount();
		echo $getRowCount;
	}

	/*0- all, 1- faculty, 2- parent, 3- student, 4- treasurer*/
	public function showEvents(){
		$admin_id = $_SESSION['accid'];
		$sql = $this->conn->prepare("SELECT *, DATE_FORMAT(date(date_start), '%M %e') as 'event_date' FROM announcements WHERE holiday = 'No' AND title IS NOT NULL AND (view_lim LIKE '%0%' OR view_lim LIKE '%1%')") or die ("failed!");
		$sql->execute();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				echo '<tr>
					<td>'.$r['title'].'</td>
					<td>'.$r['event_date'].'</td>
				</tr>';
			}
		}
	}
	
	public function showHolidays(){
		$sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e') as date_start_1,  DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, DAY(CURDATE()), DAY(date_start) FROM announcements WHERE (date_start between now() and adddate(now(), +15)) AND holiday = 'Yes'") or die ("failed!");
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
			$html .= $row['attachment'] !== null ? '<p class="tright attachment"><a href="public/attachment/'.$row['attachment'].'" download">Download attachment</a></p>' : '';
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

	public function getSchoolYear(){
		$query = $this->conn->prepare("SELECT school_year 'sy' FROM student group by 1");
		$query->execute();
		$rowCount = $query->fetch();
		$rowCount1 = $rowCount['sy'] + 1;
		echo " " . $rowCount['sy'] . "-" . $rowCount1 . " ";
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

	public function enrollNewStudent($post) {
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
				':last_name' => $post['last_name'],
				':first_name' => $post['first_name'],
				':middle_name' => $post['middle_name'],
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
			$getStudentID = $this->conn->query("SELECT stud_id FROM student ORDER BY 1 DESC LIMIT 1");
			$result = $getStudentID->fetch();
			$stud_id = $result['stud_id'];
			$addtoBal = $this->conn->query("INSERT INTO balance (misc_fee, bal_amt, bal_status, stud_idb) VALUES ((SELECT SUM(total_amount) FROM budget_info), (SELECT SUM(total_amount) FROM budget_info), 'Not Cleared', '".$stud_id."')");
			
			$this->createLog('Insert', 'Enrolled '.$post['first_name'].' '.$post['middle_name'][0].'. '.$post['last_name']);
			$this->others->Message('Success!', $post['first_name'].' '.$post['middle_name'][0].'. '.$post['last_name'].' has successfully been enrolled!', 'success', 'faculty-assess');
		} else {
			$this->others->Message('Error!', 'That student is already enrolled!', 'error', 'faculty-enroll');
		}
	}

	public function updateStudentDetails($post) {		
		$curr_stat = $this->conn->query("SELECT * FROM student WHERE stud_lrno = '".$post['lrn']."'");
		$result = $curr_stat->fetch();
		if ($post['curr-status'] === 'Transfer') {
			$change_stat = $this->conn->query("UPDATE student SET stud_status = 'Transferred' WHERE stud_lrno ='".$post['lrn']."'");
			$this->createLog('Update', 'Transferred a student.');
			$this->others->Message('Success!', "The student has been transferred!", "success", "faculty-assess");
		} else {
			$change_stat = $this->conn->query("UPDATE student SET stud_status = '".$post['curr-status']."' WHERE stud_lrno ='".$post['lrn']."'");
			if ($result['stud_status'] === 'Not Enrolled') {
				$getCurrent_year_level = $this->conn->query("SELECT stud_id, year_level, gender, CONCAT(first_name, ' ', middle_name, ' ', last_name) as 'name' FROM student WHERE stud_lrno='".$post['lrn']."'");
				$result = $getCurrent_year_level->fetch();
				$newyr_lvl = (int) $result['year_level'] + 1;
				$newSec = $this->getSection($result['gender'], strval($newyr_lvl));
				$this->conn->query("UPDATE student SET year_level='".$newyr_lvl."', secc_id='".$newSec."' WHERE stud_lrno='".$post['lrn']."'");
				$update_balance = $this->conn->prepare("UPDATE balance SET misc_fee = (SELECT SUM(total_amount) FROM budget_info), bal_amt = (SELECT SUM(total_amount) FROM budget_info), bal_status = 'Not Cleared' WHERE stud_idb = :stud_id");
				$update_balance->execute(array(
					':stud_id' => $result['stud_id']
				));
				$this->createLog('Update', $result['name'].' has been enrolled.');
				$this->others->Message('Success!', $result['name'].' has been enrolled', "success", "faculty-assess");
			} else {
				$this->createLog('Update', 'Change the '.$resul['name'].'\'s status.');
				$this->others->Message('Success!,', "The status of the student has been changed successfully!", "success", "faculty-assess");
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
			':guar_fname' => $post['guar_first'],
			':guar_lname' => $post['guar_last'],
			':guar_midname' => $post['guar_middle_name'],
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

	public function showAdvStudent($fac_id) {
		$sql = $this->conn->prepare("SELECT  *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as stud_fullname FROM guardian gr JOIN student st ON gr.guar_id = st.guar_id JOIN section ON secc_id = sec_id JOIN faculty ON fac_id = fac_idv WHERE fac_id = (SELECT fac_id FROM faculty join accounts ON acc_id = acc_idz WHERE acc_id=:fac_id) AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated')");
		$sql->execute(array(':fac_id' => $fac_id));
		$result = $sql->fetchAll();
		foreach ($result as $row) {
			$transfer = '<input class="stud_id" type="hidden" value="'.$row['stud_id'].'"><button class="transfer">Transfer</button>';
			$cancel = '<input class="stud_id" type="hidden" value="'.$row['stud_id'].'"><button class="cancel">Cancel</button>';
			echo '<tr>';
			echo '<td width="15%">'.$row['stud_lrno'].'</td>';
			echo '<td width="65%">'.$row['stud_fullname'].'</td>';
			echo '<td width="20%">'.(($row['sec_stat'] === 'Permanent') ? $transfer : $cancel);
			echo $this->editDetailsMessage($row).'</td>';	
			echo '</tr>';
		}
	}

	public function updateStudentInfo($post) {
		$sql = $this->conn->prepare("SELECT * FROM student WHERE stud_lrno = :stud_lrno");
		$sql->execute(array(
			':stud_lrno' => $post['stud_lrno']
		));
		$exist = $sql->rowCount();
		if (!($exist > 0)) {
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
				':medical_stat' => (isset(($post['medical_stat'])) ? $post['medical_stat'] : null),
				':student_id' => $post['student_id']
			));
			$this->createLog('Update', 'Updated the details of '.$result['stud_fullname']);
			$this->others->Message('Success!,', 'The details of '.$result['stud_fullname'].' has been changed', "success", "faculty-student");
		} else {
			$this->others->Message('Error!,', "You can't use that LRN No. because it already exist!", "error", "faculty-student");
		}
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
		$sql = $this->conn->prepare("SELECT  CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS oppo_section FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id <> :acc_id AND grade_lvl = :grade_lvl");
		$sql->execute(array(':acc_id' => $acc_id, ':grade_lvl' => $grade_lvl));
		$result = $sql->fetch();
		echo $result['oppo_section'];
	}

	public function showOppoStudent($acc_id) {
		$getAdvSection = $this->conn->prepare("SELECT  CONCAT('Grade ', grade_lvl, ' - ', sec_name) AS section_handled, grade_lvl FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id");
		$getAdvSection->execute(array(':acc_id' => $acc_id));
		$resultAdv = $getAdvSection->fetch();
		$grade_lvl =$resultAdv['grade_lvl'];
		$sql = $this->conn->prepare("SELECT *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as stud_fullname FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv JOIN student ON sec_id = secc_id WHERE sec_stat = 'Temporary' AND grade_lvl = (SELECT grade_lvl FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id) AND acc_id <> :acc_id AND grade_lvl = :grade_lvl AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated')");
		$sql->execute(array(':acc_id' => $acc_id, ':grade_lvl' => $grade_lvl));
		$result = $sql->fetchAll();
		foreach ($result as $row) {
			echo '<tr>';
			echo '<td width="15%">'.$row['stud_lrno'].'</td>';
			echo '<td width="65%">'.$row['stud_fullname'].'</td>';
			echo '<td width="20%"><input class="stud_id" type="hidden" value="'.$row['stud_id'].'"><button class="accept inline-btn">Accept</button><button class="reject inline-btn">Reject</button></td>';
			echo '</tr>';
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
			$this->others->Message('Success!,', 'The announcement has been posted', "success", "faculty-classes");
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
				$this->others->Message('Success!,', 'The announcement has been posted', "success", "faculty-classes");
			} else {
				$this->others->Message('Error!,', "You're file is too large!", "error", "faculty-classes");
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
        $querySchedule = $this->conn->prepare("SELECT  '09:40:00' as 'time_start', '10:00:00' AS 'time_end', 'RECESS' AS subj_name, '' AS 'stud_sec' UNION SELECT  '12:00:00' as 'time_start', '13:00:00' AS 'time_end', 'LUNCH' AS subj_name, '' AS 'stud_sec' UNION SELECT  time_start, time_end, subj_name, CONCAT('Grade ', year_level, ' - ', sec_name) AS 'stud_sec' FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN student ON secc_id = sec_id JOIN accounts ON acc_idz = acc_id WHERE acc_id = ? AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated') GROUP BY time_start ORDER BY 1") or die("FAILED");
        $querySchedule->bindParam(1, $_SESSION['accid']);
        $querySchedule->execute();
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
        	$section = '';
        	$new_time_start = date('h:i A', strtotime($time_start[$c]));
        	$new_time_end = date('h:i A', strtotime($time_end[$c]));
        	foreach($result as $row) {
        		if ($time_start[$c] == $row['time_start']) {
        			$subj_name = $row['subj_name'];
        			$section = $row['stud_sec'];
        		}
        	}
        	echo '<td>'.$new_time_start.' - '.$new_time_end.'</td>';
        	echo '<td colspan="5">'.($subj_name  !== '' ? '<div>'.$subj_name.'<br>'.$section.'</div>' : 'Unassigned').'</td>';
        	echo '</tr>';
        }
        
    }

    public function createSectionOptions() {
    	$sql = $this->conn->prepare("SELECT  time_start, time_end, subj_name, CONCAT('Grade ', year_level, ' - ', sec_name) AS 'stud_sec', sec_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN student ON secc_id = sec_id JOIN accounts ON acc_idz = acc_id WHERE acc_id = :accid AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated') GROUP BY time_start ORDER BY sec_id");
    	$sql->execute(array(
    		':accid' => $_SESSION['accid']
    	));
    	$result = $sql->fetchAll();
    	foreach($result as $row) {
    		echo '<option value="'.$row['sec_id'].'">'.$row['stud_sec'].'</option>';
    	}
    }

    public function getScheduleAdvisory() {
        $querySchedule = $this->conn->prepare("SELECT  '09:40:00' AS 'time_start', '10:00:00' AS 'time_end', 'RECESS' AS subj_name, '' AS 'stud_sec', '' AS 'facultyname' UNION SELECT  '12:00:00' AS 'time_start', '13:00:00' AS 'time_end', 'LUNCH' AS subj_name, '' AS 'stud_sec', '' AS 'facultyname' UNION SELECT  time_start, time_end, subj_name, CONCAT('G', year_level, ' - ', sec_name) AS 'stud_sec', CONCAT(fac_fname, ' ', fac_midname, ' ', fac_lname) AS 'facultyname' FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN student ON secc_id = sec_id JOIN accounts ON acc_idz = acc_id WHERE sec_id = (SELECT  sec_id FROM section JOIN faculty ON section.fac_idv = faculty.fac_id JOIN schedsubj ss ON ss.fw_id = faculty.fac_id JOIN subject ON subject.subj_id = ss.schedsubjb_id JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE (fac_adviser = 'Yes' AND acc_id = ?) GROUP BY 1) GROUP BY time_start ORDER BY 1") or die ("FAILED");
        $querySchedule->bindParam(1, $_SESSION['accid']);
        $querySchedule->execute();
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
        		}
        	}
        	echo '<td>'.$new_time_start.' - '.$new_time_end.'</td>';
        	echo '<td colspan="5">'.($subj_name  !== '' ? '<div>'.$subj_name.'<br>'.$faculty.'</div>' : 'Unassigned').'</td>';
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
		foreach ($result as $row) {
			echo '<tr>';
			echo '<td>'.$row['post'].'</td>';
			echo '<td>
				<div name="dialog" title="Edit an announcement">
					<div class="container">
						<div class="modal-cont">
							<form action="faculty-classes" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="announcement_id" value="'.$row['ann_id'].'">
								<input type="textbox" name="post" value="'.$row['post'].'">';
								if ($row['gr_sec'] === $advsec['sec_id']) {
									echo '<input type="hidden" name="gr_sec" value="'.$row['gr_sec'].'">';
								} else {
									echo '<select name="gr_sec">';
									$this->createSectionOptions();
									echo '</select>';
								}
			echo 			'<input type="file" name="file">
								<input type="submit" name="update-announcements">
							</form>
						</div>
					</div>
				</div>
				<button type="button" name="opener" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
				<form action="faculty-classes" method="POST">
					<input type="hidden" name="announcement_id" value="'.$row['ann_id'].'">
					<button type="submit" name="delete-announcement"><span class="tooltip remove" title="Remove this announcement"><i class="far fa-trash-alt"></i></span></button>
				</form>
			</td>';
			echo '</tr>';
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
			$this->others->Message('Success!,', 'The announcement has been deleted', "success", "faculty-classes");
		} else {
			$path = 'public/attachment/'.$result['attachment'];
			if (file_exists($path)) {
				$deleteAnn = $this->conn->prepare("DELETE FROM announcements WHERE ann_id=:announcement_id");
				$deleteAnn->execute(array(
					':announcement_id' => $post['announcement_id']
				));
				unlink($path);
				$this->createLog('Delete', 'Delete an announcement');
				$this->others->Message('Success!,', 'The announcement has been deleted', "success", "faculty-classes");
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
				$this->others->Message('Success!,', 'The announcement has been updated', "success", "faculty-classes");
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
		$sql = $this->conn->query("SELECT * FROM section");
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

	public function insertUpdateGetSubj($post) {
		$time_start = array('07:40:00', '08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00');
        $time_end = array('08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00');
		$index = array_search($post['time_start'], $time_start);
        if (isset($post['prev-teacher'])) {
        	$update_schedsubj = $this->conn->prepare("UPDATE schedsubj SET schedsubjb_id = :subject, fw_id = :teacher WHERE fw_id=:prev_teacher AND sw_id = :sec_id");
        	$update_schedsubj->execute(array(
        		':subject' => $post['subject'],
        		':teacher' => $post['teacher'],
        		':prev_teacher' => $post['prev-teacher'],
        		':sec_id' => $post['sec_id']
        	));
        	$this->createLog('Update', 'Updated a schedule.');
        	$this->others->Message('Success!', 'The schedule has been updated!', 'success', 'faculty-editclass');
        } else {
        	$insert_schedsubj = $this->conn->prepare("INSERT INTO schedsubj (schedsubja_id, schedsubjb_id, day, time_start, time_end, fw_id, sw_id) VALUES (:sched_a, :subject, 'Monday,Tuesday,Wednesday,Thursday,Friday', :time_start, :time_end, :teacher, :sec_id)");
        	$insert_schedsubj->execute(array(
        		':sched_a' => $post['sched_a'],
        		':subject' => $post['subject'],
        		':time_start' => $time_start[$index],
        		':time_end' => $time_end[$index],
        		':teacher' => $post['teacher'],
        		':sec_id' => $post['sec_id']
        	));
        	$insert_facsec = $this->conn->prepare("INSERT INTO facsec VALUES(:teacher, :sec)");
        	$insert_facsec->execute(array(
        		':teacher' => $post['teacher'],
        		':sec' => $post['sec_id']
        	));
        	$this->createLog('Insert', 'Added a schedule.');
        	$this->others->Message('Success!', 'The schedule has been added!', 'success', 'faculty-editclass');
        }
	}

	public function deleteSched($post) {
		$delete_schedsubj = $this->conn->prepare("DELETE FROM schedsubj WHERE fw_id=:faculty_id AND sw_id=:sec_id");
		$delete_schedsubj->execute(array(
			':faculty_id' => $post['faculty_id'],
			':sec_id' => $post['sec']
		));
		$delete_allfacsec = $this->conn->query("DELETE FROM facsec");
		$getFWSW = $this->conn->query("SELECT fw_id, sw_id FROM schedsubj");
		$result = $getFWSW->fetchAll();
		foreach ($result as $row) {
			$sql = $this->conn->prepare("INSERT INTO facsec (fac_idy, sec_idy) VALUES (:fw_id, :sw_id)");
			$sql->execute(array(
				':fw_id' => $row['fw_id'],
				':sw_id' => $row['sw_id']
			));
		}
		$this->createLog('Delete', 'Deleted a schedule.');
		$this->others->Message('Success!', 'The schedule has been deleted!', 'success', 'faculty-editclass');
	}

	/********************** END OF CLASSES HANDLED **********************/

	/********************** START OF GRADES **********************/

	public function getScheduleGrades() {
        $querySchedule = $this->conn->prepare("SELECT  fac_id, time_start, time_end, subj_name, CONCAT('Grade ', year_level, ' - ', sec_name) AS 'stud_sec', sec_id, subj_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN student ON secc_id = sec_id JOIN accounts ON acc_idz = acc_id WHERE acc_id = :accid AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated') GROUP BY time_start ORDER BY time_start") or die("FAILED");
        $querySchedule->execute(array(
        	':accid' => $_SESSION['accid']
        ));
        $result = $querySchedule->fetchAll();
        foreach($result as $row) {
        	$getCurrentGrading = $this->conn->prepare("SELECT * FROM system_settings");
        	$getCurrentGrading->execute();
        	$queryResult = $getCurrentGrading->fetch();
        	$active_grading = $queryResult['active_grading'];
        	$time_start = date('h:i A', strtotime($row['time_start']));
        	$time_end = date('h:i A', strtotime($row['time_end']));
        	echo '<tr>';
        	echo '<td>Monday to Friday</td>';
        	echo '<td>'.$time_start.' - '.$time_end.'</td>';
        	echo '<td>'.$row['stud_sec'].'</td>';
        	echo '<td>
				<div name="dialog" title="Update Student Grades for '.$row['stud_sec'].'" class="upload-file-dialog">
					<div class="container">
						<div class="modal-cont">
				        	<form action="faculty-grades" method="post" class="faculty-grades-form">
				        		<div class="date-subj">
									<div class="subject">
										<p>Subject: <span>'.$row['subj_name'].'</span><input type="hidden" name="subject-code" value="'.$row['subj_id'].'" readonly=""></p>
										<input type="hidden" name="faculty-id" value="'.$row['fac_id'].'">
										<input type="hidden" name="active_grading" value="'.$active_grading.'">
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
											<th>4th Grading</th>
											<th>Input grades for '.$active_grading.' Grading</th>
											'.($active_grading == '4th' ? '<th>Input remarks</th>' : '').'
										</thead>
										<tbody>';
			$student = $this->displaySectionStudAtt($row['sec_id']);
			$c = 0;
			foreach ($student as $stud) {
				$grade_1st = $this->getStudentGrades('1st', $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
				$grade_2nd = $this->getStudentGrades('2nd', $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
				$grade_3rd = $this->getStudentGrades('3rd', $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
				$grade_4th = $this->getStudentGrades('4th', $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
				$grade_active = $this->getStudentGrades($active_grading, $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
				$remarks_active = $this->getStudentRemarks($active_grading, $stud['stud_id'], $row['fac_id'], $row['sec_id'], $row['subj_id']);
				echo '<tr>';
				echo '<td>'.$stud['Name'].'</td>';
				echo '<td>'.$grade_1st.'</td>';
				echo '<td>'.$grade_2nd.'</td>';
				echo '<td>'.$grade_3rd.'</td>';
				echo '<td>'.$grade_4th.'</td>';
				if ($active_grading != '4th') {
					echo 
					'<td>
						<input type="text" data-validation="number" data-validation-error-msg="The input value was not a correct number, it should only be between 65 to 99)" data-validation-allowing="range[65;99]" name="grade[]" '.(!empty($grade_active) ? 'value="'.$grade_active.'"' : '').'>
						<input type="hidden" name="stud_id[]" value="'.$stud['stud_id'].'">
					</td>';
				} else {
					echo 
					'<td>
						<input type="text" name="grade[]" '.(!empty($grade_active) ? 'value="'.$grade_active.'"' : '').'>
						<input type="hidden" name="stud_id[]" value="'.$stud['stud_id'].'">
					</td>';
					echo 
					'<td>
						<input type="text" name="remarks[]" class="remarks" '.(!empty($remarks_active) ? 'value="'.$remarks_active.'"' : '').'>	
					</td>';
				}
				echo '</tr>';
				$c++;
			}
			echo '						</tbody>
									</table>
								</div>
								<button type="submit" name="submit-grades">SAVE</button>
				        	</form>
						</div>
					</div>
				</div>
				<button type="button" name="opener" data-type="open-dialog"><i class="fas fa-pen"></i></button>
        	</td>';
        	echo '</tr>';
        }
    }

    /********** DIVISION FOR GRADES TO CORE VALUE ***********/

    public function getCoreVal() {
        $querySchedule = $this->conn->prepare("SELECT  fac_id, time_start, time_end, subj_name, CONCAT('Grade ', year_level, ' - ', sec_name) AS 'stud_sec', sec_id, subj_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN student ON secc_id = sec_id JOIN accounts ON acc_idz = acc_id WHERE acc_id = :accid AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated') GROUP BY time_start ORDER BY time_start") or die("FAILED");
        $querySchedule->execute(array(
        	':accid' => $_SESSION['accid']
        ));
        $result = $querySchedule->fetchAll();
        foreach($result as $row) {
        	$getCurrentGrading = $this->conn->prepare("SELECT * FROM system_settings");
        	$getCurrentGrading->execute();
        	$queryResult = $getCurrentGrading->fetch();
        	$active_grading = $queryResult['active_grading'];
        	$time_start = date('h:i A', strtotime($row['time_start']));
        	$time_end = date('h:i A', strtotime($row['time_end']));
        	echo '<tr>';
        	echo '<td>Monday to Friday</td>';
        	echo '<td>'.$time_start.' - '.$time_end.'</td>';
        	echo '<td>'.$row['stud_sec'].'</td>';
        	echo '<td>
				<div name="dialog" title="Update Student Grades for '.$row['stud_sec'].'" class="upload-file-dialog">
					<div class="container">
						<div class="modal-cont">
				        	<form action="faculty-grades" method="post" class="faculty-grades-form">
				        		<div class="date-subj">
									<div class="subject">
										<p>Subject: <span>'.$row['subj_name'].'</span><input type="hidden" name="subject-code" value="'.$row['subj_id'].'" readonly=""></p>
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
			$student = $this->displaySectionStudAtt($row['sec_id']);
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
								<button type="submit" name="submit-core-values">SAVE</button>
				        	</form>
						</div>
					</div>
				</div>
				<button type="button" name="opener" data-type="open-dialog"><i class="fas fa-pen"></i></button>
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
    	$checkIfGradesExist = $this->conn->prepare("SELECT * FROM grades WHERE grading = :grading AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id");
    	$checkIfGradesExist->execute(array(
    		':grading' => $post['active_grading'],
    		':fac_id' => $post['faculty-id'],
    		':sec_id' => $post['sec_id'],
    		':subj_id' => $post['subject-code']
    	)) or die('Error!');
    	if ($post['active_grading'] != '4th') {
	    	if ($checkIfGradesExist->rowCount() > 0) {
	    		$c = 0;
	    		foreach($post['stud_id'] as $stud_id) {
	    			$insertStudentGrade = $this->conn->prepare("UPDATE grades SET grade = :grade WHERE grading = :grading AND studd_id = :stud_id AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id");
	    			$insertStudentGrade->execute(array(
	    				':grade' => $post['grade'][$c],
	    				':grading' => $post['active_grading'],
	    				':stud_id' => $stud_id,
	    				':fac_id' => $post['faculty-id'],
	    				':sec_id' => $post['sec_id'],
	    				':subj_id' => $post['subject-code']
	    			));
	    			$c++;
	    		}
    			$this->createLog('Insert', 'Inserted grades for '.$post['section']);
				$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');
	    	} else {
	    		$c = 0;
	    		foreach($post['stud_id'] as $stud_id) {
	    			$insertStudentGrade = $this->conn->prepare("INSERT INTO grades (grade, grading, studd_id, facd_id, secd_id, subj_ide) VALUES (:grade, :grading, :stud_id, :fac_id, :sec_id, :subj_id)");
	    			$insertStudentGrade->execute(array(
	    				':grade' => $post['grade'][$c],
	    				':grading' => $post['active_grading'],
	    				':stud_id' => $stud_id,
	    				':fac_id' => $post['faculty-id'],
	    				':sec_id' => $post['sec_id'],
	    				':subj_id' => $post['subject-code']
	    			));
	    			$c++;
	    		}
    			$this->createLog('Insert', 'Inserted grades for '.$post['section']);
				$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');
	    	}
    	} else {
    		if ($checkIfGradesExist->rowCount() > 0) {
	    		$c = 0;
	    		foreach($post['stud_id'] as $stud_id) {
	    			$insertStudentGrade = $this->conn->prepare("UPDATE grades SET grade = :grade, remarks = :remarks WHERE grading = :grading AND studd_id = :stud_id AND facd_id = :fac_id AND secd_id = :sec_id AND subj_ide = :subj_id");
	    			$insertStudentGrade->execute(array(
	    				':grade' => (!empty($post['grade'][$c]) ? $post['grade'][$c] : null),
	    				':remarks' => ((!empty($post['remarks'][$c]) && empty($post['grade'][$c]) ) ? $post['remarks'][$c] : null),
	    				':grading' => $post['active_grading'],
	    				':stud_id' => $stud_id,
	    				':fac_id' => $post['faculty-id'],
	    				':sec_id' => $post['sec_id'],
	    				':subj_id' => $post['subject-code']
	    			));
	    			$c++;
	    		}
    			$this->createLog('Insert', 'Inserted grades for '.$post['section']);
				$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');
	    	} else {
	    		$c = 0;
	    		foreach($post['stud_id'] as $stud_id) {
	    			$insertStudentGrade = $this->conn->prepare("INSERT INTO grades (grade, remarks, grading, studd_id, facd_id, secd_id, subj_ide) VALUES (:grade, :remarks, :grading, :stud_id, :fac_id, :sec_id, :subj_id)");
	    			$insertStudentGrade->execute(array(
	    				':grade' => (!empty($post['grade'][$c]) ? $post['grade'][$c] : null),
	    				':remarks' => ((!empty($post['remarks'][$c]) && empty($post['grade'][$c]) ) ? $post['remarks'][$c] : null),
	    				':grading' => $post['active_grading'],
	    				':stud_id' => $stud_id,
	    				':fac_id' => $post['faculty-id'],
	    				':sec_id' => $post['sec_id'],
	    				':subj_id' => $post['subject-code']
	    			));
	    			$c++;
	    		}
    			$this->createLog('Insert', 'Inserted grades for '.$post['section']);
				$this->others->Message('Success!', 'The grades has been submitted!', 'success', 'faculty-grades');
	    	}
    	}
    }

	/********************** END OF GRADES **********************/

	/********************** START OF ATTENDANCE **********************/

	public function getScheduleAttendance() {
        $querySchedule = $this->conn->prepare("SELECT  fac_id, time_start, time_end, subj_name, CONCAT('Grade ', year_level, ' - ', sec_name) AS 'stud_sec', sec_id, subj_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN student ON secc_id = sec_id JOIN accounts ON acc_idz = acc_id WHERE acc_id = :accid AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated') GROUP BY time_start ORDER BY time_start") or die("FAILED");
        $querySchedule->execute(array(
        	':accid' => $_SESSION['accid']
        ));
        $result = $querySchedule->fetchAll();
        foreach($result as $row) {
        	$time_start = date('h:i A', strtotime($row['time_start']));
        	$time_end = date('h:i A', strtotime($row['time_end']));
        	echo '<tr>';
        	echo '<td>Monday to Friday</td>';
        	echo '<td>'.$time_start.' - '.$time_end.'</td>';
        	echo '<td>'.$row['stud_sec'].'</td>';
        	echo '<td>
				<div name="dialog" title="Update attendance for '.$row['stud_sec'].'" class="upload-file-dialog">
					<div class="container">
						<div class="modal-cont">
				        	<form action="faculty-attendance" method="post" class="faculty-attendance-form">
				        		<div class="date-subj">
									<div class="date"><p>Date: <input name="attDate" data-section="'.$row['sec_id'].'" type="text" placeholder="YYYY-MM-DD" class="datepicker-attendance" readonly=""></p></div>
									<div class="subject">
										<p>Subject: <span>'.$row['subj_name'].'</span><input type="hidden" name="subject-code" value="'.$row['subj_id'].'" readonly=""></p>
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
			$student = $this->displaySectionStudAtt($row['sec_id']);
			$c = 0;
			foreach ($student as $stud) {
				$option = '';
				if ($stud['remarks'] == 'No remarks yet') {
					$option = '<input type="text" name="student['.$c.'][attendance]" value="Present" class="present" readonly="">';
				} else if ($stud['remarks'] == 'Late') {
					$option = '<input type="text" name="student['.$c.'][attendance]" value="Late" class="late" readonly="">';
				} else if ($stud['remarks'] == 'Absent') {
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
			echo '						</tbody>
									</table>
								</div>
								<button type="submit" name="submit-attendance">SAVE</button>
				        	</form>
						</div>
					</div>
				</div>
				<button type="button" name="opener" data-type="open-dialog"><i class="fas fa-pen"></i></button>
        	</td>';
        	echo '</tr>';
        }
    }


	public function displaySectionStudAtt($sec_id) {
		date_default_timezone_set('Asia/Manila');
		$att_date = date('Y-m-d');
		$getStuds = $this->conn->prepare("SELECT  CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name', CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec', CASE WHEN s.stud_id NOT IN (SELECT  stud_ida FROM attendance where attendance.att_date = :att_date GROUP BY 1) THEN 'No remarks yet' WHEN s.stud_id IN (SELECT  stud_ida FROM attendance GROUP BY 1) THEN (SELECT  remarks FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student st ON st.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND sec_ide = :sec_id AND att_date = :att_date AND s.stud_id = st.stud_id AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated')) END 'remarks', subj_name, stud_id, sec_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN student s ON secc_id = sec_id JOIN accounts ON acc_idz = :accid WHERE sec_id = :sec_id  UNION SELECT  CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name', CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec', remarks, subj_name, stud_id, sec_id FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student sst ON sst.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated') AND sec_ide = :sec_id AND att_date = :att_date GROUP BY 1 ORDER BY 1");
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
						$updateNewAtt = $this->conn->prepare("UPDATE attendance SET remarks = :remarks WHERE att_id = :att_id");
						$updateNewAtt->execute(array(
							':remarks' => $post['student'][$c]['attendance'],
							':att_id' => $result['att_id']
						)) or die($this->others->Message('Error!', 'Query Error', 'error', 'faculty-attendance'));
					} else {
						$insert = $this->conn->prepare("INSERT INTO attendance (att_date, remarks, stud_ida, fac_idb, subjatt_id, sec_ide) VALUES (:attDate, :remarks, :stud_id, :fac_id, :sub_id, :sec_id)");
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
				if ($post['student'][$c]['attendance'] === 'Absent' || $post['student'][$c]['attendance'] === 'Late') {
					$insert = $this->conn->prepare("INSERT INTO attendance (att_date, remarks, stud_ida, fac_idb, subjatt_id, sec_ide) VALUES (:attDate, :remarks, :stud_id, :fac_id, :sub_id, :sec_id)");
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

	/********************** END OF ATTENDANCE **********************/

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
		$query = $this->conn->prepare("SELECT  CASE WHEN sec1.count < sec2.count THEN sec1.sec_id WHEN sec1.count > sec2.count THEN sec2.sec_id WHEN sec1.count = sec2.count THEN sec1.sec_id ELSE sec1.sec_id END AS sec_id FROM (SELECT  0 AS 'count', (SELECT  sec_id FROM section WHERE grade_lvl = :year_level ORDER BY 1 LIMIT 1) sec_id UNION SELECT  COUNT(gender) AS 'count', sec_id FROM student JOIN section ON secc_id = sec_id WHERE year_level = :year_level AND gender = :gender AND sec_id = (SELECT  sec_id FROM section WHERE grade_lvl = :year_level ORDER BY 1 ASC LIMIT 1) GROUP BY secc_id ORDER BY 1 DESC LIMIT 1) sec1 JOIN (SELECT  0 AS 'count', (SELECT  sec_id FROM section WHERE grade_lvl = :year_level ORDER BY 1 DESC LIMIT 1) sec_id UNION SELECT  COUNT(gender) AS 'count', sec_id FROM student JOIN section ON secc_id = sec_id WHERE year_level = :year_level AND gender = :gender AND sec_id = (SELECT  sec_id FROM section WHERE grade_lvl = :year_level ORDER BY 1 DESC LIMIT 1) AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated') GROUP BY secc_id ORDER BY 1 DESC LIMIT 1) sec2");
		$query->execute(array(
			':year_level' => $year_level,
			':gender' => $gender
		));
		$result = $query->fetch();
		return $result['sec_id'];
	}

	/*For long echo messages add them here and set them as private to avoid being used and showing long echos between methods*/
	private function editStatusMessage($name, $options, $lrno) {
		return '<div class="edit-status-cont">
				<div name="dialog" title="Edit status for '.$name.'">
						<div class="container">
							<div class="modal-cont">
								<form action="faculty-enroll" method="POST">
									<input type="hidden" value="'.$lrno.'" name="lrn">
									<label>Status: </label>
									<select name="curr-status">
										'.$options.'
									</select>
									<button type="submit" name="change-stud-status">Change</button>
								</form>
							</div>
						</div>
					</div>
				<button type="button" name="opener" class="edit-status" data-type="open-dialog">STATUS</button>
				</div>';
	}
	private function editDetailsMessage($row) {
		$radio = $row['gender'] === 'Male' ? '<input type="radio" name="gender" value="Male" checked="checked" required/>MALE&nbsp;&nbsp;<input type="radio" name="gender" value="Female"/>FEMALE' : '<input type="radio" name="gender" value="Male" required/>MALE&nbsp;&nbsp;<input type="radio" name="gender" checked="checked" value="Female"/>FEMALE';
		$options2 =  $this->createOption(array('O', 'A', 'B', 'AB'), $row['blood_type']);
		return '<div class="edit-details-cont">
				<div name="dialog" title="Edit student information">
					<div class="container">
						<div class="modal-cont">
							<form action="faculty-student" method="POST" class="edit-stud-detail" id="Student-Details-All">
								<input type="hidden" name="student_id" value="'.$row['stud_id'].'">
								<div class="tabs">
									<ul>
										<li><a href="#Student-Details">STUDENT INFORMATION</a></li>
									</ul>
									<div id="Student-Details">
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
				<button type="button" name="opener" class="edit-details" data-type="open-dialog">Details</button>
			</div>';
	}

	private function createSectionTable($row) {
		$fac_id = $row['fac_idv'];
		$getFacInfo = $this->conn->query("SELECT * FROM faculty WHERE fac_id = '".$fac_id."'");
		$getSchedID = $this->conn->query("SELECT sched_id FROM schedule WHERE sched_yrlevel = '".$row['grade_lvl']."'");
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
		$sched_1 = $this->getSchedInfo($sched_id['sched_id'], $time_start[0], $row['sec_id']);
		$sched_2 = $this->getSchedInfo($sched_id['sched_id'], $time_start[1], $row['sec_id']);
		$sched_3 = $this->getSchedInfo($sched_id['sched_id'], $time_start[2], $row['sec_id']);
		$sched_4 = $this->getSchedInfo($sched_id['sched_id'], $time_start[3], $row['sec_id']);
		$sched_5 = $this->getSchedInfo($sched_id['sched_id'], $time_start[4], $row['sec_id']);
		$sched_6 = $this->getSchedInfo($sched_id['sched_id'], $time_start[5], $row['sec_id']);
		$sched_7 = $this->getSchedInfo($sched_id['sched_id'], $time_start[6], $row['sec_id']);
		$remove = function($sched) {
			$html = '<form action="faculty-editclass"  method="POST">
			<input type="hidden" name="sec" value="'.$sched['sec_id'].'">
			<input type="hidden" name="sched" value="'.$sched['sched_id'].'">
			<input type="hidden" name="subj_id" value="'.$sched['subj_id'].'">
			<input type="hidden" name="timestart" value="'.$sched['time_start'].'">
			<input type="hidden" name="faculty_id" value="'.$sched['fac_id'].'">
			<button type="remove-class-schedule" class="edit-status-remove" name="remove-this-schedule"><span class="tooltip remove" title="Remove this schedule"><i class="far fa-trash-alt"></i></span></button>
			</form>';
			return $html;
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
											' : 'value="'.$row['sec_id'].'"').'>
											<input type="hidden" name="sched_a" '.($sched_1['exist'] === true ? 'value="'.$sched_1['sched_id'].'"
											' : 'value="'.$sched_id['sched_id'].'"').'>
											<input type="hidden" name="subj_id" '.($sched_1['exist'] === true ? 'value="'.$sched_1['subj_id'].'"
											' : '').'>
											<input type="hidden" name="time_start" value="'.$time_start[0].'">
											'.($sched_1['exist'] === true ? '<input type="hidden" name="prev-teacher" value="'.$sched_1['fac_id'].'">' : '').'
											<label class="teacher">Teacher: </label>
											<select name="teacher" class="editclass-teacher" required>
												<option value="">Select a Teacher</option>'.$teachers($sched_1).'
											</select>
											<br>
											<label class="subject">Subject: </label>
											<select name="subject" class="editclass-subjects" required>
												<option value="">Select a Subject</option>'.$subjects($sched_1).'
											</select>
											<br>
											<div class="forms-btn">
												<button type="submit" name="submit-edit-class">Submit</button>
												<button type="reset" class="reset">Reset</button>
											</div>
										</form>
									</div>
								</div>
								<button type="button" name="opener" class="edit-status" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
								'.($sched_1['exist'] === true ? $remove($sched_1) : '').'
							</div>
						</td>
					</tr>
					<tr>
						<td>8:40 - 9:40</td>
						<td colspan="5" class="row-subj">
							<div class="sched-info">
								<p class="info">'.($sched_2['exist'] === true ? $sched_2['subj'].' - '.$sched_2['name']: 'No data yet').'</p>
								<div name="dialog" title="Select a subject and teacher for ">
									<div class="container">
										<form action="faculty-editclass" method="POST" class="classes-sched">
											<input type="hidden" name="sec_id" '.($sched_2['exist'] === true ? 'value="'.$sched_2['sec_id'].'"
											' : 'value="'.$row['sec_id'].'"').'>
											<input type="hidden" name="sched_a" '.($sched_2['exist'] === true ? 'value="'.$sched_2['sched_id'].'"
											' : 'value="'.$sched_id['sched_id'].'"').'>
											<input type="hidden" name="subj_id" '.($sched_2['exist'] === true ? 'value="'.$sched_2['subj_id'].'"
											' : '').'>
											<input type="hidden" name="time_start" value="'.$time_start[1].'">
											'.($sched_2['exist'] === true ? '<input type="hidden" name="prev-teacher" value="'.$sched_2['fac_id'].'">' : '').'
											<label class="teacher">Teacher: </label>
											<select name="teacher" class="editclass-teacher" required>
												<option value="">Select a Teacher</option>'.$teachers($sched_2).'
											</select>
											<br>
											<label class="subject">Subject: </label>
											<select name="subject" class="editclass-subjects">
											<option value="">Select a Subject</option>'.$subjects($sched_2).'
											</select>
											<br>
											<div class="forms-btn">
												<button type="submit" name="submit-edit-class">Submit</button>
												<button type="reset" class="reset">Reset</button>
											</div>
										</form>
									</div>
								</div>
								<button type="button" name="opener" class="edit-status" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
								'.($sched_2['exist'] === true ? $remove($sched_2) : '').'
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
								<div name="dialog" title="Select a subject and teacher for ">
									<div class="container">
										<form action="faculty-editclass" method="POST" class="classes-sched">
											<input type="hidden" name="sec_id" '.($sched_3['exist'] === true ? 'value="'.$sched_3['sec_id'].'"
											' : 'value="'.$row['sec_id'].'"').'>
											<input type="hidden" name="sched_a" '.($sched_3['exist'] === true ? 'value="'.$sched_3['sched_id'].'"
											' : 'value="'.$sched_id['sched_id'].'"').'>
											<input type="hidden" name="subj_id" '.($sched_3['exist'] === true ? 'value="'.$sched_3['subj_id'].'"
											' : '').'>
											<input type="hidden" name="time_start" value="'.$time_start[2].'">
											'.($sched_3['exist'] === true ? '<input type="hidden" name="prev-teacher" value="'.$sched_3['fac_id'].'">' : '').'
											<label class="teacher">Teacher: </label>
											<select name="teacher" class="editclass-teacher" required>
												<option value="">Select a Teacher</option>'.$teachers($sched_3).'
											</select>
											<br>
											<label class="subject">Subject: </label>
											<select name="subject" class="editclass-subjects">
											<option value="">Select a Subject</option>'.$subjects($sched_3).'
											</select>
											<br>
											<div class="forms-btn">
												<button type="submit" name="submit-edit-class">Submit</button>
												<button type="reset" class="reset">Reset</button>
											</div>
										</form>
									</div>
								</div>
								<button type="button" name="opener" class="edit-status" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
								'.($sched_3['exist'] === true ? $remove($sched_3) : '').'
							</div>
						</td>
					</tr>
					<tr>
						<td>11:00 - 12:00</td>
						<td colspan="5" class="row-subj">
							<div class="sched-info">
								<p class="info">'.($sched_4['exist'] === true ? $sched_4['subj'].' - '.$sched_4['name']: 'No data yet').'</p>
								<div name="dialog" title="Select a subject and teacher for ">
									<div class="container">
										<form action="faculty-editclass" method="POST" class="classes-sched">
											<input type="hidden" name="sec_id" '.($sched_4['exist'] === true ? 'value="'.$sched_4['sec_id'].'"
											' : 'value="'.$row['sec_id'].'"').'>
											<input type="hidden" name="sched_a" '.($sched_4['exist'] === true ? 'value="'.$sched_4['sched_id'].'"
											' : 'value="'.$sched_id['sched_id'].'"').'>
											<input type="hidden" name="subj_id" '.($sched_4['exist'] === true ? 'value="'.$sched_4['subj_id'].'"
											' : '').'>
											<input type="hidden" name="time_start" value="'.$time_start[3].'">
											'.($sched_4['exist'] === true ? '<input type="hidden" name="prev-teacher" value="'.$sched_4['fac_id'].'">' : '').'
											<label class="teacher">Teacher: </label>
											<select name="teacher" class="editclass-teacher" required>
												<option value="">Select a Teacher</option>'.$teachers($sched_4).'
											</select>
											<br>
											<label class="subject">Subject: </label>
											<select name="subject" class="editclass-subjects">
											<option value="">Select a Subject</option>'.$subjects($sched_4).'
											</select>
											<br>
											<div class="forms-btn">
												<button type="submit" name="submit-edit-class">Submit</button>
												<button type="reset" class="reset">Reset</button>
											</div>
										</form>
									</div>
								</div>
								<button type="button" name="opener" class="edit-status" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
								'.($sched_4['exist'] === true ? $remove($sched_4) : '').'
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
								<div name="dialog" title="Select a subject and teacher for ">
									<div class="container">
										<form action="faculty-editclass" method="POST" class="classes-sched">
											<input type="hidden" name="sec_id" '.($sched_5['exist'] === true ? 'value="'.$sched_5['sec_id'].'"
											' : 'value="'.$row['sec_id'].'"').'>
											<input type="hidden" name="sched_a" '.($sched_5['exist'] === true ? 'value="'.$sched_5['sched_id'].'"
											' : 'value="'.$sched_id['sched_id'].'"').'>
											<input type="hidden" name="subj_id" '.($sched_5['exist'] === true ? 'value="'.$sched_5['subj_id'].'"
											' : '').'>
											<input type="hidden" name="time_start" value="'.$time_start[4].'">
											'.($sched_5['exist'] === true ? '<input type="hidden" name="prev-teacher" value="'.$sched_5['fac_id'].'">' : '').'
											<label class="teacher">Teacher: </label>
											<select name="teacher" class="editclass-teacher" required>
												<option value="">Select a Teacher</option>'.$teachers($sched_5).'
											</select>
											<br>
											<label class="subject">Subject: </label>
											<select name="subject" class="editclass-subjects">
											<option value="">Select a Subject</option>'.$subjects($sched_5).'
											</select>
											<br>
											<div class="forms-btn">
												<button type="submit" name="submit-edit-class">Submit</button>
												<button type="reset" class="reset">Reset</button>
											</div>
										</form>
									</div>
								</div>
								<button type="button" name="opener" class="edit-status" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
								'.($sched_5['exist'] === true ? $remove($sched_5) : '').'
							</div>
						</td>
					</tr>
					<tr>
						<td>2:00 - 3:00</td>
						<td colspan="5" class="row-subj">
							<div class="sched-info">
								<p class="info">'.($sched_6['exist'] === true ? $sched_6['subj'].' - '.$sched_6['name']: 'No data yet').'</p>
								<div name="dialog" title="Select a subject and teacher for ">
									<div class="container">
										<form action="faculty-editclass" method="POST" class="classes-sched">
											<input type="hidden" name="sec_id" '.($sched_6['exist'] === true ? 'value="'.$sched_6['sec_id'].'"
											' : 'value="'.$row['sec_id'].'"').'>
											<input type="hidden" name="sched_a" '.($sched_6['exist'] === true ? 'value="'.$sched_6['sched_id'].'"
											' : 'value="'.$sched_id['sched_id'].'"').'>
											<input type="hidden" name="subj_id" '.($sched_6['exist'] === true ? 'value="'.$sched_6['subj_id'].'"
											' : '').'>
											<input type="hidden" name="time_start" value="'.$time_start[5].'">
											'.($sched_6['exist'] === true ? '<input type="hidden" name="prev-teacher" value="'.$sched_6['fac_id'].'">' : '').'
											<label class="teacher">Teacher: </label>
											<select name="teacher" class="editclass-teacher" required>
												<option value="">Select a Teacher</option>'.$teachers($sched_6).'
											</select>
											<br>
											<label class="subject">Subject: </label>
											<select name="subject" class="editclass-subjects">
											<option value="">Select a Subject</option>'.$subjects($sched_6).'
											</select>
											<br>
											<div class="forms-btn">
												<button type="submit" name="submit-edit-class">Submit</button>
												<button type="reset" class="reset">Reset</button>
											</div>
										</form>
									</div>
								</div>
								<button type="button" name="opener" class="edit-status" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
								'.($sched_6['exist'] === true ? $remove($sched_6) : '').'
							</div>
						</td>
					</tr>
					<tr>
						<td>3:00 - 4:00</td>
						<td colspan="5" class="row-subj">
							<div class="sched-info">
								<p class="info">'.($sched_7['exist'] === true ? $sched_7['subj'].' - '.$sched_7['name']: 'No data yet').'</p>
								<div name="dialog" title="Select a subject and teacher for ">
									<div class="container">
										<form action="faculty-editclass" method="POST" class="classes-sched">
											<input type="hidden" name="sec_id" '.($sched_7['exist'] === true ? 'value="'.$sched_7['sec_id'].'"
											' : 'value="'.$row['sec_id'].'"').'>
											<input type="hidden" name="sched_a" '.($sched_7['exist'] === true ? 'value="'.$sched_7['sched_id'].'"
											' : 'value="'.$sched_id['sched_id'].'"').'>
											<input type="hidden" name="subj_id" '.($sched_7['exist'] === true ? 'value="'.$sched_7['subj_id'].'"
											' : '').'>
											<input type="hidden" name="time_start" value="'.$time_start[6].'">
											'.($sched_7['exist'] === true ? '<input type="hidden" name="prev-teacher" value="'.$sched_7['fac_id'].'">' : '').'
											<label class="teacher">Teacher: </label>
											<select name="teacher" class="editclass-teacher" required>
												<option value="">Select a Teacher</option>'.$teachers($sched_7).'
											</select>
											<br>
											<label class="subject">Subject: </label>
											<select name="subject" class="editclass-subjects">
											<option value="">Select a Subject</option>'.$subjects($sched_7).'
											</select>
											<br>
											<div class="forms-btn">
												<button type="submit" name="submit-edit-class">Submit</button>
												<button type="reset" class="reset">Reset</button>
											</div>
										</form>
									</div>
								</div>
								<button type="button" name="opener" class="edit-status" data-type="open-dialog"><span class="tooltip edit" title="Edit this schedule"><i class="far fa-edit"></i></span></button>
								'.($sched_7['exist'] === true ? $remove($sched_7) : '').'
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>';
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
	/********************** END OF PRIVATE METHODS **********************/

	/***** Other functionalities for the website  *****/

}
?>