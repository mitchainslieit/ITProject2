	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct(); ?>
	<?php 
	if(isset($_POST['secaccept-button'])){
		extract($_POST);
		$obj->secacceptRequest();
	}
	
	if(isset($_POST['secreject-button'])){
		extract($_POST);
		$obj->secrejectRequest();
	}
	
	if(isset($_POST['submit-button'])){
		extract($_POST);
		$obj->addSection($s_name, $gr_lvl);
	}
	if(isset($_POST['update-button'])){
		extract($_POST);
		$obj->updatesection($sectionid, $s_name, $gr_lvl);
	}
	if(isset($_POST['delete-button'])){
		extract($_POST);
		$obj->deleteSection($sectionid);
	}
	if(isset($_POST['delete-all-button'])){
		extract($_POST);
		$obj->multipleDeleteSection();
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
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent sectionContent">
					<div class="cont1">
						<div name="content">
							<button name="opener" class="customButton">Add Section <i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Add Section">
								<form action="superadmin-section" method="POST" autocomplete="off">
									<span>Grade Level</span>
									<select name="gr_lvl" value="" required>
										<option value="" selected disabled hidden>Select Grade Level</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
									</select>
									<span>Section Name:</span>
									<input type="text" name="s_name" value="" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Section Name" required>
									<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="cont2">
						<form method="post" action="superadmin-section" id="form1"></form>
						<form action="superadmin-section" method="POST" id="form2"></form>
							<table id="superadmin-table-section-top" class="display">
								<thead>
									<tr>
										<th><span class="selectAll">Select All</span><input type="checkbox" id="checkAl1" class="selectAllCheck" form="form1"> </th>
										<th class="tleft custPad">Grade Level</th>
										<th class="tleft custPad">Section Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
<?php
foreach ($obj->showSectionTable() as $value) {
	extract($value);
	$grade_level = ['7', '8', '9', '10'];
	echo '
		<tr>
			<td><input type="checkbox" class="chkbox1" id="checkItem" name="check[]" value="'.$sectionid.'" form="form1"></td>
			<td class="tleft custPad">'.$gr_lvl.'</td>
			<td class="tleft custPad">'.$s_name.'</td>
			<td class="action">
				<div name="content">
					<button name="opener">
						<div class="tooltip">
							<i class="fas fa-edit"></i>
							<span class="tooltiptext">edit</span>
						</div>
					</button>
					<div name="dialog" title="Update section data">
						<form action="superadmin-section" method="POST" required autocomplete="off" class="validateChangesInForm">
							<input type="hidden" value="'.$sectionid.'" name="sectionid">
							<span>Grade Level</span>
							<select name="gr_lvl" required>
							';
							for ($c = 0; $c < sizeof($grade_level); $c++) {
								echo $gr_lvl === $grade_level[$c] ? '<option value="'.$grade_level[$c].'" selected="selected">'.$grade_level[$c].'</option>' : '<option value="'.$grade_level[$c].'">'.$grade_level[$c].'</option>';	
							}
							echo '
							</select>
							<span>Section Name</span>
							<input type="text" name="s_name" value="'.$s_name.'" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Section Name"  required>
							<button name="update-button" class="customButton" >Update <i class="fas fa-save fnt"></i></button>
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
					<div name="dialog" title="Delete Section">
						<form action="superadmin-section" method="POST" required>
							<p>Are you sure you want to delete this Section?</p>
							<input type="hidden" value="'.$sectionid.'" name="sectionid">
							<button type="submit" name="delete-button" class="customButton">Yes <i class="fas fa-save fnt"></i> </button>
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
						<p class="tleft"><button type="submit" form="form1" name="delete-all-button" class="customButton">Delete <i class="fas fa-trash-alt"></i></button></p>
					</div>
				</div>
			</div>
			<!-- Admin's Request -->
			<div class="widget SectionWidget">	
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
											<td><input type="checkbox" id="checkItem" name="check[]" value="'.$request_id.'"></td>
											<td class="tleft custPad">';
											echo $request_type == 'Insert' ? 'Add' : $request_type;
											echo '</td>
											<td class="tleft custPad">'.$request_desc.'</td>
										</tr>';
									}
									?>
								</tbody>
							</table>
							<p class="tleft buttonContainer">
								<button name="secaccept-button" class="customButton" >Accept <i class="fas fa-check"></i></button>
								<button name="secreject-button" class="customButton" >Reject <i class="fas fa-trash"></i></button>
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
