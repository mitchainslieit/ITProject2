	<?php require 'app/model/faculty-funct.php'; $obj = new FacultyFunct;?>
	<?php 
		if(isset($_POST['profile-button'])){
			extract($_POST);
			$obj->updateProfile($_FILES['prof_pic']);
		}
		if (isset($_POST['change'])) {
		   $oldPassword = $_POST['oldPassword'];
	        $password = $_POST['password'];
	        $repassword = $_POST['repassword'];
	        $obj->newPassword($oldPassword,$password, $repassword);
	    }
	?>
	<?php
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	?>
<?php foreach($obj->facultyDetails() as $value){
	extract($value);
	echo'
	<div class="contentpage">
		<div class="profile-banner">
			<div class="row">
				<div class="tleft">';
					$queryCheckExist=$this->conn->prepare("SELECT * FROM accounts where acc_id=:acc_id");
					$queryCheckExist->execute(array(
						':acc_id' => $_SESSION['accid']
					));
					$rowQueryCheckExist=$queryCheckExist->fetch(PDO::FETCH_ASSOC);
					$prof_pic=$rowQueryCheckExist['prof_pic'];
					if($prof_pic == NULL || $prof_pic == ''){
						echo '<img src="public/images/common/profpic/user.png" class="img-circle profile-avatar" alt="User avatar" height=200>';
					}else{
						echo '<img src="public/images/common/profpic/'.$prof_pic.'" class="img-circle profile-avatar" alt="User avatar" height=200>';
					}
				echo '
				</div>
			</div>
		</div>
	</div>
	<div class="contentpage">
		<div class="row rowProf">
			<div class="nameCont">
				<div name="content" id="changeProfileCont">
					<button name="opener">Change Profile</button>
					<div name="dialog" title="Change Profile">
						<form action="faculty-profile" method="POST" enctype="multipart/form-data">
							<input type="file" name="prof_pic" id="" placeholder="Attachment(optional)">
							<button name="profile-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
						</form>
					</div>  
				</div>
				<h4>
					<b>'.$facultyName.'</b>
				</h4>
				<h5>'.$acc_type.'</h5>
				<div name="content">
					<button name="opener" class="btn btn-success btn-sm btn-block">Change Password</button>
					<div name="dialog" title="Change Password">
						<p>Password must be at least 8 characters</p>
						<form action="faculty-profile" method="post" autocomplete="off">
							<div class="inputs">
								<div class="password">
								<span>Old Password</span>
									<input type="password" name="oldPassword" placeholder="Old Password" required>
								</div>
								<div class="password">
								<span>New Password</span>
									<input type="password" name="password" placeholder="Password" required data-validation="length" data-validation-length="min8">
								</div>
								<div class="password">
								<span>Confirm Password</span>
									<input type="password" name="repassword" placeholder="Confirm Password" required data-validation="length" data-validation-length="min8">
								</div>
							</div>
							<div class="item-right">
								<button type="submit" name="change" class="btn btn-success btn-sm btn-block" value="Change">Change</button>
							</div>
						</form>
					</div>  
				</div>
			</div>
			<div class="widget">
				<div class="widgetcontent">
					<div class="box box1">
						<span>Employee ID:</span>
						<input type="text" value="'.$fac_no.'" disabled>
					</div>
					<div class="box box2">
						<span>Department:</span>
						<input type="text" value="'.$fac_dept.'" disabled>
					</div>
					<div class="box box3">
						<span>Edit Schedule Privilege:</span>
						<input type="text" value="'.$sec_privilege.'" disabled>
					</div>
					<div class="box box4">
						<span>Enroll Privilege:</span>
						<input type="text" value="'.$enroll_privilege.'" disabled>
					</div>
				</div>
			</div>
		</div>
	</div>';
}
?>