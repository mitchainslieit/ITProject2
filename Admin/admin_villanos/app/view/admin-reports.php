	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Reports</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<div name="content">
							<span>Select Grade Level: </span>
								<select name="year_level" value="">
									<option value="7">Grade 7</option>
									<option value="8">Grade 8</option>
									<option value="9">Grade 9</option>
									<option value="10">Grade 10</option>
								</select>
							<span>Select Class Section: </span>
								<select name="sec_name" value="">
									<option value="Makulot">Makulot</option>
									<option value="Independent">Independent</option>
								</select>
							<span>Select Balance Status: </span>
								<select name="bal_status" value="">
									<option value="Cleared">Cleared</option>
									<option value="Not Cleared">Not Cleared</option>
								</select>
							<span>Select School Year: </span>
								<select name="school_year" value="">
									<option value="2018-2019">2018-2019</option>
								</select>
						</div>
					</div>
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>School Year</th>
									<th>Name</th>
									<th>Grade Level</th>
									<th>Section</th>
									<th>Amount Paid</th>
									<th>Balance</th>
									<th>Balance Status</th>
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