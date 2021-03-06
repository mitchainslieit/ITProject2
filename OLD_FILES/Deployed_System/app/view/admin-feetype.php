	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
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
		if (isset($_POST['cancel-button'])){
			extract($_POST);
			$obj->cancelFeeType($request_id);
		}
	?>
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
							<?php 
								$queryCheckSystem=$this->conn->query("SELECT * FROM system_settings WHERE sy_status='Current'");
								if($queryCheckSystem->rowCount() > 0){
									echo '
									<div name="dialog" title="Create new Fee type">
										<form action="superadmin-feetype" id="" method="POST" required autocomplete="off">
											<span>Fee Type:</span>
											<input type="text" name="bd_name" value="" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Fee Type" required>
											<span>Total Amount:</span>
											<input type="text" name="tot_amt" data-validation="number" data-validation-error-msg="Input numbers only" value="" placeholder="Total Amount" required>
											<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
										</form>
									</div>
									';
								}else{
									echo'
									<div name="dialog" title="Create new Fee type">
										<form action="superadmin-feetype" id="" method="POST" required autocomplete="off">
											<p>The School Year is not yet started!</p>
										</form>
									</div>
									';
								}
							?>
						</div>
					</div>
					<div class="cont2">
						<form action="admin-feetype" method="POST" id="form1"></form>
						<form action="admin-feetype" method="POST" id="form2"></form>
						<table id="noFilterTable" class="display">
							<thead>
								<tr>
									<th><span class="selectAll">Select All</span><input type="checkbox" id="checkAl" class="selectAllCheck" form="form1"> </th>
									<th>Fee Type</th>
									<th>Total Amount</th>
<?php 
										$queryCount=$this->conn->prepare("SELECT * FROM request join budget_info_temp on request_id=bd_request WHERE request_status='Temporary'");
										$queryCount->execute();
										$rowQueryCount=$queryCount->rowCount();
										echo $rowQueryCount > 0 ? '<th>Request Type</th>' : '';
										echo $rowQueryCount > 0 ? '<th>Request Status</th>' : '';
									echo'
									<th>Action</th>
								</tr>
							</thead>
							<tbody>';
 foreach($obj->showFeeType() as $value){
 extract($value);
 echo '
 <tr>
 	<td><input type="checkbox" id="checkItem" name="check[]" value="'.$bd_id.'" form="form1"></td>';
 	echo $request_status == "Temporary" ? '<td class="tleft"><div class="temporaryContainer"><span class="temporary">'.$bd_name.'</span><span class="temporaryDesc">There is a pending request in this fee type!</span></div>' : ' <td class="tleft">'.$bd_name.'</td>';
 	echo $request_status == "Temporary" ? '<td class="tright"><span class="temporary">'.number_format($tot_amt, 2).'</span></td>' : ' <td class="tright">'.number_format($tot_amt, 2).'</td>';
 	if($rowQueryCount > 0){
	 	if($request_status == "Temporary"){
	 		echo '
	 		<td>
	 		';
	 			echo $request_type == 'Insert' ? 'Add' : $request_type;
	 		echo'
	 		</td>
	 		';
	 	}else{
	 		echo '<td> </td>';
	 	}
 	}
 	if($rowQueryCount > 0){
	 	if($request_status == "Temporary"){
	 		echo '
	 		<td>
	 		';
	 			if($request_type == 'Insert' || $request_type == 'Update' || $request_type='Delete'){
	 				echo '<div class="pendingContainer">
	 						<button class="pending">Pending</button>
 							<input type="hidden" name="request_id" value="'.$request_id.'" form="form2">
 							<button class="cancel" name="cancel-button" form="form2"><i class="far fa-window-close"></i></button>
 						</div>';
	 			}else{
	 				echo '';
	 			}
	 		echo'
	 		</td>
	 		';
	 	}else{
	 		echo '<td> </td>';
	 	}
 	}
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
				<form action="admin-feetype" method="POST" required autocomplete="off" class="validateChangesInForm">
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
				<form action="admin-feetype" method="POST">
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
	echo '</tr>
';
?>
							</tbody>
						</table>
						<p class="tleft"><button type="submit" form="form1" name="delete-all-button" class="customButton">Delete <i class="fas fa-trash-alt"></i></button></p>
					</div>
				</div>
			</div>
		</div>
	</div>