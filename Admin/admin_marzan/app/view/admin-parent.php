	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php
		
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->insertPTAData($tr_fname, $tr_midname, $tr_lname);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			$obj->updatePTAData($guar_id, $tr_fname, $tr_midname, $tr_lname);
		}
		if(isset($_POST['reset-button'])){
			extract($_POST);
			$obj->updateParentAccount2($guar_id, $guar_fname, $guar_midname, $guar_lname, $guar_address, $guar_mobno, $guar_telno);
		}
		if(isset($_POST['delete-button'])){
			extract($_POST);
			$obj->deletePTAData($acc_idx);
		}
		if(isset($_POST['status-button1'])){
			extract($_POST);
			if($obj->updateParentAccountStatus($acc_id, $acc_status));
		}
		if(isset($_POST['status-button'])){
			extract($_POST);
			if($obj->updatePTAAccountStatus($acc_id, $acc_status));
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
								<input type="text" name="tr_fname" value="" placeholder="First name" required>
								<span>Middle Name:</span>
								<input type="text" name="tr_midname" value="" placeholder="Middle name" required>
								<span>Last name:</span>
								<input type="text" name="tr_lname" value="" placeholder="Last name" required>
								<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
							</form>
						</div>
					</div>
					<table id="ptaTable" class="display">
						<thead>
							<tr>
								<th>PTA Treasurer</th>
								<th>Username</th>
								<th>Account Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
<?php 
foreach ($obj->showTreasurerList() as $value) {
extract($value);
/*$studentId = $obj->studentId();
$studentName = $obj->studentName();*/
$status = ['Active','Deactivated'];
echo '
	<tr>
		<td>'.$tr_fname.' '.$tr_midname.' '.$tr_lname.'</td>
		<td>'.$username.'</td>
		<td>'.$acc_status.'</td>
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
						<input type="hidden" value="'.$tr_id.'" name="guar_id">
						<span>First name:</span>
						<input type="text" name="tr_fname" value="'.$tr_fname.'" placeholder="First name" required>
						<span>Middle Name:</span>
						<input type="text" name="tr_midname" value="'.$tr_midname.'" placeholder="Middle name" required>
						<span>Last name:</span>
						<input type="text" name="tr_lname" value="'.$tr_lname.'" placeholder="Last name" required>
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
						<input type="hidden" value="'.$acc_trid.'" name="acc_idx">
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
					<form action="admin-parent" method="POST" required>
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
					<table id="admin-table-withScroll" class="display">
						<thead>
							<tr>
								<th data-priority="2">Parent Name</th>
								<th>Address</th>
								<th>Mobile Number</th>
								<th>Telephone Number</th>
								<th>Child Name</th>
								<th>Username</th>
								<th>Status</th>
								<th data-priority="1">Action</th>
							</tr>
						</thead>
						<tbody>
<?php foreach ($obj->showParentList() as $value) {
extract($value);
$status = ['Active','Deactivated'];
echo '
<tr>
	<td>'.$guar_fname.' '.$guar_midname.' '.$guar_lname.'</td>
	<td>'.$guar_address.'</td>
	<td>'.$guar_mobno.'</td>
	<td>'.$guar_telno.'</td>
	<td>'.$first_name.' '.$last_name.'</td>
	<td>'.$username.'</td>
	<td>'.$acc_status.'</td>
	<td class="action">
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-retweet"></i>
					<span class="tooltiptext">Reset</span>
				</div>
			</button>
			<div name="dialog" title="Reset Parent Account">
				<form action="admin-parent" method="POST" required>
					<input type="hidden" value="'.$guar_id.'" name="guar_id">
					<span>First name:</span>
					<input type="text" name="guar_fname" value="'.$guar_fname.'" placeholder="First name" required>
					<span>Middle Name:</span>
					<input type="text" name="guar_midname" value="'.$guar_midname.'" placeholder="Middle name" required>
					<span>Last name:</span>
					<input type="text" name="guar_lname" value="'.$guar_lname.'" placeholder="Last name" required>
					<span>Address:</span>
					<input type="text" name="guar_address" value="'.$guar_address.'" placeholder="Last name" required>
					<span>Mobile Number:</span>
					<input type="text" name="guar_mobno" value="'.$guar_mobno.'" placeholder="" >
					<span>Telephone Number:</span>
					<input type="text" name="guar_telno" value="'.$guar_telno.'" placeholder="" >
					<span>Child name:</span>
					<input type="text" name="guar_fname" value="'.$first_name.' '.$last_name.'" placeholder="First name" required disabled>
					<button name="reset-button" class="customButton">Reset <i class="fas fa-save fnt"></i></button>
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
				<form action="admin-parent" method="POST" required>
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
					<button name="status-button1" class="customButton">Change Status <i class="fas fa-save fnt"></i></button>
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