	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php
		if(isset($_POST['reset-button'])){
			extract($_POST);
			if($obj->resetFacultyPassword($acc_id));
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
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
					</div>
					<div class="cont2">
						<table class="admin-table" class="display">
							<thead>
								<tr>
									<th>Admin Name</th>
									<th>Username</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
 <?php
 /*$department = $obj->department();*/
 foreach($obj->showTwoTables("admin","accounts", "acc_admid", "acc_id") as $row){
 extract($row);
 echo '
 <tr>
 	<td class="tleft custPad2">'.$adm_fname.' '.$adm_midname.' '.$adm_lname.'</td>
 	<td class="tleft custPad2">'.$username.'</td>
 	<td class="action">
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-retweet"></i>
					<span class="tooltiptext">Reset</span>
				</div>
			</button>
			<div name="dialog" title="Reset Password">
				<form action="super-admin" method="POST" required>
					<input type="hidden" value="'.$acc_id.'" name="acc_id">
					<p>Are you sure you want to reset the password of this account?</p>
					<button name="reset-button" class="customButton">Reset <i class="fas fa-save fnt"></i></button>
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
