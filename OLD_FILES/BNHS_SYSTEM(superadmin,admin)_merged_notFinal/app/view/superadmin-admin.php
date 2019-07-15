	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;

		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->insertAdminAccount($adm_fname, $adm_midname, $adm_lname);
		}
		if(isset($_POST['reset-button'])){
			extract($_POST);
			if($obj->resetAdminPassword($acc_id));
		}
		if(isset($_POST['status-button'])){
			extract($_POST);
			if($obj->updateAdminAccountStatus($acc_id, $acc_status));
		}
	?>
	<?php
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	?>
	<div class="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Admin List</span>
					</div>
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent adminContent">
					<div class="cont1">
						<?php 
						$queryCount=$this->conn->prepare("SELECT * FROM admin join accounts on acc_admid=acc_id WHERE acc_type='Admin' and acc_status='Deactivated'");
							$queryCount->execute();
							$rowQueryCount=$queryCount->rowCount();
							if($rowQueryCount > 0){
								echo '
								<div name="content">
									<button name="opener" class="customButton">Create new account<i class="fas fa-plus fnt"></i></button>
									<div name="dialog" title="Create new admin account">
										<form action="superadmin-admin" method="POST" autocomplete="off">
											<span>First name:</span>
											<input type="text" name="adm_fname" value="" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-&ñ. ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="First name" maxlength="45" required>
											<span>Middle Name:</span>
											<input type="text" name="adm_midname" value="" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-&ñ. ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Middle name" required>
											<span>Last name:</span>
											<input type="text" name="adm_lname" value="" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-&ñ. ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Last name" required>
											<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
										</form>
									</div>
								</div>';
							}else{
								echo '';
							}
					?>
					</div>
					<div class="cont2">
						<table id="superadmin-table-all" class="display">
							<thead>
								<tr>
									<th class="tleft">Name</th>
									<th class="tleft">Username</th>
									<th class="tleft">Date Started</th>
									<th class="tleft">Date Ended</th>
									<th>Account Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
<?php
foreach($obj->showAdminList() as $value){
	extract($value);
	$status = ['Active','Deactivated'];
	echo '
	<tr>
	<td class="tleft">'.$adm_fname.' '.$adm_midname.' '.$adm_lname.'</td>
	<td class="tleft">'.$username.'</td>
	<td class="tleft">'.$yearStarted.'</td>
	<td class="tleft">'.$yearEnded.'</td>
	<td class="">'.$acc_status.'</td>
	<td class="action">
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-retweet"></i>
					<span class="tooltiptext">Reset</span>
				</div>
			</button>
			<div name="dialog" title="Reset Password">
				<form action="superadmin-admin" method="POST" required>
					<input type="hidden" value="'.$acc_id.'" name="acc_id">
					<p>Are you sure you want to reset the password of this account?</p>
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
				<form action="superadmin-admin" method="POST" required>
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
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
