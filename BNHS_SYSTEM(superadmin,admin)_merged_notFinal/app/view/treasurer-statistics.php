<?php 
require 'app/model/treasurer_func.php'; $run= new TreasurerFunc; 
$yr_level = !isset($_SESSION['year_level']) ? 'All' : $_SESSION['year_level'];
?>
<script type="text/javascript">
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawBasic);

	function drawBasic() {

		var data = google.visualization.arrayToDataTable([
			['Budget Name', 'Total Collected Payment'],
			<?php $run->getStatistics($yr_level); ?>
			]);

		var options = {
			<?php
			if($yr_level === "All") {
				echo 'title: "Payment Collected per Breakdown"';
			}
			else {
				echo 'title: "Payment Collected per Breakdown in Grade '.$yr_level.'"';
			}

			?>,
			chartArea: {width: '60%', height: '65%'},
			hAxis: {
				<?php
				if($yr_level === "All") {
					echo
					'   
					title: "Total Payment Collected",
					minValue: 0
					';
				} else {
					echo
					' 
					title: "Total Payment Collected in Grade '.$yr_level.'",
					minValue: 0
					';
				}
				?>
			},
			vAxis: {
				title: 'Budget Name'
			}
		};

		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

		chart.draw(data, options);
	}

</script>
<div class="contentpage">
	<div class="row">
		<div class="widget">	
			<div class="header">	
				<p>	
					<i class="fas fa-dollar-sign"></i>
					<span>Total Amount Collected</span>
				</p>
			</div>	
			<div class="eventcontent statementContent">
				<div class="widgetContent">
					<div class="cont1">
						<p>Grade Level: </p> &nbsp;
						<select name="year_level" class="year_level" id='select-year-level'>
							<option value="All" <?php if(isset($_SESSION['year_level']) && $_SESSION['year_level'] === 'All') echo 'selected'; ?>>All</option>
							<?php
							foreach($run->getYearLevel() as $row) {
								extract($row);
								echo '
								<option value='.$sched_yrlevel.' '.($sched_yrlevel === $_SESSION['year_level'] ? 'selected' : '').'> Grade '.$sched_yrlevel.' </option>
								';
							}
							?>
							
						</select>
					</div>
					<div class="cont2" id ="filter-yr-level">
						<table id="treasurer-table-1" class="display">
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
			<div class="eventcontent">
				<div class="cont2">
					<div id="chart_div">
					</div>
				</div>
			</div>
		</div>
		

	</div>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<?php if(isset($_SESSION['year_level'])) unset($_SESSION['year_level']); ?>


