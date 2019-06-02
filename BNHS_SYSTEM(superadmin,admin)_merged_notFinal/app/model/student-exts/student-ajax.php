<?php 
require '../connection.php';

class studentAjax {
	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
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
}

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
$run = new studentAjax;
if(isset($_GET['data'][0]) && $_GET['data'][0] === 'getNotif') $run->getNotif();
?>

}