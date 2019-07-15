<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>
<?php 
	if(isset($_POST['profile-button'])){
		extract($_POST);
		$run->updateProfile($_FILES['prof_pic']);
	}
	if (isset($_POST['change'])) {
		$oldPassword = $_POST['oldPassword'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		$run->newPassword($oldPassword,$password, $repassword);
	}
?>
<div class="contentpage">
	<div class="row">
		<div class="container">
			<div class="cont cont4" id = "cont4">
				<?php $this->helpers->getUserImage(); ?> </br>
				<p><span> <?php $run->getName(); ?> </span></p>
				<div name="content" id="changeProfileCont">
					<button name="opener">Change Picture</button>
					<div name="dialog" title="Change Picture">
						<form action="student-information" method="POST" enctype="multipart/form-data">
							<input type="file" name="prof_pic" id="" accept="image/*" placeholder="Attachment(optional)">
							<button name="profile-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
						</form>
					</div> 
				</div>
				<div name="content">
					<button name="opener" class="btn btn-success btn-sm btn-block">Change Password</button>
					<div name="dialog" title="Change Password">
						<p class="mb-3">Password must be at least 8 characters</p>
						<form action="student-information" method="post" autocomplete="off">
							<div class="inputs">
								<div class="password">
									<span class="d-inline-block text-left mb-3" style="width: 165px;">Old Password</span>
									<input type="password" name="oldPassword" placeholder="Old Password" required>
								</div>
								<div class="password">
									<span class="d-inline-block text-left mb-3" style="width: 165px;">New Password</span>
									<input type="password" name="password" placeholder="Password" required data-validation="length" data-validation-length="min8">
								</div>
								<div class="password">
									<span class="d-inline-block text-left mb-3" style="width: 165px;">Confirm Password</span>
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
			<div class="cont cont2">
				<div id="widget">
				<div class="header">
					<p><i class="fas fa-user fnt"></i><span>&nbsp;&nbsp;Student Information</span></p>
				</div>
				<div class="widgetcontent">
					<div class="conthead">
						<p><b>Personal Information</b></p>
					</div>
						<?php $run->studGeneralInfo();?>
					<div class="conthead">
						<p><b>Contact Information</b></p>
					</div>
					<?php $run->studContactInfo(); ?>
					<div class="conthead">
						<p><b>Account Information</b></p>
					</div>
					<?php $run->getAccountInfo(); ?>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>