	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;
	if(isset($_POST['status-button'])){
			extract($_POST);
			if($obj->updateStudentAccountStatus($acc_id, $acc_status));
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
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent studentContent">
					<div class="cont1">
						
					</div>
					<div class="cont2">
						<table id="admin-table-withScroll" class="display">
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
									<th>Student Acct Status</th>
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
 	<td>'.$stud_lrno.'</td>
	<td>'.$first_name.' '.$middle_name.' '.$last_name.'</td>
	<td>'.$username.'</td>
	<td>'.$gender.'</td>
	<td>'.$year_level.'</td>
	<td>'.$stud_address.'</td>
	<td>'.$stud_bday.'</td>
	<td>'.$mother_name.'</td>
	<th>'.$father_name.'</th>
	<td>'.$nationality.'</td>
	<td>'.$ethnicity.'</td>
	<td>'.$blood_type.'</td>
	<td>'.$medical_stat.'</td>
	<td>'.$stud_status.'</td>
	<td>'.$curr_stat.'</td>
	<td>'.$acc_status.'</td>
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
