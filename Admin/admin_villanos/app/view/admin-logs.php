	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Miscellaneaous Fee History</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>Employee ID</th>
									<th>Edited By</th>
									<th>Position</th>
									<th>Timestamp</th>
									<th>Old Amount</th>
									<th>Updated Amount</th>
								</tr>
							</thead>
							<tbody>

<?php
 foreach($obj->showFourTables("faculty", "payment", "accounts", "budget_info", "fac_id", "pay_id", "acc_id", "budget_id") as $value){
 extract($value);
 echo <<<show
 <tr>
	 <td>$fac_id</td>
	 <td>$username</td>
	 <td>$acc_type</td>
	 <td>$pay_date</td>
	 <td>$acc_amount</td>
 	 <td>$acc_amount</td>
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

	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Users History</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>Employee ID</th>
									<th>Admin</th>
									<th>Position</th>
									<th>Timestamp</th>
									<th>Name</th>
									<th>Major</th>
									<th>Department</th>
									<th>Status</th>
									<th>Operation</th>
								</tr>
							</thead>
							<tbody>

<?php
 foreach($obj->showFourTables("student","payment", "balance", "section", "stud_id", "pay_id", "bal_id", "sec_id") as $value){
 extract($value);
 echo <<<show
 <tr>
	 <td>$school_year</td>
	 <td>$first_name $middle_name. $last_name</td>
	 <td>$year_level</td>
	 <td>$sec_name</td>
	 <td>$pay_amt</td>
 	 <td>$bal_amt</td>
 	 <td>$bal_amt</td>
 	 <td>$bal_amt</td>
 	 <td>$bal_amt</td>
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