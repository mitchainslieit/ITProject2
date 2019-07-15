	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;
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
						<table class="admin-table-withScroll" class="display">
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
									<th>Action</th>
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
	<td class="action">
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-exchange-alt"></i>
					<span class="tooltiptext">Status</span>
				</div>
			</button>
			<div name="dialog" title="Change Status">
				<form action="admin-student" method="POST" required>
					<input type="hidden" value="'.$acc_id.'" name="acc_id">
					<select name="acc_status">
					';
					for ($c = 0; $c < sizeof($status); $c++) {
						echo $acc_status === $status[$c] ? 
						'<option value="'.$status[$c].'" selected="selected">'.$status[$c].'</option>' 
						:
						'<option value="'.$status[$c].'">'.$status[$c].'</option>';	
					}
					echo '
					</select>
					<button name="status-button" class="customButton">Change Status <i class="fas fa-save fnt"></i></button>
				</form>
				
			</div>
		</div>
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-retweet"></i>
					<span class="tooltiptext">Reset</span>
				</div>
			</button>
			<div name="dialog" title="Reset Password">
				<form action="admin-student" method="POST" required>
					<input type="hidden" value="'.$acc_id.'" name="acc_id">
					<p>Are you sure you want to reset the password of this account?</p>
					<button name="reset-button" class="customButton">Reset <i class="fas fa-save fnt"></i></button>
				</form>
			</div>  
		</div>
	</td>
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
