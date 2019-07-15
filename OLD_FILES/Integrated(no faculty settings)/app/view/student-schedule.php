<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>
<div class="contentpage">
	<div class="row">
		<div id="widget">
			<div class="header">
				<p>	
					<i class="fas fa-user fnt"></i>
					<span>Class Schedule</span>
				</p>			
			</div>
			<div class="widgetcontent">
				<table id="sched">
					<tr>
						<td>Schedule</td>
						<td colspan="5">Teacher and Subject</td>
					</tr>
					<?php $run->getSchedule($_SESSION['accid']); ?>
				</table>
			</div>
		</div>
	</div>
</div>