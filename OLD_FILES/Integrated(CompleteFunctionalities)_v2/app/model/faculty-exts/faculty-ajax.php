<?php 
require '../connection.php';
require '../other-funct.php';
class FacultyAjax {

	public function __construct() {
		$this->others = new OtherMethods;
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function setLevel() {
		$year_level = explode('=', $_POST['data'][1]);
		$sql = $this->conn->query("SELECT subj_level FROM subject JOIN section ON subj_level = grade_lvl WHERE sec_id = ".$year_level[1]." GROUP BY grade_lvl");
		$result = $sql->fetch();
		$_SESSION['subj_lvl'] = $result['subj_level'];
	}

	public function fillOutForm() {
		$id = explode('=', $_POST['data'][1]);
		$sql = $this->conn->query("SELECT * FROM student st JOIN guardian gr ON st.guar_id = gr.guar_id WHERE st.guar_id = '".$id[1]."' GROUP BY st.guar_id LIMIT 1");
		$_SESSION['full_stud_guar_info'] = $sql->fetchAll();
	}

	public function getNotif(){
		$sql = $this->conn->prepare("SELECT *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as stud_fullname FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv JOIN student ON sec_id = secc_id WHERE sec_stat = 'Temporary' AND grade_lvl = (SELECT grade_lvl FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id) AND acc_id <> :acc_id");
		$sql->execute(array(':acc_id' => $_SESSION['accid']));
		$result = $sql->fetchAll();
		$_SESSION['notif'] = $sql->rowCount();
		$data = array();
		$data['addthis'] = array();
		foreach($result as $row) {
			$data['addthis'][] = '
			<tr>
				<td width="15%">'.$row['stud_lrno'].'</td>
				<td width="65%">'.$row['stud_fullname'].'</td>
				<td width="20%"><input class="stud_id" type="hidden" value="'.$row['stud_id'].'"><button class="accept inline-btn">Accept</button><button class="reject inline-btn">Reject</button></td>
			</tr>
			';
		}
		$data['response'] = $_SESSION['notif'];
		echo json_encode($data);
	}

	public function getNewAttTable() {
		$getStudents = $this->conn->prepare("SELECT *, CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name' FROM student WHERE secc_id = :sec_id");
		$getStudents->execute(array(
			':sec_id' => $_GET['data'][2]
		));
		$student = $getStudents->fetchAll();
		$c = 0;
		$html = '';
		foreach ($student as $stud) {
			$checkAttendance = $this->conn->prepare("SELECT * FROM attendance WHERE att_date = :att AND stud_ida = :stud AND fac_idb = :fac AND subjatt_id = :subj AND sec_ide = :sec");
			$checkAttendance->execute(array(
				':att' => $_GET['data'][1],
				':stud' => $stud['stud_id'],
				':fac' => $_GET['data'][3],
				':subj' => $_GET['data'][4],
				':sec' => $_GET['data'][2]
			));
			$studentAtt = $checkAttendance->fetch();
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
			$html .= '<tr>';
			$html .= '<td>'.$stud['Name'].'</td>';
			$html .= '<td>'.$input.'</td>';
			$html .= '</tr>';
			$c++;
		}
		echo $html;
	}

	public function getNewReasonTable() {
		$getStuds = $this->conn->prepare("SELECT CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name', CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec', CASE WHEN s.stud_id NOT IN (SELECT  stud_ida FROM attendance WHERE attendance.att_date = :att_date GROUP BY 1) THEN 'No remarks yet' WHEN s.stud_id IN (SELECT stud_ida FROM attendance GROUP BY 1) THEN (SELECT att_remarks FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student st ON st.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND sec_ide = :sec_id AND att_date = :att_date AND subj_id = :subj_id AND s.stud_id = st.stud_id AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated')) END 'att_remarks', '' as type, CASE WHEN s.stud_id NOT IN (SELECT stud_ida FROM attendance WHERE attendance.att_date = :att_date GROUP BY 1) THEN 'Present' WHEN s.stud_id IN (SELECT stud_ida FROM attendance GROUP BY 1) THEN (SELECT  remarks FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student st ON st.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND sec_ide = :sec_id AND att_date = :att_date AND subj_id = :subj_id AND s.stud_id = st.stud_id AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated')) END 'remarks', CASE WHEN s.stud_id NOT IN (SELECT stud_ida FROM attendance WHERE attendance.att_date = :att_date GROUP BY 1) THEN 'No attachment' WHEN s.stud_id IN (SELECT stud_ida FROM attendance GROUP BY 1) THEN (SELECT  att_attachment FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student st ON st.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND sec_ide = :sec_id AND att_date = :att_date AND subj_id = :subj_id AND s.stud_id = st.stud_id AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated')) END 'att_attachment', subj_name, stud_id, sec_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN student s ON secc_id = sec_id JOIN accounts ON acc_idz = :accid WHERE sec_id = :sec_id AND subj_id = :subj_id UNION SELECT CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name', CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec', att_remarks, type, remarks, att_attachment, subj_name, stud_id, sec_id FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student sst ON sst.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND (stud_status <> 'Transferred' AND stud_status <> 'Not Enrolled' AND stud_status <> 'Graduated') AND sec_ide = :sec_id AND att_date = :att_date AND subj_id = :subj_id GROUP BY 1 ORDER BY 1");
		$getStuds ->execute(array(
			':accid' => $_SESSION['accid'],
			':sec_id' => $_GET['data'][2],
			':att_date' => $_GET['data'][1],
			':subj_id' => $_GET['data'][3]
		));
		$studResult = $getStuds->fetchAll();
		$draw = array();
		$html = '';
		$c = 0;
		$checkIfExistAbsent = 0;
		if($getStuds->rowCount() > 0) {
			foreach ($studResult as $stud) {
				if ($stud['type'] !== '') {
					if ($stud['att_remarks'] !== 'No remarks yet') {
						if (strpos($stud['subj_name'],'Arts') !== 0 && strpos($stud['subj_name'],'(PE)') !== 0 && strpos($stud['subj_name'],'Health') !== 0 && strpos($stud['subj_name'],'Physical Education') !== 0) {
							$option = '';
							if ($stud['att_remarks'] == 'No reason yet') {
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
							$html .= '<tr>';
							$html .= '<td>'.$stud['Name'].'</td>';
							$html .= '<td>'.$stud['type'].'</td>';
							$html .= '<td><span> '.($stud['att_attachment'] !== null ? '<p class="tright attachment" style="font-size: 12px;"><a href="public/letter/'.$stud['att_attachment'].'" download>Download attachment</a></p>' : '').'</span></td>';
							$html .= '<td>'.$input.'</td>';
							$html .= '</tr>';
							$c++;
						}
					}
				} else {
					$checkIfExistAbsent++;
				}
			}
		}
		if($checkIfExistAbsent === count($studResult)) {
			$html = '<tr><td colspan="5" style="text-align:center;">There are no student who are absent or late this day!</td></tr>';
		}
		echo $html;
	}

	public function filterSelects() {
		if(empty($_GET['data'][1])) {
			$data = array();
			$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = gg_fid WHERE acc_id = :accid GROUP BY gr_sec ORDER BY gr_level, gr_sec");
			$query->execute(array(
				':accid' => $_SESSION['accid']
			));
			$data['sec'] = '<option value="">All</option>';
			foreach($query->fetchAll() as $row) {
				$data['sec'] .= '<option value="Grade '.$row['gr_level'].' - '.$row['gr_sec'].'">Grade '.$row['gr_level'].' - '.$row['gr_sec'].'</option>';
			}

			$query1 = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = gg_fid WHERE acc_id = :accid GROUP BY subject_name ORDER BY subject_name");
			$query1->execute(array(
				':accid' => $_SESSION['accid']
			));
			$data['sub'] = '<option value="">All</option>';
			foreach($query1->fetchAll() as $row) {
				$data['sub'] .= '<option value="'.$row['subject_name'].'">'.$row['subject_name'].'</option>';
			}
			echo json_encode($data);
		} else {
			$data = array();
			$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = gg_fid WHERE acc_id = :accid AND gg_sy = :sy GROUP BY gr_sec ORDER BY gr_level, gr_sec");
			$query->execute(array(
				':accid' => $_SESSION['accid'],
				':sy' => $_GET['data'][1]
			));
			$data['sec'] = '<option value="">All</option>';
			foreach($query->fetchAll() as $row) {
				$data['sec'] .= '<option value="Grade '.$row['gr_level'].' - '.$row['gr_sec'].'">Grade '.$row['gr_level'].' - '.$row['gr_sec'].'</option>';
			}

			$query1 = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = gg_fid WHERE acc_id = :accid AND gg_sy = :sy GROUP BY subject_name ORDER BY subject_name");
			$query1->execute(array(
				':accid' => $_SESSION['accid'],
				':sy' => $_GET['data'][1]
			));
			$data['sub'] = '<option value="">All</option>';
			foreach($query1->fetchAll() as $row) {
				$data['sub'] .= '<option value="'.$row['subject_name'].'">'.$row['subject_name'].'</option>';
			}
			echo json_encode($data);
		}
	}

	public function filterSelects2() {
		if(empty($_GET['data'][1])) {
			$data = array();
			$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = adv_id WHERE acc_id = :accid GROUP BY gr_sec ORDER BY gr_level, gr_sec");
			$query->execute(array(
				':accid' => $_SESSION['accid']
			));
			$data['sec'] = '<option value="">All</option>';
			foreach($query->fetchAll() as $row) {
				$data['sec'] .= '<option value="Grade '.$row['gr_level'].' - '.$row['gr_sec'].'">Grade '.$row['gr_level'].' - '.$row['gr_sec'].'</option>';
			}

			$query1 = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = adv_id WHERE acc_id = :accid GROUP BY subject_name ORDER BY subject_name");
			$query1->execute(array(
				':accid' => $_SESSION['accid']
			));
			$data['sub'] = '<option value="">All</option>';
			foreach($query1->fetchAll() as $row) {
				$data['sub'] .= '<option value="'.$row['subject_name'].'">'.$row['subject_name'].'</option>';
			}
			echo json_encode($data);
		} else {
			$data = array();
			$query = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = adv_id WHERE acc_id = :accid AND gg_sy = :sy GROUP BY gr_sec ORDER BY gr_level, gr_sec");
			$query->execute(array(
				':accid' => $_SESSION['accid'],
				':sy' => $_GET['data'][1]
			));
			$data['sec'] = '<option value="">All</option>';
			foreach($query->fetchAll() as $row) {
				$data['sec'] .= '<option value="Grade '.$row['gr_level'].' - '.$row['gr_sec'].'">Grade '.$row['gr_level'].' - '.$row['gr_sec'].'</option>';
			}

			$query1 = $this->conn->prepare("SELECT * FROM accounts JOIN faculty ON acc_id = acc_idz JOIN grades_grading ON fac_id = adv_id WHERE acc_id = :accid AND gg_sy = :sy GROUP BY subject_name ORDER BY subject_name");
			$query1->execute(array(
				':accid' => $_SESSION['accid'],
				':sy' => $_GET['data'][1]
			));
			$data['sub'] = '<option value="">All</option>';
			foreach($query1->fetchAll() as $row) {
				$data['sub'] .= '<option value="'.$row['subject_name'].'">'.$row['subject_name'].'</option>';
			}
			echo json_encode($data);
		}
	}
}

/* OUTSIDE THE CLASS */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$run = new FacultyAjax;
if(isset($_POST['data'][0]) && $_POST['data'][0] === 'setLevel') $run->setLevel();
if(isset($_POST['data'][0]) && $_POST['data'][0] === 'filloutform') $run->fillOutForm();
if(isset($_POST['data'][0]) && $_POST['data'][0] === 'deleteSched') $run->deleteSched();
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'setSubj') $run->setDept();
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'getNotif') $run->getNotif();
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'att-changedate') $run->getNewAttTable();
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'att-changedate1') $run->getNewReasonTable();
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'filter-selects') $run->filterSelects();
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'filter-selects2') $run->filterSelects2();
?>