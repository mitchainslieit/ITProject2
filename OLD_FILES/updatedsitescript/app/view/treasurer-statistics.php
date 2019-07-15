<?php 
require 'app/model/treasurer_func.php'; $run= new TreasurerFunc; 
$year_level = array('All', '7', '8', '9', '10');
?>
<?php
	$c = 0;
	echo '<script type="text/javascript">';
	echo 'google.charts.load("current", {packages:["corechart"]});';
	foreach($year_level as $yr_level) {
		echo 'google.charts.setOnLoadCallback(drawChart'.$c.');';
		echo 'function drawChart'.$c.'() {';
		echo 'var data = google.visualization.arrayToDataTable([
			["Budget Name", "Total Collected Payment", { role: "style" } ],
			'.$run->getStatistics($yr_level).'
		]);';

		echo 'var view = new google.visualization.DataView(data);
		view.setColumns([0, 1,
			{ 
				calc: "stringify",
				sourceColumn: 1,
				type: "string",
				role: "annotation" 
			}, 2
		]);';

		$forLevel = function($yr_lvl) {
			if ($yr_lvl === 'All') {
				return 'All';
			} else {
				return 'Grade '.$yr_lvl;
			}
		};

		echo 'var options = {
			title: "Payment Collected per Breakdown for '.$forLevel($yr_level).'",
			width: "100%",
			height: 400,
			bar: {groupWidth: "75%"},
			legend: { position: "none" },
			hAxis: {   
				title: "Total Payment Collected",
				minValue: 1
			},
			vAxis: {
				title: \'Budget Name\'
			}
		};
		var chart = new google.visualization.BarChart(document.getElementById("chart_'.$c.'"));
		chart.draw(view, options);';
		echo '}';
	$c++;
	}
	echo '</script>';
?>
<div class="contentpage">
	<div class="row">
		<div class="widget">	
			<div class="header">	
				<p>	
					<i class="fas fa-dollar-sign"></i>
					<span>Total Amount Collected</span>
				</p>
				<p>School Year: <?php $run->getSchoolYear(); ?></p>
			</div>	
			<div class="eventcontent statementContent">
				<div class="widgetContent">
					<div class="cont1">
						<p>Grade Level: </p> &nbsp;
						<select name="year_level" class="year_level" id='select-year-level'>
							<option value="All">All</option>
							<?php
							foreach($run->getYearLevel() as $row) {
								extract($row);
								echo '
								<option value="'.$sched_yrlevel.'"> Grade '.$sched_yrlevel.' </option>
								';
							}
							?>
							
						</select>
					</div>
					<div class="cont1">
						<p>Total Amount Collected: <?php $run->getTotalBudgetAmount() ?> </p> &nbsp;
						
					</div>
					<?php foreach($year_level as $yr_level) { ?>
					<div class="cont2" class ="filter-yr-level" data-lvl="<?php echo $yr_level; ?>">
						<table class="treasurer-table-1" class="display">
							<thead>	
								<tr>
									<?php
									$result = count($run->getStats($yr_level)) !== 0 ? $run->getStats($yr_level) : $run->getBudgetName();
									foreach($result as $row) {
										extract($row);
										echo 
										'
										<th> '.$budget_name.' </th>
										';
									}
									?>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php
									$count = count($run->getBudgetName());
									$result = $run->getStats($yr_level);
									foreach($result as $row) {
										extract($row);
										echo 
										'
										<td> &#x20B1;'.number_format($total,2).' </td>
										';
									}
									echo (count($result) === 0 ? '<td colspan="'.$count.'">There are no data yet!</td>' : '');
									?>
								</tr>
							</tbody>
						</table>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>	
		<br>
		<div class="widget">	
			<div class="header">	
				<p>	
					<i class="far fa-chart-bar"></i>
					<span>Statistics</span>
				</p>
			</div>	
			<div class="eventcontent charts-container">
				<div class="cont2">
					<div id="chart_0" data-lvl="All">
					</div>
					<div id="chart_1"  data-lvl="7">
					</div>
					<div id="chart_2"  data-lvl="8">
					</div>
					<div id="chart_3"  data-lvl="9">
					</div>
					<div id="chart_4"  data-lvl="10">
					</div>
				</div>
			</div>
		</div>
	
	</div>
</div>