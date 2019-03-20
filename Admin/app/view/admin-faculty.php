	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php
		
		if(isset($_POST['submit-button'])){
			extract($_POST);
			if($obj->insertFacultyData($fac_fname,$fac_midinitial,$fac_lname,$fac_dept, $fac_adviser,"Faculty"));
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			if($obj->updateFacultyData($fac_id, $fac_fname,$fac_midinitial,$fac_lname,$fac_dept, $fac_adviser,"Faculty")){
			}
		}
		if(isset($_POST['delete-button'])){
			extract($_POST);
			if($obj->deleteFacultyData($fac_id, "Faculty"));
		}
		if(isset($_POST['status-button'])){
			extract($_POST);
			if($obj->updateAccountStatus($acc_id, $acc_status, "Accounts"));
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
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<div name="content">
							<button name="opener" class="customButton">Create new account<i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Create new faculty account">
								<form action="admin-faculty" method="POST" required>
									<span>First name:</span>
									<input type="text" name="fac_fname" value="" placeholder="First name" required>
									<span>Middle initial:</span>
									<input type="text" name="fac_midinitial" value="" placeholder="Middle name" required>
									<span>Last name:</span>
									<input type="text" name="fac_lname" value="" placeholder="Last name" required>
									<span>Department</span>
									<select name="fac_dept" value="">
										<option value="Filipino">Filipino</option>
										<option value="Math">Math</option>
										<option value="MAPEH">MAPEH</option>
										<option value="Science">Science</option>
										<option value="AP">AP</option>
										<option value="Math">Math</option>
										<option value="English">English</option>
										<option value="TLE">TLE</option>
										<option value="Math">Math</option>
									</select>
									<span>Adviser</span>
									<select name="fac_adviser" value="">
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>First Name</th>
									<th>Middle Name</th>
									<th>Last Name</th>
									<th>Department</th>
									<th>Username</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
 <?php
 foreach($obj->showTwoTables("faculty","accounts", "acc_idz", "acc_id") as $row){
 extract($row);
 $subjects = ['Filipino', 'Math', 'MAPEH', 'Science', 'AP', 'English', 'TLE'];
 $adviser = ['Yes', 'No'];
 $status = ['Active','Deactivated','Denied'];
 echo '
 <tr>
 	<td>'.$fac_fname.'</td>
 	<td>'.$fac_midinitial.'</td>
 	<td>'.$fac_lname.'</td>
 	<td>'.$fac_dept.'</td>
 	<td>'.$username.'</td>
 	<td>'.$acc_status.'</td>
 	<td class="action">
 	';
 	echo '
 		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-edit"></i>
					<span class="tooltiptext">edit</span>
				</div>
			</button>
			<div name="dialog" title="Update faculty data">
				<form action="admin-faculty" method="POST" required>
					<input type="hidden" value="'.$fac_id.'" name="fac_id">
					<span>First name:</span>
					<input type="text" name="fac_fname" value="'.$fac_fname.'" placeholder="First name" required>
					<span>Middle Name:</span>
					<input type="text" name="fac_midinitial" value="'.$fac_midinitial.'" placeholder="Middle name" required>
					<span>Last name:</span>
					<input type="text" name="fac_lname" value="'.$fac_lname.'" placeholder="Last name" required>
					<span>Department</span>
					<select name="fac_dept">
					';
					for ($c = 0; $c < sizeof($subjects); $c++) {
						echo $fac_dept === $subjects[$c] ? '<option value="'.$subjects[$c].'" selected="selected">'.$subjects[$c].'</option>' : '<option value="'.$subjects[$c].'">'.$subjects[$c].'</option>';	
					}
					echo '
					</select>
					<span>Adviser</span>
					<select name="fac_adviser">
					';
					for ($c = 0; $c < sizeof($adviser); $c++) {
						echo $fac_adviser === $adviser[$c] ? '<option value="'.$adviser[$c].'" selected="selected">'.$adviser[$c].'</option>' : '<option value="'.$adviser[$c].'">'.$adviser[$c].'</option>';	
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
					<input type="hidden" value="'.$fac_id.'" name="fac_id">
					<button name="delete-button" class="customButton">Yes <i class="fas fa-save fnt"></i></button>
				</form>
			</div>  
		</div>
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-exchange-alt"></i>
					<span class="tooltiptext">Change Status</span>
				</div>
			</button>
			<div name="dialog" title="Change Status">
				<form action="admin-faculty" method="POST" required>
					<input type="hidden" value="'.$acc_id.'" name="acc_id">
					<select name="acc_status">
					';
					for ($c = 0; $c < sizeof($status); $c++) {
						echo $acc_status === $status[$c] ? '<option value="'.$status[$c].'" selected="selected">'.$status[$c].'</option>' : '<option value="'.$status[$c].'">'.$status[$c].'</option>';	
					}
					echo '
					</select>
					<button name="status-button" class="customButton">Change Status <i class="fas fa-save fnt"></i></button>
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
		</div>
	</div>
