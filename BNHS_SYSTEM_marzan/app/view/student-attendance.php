<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>

<div class="contentpage">
	<div class="row">
		<div id="widget">
			<div class="header">
				<p><i class="fas fa-check-square fnt"></i><span> Attendance</span></p>
			</div>
			<div class='widgetcontent'>
				<?php $run->studAttendance(); ?>
			</div>
		</div>
	</div>
</div>