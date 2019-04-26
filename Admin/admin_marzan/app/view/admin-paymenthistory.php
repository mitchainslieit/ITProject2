	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php
	if (isset($_POST['update-button'])){
			extract($_POST);
		}

	?>
	<?php 
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();	
	?>
	<?php $yr_level = !isset($_SESSION['year_level']) ? 'All' : $_SESSION['year_level']; ?>
	<script type="text/javascript">
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawBasic);

	function drawBasic() {

		var data = google.visualization.arrayToDataTable([
			['Budget Name', 'Total Collected Payment'],
			<?php $obj->getStatistics($yr_level); ?>
			]);

		var options = {
			<?php
			if($yr_level === "All") {
				echo 'title: "Payment Collected per Grade Level"';
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
				title: 'Grade Level'
			}
		};

		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

		chart.draw(data, options);
	}

</script>

	<div class="contentpage" id="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p>	
						<i class="fas fa-money-bill fnt"></i>
						<span>Student's Payment Transactions</span>
					</p>
					<p>School Year: 2019-2020</p>
				</div>	
				<div class="widgetContent payHistoryContent">
					<p>Miscellaneous Fee: &#x20B1; <?php $obj->getMiscFee(); ?></p>
					<div class="cont1">
						<div class="box box1">
							<p>Grade Level and Section:</p>
							<select name="gradeAndsection" id="gradeAndsection" class="year_level_payhist">
								<option value="">All</option>
								<?php $obj->getGradeAndSection(); ?>
							</select>
						</div>
					</div>
					<div class="cont2">
						<table id="admin-table-payhist" class="display">
							<thead>
								<tr>
									<th class="tleft custPad2">LRN</th>
									<th class="tleft custPad2">Name</th>
									<th class="tleft custPad2">Grade Level</th>
									<th class="tleft custPad2">Section Name</th>
									<th class="tleft custPad2">OR Number</th>
									<th class="tleft custPad2">Latest Payment Timestamp</th>
									<th class="tright">Amount Paid</th>
									<th class="tleft custPad2">Payment History</th>
									<th class="tleft custPad2">section</th>
								</tr>
							</thead>
							<tbody>

<?php
 foreach($obj->showPaymentHistory('bal_id','stud_lrno', 'first_name', 'middle_name', 'last_name', 'year_level', 'sec_name', 'orno', 'pay_date', 'pay_amt') as $value){
 extract($value);
 echo '
 <tr>
	 <td class="tleft custPad2">'.$stud_lrno.'</td>
	 <td class="tleft custPad2">'.$Name.'</td>	
	 <td class="tleft custPad2">'.$year_level.'</td>
	 <td class="tleft custPad2">'.$sec_name.'</td>
	 <td class="tleft custPad2">'.$orno.'</td>
 	 <td class="tleft custPad2">'.$payment_date.'</td>
 	 <input type="hidden" value="'.$bal_id.'" /> 
	 <td align="right">'.number_format($pay_amount, 2).'</td>
	 <td class="action tleft">
 		<div name="content">
			 <button name="opener2">
				<div class="tooltip">
					<i class="fas fa-eye"></i>
					<span class="tooltiptext">view</span>
				</div>
			</button>
			<div name="dialog2" title="History of Payments">
				<div class="cont2">
					<table id="historyDataTable" class="display">
						<thead>
							<tr>
								<th align="center">Amount Paid</th>
								<th align="tleft custpad2">OR Number</th>
								<th align="tleft custpad2">Previous Payment Timestamp</th>
							</tr>
						</thead>
						<tbody>';
						$sql=$this->conn->prepare("SELECT pm.pay_amt, pm.orno, DATE_FORMAT(MAX(pm.pay_date), '%M %e, %Y - %H:%i:%S') AS 'payment_date' FROM balance bal
						 JOIN balpay bp ON bp.bal_ida = bal.bal_id
						 JOIN payment pm ON pm.pay_id = bp.pay_ida
						 JOIN student st ON st.stud_id = bal.stud_idb
						 JOIN budget_info bi ON pm.budg_ida = bi.budget_id
						 WHERE bal_id = :bal_id GROUP BY pay_id") or die("failed!");
						$sql->execute(array(':bal_id' => $bal_id));		
						while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
							echo'
								<tr>
									 <td align="right">'.number_format($row['pay_amt'], 2).'</td>
									 <td align="tleft custPad2">'.$row['orno'].'</td>
									 <td align="tleft custPad2">'.$row['payment_date'].'</td>
								</tr>
							';
						}
					echo'
						</tbody>
					</table>	
				</div>				
			</div>
		</div>
	 </td>
	 <td>'.str_replace(' ', '', strtolower(('Grade'.$year_level.'-'.$sec_name))).'</td>
 </tr> ';
 }
 ?>	
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>	
	</div>

	<div class="contentpage" id="contentpage">	
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<p>	
						<i class="fas fa-signal fnt"></i>
						<span>Total Payment Statistics</span>
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
	</div>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<?php if(isset($_SESSION['year_level'])) unset($_SESSION['year_level']); ?>