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
						$_SESSION['account_name'] = $this->getName($user['acc_id'], $user['acc_type']);
						switch ($user['acc_type']) {
							case 'Admin': 
								echo '<meta http-equiv="refresh" content="0"; url=admin-dashboard">';
								break;
							case 'Student': 
								echo '<meta http-equiv="refresh" content="0"; url=student-dashboard">';
								break;
							case 'Faculty': 
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
			case 'Admin': 
				$query = $this->conn->prepare("SELECT * from accounts JOIN admin ON acc_id = acc_admid WHERE acc_id = ?");
				$query->bindParam(1, $acc_id);
				$query->execute();
				$user = $query->fetch();
				return $user['adm_fname'].' '.$user['adm_midinitial'].'. '.$user['adm_lname'];
			break;
			case 'Faculty': 
				$query = $this->conn->prepare("SELECT * from accounts JOIN faculty ON acc_idz = acc_id WHERE acc_id = ?");
				$query->bindParam(1, $acc_id);
				$query->execute();
				$user = $query->fetch();
				return $user['fac_fname'].' '.$user['fac_midinitial'].'. '.$user['fac_lname'];
				break;
			case 'Student': 
				$query = $this->conn->prepare("SELECT * from accounts JOIN student ON accc_id = acc_id WHERE acc_id = ?");
				$query->bindParam(1, $acc_id);
				$query->execute();
				$user = $query->fetch();
				return $user['first_name'].' '.substr($user['middle_name'], 0, 1).'. '.$user['last_name'];
				break;
			case 'Parent': 
				$query = $this->conn->prepare("SELECT * from accounts JOIN parent ON acc_idx = acc_id WHERE acc_id = ?");
				$query->bindParam(1, $acc_id);
				$query->execute();
				$user = $query->fetch();
				return $user['pr_fname'].' '.$user['pr_midinitial'].'. '.$user['pr_lname'];
				break;
			case 'Treasurer': 
				$query = $this->conn->prepare("SELECT * from accounts JOIN parent ON acc_idx = acc_id WHERE acc_id = ?");
				$query->bindParam(1, $acc_id);
				$query->execute();
				$user = $query->fetch();
				return $user['pr_fname'].' '.$user['pr_midinitial'].'. '.$user['pr_lname'];
				break;
		}
	}
} 
?>