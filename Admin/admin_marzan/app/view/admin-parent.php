	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php
		
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->insertPTAData($pr_fname, $pr_midname, $pr_lname, $pr_address, $stude_id);
		}
		/*if(isset($_POST['update-button'])){
			extract($_POST);
			if($obj->updateFacultyData($fac_id, $fac_no, $fac_fname,$fac_midname,$fac_lname,$fac_dept, $fac_adviser));
		}
		if(isset($_POST['delete-button'])){
			extract($_POST);
			$obj->deleteFacultyData($acc_idz);
		}
		if(isset($_POST['status-button'])){
			extract($_POST);
			if($obj->updateAccountStatus($acc_id, $acc_status));
		}*/
	?>
	<div class="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Parent List</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent parentContent">
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
								<span>Student Name:</span>
								<select name="stude_id" id="" required>
									<option value="" selected disabled hidden>Choose Student</option>
									<?php 
										$obj->studentList();
									?>
								</select>
								<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
							</form>
						</div>
					</div>
					<!-- <table class="customTable">
						<tr>
							<th>s</th>
							<th>s</th>
							<th>s</th>
						</tr>
						<tr>
							<td>a</td>
							<td>a</td>
							<td>s</td>
						</tr>
						<tr>
							<td>d</td>
							<td>d</td>
							<td>x</td>
						</tr>
					</table> -->
					<table id="admin-table" class="display">
						<thead>
							<tr>
								<th>Parent Name</th>
								<th>Guardian Mobile Number</th>
								<th>Parent Address</th>
								<th>Student Name</th>
							</tr>
						</thead>
						<tbody>
<?php foreach ($obj->showTwoTables("parent", "student", "stude_id", "stud_id") as $value) {
extract($value);
echo <<<show
<tr>
	<td>$pr_fname $pr_midname $pr_lname</td>
	<td>$guar_mobno</td>
	<td>$pr_address</td>
	<td>$first_name $last_name</td>
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