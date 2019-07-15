<?php
require 'app/model/connection.php';
class ChangePassword {

	private $conn;

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}

	public function newPassword($password, $repassword) {
		if ($password === $repassword) {
			if (strlen($password) >= 8) {
				$hashed = password_hash($password, PASSWORD_DEFAULT);
				$update = $this->conn->prepare("UPDATE accounts SET password = :hashed, acc_details = 'Old' WHERE acc_id = :accid");
				$update->execute(array(
					':hashed' => $hashed,
					':accid' => $_SESSION['accid']
				));
				$_SESSION['acc_details'] = 'Old';
				$_SESSION['success_pass'] = 'You\'ve successfully changed your password';
				echo '<meta http-equiv="refresh" content="0"; url=admin-dashboard">';
			} else {
				$this->errorMessage("Invalid password. Password length must be 8 characters and above");
			} 
		} else {
			$this->errorMessage("Passwords doesn't match");
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
} 
?>