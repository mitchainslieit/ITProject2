<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct(); ?>
<?php
	if(isset($_POST['submit-attendance'])) {
		$getFactFunct->submitAttendance($_POST);
	}

	if(isset($_POST['submit-reason'])) {
		$getFactFunct->submitReason($_POST);
	}
?>
	<div class="contentpage">
		<div class="row">
			<div class="newwidget widget">
				<div class="classattendance header">
					<p>
						<i class="fas fa-th"></i>&nbsp;
						<span>Attendance</span>
					</p>
					<p>School Year: <?php $getFactFunct->getSchoolYear(); ?></p>
				</div>
				<div class="attendancecontent widgetcontent">
					<p>Click on edit button to add or update the attendance for that section</p>
					<div class="widget">
						<table>
							<thead>
								<th>Section</th>
								<th>Subject</th>
								<th>Time</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php $getFactFunct->getScheduleAttendance(); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="space"></div>
			<div class="newwidget widget">
				<div class="classattendance header">
					<p>
						<i class="fas fa-th"></i>&nbsp;
						<span>Excuse/Unexcuse a student</span>
					</p>
					<p>School Year: <?php $getFactFunct->getSchoolYear(); ?></p>
				</div>
				<div class="attendancecontent widgetcontent">
					<p>Click on edit button to add or update the reason for that section</p>
					<div class="widget">
						<table>
							<thead>
								<th>Section</th>
								<th>Subject</th>
								<th>Time</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php $getFactFunct->getScheduleReason(); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>