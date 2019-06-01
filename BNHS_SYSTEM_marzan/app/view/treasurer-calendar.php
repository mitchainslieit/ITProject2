<?php require 'app/model/treasurer_func.php'; $run = new TreasurerFunc;?>
	<?php 
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();	
	?>
	<div class="contentpage">
		<div class="row">	
			<div class="dashboardWidget">
				<div class="cont2">	
					<div class="header">
						<p>	
							<i class="far fa-calendar-alt fnt"></i>
							<span>Calendar</span>
						</p>
					</div>
					<div class="eventcontent">
						<div id="calendar"></div>
					</div>
				</div>
			</div>
		</div>	
	</div>