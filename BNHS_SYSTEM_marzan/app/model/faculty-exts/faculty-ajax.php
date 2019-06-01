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

	public function acceptStudent() {
		$sql = $this->conn->query("SELECT sec_id FROM section WHERE sec_id <> (SELECT secc_id FROM student JOIN section ON secc_id = sec_id WHERE stud_id = '".$_POST['data'][1]."') AND grade_lvl = (SELECT year_level FROM student JOIN section ON secc_id = sec_id WHERE stud_id = '".$_POST['data'][1]."')");
		$result = $sql->fetch();
		$updateSec = $this->conn->query("UPDATE student SET secc_id = '".$result['sec_id']."', sec_stat='Permanent' WHERE stud_id = '".$_POST['data'][1]."'") or die("Query failed!");
		echo "<script>
			swal({
				title: \"Good job!\",
				text: \"The student has been accepted!\",
				icon: \"success\"
			}).then(function() {
				window.location.href = 'faculty-student';
			});
		</script>";
	}

	public function rejectStudent() {
		$sql = $this->conn->query("UPDATE student SET sec_stat='Permanent' WHERE stud_id ='".$_POST['data'][1]."'");
		echo "<script>
			swal({
				title: \"Rejected!\",
				text: \"You have rejected a request.\",
				icon: \"error\"
			}).then(function() {
				window.location.href = 'faculty-student';
			});
		</script>";
	}

	public function transferStudent() {
		$sql = $this->conn->query("UPDATE student SET sec_stat='Temporary' WHERE stud_id ='".$_POST['data'][1]."'") or die('Query Failed!');
		echo "<script>
			swal({
				title: \"Requested!\",
				text: \"You have requested a transfer for that student.\",
				icon: \"success\"
			}).then(function() {
				window.location.href = 'faculty-student';
			});
		</script>";
	}

	public function cancelTransferStudent() {
		$sql = $this->conn->query("UPDATE student SET sec_stat='Permanent' WHERE stud_id ='".$_POST['data'][1]."'");
		echo "<script>
			swal({
				title: \"Cancelled.\",
				text: \"You've cancelled a request.\",
				icon: \"error\"
			}).then(function() {
				window.location.href = 'faculty-student';
			});
		</script>";
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
		$getStuds = $this->conn->prepare("SELECT  CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name', CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec', CASE WHEN s.stud_id NOT IN (SELECT  stud_ida FROM attendance where attendance.att_date = :att_date GROUP BY 1) THEN 'No remarks yet' WHEN s.stud_id IN (SELECT  stud_ida FROM attendance GROUP BY 1) THEN (SELECT  remarks FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student st ON st.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND sec_ide = :sec_id AND att_date = :att_date AND s.stud_id = st.stud_id) END 'remarks', subj_name, stud_id, sec_id FROM schedsubj ss JOIN subject ON ss.schedsubjb_id = subject.subj_id JOIN facsec fs ON (fs.fac_idy = ss.fw_id && fs.sec_idy = ss.sw_id) JOIN faculty ON fac_idy = fac_id JOIN section ON fs.sec_idy = section.sec_id JOIN student s ON secc_id = sec_id JOIN accounts ON acc_idz = :accid WHERE sec_id = :sec_id  UNION SELECT  CONCAT(last_name, ', ', first_name, ' ', middle_name) AS 'Name', CONCAT('GRADE ', year_level, ' - ', sec_name) AS 'stud_sec', remarks, subj_name, stud_id, sec_id FROM attendance att JOIN schedsubj ss ON att.fac_idb = ss.fw_id && att.sec_ide = ss.sw_id && att.subjatt_id = ss.schedsubjb_id JOIN subject ON subject.subj_id = att.subjatt_id JOIN student sst ON sst.stud_id = att.stud_ida JOIN faculty ON att.fac_idb = faculty.fac_id JOIN section sec ON sec.sec_id = att.sec_ide JOIN accounts ON accounts.acc_id = faculty.acc_idz WHERE acc_id = :accid AND sec_ide = :sec_id AND att_date = :att_date GROUP BY 1 ORDER BY 1");
		$getStuds ->execute(array(
			':accid' => $_SESSION['accid'],
			':sec_id' => $_GET['data'][2],
			':att_date' => $_GET['data'][1]
		));
		$studResult = $getStuds->fetchAll();
		$draw = array();
		$html = '';
		$c = 0;
		foreach ($studResult as $stud) {
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
			$html .= '<tr>';
			$html .= '<td>'.$stud['Name'].'</td>';
			$html .= '<td>'.$input.'</td>';
			$html .= '</tr>';
			$c++;
		}
		echo $html;
	}
}

/* OUTSIDE THE CLASS */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$run = new FacultyAjax;
if(isset($_POST['data'][0]) && $_POST['data'][0] === 'setLevel') $run->setLevel();
if(isset($_POST['data'][0]) && $_POST['data'][0] === 'filloutform') $run->fillOutForm();
if(isset($_POST['data'][0]) && $_POST['data'][0] === 'accept') $run->acceptStudent();
if(isset($_POST['data'][0]) && $_POST['data'][0] === 'reject') $run->rejectStudent();
if(isset($_POST['data'][0]) && $_POST['data'][0] === 'transfer') $run->transferStudent();
if(isset($_POST['data'][0]) && $_POST['data'][0] === 'cancel') $run->cancelTransferStudent();
if(isset($_POST['data'][0]) && $_POST['data'][0] === 'deleteSched') $run->deleteSched();
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'setSubj') $run->setDept();
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'getNotif') $run->getNotif();
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'att-changedate') $run->getNewAttTable();
?>