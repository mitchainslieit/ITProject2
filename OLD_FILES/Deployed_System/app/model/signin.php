<?php
require 'app/model/connection.php';
class Signin {

	private $conn;

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function userSignin($username, $password) {
		if (!empty($username) && !empty($password)) {
			$query = $this->conn->prepare("SELECT * FROM accounts WHERE username=?");
			$query->bindParam(1, $username);
			$query->execute();
			$getRowCount = $query->rowCount();
			if ( $getRowCount == 0 ){
			   $this->errorMessage("That user doesn't exist!");
			} else {
				$user = $query->fetch();
				if ( password_verify($password, $user['password']) ) {
					$accstat = $user['acc_status'];
					if ( $accstat === "Deactivated" ) {
						$this->errorMessage("Account Deactivated!");
					} else {
						$_SESSION['loggedin'] = "1";
						$_SESSION['user_type'] = $user['acc_type'];
						$_SESSION['username'] = $user['username'];
						$_SESSION['accid'] = $user['acc_id'];
						$_SESSION['acc_details'] = $user['acc_details'];
						$_SESSION['account_name'] = $this->getName($user['acc_id'], $user['acc_type']);
						switch ($user['acc_type']) {
							case 'Superadmin': 
							$this->needsForSuperadmin();
							$this->getTransferRequests();
							$this->getCurriculumRequests();
							$this->getSectionRequest();
							echo '<meta http-equiv="refresh" content="0"; url=superadmin-dashboard">';
							break;
							case 'Admin': 
							$this->getFacultyRequests();
							echo '<meta http-equiv="refresh" content="0"; url=admin-dashboard">';
							break;
							case 'Student': 
							echo '<meta http-equiv="refresh" content="0"; url=student-dashboard">';
							break;
							case 'Faculty': 
							$this->getNeedsForFaculty();
							echo '<meta http-equiv="refresh" content="0"; url=faculty-dashboard">';
							break;
							case 'Parent': 
							echo '<meta http-equiv="refresh" content="0"; url=parent-dashboard">';
							break;
							case 'Treasurer': 
							echo '<meta http-equiv="refresh" content="0"; url=treasurer-dashboard">';
							break;
						}
					}
				} else {
				    $this->errorMessage("Invalid Password!");
				}
			}
		}
	}

	private function getNeedsForFaculty() {
		$sql = $this->conn->query("SELECT * FROM faculty WHERE acc_idz = '".$_SESSION['accid']."'");
		$sql->execute();
		$row = $sql->fetch();
		$_SESSION['adviser'] = $row['fac_adviser'];
		$_SESSION['sec_privilege'] = $row['sec_privilege'];
		$sql = $this->conn->prepare("SELECT *, CONCAT(first_name, ' ', middle_name, ' ', last_name) as stud_fullname FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv JOIN student ON sec_id = secc_id WHERE sec_stat = 'Temporary' AND grade_lvl = (SELECT grade_lvl FROM accounts JOIN faculty ON acc_id = acc_idz JOIN section ON fac_id = fac_idv WHERE acc_id = :acc_id) AND acc_id <> :acc_id");
		$sql->execute(array(':acc_id' => $_SESSION['accid']));
		$_SESSION['notif'] = $sql->rowCount();
		$checkEditClassEnabled = $this->conn->prepare("SELECT * FROM system_settings");
		$checkEditClassEnabled->execute();
		$result = $checkEditClassEnabled->fetch();
		$_SESSION['editclass'] = $result['edit_class'];
		$_SESSION['transfer_enabled'] = $result['student_transfer'];
		$_SESSION['enroll_privilege'] = $row['enroll_privilege'];
	}

	private function needsForSuperadmin() {
		$sql = $this->conn->query("SELECT * from request join budget_info_temp bi on request.request_id = bi.bd_request where request_status = 'Temporary'");
		$sql->execute();
		$_SESSION['sanotif_1'] = $sql->rowCount();
	}
	
	private function getFacultyRequests(){
		$query=$this->conn->prepare("SELECT * FROM logs WHERE towhom = :us AND seen_unseen = 'Unseen'");
		$query->execute(array(':us' => $_SESSION['accid']));
		$_SESSION['adminNotif'] = $query->rowCount();
	}
	
