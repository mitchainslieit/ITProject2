<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php 
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();	
	?>
	<div class="contentpage">
		<div class="row">	
			<div class="summary">
				<div class="box box1">
					<a href="admin-enrolledstudents"><h4>TOTAL <span>No. Of Enrolled Students</span></h4></a>
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
				</div>
				<div class="box box2">
					<a href="admin-parent"><h4>TOTAL <span>No. Of Parents</span></h4></a>
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
				</div>
				<div class="box box3">
					<a href="admin-faculty"><h4>TOTAL <span>No. Of Teachers</span></h4></a>
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
				</div>
				<div class="box box4">
					<a href="admin-classes"><h4>TOTAL <span>No. Of Classes</span></h4></a>
					<div class="innercont">	
						<span><?php 
								$sql=$this->conn->query("SELECT count(sec_id) FROM section") or die ("failed!");
								$sql->execute();
								while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
								echo "".$row['count(sec_id)']."";
								}
							   ?></span>
						<i class="fas fa-users"></i>
					</div>	
				</div>
			</div>
			<div class="dashboardWidget">
				<div class="contright">
					<div class="header">
						<p>	
							<i class="far fa-calendar-alt fnt"></i>
							<span>Calendar</span>
						</p>
					</div>
					<div class="eventcontent">
						<div id="calendarAdmin"></div>
						<div id="eventDialog" title="Event Details" style="display:none;">
							<form action="">
								Start Date: <span id="startDate"></span><br>
								End Date: <span id="endDate"></span><br><br>
								<span>Title:</span>
								<p id="eventInfo"></p>
								<input type="text" id="title" name="" value="" placeholder="Title" required>
								<button type="submit" class="customButtom">Save changes</button>
							</form>
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
	<td class="tleft custPad2">'.$title.'</td>
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

