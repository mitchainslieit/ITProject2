	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct(); ?>
	<?php 
		if(isset($_POST['advaccept-button'])){
			extract($_POST);
			$obj->advAcceptRequest();
		}
		if(isset($_POST['classreject-button'])){
			extract($_POST);
			$obj->advRejectRequest();
		}
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->addClass($sectionid, $fc_id);
		}
		if(isset($_POST['reject-button'])){
			extract($_POST);
			$obj->updateClass($sectionid, $fc_id);
		}
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Classes</span>
					</div>
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<div name="content">
							<button name="opener" class="customButton">Add class <i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Add Class">
								<form action="superadmin-classes" method="POST" autocomplete="off">
									<span>Choose Adviser</span>
									<?php $obj->facultyList();?>
									<span>Section Name:</span>
									<?php $obj->sectionTemp();	?> 	
									<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="cont2">
						<form action="superadmin-classes" method="POST" id="form2"></form>
						<table id="superadmin-table-classes" class="display">
							<thead>
								<tr>
									<th class="tleft custPad">Employee ID</th>
									<th class="tleft custPad">Adviser</th>
									<th class="tleft custPad">Section Name</th>
									<th class="tleft custPad">Grade Level</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
<?php
foreach ($obj->showClasses() as $value) {
extract($value);
$faculty_id = $obj->faculty_id();
$facultyname = $obj->facultyname();
$section_type=['A','B'];
echo '
	<tr>
	<td class="tleft">'.$fac_no.'</td>
	<td class="tleft">'.$fullname.'</td>
	<td class="tleft">'.$s_name.'</td>
	<td class="tleft">'.$gr_lvl.'</td>
	<td class="action">
		<div name="content">
			<button name="opener">
				<div class="tooltip">
					<i class="fas fa-edit"></i>
					<span class="tooltiptext">edit</span>
				</div>
			</button>
			<div name="dialog" title="Update class data">
				<form action="superadmin-classes" method="POST" required autocomplete="off" class="validateChangesInForm">
					<input type="hidden" name="sectionid" value="'.$sectionid.'">
					<span>Employee ID</span>
					<input type="text" name="" value="'.$fac_no.'" disabled="disabled">
					<span>Adviser Name</span>
					<select name="fc_id" data-validation="required" >
						';
						for ($c = 0; $c < sizeof($faculty_id); $c++) {
							if($fc_id==$faculty_id[$c]){
								echo '<option value="'.$faculty_id[$c].'" selected>';
							}else{
								echo '<option value="'.$faculty_id[$c].'"">';
							}
							echo ''.$facultyname[$c].'</option>';
						}
						echo '
					</select>
					<span>Section Name</span>
					<select name="" disabled="disabled">
						<option value="">'.$s_name.'</option>
					</select>
					<span>Grade Level:</span>
					<select name="" disabled="disabled">
						<option value="">'.$gr_lvl.'</option>
					</select>
					<button name="reject-button" class="customButton">Update <i class="fas fa-save fnt"></i></button>
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
			<!-- Admin's Request -->
			<div class="widget ClassWidget hidden">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-bell"></i>
						<span>Admin Request</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent sectionContent">
					<div class="cont2">
						<form action="superadmin-classes" method="POST" required autocomplete="off">
							<table id="superadmin-table-classesRequest" class="display">
								<thead>
									<tr>
										<th><span class="selectAll">Select All </span><input type="checkbox" id="checkAl" class="selectAllCheck" form="form1"> </th>
										<th class="tleft custPad">Request Type</th>
										<th class="tleft custPad">Request Description</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach($obj->classRequest() as $value){
										extract($value);
										echo '
										<tr>
											<td><input type="checkbox" id="checkItem" name="check[]" value="'.$request_id.'"></td>
											<td class="tleft custPad">';
												if($request_type == 'Adviser_Insert'){
									 				echo 'Add';
									 			}else if($request_type == 'Adviser_Update'){
									 				echo 'Update';
									 			}else{
									 				echo '';
									 			}
											echo '</td>
											<td class="tleft custPad">'.$request_desc.'</td>
										</tr>';
									}
									?>
								</tbody>
							</table>
							<p class="tleft buttonContainer">
								<button name="advaccept-button" class="customButton" >Accept <i class="fas fa-check"></i></button>
								<button name="classreject-button" class="customButton" >Reject <i class="fas fa-trash"></i></button>
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>