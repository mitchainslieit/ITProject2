	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
	<?php
	if (isset($_POST['submit-button'])){
		extract($_POST);
		if($obj->addFeeType($bd_name, $tot_amt));
	}
	if (isset($_POST['update-button'])){
		extract($_POST);
		if($obj->updateFeeType($bd_id, $bd_name, $tot_amt));
	}
	if (isset($_POST['delete-button'])){
		extract($_POST);
		if($obj->deleteFeeType($bd_id, "budget_info"));
	}
	if(isset($_POST['delete-all-button'])){
		extract($_POST);
		$obj->multipleDeleteFee();
	}
	if(isset($_POST['accept-button'])){
		extract($_POST);
		$obj->acceptRequest();
	}
	if(isset($_POST['reject-button'])){
		extract($_POST);
		$obj->rejectRequest();
	}?>
	<?php
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Fee Type</span>
					</div>
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent feeTypeContent">
					<div class="cont1">
						<div name="content">
							<button name="opener" class="customButton">Add Fee Type<i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Create new Fee type">
								<form action="superadmin-feetype" id="" method="POST" required autocomplete="off">
									<span>Fee Type:</span>
									<input type="text" name="bd_name" value="" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Fee Type" required>
									<span>Total Amount:</span>
									<input type="text" name="tot_amt" data-validation="number" data-validation-error-msg="Input numbers only" value="" placeholder="Total Amount" required>
									<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="cont2">
						<form action="superadmin-feetype" method="POST" id="form1"></form>
						<form action="superadmin-feetype" method="POST" id="form2"></form>
						<table id="noFilterTable" class="display">
							<thead>
								<tr>
									<th><span class="selectAll">Select All</span><input type="checkbox" id="checkAl1" class="selectAllCheck" form="form1"> </th>
									<th>Fee Type</th>
									<th>Total Amount</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
<?php
$queryCount=$this->conn->prepare("SELECT * FROM request join budget_info_temp on request_id=bd_request WHERE request_status='Temporary'");
$queryCount->execute();
$rowQueryCount=$queryCount->rowCount();
 foreach($obj->showFeeType() as $value){
 extract($value);
 echo '
 <tr>
 	<td><input type="checkbox" class="chkbox1" id="checkItem" name="check[]" value="'.$bd_id.'" form="form1"></td>';
 	echo $request_status == "Temporary" ? '<td class="tleft"><div class="temporaryContainer"><span class="temporary">'.$bd_name.'</span><span class="temporaryDesc">There is a pending request in this fee type!</span></div>' : ' <td class="tleft">'.$bd_name.'</td>';
 	echo $request_status == "Temporary" ? '<td class="tleft"><span class="temporary">'.number_format($tot_amt, 2).'</span>' : ' <td class="tleft">'.number_format($tot_amt, 2).'</td>';
 	echo'
 	<td class="action">
 		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-edit"></i>
					<span class="tooltiptext">edit</span>
				</div>
			</button>
			<div name="dialog" title="Update fee type">
				<form action="superadmin-feetype" method="POST" required autocomplete="off" class="validateChangesInForm">
					<input type="hidden" value="'.$bd_id.'" name="bd_id">
					<span>Fee Type:</span>
					<input type="text"  name="bd_name" value="'.$bd_name.'" data-validation="length custom" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Fee Type" >
					<span>Total Amount:</span>
					<input type="text"  name="tot_amt" data-validation="number" data-validation-error-msg="Input numbers only"  value="'.$tot_amt.'" placeholder="Total Amount" required >
					<button name="update-button" class="customButton" >Update<i class="fas fa-save fnt"></i></button>
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
			<div name="dialog" title="Delete fee type">
				<form action="superadmin-feetype" method="POST">
					<p>Are you sure you want to delete this fee type?</p>
					<input type="hidden" value="'.$bd_id.'" name="bd_id">
					<button name="delete-button" class="customButton">Yes <i class="fas fa-save fnt" > </i></button>
				</form>
			</div>  
		</div>
 	</td>
 </tr> ';
}

echo'
<tr>
	<td></td>
	<td><b>TOTAL AMOUNT:<b></td>';
	if($rowQueryCount > 0){
		echo'<td align="right"><div class="temporaryContainer"><span class="temporary">';$obj->getTotalTotalAmount(); echo'</span><span class="temporaryDesc">The total amount is not yet final.</span></td>' ;
	}else{
		echo '<td align="right"><font color="green"><b>&#8369'; $obj->getTotalTotalAmount(); echo'</b></font></td>';
	}

?>
<td></td>
</tr>
							</tbody>
						</table>
						<p class="tleft"><button type="submit" form="form1" name="delete-all-button" class="customButton">Delete <i class="fas fa-trash-alt"></i></button></p>
					</div>
				</div>
			</div>
				<!-- Admin's Request -->

			<div class="widget FeeTypeWidgetHide hidden">	
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
										<th class="tleft">Requested by</th>
										<th class="tleft">Request Type</th>
										<th class="tleft">Request Description</th>
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
										<td class="tleft custPad2">'.$currentAdm.'</td>
										<td class="tleft custPad2">';
										echo $request_type == 'Insert' ? 'Add' : $request_type;
										echo '</td>
										<td class="tleft custPad2">'.$request_desc.'</td></tr>';
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