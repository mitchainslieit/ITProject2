	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<div class="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Student List</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent studentContent">
					<div class="cont1">
						
					</div>
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>LRN No.</th>
									<th>Student Name</th>
									<th>Username</th>
									<th>Gender</th>
									<th>Year Level</th>
									<th>Address</th>
									<th>Birth Day</th>
									<th>Nationality</th>
									<th>Religion</th>
									<th>Guardian Name</th>
									<th>Guardian Mobile No.</th>
									<th>Student Acct Status</th>
									<th>Current Status</th>
								</tr>
							</thead>
							<tbody>
<?php
 foreach($obj->showStudentList() as $value){
 extract($value);
 echo <<<show
 <tr>
 	<td>$stud_lrno</td>
	<td>$first_name $middle_name. $last_name</td>
	<td>$username</td>
	<td>$gender</td>
	<td>$year_level</td>
	<td>$stud_address</td>
	<td>$stud_bday</td>
	<td>$nationality</td>
	<td>$ethnicity</td>
	<td>$guar_name</td>
	<td>$guar_mobno</td>
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
