<?php 
require 'app/model/treasurer_func.php'; $run= new TreasurerFunc; 
$year = array();
foreach($run->getPrevBDOFYearOnly() as $row){
	$year[] = $row['bd_prevsy'];
}
?>
<?php
	$c = 0;
	echo '<script type="text/javascript">';
	echo 'google.charts.load("current", {packages:["corechart"]});';
	foreach($year as $yearPrev) {
		echo 'google.charts.setOnLoadCallback(drawChart'.$c.');';
		echo 'function drawChart'.$c.'() {';
		echo 'var data = google.visualization.arrayToDataTable([
			["Budget Name", "Total Collected Payment", { role: "style" } ],
			'.$run->getPrevBDOFYear($yearPrev).'
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

		echo 'var options = {
			title: "Payment Collected per Breakdown for '.$yearPrev.'",
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

<?php
	$this->conn = new Connection;
	$this->conn = $this->conn->connect();
?>

<div class="contentpage">
	<div class="row">	
		<div class="widget">	
			<div class="header">	
				<p>	
					<i class="fas fa-user-plus fnt"></i>
					<span>History of Breakdown of Fees</span>
				</p>
				<p>School Year: <?php $run->getSchoolYear(); ?></p>
			</div>	
			<div class="eventcontent statementContent">
				<div class="cont1">
					<!-- <p>Miscellaneous Fee: <span>&#x20B1; <?php $run->getPrevMiscFee(); ?></span></p> -->
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<p>Previous School Year: </p> &nbsp;
						<select name="year" class="year">
							<?php
							foreach($run->getBDOFYear() as $row){
								extract($row);
								echo '<option value='.$row['bd_prevsy'].'>'.$row['bd_prevsy'].'</option>';
							}
							?>
						</select>
					</div>
					<div class="cont1" id="unique">
					<p id="unique1">Total Collected Amount:<span id="unique2"> <?php $run->getTotalBDOFAmount(); ?></span></p>
					</div>
					<div class="cont2 treasurer-table-2-class">
						<table id="treasurer-table-5" class="display">
							<thead>	
								<tr>
									<th>Fee Name</th>
									<th> Amount Allocated </th>
									<th> Total Collected Amount </th>
									<th> year </th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($run->getPrevBDOF() as $row){
									extract($row);
									echo '
									<tr>
										<td>'.$bd_name.'</td>
										<td align="right"> &#x20B1;'.number_format($bd_amountalloc,2).'</td>
										<td align="right"> &#x20B1;'.number_format($bd_accamount,2).'</td>
										<td>'.$bd_prevsy.'</td>
</tr>
';
}
?>
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
			<div class="eventcontent charts-container" id="add-charts-cont">
				<div class="cont2">
					<?php
						$c = 0;
						foreach($year as $yr) {
							echo '<div id="chart_'.$c.'"></div>';
							$c++;
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
