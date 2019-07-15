	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php
		
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->insertFacultyData($fac_no, $fac_fname, $fac_midname, $fac_lname, $fac_dept, $fac_adviser);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			if($obj->updateFacultyData($fac_id, $fac_no, $fac_fname,$fac_midname,$fac_lname,$fac_dept, $fac_adviser, $sec_privilege));
		}
		if(isset($_POST['delete-button'])){
			extract($_POST);
			$obj->deleteFacultyData($acc_idz);
		}
		if(isset($_POST['status-button'])){
			extract($_POST);
			if($obj->updateAccountStatus($acc_id, $acc_status));
		}
		if(isset($_POST['reset-button'])){
			extract($_POST);
			if($obj->resetFacultyPassword($acc_id));
		}
	?>
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
					<div class="cont1">
						<div name="content">
							<button name="opener" class="customButton">Create new account<i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Create new faculty account">
								<form action="admin-faculty" method="POST" autocomplete="off">
									<span>Employee ID:</span>
									<input type="text" name="fac_no" data-validation="length custom required" data-validation-length="max15" data-validation-regexp="^[a-zA-Z0-9\-&ñ ]+$" data-validation-error-msg="Enter less than 15 characters and Alphaneumerics only" value="" maxlength="15" placeholder="Employee ID" required>
									<span>First name:</span>
									<input type="text" name="fac_fname" value="" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-&ñ. ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="First name" maxlength="45" required>
									<span>Middle Name:</span>
									<input type="text" name="fac_midname" value="" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-&ñ. ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Middle name" required>
									<span>Last name:</span>
									<input type="text" name="fac_lname" value="" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-&ñ. ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Last name" required>
									<span>Department</span>
									<!--<select name="fac_dept" value="">
									 uncomment this to use dynamic insertion -->
									<!-- <?php
										/*$department=$obj->department();
										for ($c = 0; $c < sizeof($department); $c++) {
											echo '<option value="'.$department[$c].'">'.$department[$c].'</option>';
										}	*/
									?>
									</select> -->
									<select name="fac_dept" value="" data-validation="required" required>
										<option selected disabled hidden>Select Department</option>
										<option value="Filipino">Filipino</option>
										<option value="Math">Math</option>
										<option value="MAPEH">MAPEH</option>
										<option value="Science">Science</option>
										<option value="AP">AP</option>
										<option value="Math">Math</option>
										<option value="English">English</option>
										<option value="TLE">TLE</option>
										<option value="Values">Values</option>
									</select>
									<span>Adviser</span>
									<select name="fac_adviser" value="" data-validation="required" required>
										<option value="" selected disabled hidden>Adviser</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="cont2">
						<table class="admin-table" class="display">
							<thead>
								<tr>
									<th>Employee ID</th>
									<th>Name</th>
									<th>Department</th>
									<th>Username</th>
									<th>Adviser</th>
									<th>Status</th>
									<th>Can Edit Section</th>
									<th>Action</th>
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
 	<td class="action">
 		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-edit"></i>
					<span class="tooltiptext">edit</span>
				</div>
			</button>
			<div name="dialog" title="Update faculty data">
				<form action="admin-faculty" method="POST" required autocomplete="off">
					<input type="hidden" value="'.$fac_id.'" name="fac_id">
					<span>Employee ID</span>
					<input type="text" name="fac_no" value="'.$fac_no.'" data-validation="length custom required" data-validation-length="max15" data-validation-regexp="^[a-zA-Z0-9\-&ñ ]+$" data-validation-error-msg="Enter less than 15 characters and Alphaneumerics only" placeholder="Employee ID" required>
					<span>First name:</span>
					<input type="text" name="fac_fname" value="'.$fac_fname.'" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-&ñ. ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="First name" required>
					<span>Middle Name:</span>
					<input type="text" name="fac_midname" value="'.$fac_midname.'" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-&ñ. ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Middle name" required>
					<span>Last name:</span>
					<input type="text" name="fac_lname" value="'.$fac_lname.'" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-&ñ. ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Last name" required>
					<span>Department</span>
					<select name="fac_dept" required data-validation="required">
					';
					for ($c = 0; $c < sizeof($department); $c++) {
						echo $fac_dept === $department[$c] ? '<option value="'.$department[$c].'" selected="selected">'.$department[$c].'</option>' : '<option value="'.$department[$c].'">'.$department[$c].'</option>';	
					}
					echo '
					</select>
					<span>Adviser</span>
					<select name="fac_adviser" required data-validation="required">
					';
					for ($c = 0; $c < sizeof($adviser); $c++) {
						echo $fac_adviser === $adviser[$c] ? '<option value="'.$adviser[$c].'" selected="selected">'.$adviser[$c].'</option>' : '<option value="'.$adviser[$c].'">'.$adviser[$c].'</option>';	
					}
					echo '
					</select>
					<span>Can edit section:</span>
					<select name="sec_privilege" value="" >
					';
					
					if($obj->priv() === true) {
						if($sec_privilege=='Yes'){
							echo '<option value="Yes" selected>Yes</option>';
							echo '<option value="No">No</option>';
						}else{
							echo '<option value="No" selected>No</option>';
						}
					}else{
						if($sec_privilege=='No'){
							echo '<option value="Yes">Yes</option>';
							echo '<option value="No" selected>No</option>';
						}
					}
					echo '
					</select>
					<button name="update-button" class="customButton">Update <i class="fas fa-save fnt"></i></button>
				</form>
			</div>  
		</div>
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-trash-alt"></i>
					<span class="tooltiptext">delete</span>
				</div>
			</button>
			<div name="dialog" title="Delete faculty account">
				<form action="admin-faculty" method="POST" required>
					<p>Are you sure you want to delete this account?</p>
					<input type="hidden" value="'.$acc_idz.'" name="acc_idz">
					<button name="delete-button" class="customButton">Yes <i class="fas fa-save fnt"></i></button>
				</form>
			</div>  
		</div>
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-exchange-alt"></i>
					<span class="tooltiptext">Status</span>
				</div>
			</button>
			<div name="dialog" title="Change Status">
				<form action="admin-faculty" method="POST" required>
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
				<form action="admin-faculty" method="POST" required>
					<input type="hidden" value="'.$acc_id.'" name="acc_id">
					<p>Are you sure you want to reset the password of this account?</p>
					<button name="reset-button" class="customButton">Reset <i class="fas fa-save fnt"></i></button>
				</form>
			</div>  
		</div>
 	</td>
 </tr> ';
 }
 ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="widget">	
				<div class="header">	
					<p>	<i class="fa fa-user fnt"></i><span>Adviser Class Schedule</span></p>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>	
				<div class="editContent widgetcontent">
					<div class="cont2">
						<div class="table-scroll">
							<div class ="cont fl">
								<span>SECTION: </span>
								<select name="sec_id" id="getCurrentLevel">
									<?php $obj->showSections(); ?>
								</select>
							</div>
							<?php $obj->showTabledSections(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
