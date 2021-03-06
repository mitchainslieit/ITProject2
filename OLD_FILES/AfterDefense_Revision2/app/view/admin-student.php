	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;
		if(isset($_POST['status-button'])){
			extract($_POST);
			if($obj->updateStudentAccountStatus($acc_id, $acc_status));
		}
		if(isset($_POST['reset-button'])){
			extract($_POST);
			if($obj->resetStudentPassword($acc_id));
		}
		if(isset($_POST['reset-all-button'])){
			extract($_POST);
			$obj->multipleResetStudent();
		}
		if(isset($_POST['deactive-button'])){
			extract($_POST);
			$obj->deactiveStudent();
		}
		if(isset($_POST['active-button'])){
			extract($_POST);
			$obj->activeStudent();
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
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent studentContent">
					<div class="cont1">
						<div class="box box1">
							<p>Grade Level and Section:</p>
							<select name="gradeAndsection" id="gradeAndsection" class="year_level_balstatus1">
								<option value="">All</option>
								<?php $obj->getGradeAndSection2(); ?>
							</select>
						</div>
					</div>
					<div class="cont2">
						<form action="admin-student" method="POST" id="form1"></form>
						<table id="admin-table-student" class="display" width="100%">
							<thead>
								<tr>
									<th><span class="selectAll">Select All</span><input type="checkbox" id="checkAl" class="selectAllCheck" form="form1"> </th>
									<th>LRN No.</th>
									<th>Student Name</th>
									<th>Username</th>
									<th>Gender</th>
									<th>Grade Level and Section</th>
									<th>Address</th>
									<th>Birth Date</th>
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
 	<td><input type="checkbox" id="checkItem" name="check[]" value="'.$accc_id.'" form="form1"></td>
 	<td class="tleft">'.$stud_lrno.'</td>
	<td class="tleft">'.$first_name.' '.$middle_name.' '.$last_name.'</td>
	<td class="tleft">'.$username.'</td>
	<td class="tleft">'.$gender.'</td>
	<td class="tleft">Grade '.$year_level.' - '.$sec_name.'</td>
	<td class="tleft">'.$stud_address.'</td>
	<td class="tleft">'.$stud_bday.'</td>
	<td class="tleft">'.$mother_name.'</td>
	<td class="tleft">'.$father_name.'</td>
	<td class="tleft">'.$nationality.'</td>
	<td class="tleft">'.$ethnicity.'</td>
	<td class="tleft">'.$blood_type.'</td>
	<td class="tleft">'.$medical_stat.'</td>
	<td class="">'.$stud_status.'</td>
	<td class="tleft">';
		if($curr_stat == 'New'){
			echo 'Transferee';
		}else{
			echo 'Old';
		}
	echo'</td>
	<td class="tleft">';
	echo $acc_status=='Active' ? '<span class="accActive">Active</span>' : '<span class="accDeactive">Deactivated</span>';
	echo'</td>
	<td class="action">
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-exchange-alt"></i>
					<span class="tooltiptext">Status</span>
				</div>
			</button>
			<div name="dialog" title="Change Status">
				<form action="admin-student" method="POST" required class="validateChangesInForm">
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
						<p class="tleft buttonContainer"><button type="submit" form="form1" name="reset-all-button" class="customButton">Reset <i class="fas fa-retweet"></i></button><button type="submit" form="form1" name="deactive-button" class="customButton">Deactivate <i class="fas fa-exchange-alt"></i></button><button type="submit" form="form1" name="active-button" class="customButton">Activate <i class="fas fa-exchange-alt"></i></button></p>
					</div>
				</div>
			</div>
		</div>
	</div>
