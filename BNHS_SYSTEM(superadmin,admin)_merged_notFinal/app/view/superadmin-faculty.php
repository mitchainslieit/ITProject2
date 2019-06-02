	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Faculty List</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont2">
						<table id="superadmin-table-all" class="display">
							<thead>
								<tr>
									<th>Employee ID</th>
									<th>Name</th>
									<th>Department</th>
									<th>Username</th>
									<th>Adviser</th>
									<th>Status</th>
									<th>Sectioning Privilege</th>
									<th>Enroll Privilege</th>
								</tr>
							</thead>
							<tbody>
 <?php
 /*$department = $obj->department();*/
 foreach($obj->showTwoTables("faculty","accounts", "acc_idz", "acc_id") as $row){
 extract($row);
 $department = ['Filipino', 'Math', 'MAPEH', 'Science', 'AP', 'Math', 'English', 'TLE', 'Values'];
 $adviser = ['Yes', 'No'];
 $status = ['Active','Deactivated'];
 echo '
 <tr>
 	<td class="tleft custPad2">'.$fac_no.'</td>
 	<td class="tleft custPad2">'.$fac_fname.' '.$fac_midname.' '.$fac_lname.'</td>
 	<td class="tleft custPad2">'.$fac_dept.'</td>
 	<td class="tleft custPad2">'.$username.'</td>
 	<td>'.$fac_adviser.'</td>
 	<td>'.$acc_status.'</td>
 	<td>'.$sec_privilege.'</td>
	<td>'.$enroll_privilege.'</td>
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
	