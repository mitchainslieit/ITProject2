<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct(); ?>
<?php
	if(isset($_POST['submit-attendance'])) {
		$getFactFunct->submitAttendance($_POST);
	}
?>
	<div class="contentpage">
		<div class="row">
			<div class="newwidget widget">
				<div class="classattendance header">
					<p>
						<i class="fas fa-th"></i>
						<span>Attendance</span>
					</p>
					<p>School Year: <?php $getFactFunct->getSchoolYear(); ?></p>
				</div>
				<div class="attendancecontent widgetcontent">
					<p>Click on edit button to add or update the grades for that section</p>
					<div class="widget">
						<table>
							<thead>
								<th>Days</th>
								<th>Time</th>
								<th>Section</th>
								<th>Options</th>
							</thead>
							<tbody>
								<?php $getFactFunct->getScheduleAttendance(); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>