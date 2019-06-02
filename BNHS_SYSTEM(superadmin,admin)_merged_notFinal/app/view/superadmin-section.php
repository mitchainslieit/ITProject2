	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct(); ?>
	<?php 
	if(
		isset($_POST['secaccept-button'])){
		extract($_POST);
		$obj->secacceptRequest();
	}

	if(
		isset($_POST['secreject-button'])){
		extract($_POST);
		$obj->secrejectRequest();
	}
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Section</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont2">
						<table id="superadmin-table-all" class="display">
							<thead>
								<tr>
									<th class="tleft">Section Name</th>
									<th class="tleft">Grade Level</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($obj->showSingleTable("Section") as $value) {
									extract($value);
									$grade_level = ['7', '8', '9', '10'];
									echo '
									<tr>
									<td class="tleft">'.$sec_name.'</td>
									<td class="tleft">'.$grade_lvl.'</td>
									</tr>
									';
								}

								?>
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
				<div class="widgetContent sectionContent">
					<div class="cont2">
						<form action="superadmin-section" method="POST" required autocomplete="off">
							<table id="superadmin-table-section" class="display">
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
									foreach($obj->secRequest() as $value){
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
							<button name="secaccept-button" class="customButton" >Accept <i class="fas fa-check"></i></button>
							<button name="secreject-button" class="customButton" >Reject <i class="fas fa-trash"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
