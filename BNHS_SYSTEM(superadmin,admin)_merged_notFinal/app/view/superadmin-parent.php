	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
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
		if(isset($_POST['reset-button1'])){
			extract($_POST);
			if($obj->resetPTAPassword($acc_id));
		}
		if(isset($_POST['reset-button2'])){
			extract($_POST);
			if($obj->resetParentPassword($acc_id));
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
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent ptaContent">
					<table id="ptaTable" class="display" width="100%">
						<thead>
							<tr>
								<th class="tleft">PTA Treasurer</th>
								<th class="tleft">Username</th>
								<th class="tleft">Account Status</th>
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
		<td class="tleft">'.$tr_fname.' '.$tr_midname.' '.$tr_lname.'</td>
		<td class="tleft">'.$username.'</td>
		<td class="tleft">'.$acc_status.'</td>
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
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent parentContent">
					<table id="superadmin-table-all" class="display">
						<thead>
							<tr>
								<th class="tleft">Parent Name</th>
								<th class="tleft">Address</th>
								<th class="tleft">Mobile Number</th>
								<th class="tleft">Telephone Number</th>
								<th class="tleft">Child Name</th>
								<th class="tleft">Username</th>
								<th class="tleft">Status</th>
							</tr>
						</thead>
						<tbody>
<?php foreach ($obj->showParentList() as $value) {
extract($value);
$status = ['Active','Deactivated'];
echo '
<tr>
	<td class="tleft ">'.$guar_fname.' '.$guar_midname.' '.$guar_lname.'</td>
	<td class="tleft">'.$guar_address.'</td>
	<td class="tleft">'.$guar_mobno.'</td>
	<td class="tleft">'.$guar_telno.'</td>
	<td class="tleft">'.$first_name.' '.$last_name.'</td>
	<td class="tleft">'.$username.'</td>
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