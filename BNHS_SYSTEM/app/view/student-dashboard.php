<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>

<div class="contentpage">
	<div class="row">
		<div class="summary">
			<div class="head">
				<img src="public/images/common/logo.png" class="fl">
				<p class="fl">Bakakeng National High School </br>Student Portal </p>
			</div>
		</div>

		<div class="eventwidget">
			<div class="dashboardWidget">
				<div class="contleft" id="dashboard-left">
					<div class="innercont2">
						<div class="header">
							<p>	
								<i class="far fa-calendar-alt fnt"></i>
								<span>Announcement</span>
							</p>
						</div>
						<div class="eventcontent">
							<div class="announcementBox">
								<table id="announcementDataTable">
									<thead>
										<tr>
											<th class="tleft title">Announcement</th>
										</tr>
									</thead>
									<tbody>
										<?php $run->getAnnouncements(); ?>
									</tbody>
								</table>
							</div>
							<div class="eventBox">
								<table id="eventDataTable">
									<thead>
										<tr>
											<th class="tleft title" colspan="2">Events</th>
										</tr>
										<tr>
											<th class="tleft custPad2">Event Title</th>
											<th class="tleft custPad2">Event Date</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($run->showEvents() as $row) {
											extract($row);
											echo'
											<tr>
											<td class="tleft custPad2 longTitle">'.$title.'</td>
											<td class="tleft custPad2">'.$date_start_1.' - '.$date_end_1.'</td>
											</tr>';
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--******************************************************************************************** -->			
			<div class="contright">
				<div class="innercont1">
					<div class="header">
						<p>	
							<i class="fas fa-user fnt"></i>
							<span>Student Status</span>
						</p>
					</div>
					<div class="eventcontent">
						<div class="echead">
							<p>Status</p>
						</div>
						<?php $run->getStatus(); ?>
						<div class="echead">
							<p>Academic Performance:</p>
						</div>
						<div class="contin">
							<?php $run->getPerformance(); ?>
						</div>
					</div>
				</div>
				<div class="innercont2">
	<!-- <div class="header">
		<p>	
			<i class="far fa-calendar-alt fnt"></i>
			<span>Event Calendar</span>
		</p>
	</div>
	<div id="calendar"></div>
</div> -->

<div class="header">
	<p>	
		<i class="far fa-calendar-alt fnt"></i>
		<span>Calendar</span>
	</p>
</div>
<div class="eventcontent">
	<div class="holidayBox">
		<table id="eventDataTable">
			<thead>
				<tr>
					<th class="tleft title" colspan="2">Upcoming Holidays</th>
				</tr>
				<tr>
					<th class="tleft custPad2">Holiday Title</th>
					<th class="tleft custPad2">Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($run->showHolidays() as $row) {
					extract($row);
					echo'
					<tr>
					<td class="tleft custPad2 longTitle">'.$title.'</td>
					<td class="tleft custPad2">'.$date_start_1.'</td>
					</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>
</div>


</div>
</div>
</div>
</div>
