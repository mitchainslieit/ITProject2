<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
	<?php 
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();	
	?>
	<div class="contentpage">
		<div class="row">	
			<div class="summary">
				<a href="superadmin-enrolledstudents" class="box box1">
					<h4>TOTAL <span>No. Of Enrolled Students</span></h4>
					<div class="innercont">	
						<span><?php 
								$sql=$this->conn->query("SELECT count(stud_id) FROM student") or die ("failed!");
								$sql->execute();
								while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
								echo "".$row['count(stud_id)']."";
								}
							   ?></span>
						<i class="fas fa-user-tie"></i>
					</div>	
				</a>
				<a href="superadmin-parent" class="box box2">
					<h4>TOTAL <span>No. Of Parents</span></h4>
					<div class="innercont">	
						<span><?php 
								$sql=$this->conn->query("SELECT count(stud_id) FROM student") or die ("failed!");
								$sql->execute();
								while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
								echo "".$row['count(stud_id)']."";
								}
							   ?></span>
						<i class="fas fa-users-cog"></i>
					</div>	
				</a>
				<a href="superadmin-faculty" class="box box3">
					<h4>TOTAL <span>No. Of Teachers</span></h4>
					<div class="innercont">	
						<span><?php 
								$sql=$this->conn->query("SELECT count(fac_id) FROM faculty") or die ("failed!");
								$sql->execute();
								while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
								echo "".$row['count(fac_id)']."";
								}
							   ?></span>
						<i class="fas fa-male"></i>
					</div>	
				</a>
				<a href="superadmin-classes" class="box box4">
					<h4>TOTAL <span>No. Of Classes</span></h4>
					<div class="innercont">	
						<span><?php 
								$sql=$this->conn->query("SELECT count(sec_id) FROM section WHERE fac_idv IS NOT NULL") or die ("failed!");
								$sql->execute();
								while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
								echo "".$row['count(sec_id)']."";
								}
							   ?></span>
						<i class="fas fa-users"></i>
					</div>	
				</a>
			</div>
			<div class="dashboardWidget">
				<div class="contright">
					<div class="header">
						<p>	
							<i class="far fa-calendar-alt fnt"></i>
							<span>Holidays</span>
						</p>
					</div>
					<div class="eventcontent">
						<div class="holidayBox">
							<table id="eventDataTable">
								<thead>
									<tr>
										<th class="tleft title">Upcoming Holidays</th>
									</tr>
									<tr>
										<th class="tleft custPad2">Holiday Title</th>
										<th class="tleft custPad2">Date</th>
									</tr>
								</thead>
								<tbody>
<?php foreach ($obj->showHolidays() as $row) {
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
										<?php $obj->getAnnouncements(); ?>
									</tbody>
								</table>
							</div>
							<div class="eventBox">
								<table id="eventDataTable">
									<thead>
										<tr>
											<th class="tleft title">Events</th>
										</tr>
										<tr>
											<th class="tleft custPad2">Event Title</th>
											<th class="tleft custPad2">Event Date</th>
										</tr>
									</thead>
									<tbody>
<?php foreach ($obj->showEvents() as $row) {
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
		</div>	
	</div>	

