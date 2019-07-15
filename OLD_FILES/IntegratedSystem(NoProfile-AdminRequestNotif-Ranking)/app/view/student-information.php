<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>
<div class="contentpage">
	<div class="row">
		<div class="container">
			<div class="cont cont4" id = "cont4">
				<?php $this->helpers->getUserImage(); ?> </br>
				<p><span> <?php $run->getName(); ?> </span></p>
				<!-- <a href="student-accountInfo"><i class="fa fa-inbox">&nbsp;&nbsp;Account Info</i>&nbsp;&nbsp;&nbsp;</a>
				<a href="student-information"><i class="fa fa-user">&nbsp;Personal Details</i></a> -->
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
					<p>To change/reset password, please request the admin.</p>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>