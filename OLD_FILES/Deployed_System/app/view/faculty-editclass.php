<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct() ?>
<?php
	if(isset($_POST['submit-classes'])) {
		$getFactFunct->setSchedule($_POST);
	} else if (isset($_POST['submit-edit-class'])) {
		$getFactFunct->insertUpdateGetSubj($_POST);
	} else if (isset($_POST['remove-this-schedule'])) {
		$getFactFunct->deleteSched($_POST);
	} else if (isset($_POST['request-sched'])) {
		$getFactFunct->sendRequestToAdminForSched();
	} else if (isset($_POST['cancel-sched'])) {
		$getFactFunct->cancelRequestToAdminForSched();
	}
?>
<?php 
if (isset($_SESSION['sec_privilege']) && $_SESSION['sec_privilege'] === 'No') {
	echo '<script>window.location = "faculty-dashboard";</script>';
} 
?>	
<div class="contentpage">
	<div class="row">	
		<div class="widget">	
			<div class="header">	
				<p>	<i class="fas fa-user-plus fnt"></i><span> Edit Class</span></p>
				<p>School Year: <?php $getFactFunct->getSchoolYear(); ?></p>
			</div>	
			<div class="editContent widgetcontent">
				<div class="cont3">
					<div class="table-scroll">
						<div class ="cont fl">
							<span>SECTION : </span>
							<select name="sec_id" id="getCurrentLevel">
								<?php $getFactFunct->showSections_temp(); ?>
							</select>
						</div>
						<?php $getFactFunct->showTabledSections(); ?>
					<div id="final-submit">
						<form action="faculty-editclass" method="POST">
							<?php $getFactFunct->getStatusofCurrentEdittingSession(); ?>
						</form>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
