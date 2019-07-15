	<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct(); ?>
	<div class="contentpage">
		<div class="row">
			<div class="container"></div>	
			<div class="summary">
				<div class="box box2">
					<h4>TOTAL <span>No. Of Male Students</span></h4>
					<div class="innercont">	
						<span><?php $getFactFunct->getNoOfMaleStudent(); ?></span>
						<i class="fas fa-users"></i>
					</div>	
				</div>
				<div class="box box3">
					<h4>TOTAL <span>No. Of Female Students</span></h4>
					<div class="innercont">	
						<span><?php $getFactFunct->getNoOfFemaleStudent(); ?></span>
						<i class="fas fa-users"></i>
					</div>	
				</div>
				<div class="box box4">
					<h4>TOTAL <span>No. Of Enrolled Students</span></h4>
					<div class="innercont">	
						<span><?php $getFactFunct->getNoOfNewStudent(); ?></span>
						<i class="fas fa-users"></i>
					</div>	
				</div>
			</div>
			<div class="dashboardWidget">
				<div class="contright">
					<div class="header">
						<p>	
							<i class="far fa-calendar-alt fnt"></i>
							<span>Holiday</span>
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
									<?php $getFactFunct->showHolidays(); ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="contleft">
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
										<?php $getFactFunct->getAnnouncements(); ?>
									</tbody>
								</table>
							</div>
							<div class="eventBox">
								<table id="eventDataTable" class="w-100">
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
										<?php $getFactFunct->showEvents(); ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>