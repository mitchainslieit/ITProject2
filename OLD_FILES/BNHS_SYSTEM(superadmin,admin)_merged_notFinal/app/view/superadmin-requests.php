	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct(); ?>
	<?php 
	if(isset($_POST['submit-button'])){
		extract($_POST);
		$obj->addClass($sec_id, $fac_idv);
	}
	if(isset($_POST['update-button'])){
		extract($_POST);
		$obj->updateClass($sec_id, $fac_idv);
	}
	if(isset($_POST['accept-button'])){
		extract($_POST);
		$obj->acceptRequest();
	}
	if(isset($_POST['reject-button'])){
		extract($_POST);
		$obj->rejectRequest();
	}
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
<!-- 				<div class="header">	
					<div class="cont">	
						<i class="fas fa-bell"></i>
						<span>Admin Request</span>
					</div>
					<p>School Year: <?php// echo date("Y"); ?> - <?php //echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont2">
						<table class="superadmin-request-table" class="display">
							<thead>
								<tr>
									<th><span class="selectAll">Select All </span><input type="checkbox" id="checkAl" class="selectAllCheck" form="form1"> </th>
									<th class="tleft custPad">Name</th>
									<th class="tleft custPad">Request</th>
								</tr>
							</thead>
							<tbody>
<?php //foreach($obj->adminRequests() as $value){
//extract($value);
//$currentAdmin = $obj->currentAdmin();
/*echo '
	<tr>
		<td><input type="checkbox" id="checkItem" name="check[]" value="'.$acc_idz.'" form="form1"></td>
		<td class="tleft custPad">'.$currentAdmin.'</td>
		<td class="tleft custPad">'.$budget_name.'</td>
	</tr>
	';
}*/
?>
							</tbody>
						</table>
					</div>
				</div>
			</div> -->

			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-bell"></i>
						<span>Admin Request</span>
					</div>
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont2">
						<form action="superadmin-requests" method="POST" required autocomplete="off">
							<table class="superadmin-request-table" class="display">
							<thead>
								<tr>
									<th><span class="selectAll">Select All </span><input type="checkbox" id="checkAl" class="selectAllCheck" form="form1"> </th>
									<th class="tleft custPad">Requested by</th>
									<th class="tleft custPad">Request Type</th>
									<th class="tleft custPad">Request Description</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($obj->adminRequests() as $value){
									extract($value);
									$currentAdm = $obj->currentAdmin();
									echo '
									<tr>
									<td>
									<input type="checkbox" id="checkItem" name="check[]" value="'.$request_id.'"></td>
									<td>'.$currentAdm.'</td>
									<td>'.$request_type.'</td>
									<td>'.$request_desc.'</td></tr>';
								}
								?>
							</tbody>
						</table>
							<button name="accept-button" class="customButton" >Accept <i class="fas fa-check"></i></button>
							<button name="reject-button" class="customButton" >Reject <i class="fas fa-trash"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
