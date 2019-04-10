	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php
		
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->insertPTAData($pr_fname, $pr_midname, $pr_lname, $pr_address);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			if($obj->updatePTAData($pr_id, $pr_fname, $pr_midname, $pr_lname, $pr_address));
		}
		if(isset($_POST['delete-button'])){
			extract($_POST);
			$obj->deletePTAData($acc_idx);
		}
		
	?>
	<div class="contentpage">
		<div class="row">
			<div class="widget widgetParent">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>PTA Treasurer List</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent ptaContent">
					<div name="content">
						<button name="opener" class="customButton">Add PTA<i class="fas fa-plus fnt"></i></button>
						<div name="dialog" title="Add a new PTA Treasurer">
							<form action="admin-parent" method="POST">
								<span>First name:</span>
								<input type="text" name="pr_fname" value="" placeholder="First name" required>
								<span>Middle Name:</span>
								<input type="text" name="pr_midname" value="" placeholder="Middle name" required>
								<span>Last name:</span>
								<input type="text" name="pr_lname" value="" placeholder="Last name" required>
								<span>Address:</span>
								<input type="text" name="pr_address" value="" placeholder="Address" required>
								<!-- <span>Student Name:</span>
								<select name="stude_id" id="" required>
									<option value="" selected disabled hidden>Choose Student</option>
									<?php 
										//$obj->studentList();
									?>
								</select> -->
								<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
							</form>
						</div>
					</div>
					<table id="ptaTable" class="display">
						<thead>
							<tr>
								<th>PTA Treasurer</th>
								<th>Address</th>
								<th>Username</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
<?php 
foreach ($obj->showTreasurerList() as $value) {
extract($value);
/*$studentId = $obj->studentId();
$studentName = $obj->studentName();*/
echo '
	<tr>
		<td>'.$pr_fname.' '.$pr_midname.' '.$pr_lname.'</td>
		<td>'.$pr_address.'</td>
		<td>'.$username.'</td>
		<td class="action">
			<div name="content">
				<button name="opener">
					<div class="tooltip">
						<i class="fas fa-edit"></i>
						<span class="tooltiptext">edit</span>
					</div>
				</button>
				<div name="dialog" title="Update PTA Treasurer data">
					<form action="admin-parent" method="POST" required>
						<input type="hidden" value="'.$pr_id.'" name="pr_id">
						<span>First name:</span>
						<input type="text" name="pr_fname" value="'.$pr_fname.'" placeholder="First name" required>
						<span>Middle Name:</span>
						<input type="text" name="pr_midname" value="'.$pr_midname.'" placeholder="Middle name" required>
						<span>Last name:</span>
						<input type="text" name="pr_lname" value="'.$pr_lname.'" placeholder="Last name" required>
						<span>Address:</span>
						<input type="text" name="pr_address" value="'.$pr_address.'" placeholder="Last name" required>
						
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
				<div name="dialog" title="Delete PTA Treasurer account">
					<form action="admin-parent" method="POST">
						<p>Are you sure you want to delete this account?</p>
						<input type="hidden" value="'.$acc_idx.'" name="acc_idx">
						<button name="delete-button" class="customButton">Yes <i class="fas fa-save fnt"></i></button>
					</form>
				</div>  
			</div>
		</td>
	</tr>
';
}
?>
<!-- <span>Student Name</span>
<select name="stude_id">
';
for ($c = 0; $c < sizeof($studentId); $c++) {
		if($stud_id==$studentId[$c]){
			echo '<option value="'.$studentId[$c].'" selected>';
		}else{
			echo '<option value="'.$studentId[$c].'"">';
		}	
		echo ''.$studentName[$c].'</option>';
	}
echo '
</select>-->				
						</tbody>
					</table> 
				</div>
			</div>
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Parent List</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent parentContent">
					<table id="admin-table" class="display">
						<thead>
							<tr>
								<th>Parent Name</th>
								<th>Username</th>
								<th>Guardian Mobile Number</th>
								<th>Parent Address</th>
								<th>Student Name</th>
							</tr>
						</thead>
						<tbody>
<?php foreach ($obj->showParentList() as $value) {
extract($value);
echo '
<tr>
	<td>'.$pr_fname.' '.$pr_midname.' '.$pr_lname.'</td>
	<td>'.$username.'</td>
	<td>'.$guar_mobno.'</td>
	<td>'.$pr_address.'</td>
	<td>'.$first_name.' '.$last_name.'</td>
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