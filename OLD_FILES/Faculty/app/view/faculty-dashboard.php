	<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct(); ?>
	<div class="contentpage">
		<div class="row">	
			<div class="summary">
				<div class="box box1">
					<h4>TOTAL <span>No. Of Students</span></h4>
					<div class="innercont">	
						<span><?php $getFactFunct->getNoOfStudent(); ?></span>
						<i class="fas fa-users"></i>
					</div>	
				</div>
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
					<h4>TOTAL <span>No. Of New Students</span></h4>
					<div class="innercont">	
						<span><?php $getFactFunct->getNoOfNewStudent(); ?></span>
						<i class="fas fa-users"></i>
					</div>	
				</div>
			</div>
			<div class="dashboardWidget">
				<div class="container contleft">
					<div class="header">
						<p>	
							<i class="fas fa-th"></i>
							<span>Calendar</span>
						</p>
					</div>	
					<div class="widgetcontent">
						<div id="calendar"></div>
					</div>
				</div>
				<div class="container contright">
					<div class="innercont1">
						<div class="header">
							<p>	
								<i class="far fa-calendar-alt fnt"></i>
								<span>Announcement</span>
							</p>
						</div>
						<div class="eventcontent">
							<?php $getFactFunct->getAnnouncements(); ?>
						</div>	
						<div class="widgetcontent2">
						<div id="announcement"></div>
						</div>
					</div>
				</div>
			</div>	
		</div>	
	</div>
