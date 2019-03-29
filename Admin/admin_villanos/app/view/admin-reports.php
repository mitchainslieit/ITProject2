		<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>List of Paid Students</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>LRN</th>
									<th>Name</th>
									<th>Grade Level</th>
									<th>Section</th>
									<th>Amount Paid</th>
									<th>Remaining Balance</th>
									<th>Balance Status</th>
								</tr>
							</thead>
							<tbody>

<?php
 foreach($obj->showPaidStudents("stud_lrno", "first_name", "middle_name", "last_name", "year_level", "sec_name", "pay_amt", "bal_amt", "bal_status") as $value){
 extract($value);
 echo <<<show
 <tr>
 	 <td>$stud_lrno</td>
	 <td>$Name</td>
	 <td>$year_level</td>
	 <td>$sec_name</td>
	 <td align="right">&#x20B1 $pay_amt</td>
 	 <td align ="right">&#x20B1 $bal_amt</td>
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

	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>List of Unpaid Students</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>LRN</th>
									<th>Name</th>
									<th>Grade Level</th>
									<th>Section</th>
									<th>Amount Paid</th>
									<th>Remaining Balance</th>
									<th>Balance Status</th>
								</tr>
							</thead>
							<tbody>

<?php
 foreach($obj->showUnpaidStudents("stud_lrno", "first_name", "middle_name", "last_name", "year_level", "sec_name", "pay_amt", "bal_amt", "bal_status") as $value){
 extract($value);
 echo <<<show
 <tr>
 	 <td>$stud_lrno</td>
	 <td>$Name</td>
	 <td>$year_level</td>
	 <td>$sec_name</td>
	 <td align="right">&#x20B1 $pay_amt</td>
 	 <td align ="right">&#x20B1 $bal_amt</td>
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

	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>List of Enrolled Students</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>LRN</th>
									<th>Name</th>
									<th>Grade Level</th>
									<th>Section</th>
									<th>Gender</th>
									<th>Ethnicity</th>
									<th>Student Status</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>

<?php
 foreach($obj->showEnrolledStudents("stud_lrno", "first_name", "middle_name", "last_name", "year_level", "sec_name", "gender", "religion", "stud_status", "curr_status") as $value){
 extract($value);
 echo <<<show
 <tr>
 	 <td>$stud_lrno</td>
	 <td>$Name</td>
	 <td>$year_level</td>
	 <td>$sec_name</td>
	 <td>$gender</td>
 	 <td>$religion</td>
 	 <td>$stud_status</td>
 	 <td>$curr_stat</td>
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
