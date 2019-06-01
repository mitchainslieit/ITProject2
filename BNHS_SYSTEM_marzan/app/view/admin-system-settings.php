	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php 
		if(isset($_POST['insert-holiday-button'])){
			extract($_POST);
			$obj->insertHolidays();
		}
		if(isset($_POST['start-button'])){
			extract($_POST);
			$obj->schoolYear($sy_start, $sy_end);
		}
		if(isset($_POST['sy-button'])){
			extract($_POST);
			$obj->syStatus($sy_status);
		}
		if(isset($_POST['edit-class-button'])){
			extract($_POST);
			$obj->editClass($edit_class);
		}
		if(isset($_POST['grading-button'])){
			extract($_POST);
			$obj->activeGrading($active_grading);
		}
		if(isset($_POST['transfer-button'])){
			extract($_POST);
			$obj->transferStudents($student_transfer);
		}
	?>
	<div class="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Event</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent systemContent">
					<div class="cont1">
						<div class="innerCont">
							<button name="opener" class="customButton">Enter date of school year <i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Enter date of school year" >
								<form action="admin-system-settings" method="POST" autocomplete="off">
								<?php
									foreach($obj->showSystemSettings() as $value){
										extract($value);
										echo'
										<span>Start of School Year:</span>
										<input type="text" name="sy_start" readonly="readonly" data-validation="required" class="datepickerAdmin" data-validation="required" value="'.$sy_start.'" placeholder="Date Start" required>
										<span>End of School Year:</span>
										<input type="text" name="sy_end" readonly="readonly" data-validation="required" class="datepickerAdmin" value="'.$sy_end.'" data-validation="required" placeholder="End Date" required>
										<button name="start-button" class="customButton">Yes <i class="fas fa-save fnt"></i></button>
										';
									}
								?>
								</form>
							</div>
						</div>
						<div class="innerCont">
							<button name="opener" class="customButton">Enable Start/End of school year<i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Enable Start/End of school year" >
								<form action="admin-system-settings" method="POST" autocomplete="off">
									<select name="sy_status">
										<option selected disabled hidden>Enable Start/End of school year</option>
									<?php 
									$status=['Started', 'Ended'];
									$viewStatus=['Start', "End"];
									foreach ($obj->showSystemSettings() as $value) {
										extract($value);
										for ($c = 0; $c < sizeof($status); $c++) {
											echo $sy_status === $status[$c] ? 
											'<option value="'.$status[$c].'" selected="selected">'.$viewStatus[$c].'</option>' 
											:
											'<option value="'.$status[$c].'">'.$viewStatus[$c].'</option>';	
										}
									}
									?>
									</select>
									<button name="sy-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
						<div class="innerCont">
							<button name="opener" class="customButton">Enable Faculty operation to edit class<i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Enable Faculty operation to edit class" >
								<form action="admin-system-settings" method="POST" autocomplete="off">
									<select name="edit_class">
										<option selected disabled hidden>Enable Faculty operation to edit class</option>
									<?php 
									foreach ($obj->showSystemSettings() as $value) {
										extract($value);
										for ($c = 0; $c < sizeof($status); $c++) {
											echo $edit_class === $status[$c] ? 
											'<option value="'.$status[$c].'" selected="selected">'.$viewStatus[$c].'</option>' 
											:
											'<option value="'.$status[$c].'">'.$viewStatus[$c].'</option>';	
										}
									}
									?>
									</select>
									<button name="edit-class-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
						<div class="innerCont">
							<button name="opener" class="customButton">Enable transferring of student<i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Enable transferring of student" >
								<form action="admin-system-settings" method="POST" autocomplete="off">
									<select name="student_transfer">
										<option disabled hidden>Enable transferring of student</option>
									<?php 
									$transfer=['Yes', 'No'];
									foreach ($obj->showSystemSettings() as $value) {
										extract($value);
										for ($c = 0; $c < sizeof($transfer); $c++) {
											echo $student_transfer === $transfer[$c] ? 
											'<option value="'.$transfer[$c].'" selected="selected">'.$transfer[$c].'</option>' 
											:
											'<option value="'.$transfer[$c].'">'.$transfer[$c].'</option>';	
										}
									}
									?>
									</select>
									<button name="transfer-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
						<div class="innerCont">
							<button name="opener" class="customButton">Enable grading<i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Enable grading" >
								<form action="admin-system-settings" method="POST" autocomplete="off">
									<select name="active_grading">
										<option disabled hidden>Enable Grading</option>
									<?php 
									$gradingList=['1st', '2nd', '3rd', '4th'];
									foreach ($obj->showSystemSettings() as $value) {
										extract($value);
										for ($c = 0; $c < sizeof($gradingList); $c++) {
											echo $active_grading === $gradingList[$c] ? 
											'<option value="'.$gradingList[$c].'" selected="selected">'.$gradingList[$c].'</option>' 
											:
											'<option value="'.$gradingList[$c].'">'.$gradingList[$c].'</option>';	
										}
									}
									?>
									</select>
									<button name="grading-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
						<div class="innerCont">
							<button name="opener" class="customButton">Insert Holidays <i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Insert Holidays" >
								<form action="admin-system-settings" method="POST">
									<p>Are you sure you want to insert all holidays in the calendar?</p>
									<button name="insert-holiday-button" class="customButton">Yes <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="cont2">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	