	private function getTransferRequests(){
		$query=$this->conn->prepare("SELECT * FROM student WHERE sec_stat='Temporary'");
		$query->execute();
		$_SESSION['transferNotif'] = $query->rowCount();	
	}
	
	private function getCurriculumRequests(){
		$query=$this->conn->prepare("SELECT DISTINCT(c_desc) as 'c_desc',curriculum_idx,request_id,request_desc,request_type from subject_temp join curriculum_temp on curriculum_idx=cc_id join request on curr_request=request_id WHERE request_status='Temporary'");
		$query->execute();
		$_SESSION['curriculumNotif'] = $query->rowCount();	
	}
	
	private function getSectionRequest() {
		$sql = $this->conn->query("SELECT * from section_temp st join request r on r.request_id = st.sec_req where r.request_status = 'Temporary' and (r.request_type='Insert' or r.request_type='Update' or r.request_type= 'Delete')");
		$sql->execute();
		$_SESSION['sanotif_2'] = $sql->rowCount();
	}
	
	private function getClassRequest() {
		$sql = $this->conn->query("SELECT * from section_temp st join request r on r.request_id = st.sec_req where r.request_status = 'Temporary' and (r.request_type='Adviser_Insert' or r.request_type='Adviser_Update')");
		$sql->execute();
		$_SESSION['classNotif'] = $sql->rowCount();
	}

	private function errorMessage($message) {	
		echo "<div class='modal-container'>
		<div class='modal-box'>
				<div class='content'>
					<p>".$message." Wait <span class='count'>5</span> seconds or <a href='".URL."login'>Click here</a></p>
				</div>
			</div>
		</div>
		<script>
		var sec = 4;
		var timer = setInterval(function() {
			$('.modal-box .count').text(sec--);
			if (sec == -1) {
				clearInterval(timer);
			}
		}, 1000);
		setTimeout(function(){
		   window.location = '".URL."login';
		}, 5000);
		</script>";
	}

	private function getName($acc_id, $acc_type) { 
		switch ($acc_type) {
			case 'Superadmin': 
			$query = $this->conn->prepare("SELECT * from accounts JOIN admin ON acc_id = acc_admid WHERE acc_id = ?");
			$query->bindParam(1, $acc_id);
			$query->execute();
			$user = $query->fetch();
			return $user['adm_fname'].' '.substr($user['adm_midname'], 0, 1).'. '.$user['adm_lname'];
			break;
			case 'Admin': 
			$query = $this->conn->prepare("SELECT * from accounts JOIN admin ON acc_id = acc_admid WHERE acc_id = ?");
			$query->bindParam(1, $acc_id);
			$query->execute();
			$user = $query->fetch();
			return $user['adm_fname'].' '.substr($user['adm_midname'], 0, 1).'. '.$user['adm_lname'];
			break;
			case 'Faculty': 
			$query = $this->conn->prepare("SELECT * from accounts JOIN faculty ON acc_idz = acc_id WHERE acc_id = ?");
			$query->bindParam(1, $acc_id);
			$query->execute();
			$user = $query->fetch();
			return $user['fac_fname'].' '.substr($user['fac_midname'], 0, 1).'. '.$user['fac_lname'];
			break;
			case 'Student': 
			$query = $this->conn->prepare("SELECT * from accounts JOIN student ON accc_id = acc_id WHERE acc_id = ?");
			$query->bindParam(1, $acc_id);
			$query->execute();
			$user = $query->fetch();
			return $user['first_name'].' '.substr($user['middle_name'], 0, 1).'. '.$user['last_name'];
			break;
			case 'Parent': 
			$query = $this->conn->prepare("SELECT * from accounts JOIN guardian ON acc_id = acc_idx WHERE acc_id = ?");
			$query->bindParam(1, $acc_id);
			$query->execute();
			$user = $query->fetch();
			return $user['guar_fname'].' '.substr($user['guar_midname'], 0, 1).'. '.$user['guar_lname'];
			break;
			case 'Treasurer': 
			$query = $this->conn->prepare("SELECT * from accounts JOIN treasurer ON acc_id = acc_trid WHERE acc_id = ?");
			$query->bindParam(1, $acc_id);
			$query->execute();
			$user = $query->fetch();
			return $user['tr_fname'].' '.substr($user['tr_midname'], 0, 1).'. '.$user['tr_lname'];
			break;
		}
	}
} 
?>