<?php 
require '../connection.php';
class SAAjax {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getNotif(){
		$sql = $this->conn->query("SELECT * from request join budget_info_temp bi on request.request_id = bi.bd_request where request_status = 'Temporary'");
		$sql->execute();
		$_SESSION['sanotif_1'] = $sql->rowCount();
		$data = array();
		$data['addthis'] = array();
		$data['response'] = $sql->rowCount();
		$sql_2 = $this->conn->prepare("SELECT 
			CONCAT(adm_fname, ' ', adm_lname) AS 'admin_name'
			FROM
			admin
			JOIN
			accounts ON accounts.acc_id = admin.acc_admid
			WHERE
			acc_type = 'admin'
			AND acc_status = 'Active'") or die ("failed!");
		$sql_2->execute();
		$currAd = $sql_2->fetch();
		foreach($sql->fetchAll() as $row) {
			$data['addthis'][] = '
			<tr>
				<td><input type="checkbox" id="checkItem" name="check[]" value="'.$row['request_id'].'"></td>
				<td>'.$currAd['admin_name'].'</td>
				<td>'.$row['request_type'].'</td>
				<td>'.$row['request_desc'].'</td>
			</tr>
			';
		}
		echo json_encode($data);
		/*$sql = $this->conn->prepare("SELECT *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as stud_fullname FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv JOIN student ON sec_id = secc_id WHERE sec_stat = 'Temporary' AND grade_lvl = (SELECT grade_lvl FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id) AND acc_id <> :acc_id");
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
		echo json_encode($data);*/
	}
	public function getTransferNotif(){
		$sql = $this->conn->prepare("SELECT * FROM student WHERE sec_stat='Temporary'");
		$sql->execute();
		$result = $sql->fetchAll();
		$_SESSION['transferNotif'] = $sql->rowCount();
		$data = array();
		$data['addthis'] = array();
		foreach($this->getOppoSec() as $value){
			extract($value);
			$data['addthis'][] = '
			<tr>
				<td><input type="checkbox" id="checkItem" name="check[]" value="'.$stud_id.'" form="form1"></td>
				<td class="tleft">'.$stud_lrno.'</td>
				<td class="tleft">'.$stud_fullname.'</td>
				<td class="tleft">'.$currentSection.'</td>
				<td class="tleft">'.$year_level.'</td>
				<td class="tleft">'.$faculty_fullname.'</td>
				<td class="tleft">'.$transferToSection	.'</td>
				<td class="tleft action">
					<form action="admin-transfer" method="POST" required autocomplete="off">
						<input type="hidden" value="'.$stud_id.'" name="stud_id">
						<button name="accept-button" class="customButton" >Accept <i class="fas fa-check"></i></button>
					</form>
					<form action="admin-transfer" method="POST" required autocomplete="off">
						<input type="hidden" value="'.$stud_id.'" name="stud_id">
						<button name="reject-button" class="customButton" >Reject <i class="fas fa-trash"></i></button>
					</form>
				</td>
			</tr>';	
			}
		$data['response'] = $_SESSION['transferNotif'];
		echo json_encode($data);
	}
	private function getOppoSec() {
		$sql = $this->conn->prepare("SELECT *,CONCAT(stud.first_name, ' ', stud.middle_name, ' ', stud.last_name) as stud_fullname, CONCAT(fac_fname, ' ', fac_midname, ' ', fac_lname) as faculty_fullname, sec.sec_name as 'currentSection', sec2.sec_name as 'transferToSection' from student stud join section sec on secc_id=sec.sec_id join section sec2 on stud.transfer_sec=sec2.sec_id join faculty on sec.fac_idv=fac_id where stud.sec_stat='Temporary'");	
		$sql->execute();
		if($sql->rowCount()>0){
			while($r = $sql->fetch(PDO::FETCH_ASSOC)){
				$data[]=$r;
			}
			return $data;
		}
		return $sql;
	}
}

/* OUTSIDE THE CLASS */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$run = new SAAjax;
if(isset($_GET['getNotif'])) $run->getNotif();
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'getTransferNotif') $run->getTransferNotif();
?>