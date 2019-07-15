<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>
<?php 
if(isset($_POST['changePass'])) {
	extract($_POST);
	$run->changePassword($currentPass, $newPass, $retypePass);
}
?>
<div class="contentpage">
	<div class="row">
		<div class="container">
			<div class="cont cont4">
				<img src="public/images/common/profpic/kennethmarzan33.jpg"> </br>
				<p><span> <?php $run->getName(); ?> </span></p>
				<a href="student-accountInfo"><i class="fa fa-inbox">&nbsp;&nbsp;Account Info</i>&nbsp;&nbsp;&nbsp;</a>
				<a href="student-information"><i class="fa fa-user">&nbsp;Personal Details</i></a>
				<a href="student-changePassword"><i class="fa fa-key">&nbsp;&nbsp;Change Pass</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
			</div>
			<div class="cont cont2">
				<div id="widget">
					<div class="header">
						<p><i class="fas fa-user fnt"></i><span>&nbsp;&nbsp;User Profile</span></p>
					</div>
					<div class="widgetcontent">
					<div class="continue">
                        <form action="student-changePassword" method="POST" autocomplete="off">
                        		<label for="currentPassword"><span>Current Password:</span><input type="password" name="currentPass" value="" id = "currentpass" maxlength="16" required></label>
								<label for="newPassword"><span>New Password:</span><input type="password" name="newPass" value="" id="password" maxlength="16" required></label>
								<label for="retype"><span>Retype Password:</span><input type="password" name="retypePass" value="" id = "retypePass" maxlength="16" required></label>
								<input type="submit" id="contbtn" name="changePass" onclick="checkForm()">
                        </form>
                        <!-- <div class="contbtn">
										 <button type="button" class="btn btn-default">Save</button>
										 <button type="button" class="btn btn-default">Cancel</button>
									</div> -->
                    </div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>