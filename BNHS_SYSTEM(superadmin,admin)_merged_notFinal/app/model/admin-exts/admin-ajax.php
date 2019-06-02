<?php 
require '../connection.php';
class AdminAjax {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function getNotif(){
		$sql = $this->conn->prepare("SELECT * FROM student WHERE sec_stat='Temporary'");
		$sql->execute();
		$result = $sql->fetchAll();
		$_SESSION['adminNotif'] = $sql->rowCount();
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
		$data['response'] = $_SESSION['adminNotif'];
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
$run = new AdminAjax;
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'getNotif') $run->getNotif();
?>