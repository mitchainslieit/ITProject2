<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
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
if(isset($_POST['enable-grading-button'])){
	extract($_POST);
	$obj->activeGrading($active_grading);
}
if(isset($_POST['select-grading-period'])){
	extract($_POST);
	$obj->selectGradingPeriod($active_grading);
}
if(isset($_POST['transfer-button'])){
	extract($_POST);
	$obj->transferStudents($student_transfer);
}
if(isset($_POST['select-grading-curriculum'])) {
	$obj->selectGradingPeriod($_POST);
}
?>
<div class="contentpage">
	<div class="row">
		<div class="widget">
			<div class="header">
				<div class="cont">
					<i class="fas fa-cog"></i>
					<span>System Settings</span>
				</div>
				<p>School Year: <?php $obj->getSchoolYear(); ?></p>
			</div>
			<div class="widgetContent systemContent" id="system-settings-div">
				<div class="cont1">
					<div class="innerCont" id="initializeSchoolYear-Style">
						<span><p>Initialize School Year</p><br></span>
						<form action="superadmin-system-settings" method="POST" autocomplete="off">
							<span>School Year:</span>
							<input type="text" name="sy_start" readonly="readonly" data-validation="required" class="datepicker-superadmin" data-validation="required" value="'.$sy_start.'" placeholder="Date Start" required>
							<span>to</span>
							<input type="text" name="sy_end" readonly="readonly" data-validation="required" class="datepicker-superadmin" value="'.$sy_end.'" data-validation="required" placeholder="End Date" required>&nbsp;&nbsp;&nbsp;
							<button name="start-button">Save <i class="fas fa-save fnt"></i></button>
						</form>
					</div>
					<div class="innerCont" id="#initializeSchoolYear-Style">
						<span>Enable Faculty operation to edit class</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php $obj->checkCurrentSystemEditStatus(); ?>
					</div>
					<div class="innerCont">
						<span>Transfer Student</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php $obj->checkTransferStudentEditStatus(); ?>
					</div>
					<div class="innerCont">
						<span>Set active grading</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<form action="superadmin-system-settings" method="POST" autocomplete="off">
							&nbsp;&nbsp;&nbsp;<select name="active_grading">
								<option disabled hidden>Enable Grading</option>
								<?php
								$gradingList=['1st', '2nd', '3rd', '4th'];
								$active = $obj->getCurrentQtrForOption();
								for ($c = 0; $c < sizeof($gradingList); $c++) {
									echo $active === $gradingList[$c] ?
									'<option value="'.$gradingList[$c].'" selected="selected">'.$gradingList[$c].'</option>'
									:
										'<option value="'.$gradingList[$c].'">'.$gradingList[$c].'</option>';
								}
								?>
							</select>
							&nbsp;&nbsp;&nbsp;&nbsp;<button name="enable-grading-button">Save <i class="fas fa-save fnt"></i></button>
						</form>
					</div>
					<div class="innerCont">
						<form action="superadmin-system-settings" method="POST" autocomplete="off">
							<?php $obj->selectCurriculum(); ?>
							<button name="select-grading-curriculum">Save <i class="fas fa-save fnt"></i></button>
						</form>
					</div>
					<div class="innerCont">
						<button name="opener" class="customButton">Insert Holidays <i class="fas fa-plus fnt"></i></button>
						<div name="dialog" title="Insert Holidays" >
							<form action="systemadmin-system-settings" method="POST">
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