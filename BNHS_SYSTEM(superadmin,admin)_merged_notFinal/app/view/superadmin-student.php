	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;
		if(isset($_POST['status-button'])){
			extract($_POST);
			if($obj->updateStudentAccountStatus($acc_id, $acc_status));
		}
		if(isset($_POST['reset-button'])){
			extract($_POST);
			if($obj->resetStudentPassword($acc_id));
		}
	?>
	<div class="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Student List</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent studentContent">
					<div class="cont1">
						
					</div>
					<div class="cont2">
						<table id="superadmin-table-student" class="display">
							<thead>
								<tr>
									<th>LRN No.</th>
									<th>Student Name</th>
									<th>Username</th>
									<th>Gender</th>
									<th>Year Level</th>
									<th>Address</th>
									<th>Birth Day</th>
									<th>Mother's Name</th>
									<th>Father's Name</th>
									<th>Nationality</th>
									<th>Ethnicity</th>
									<th>Blood Type</th>
									<th>Medical Status</th>
									<th>Student Status</th>
									<th>Current Status</th>
									<th>Account Status</th>
								</tr>
							</thead>
							<tbody>
<?php
 foreach($obj->showStudentList() as $value){
 extract($value);
 $status = ['Active','Deactivated'];
 echo '
 <tr>
 	<td class="tleft">'.$stud_lrno.'</td>
	<td class="tleft">'.$first_name.' '.$middle_name.' '.$last_name.'</td>
	<td class="tleft">'.$username.'</td>
	<td class="tleft">'.$gender.'</td>
	<td class="tleft">'.$year_level.'</td>
	<td class="tleft">'.$stud_address.'</td>
	<td class="tleft">'.$stud_bday.'</td>
	<td class="tleft">'.$mother_name.'</td>
	<th class="tleft">'.$father_name.'</th>
	<td class="tleft">'.$nationality.'</td>
	<td class="tleft">'.$ethnicity.'</td>
	<td class="tleft">'.$blood_type.'</td>
	<td class="tleft">'.$medical_stat.'</td>
	<td class="tleft">'.$stud_status.'</td>
	<td class="tleft">'.$curr_stat.'</td>
	<td class="tleft">'.$acc_status.'</td>

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
	</div>
