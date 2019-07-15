<?php require 'app/model/treasurer_func.php'; $run= new TreasurerFunc ?>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Percentage of Paid Students', 'Percentage of Not Paid Students'],
			<?php $run->getData() ?>
			]);

		var options = {'title':'Percentage of Cleared Balance and Not Cleared Balance of Students', 'width':450, 'height':300, 'is3D':true, };

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		chart.draw(data, options);
	}
</script>
<div class="contentpage">
	<div class="row">	
		<div class="widget">	
			<div class="header">	
				<p>	
					<i class="fas fa-th"></i>
					<span> Summary of Payment Transactions </span>
				</p>
				<p>School Year: <?php $run->getSchoolYear(); ?> </p>
			</div>	
			<div class="widgetcontent">
				<div class="box box3">
					<div class="boxheader">
						<h5><i class="fas fa-percent"></i>&nbsp;&nbsp;&nbsp;Student's Balance Status</h5>
					</div>
					<div class="boxcontent">
						<div id="piechart"></div>
					</div>
				</div>
				<div class="contRight">
					<div class="box">
						<div class="boxheader">
							<h5><i class="fas fa-percent"></i>&nbsp;&nbsp;&nbsp;Total Payment Collected</h5>
						</div>
						<div class="boxcontent">
							<p><span>as of 
								<?php echo date("F d, Y"); ?>
							</span></p>
							<h4>&#x20B1; <?php $run->getTotalPayment(); ?> </h4>
						</div>
					</div>

					<div class="box box3">
						<div class="boxheader">
							<h5><i class="fas fa-user-check"></i>&nbsp;&nbsp;&nbsp;Number of Fully Paid Students</h5>
						</div>
						<div class="boxcontent">
							<p><?php $run->getNumberOfFullyPaidStudents(); ?></p>
							Total Percentage: <span> <?php $run->getPercentageOfFullyPaidStudents() ?><i class="fas fa-percent"></i></span>
						</div>
					</div>
					<div class="box box4">
						<div class="boxheader">
							<h5><i class="fas fa-user-times"></i>&nbsp;&nbsp;&nbsp;Number of Students with Balance</h5>
						</div>
						<div class="boxcontent">
							<p><p><?php $run->getNumberOfStudentsWBalance(); ?></p></p>
							Total Percentage: <span><?php $run->getPercentageOfStudentsWBalance() ?><i class="fas fa-percent"></i></span>
						</div>
						<p></p>
					</div>
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
									<th class="tleft title">Upcoming Holidays</th>
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
									<?php $run->getAnnouncements(); ?>
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
	</div>	
</div>