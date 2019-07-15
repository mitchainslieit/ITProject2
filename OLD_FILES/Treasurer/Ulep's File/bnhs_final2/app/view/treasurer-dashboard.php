<?php require 'app/model/treasurer_func.php'; $run= new TreasurerFunc ?>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Percentage of Paid Students', 'Percentage of Not Paid Students'],
  <?php $run->getData() ?>
]);

  var options = {'title':'Percentage of Cleared Balance and Not Cleared Balance of Students', 'width':350, 'height':200, 'is3D':true, };

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
						<!-- <span>Total Number of Students: <?php $run->getTotalNoOfStudents(); ?></span> -->
					</p>
					<p>School Year: <?php $run->getSchoolYear(); ?> </p>
				</div>	
				<div class="widgetcontent">
					<div class="box box1">
						<div class="boxheader">
							<h5><i class="fas fa-percent"></i>&nbsp;&nbsp;&nbsp;Student's Balance Status</h5>
						</div>
						<div class="boxcontent">
							<div id="piechart"></div>
						</div>
					</div>

					<div class="box box1">
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
							<h4>Total Percentage: <span> <?php $run->getPercentageOfFullyPaidStudents() ?><i class="fas fa-percent"></i></span></h4>
						</div>
					</div>
					<div class="box box4">
						<div class="boxheader">
							<h5><i class="fas fa-user-times"></i>&nbsp;&nbsp;&nbsp;Number of Students with Balance</h5>
						</div>
						<div class="boxcontent">
							<p><p><?php $run->getNumberOfStudentsWBalance(); ?></p></p>
							<h4>Total Percentage: <span><?php $run->getPercentageOfStudentsWBalance() ?><i class="fas fa-percent"></i></span></h4>
						</div>
						<p></p>
					</div>
				</div>
			</div>	
			<div class="dashboardWidget widget">
				<div class="container contleft">
					<div class="header">
						<p>	
							<i class="far fa-calendar-alt fnt"></i>
							<span>Activities</span>
						</p>
					</div>
					<div class="eventcontent">
						<div class="cont4">
						 <div id="calendar">
						 </div>
						</div>
					</div>
				</div>
				<div class="container contright">
					<div class="innercont1">
						<div class="header">
							<p>	
								<i class="far fa-calendar-alt fnt"></i>
								<span>Announcements</span>
							</p>
						</div>
						<div class="eventcontent">
							<div class='table-wrap'>	
									<table>
										<tr>
											<th>Date</th>
											<th>Event</th>   
										</tr>
							<?php $run->getAnnouncements(); ?>
								</table>
								</div>
						</div>
					</div>
				</div>
			</div>	
		</div>	
	</div>