	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p>	
						<i class="fas fa-money-bill fnt"></i>
						<span>Tuition Fee</span>
					</p>
					<p>School Year: 2019-2020</p>
				</div>	
				<div class="widgetContent">
					<div class="cont1">
						<p>Miscellaneous Fee: <span>P1,993.00</span></p>
					</div>
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>LRN (Learner's Reference No.)</th>
									<th>Name</th>
									<th>Grade Level</th>
									<th>Amount Paid</th>
									<th>OR Number</th>
									<th>Payment Date</th>
									<!-- <th>Paymet Time </th> -->
									<th>Balance</th>
									<th>Balance Status</th>
								</tr>
							</thead>
							<tbody>

<?php
 foreach($obj->showThreeTables("student","payment", "balance", "stud_id", "pay_id", "bal_id") as $value){
 extract($value);
 echo <<<show
 <tr>
	 <td>$stud_lrno</td>
	 <td>$first_name $middle_name. $last_name</td>
	 <td>$year_level</td>
	 <td>$pay_amt</td>
	 <td>$orno</td>
 	 <td>$pay_date</td>
 	 <td>$bal_amt</td>
 	 <td>$bal_status</td>
 </tr>
show;
 }
 ?>	
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>	
	</div>