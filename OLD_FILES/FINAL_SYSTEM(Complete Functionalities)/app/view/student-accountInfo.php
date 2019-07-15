<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>
<div class="contentpage">
	<div class="row">
		<div class="container">
			<div class="cont cont4"id = "cont4">
				<?php $this->helpers->getUserImage(); ?> </br>
				<p><span> <?php $run->getName(); ?> </span></p>

				<a href="student-accountInfo"><i class="fa fa-inbox">&nbsp;&nbsp;Account Info</i>&nbsp;&nbsp;&nbsp;</a>
				<a href="student-information"><i class="fa fa-user">&nbsp;Personal Details</i></a>
			</div>
			<div class="cont cont2">
				<div id="widget">
					<div class="header">
						<p><i class="fas fa-user fnt"></i><span>&nbsp;&nbsp;User Profile</span></p>
					</div>
					<div class="widgetcontent">
						<div class="conthead">
							<p>Account Information</p>
						</div>
						<?php $run->getAccountInfo(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>