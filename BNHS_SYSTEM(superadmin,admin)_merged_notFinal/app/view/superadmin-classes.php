	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct(); ?>
	<?php 
		if(isset($_POST['advaccept-button'])){
			extract($_POST);
			$obj->advAcceptRequest();
		}
		if(isset($_POST['classreject-button'])){
			extract($_POST);
			$obj->updateClass($sec_id, $fac_idv);
		}/*
		if(isset($_POST['accept-schedule'])) {
			$obj->acceptNewSchedule();
		}
		if(isset($_POST['reject-schedule'])) {
			$obj->rejectNewSchedule($_POST);
		}*/
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Classes</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont2">
						<table id="superadmin-table-classesList" class="display">
							<thead>
								<tr>
									<th class="tleft">Employee ID</th>
									<th class="tleft">Adviser</th>
									<th class="tleft">Section Name</th>
									<th class="tleft">Grade Level</th>
								</tr>
							</thead>
							<tbody>
<?php foreach ($obj->showClasses() as $value) {
extract($value);
$faculty_id = $obj->faculty_id();
$facultyname = $obj->facultyname();
$section_type=['A','B'];
echo '
	<tr>
		<td class="tleft">'.$fac_no.'</td>
		<td class="tleft">'.$fullname.'</td>
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
											<td class="tleft custPad">'.$request_type.'</td>
											<td class="tleft custPad">'.$request_desc.'</td>
										</tr>';
									}
									?>
								</tbody>
							</table>
							<p class="tleft buttonContainer">
								<button name="advaccept-button" class="customButton" >Accept <i class="fas fa-check"></i></button>
								<button name="secreject-button" class="customButton" >Reject <i class="fas fa-trash"></i></button>
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>