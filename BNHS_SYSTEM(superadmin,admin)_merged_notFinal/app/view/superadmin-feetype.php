	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
	<?php
	if(isset($_POST['accept-button'])){
		extract($_POST);
		$obj->acceptRequest();
	}
	if(isset($_POST['reject-button'])){
		extract($_POST);
		$obj->rejectRequest();
	}?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Fee Type</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont2">
						<table id="noFilterTable" class="display">
							<thead>
								<tr>
									<th class="">Fee Type</th>
									<th class="">Total Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($obj->showSingleTable("budget_info") as $value){
									extract($value);
									echo '
									<tr class="tleft">
									<td class="tleft">'.$budget_name.'</td>
									<td align="right">&#8369;'.number_format($total_amount, 2).'</td>
									</tr> ';
								}
								?>

								<tr>
									<td><b>TOTAL AMOUNT:<b></td>
										<td align="right"><font color="green"><b>&#8369;<?php $obj->getTotalTotalAmount(); ?></b></font></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- Admin's Request -->
				<div class="widget">	
					<div class="header">	
						<div class="cont">	
							<i class="fas fa-bell"></i>
							<span>Admin Request</span>
						</div>
						<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
					</div>
					<div class="widgetContent feeTypeContent">
						<div class="cont2">
							<form action="superadmin-feetype" method="POST" required autocomplete="off">
								<table id="superadmin_feeType_request" class="display">
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
											<td class="tleft custPad">'.$currentAdm.'</td>
											<td class="tleft custPad">'.$request_type.'</td>
											<td class="tleft custPad">'.$request_desc.'</td></tr>';
										}
										?>
									</tbody>
								</table>
								<p class="tleft">
									<button name="accept-button" class="customButton" >Accept <i class="fas fa-check"></i></button>
									<button name="reject-button" class="customButton" >Reject <i class="fas fa-trash"></i></button>
								</p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>