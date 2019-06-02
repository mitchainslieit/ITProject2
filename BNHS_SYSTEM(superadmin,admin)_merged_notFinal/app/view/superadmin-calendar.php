<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
	<?php 
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();	
	?>
	<div class="contentpage">
		<div class="row">	
			<div class=" dashboardWidget calendarWidget">
				<div class="contright">
					<div class="header">
						<p>	
							<i class="far fa-calendar-alt fnt"></i>
							<span>Calendar</span>
						</p>
					</div>
					<div class="eventcontent">
						<div id="calendar"></div>
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
			</div>
		</div>	
	</div>	

