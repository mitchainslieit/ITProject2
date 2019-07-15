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

if(isset($_POST['curriculum-button'])){
	extract($_POST);
	$obj->selectCurriculum($curr_desc);
}

if(isset($_POST['select-grading-period'])){
	extract($_POST);
	$obj->selectGradingPeriod($active_grading);
}

/*if(isset($_POST['end_school_year'])){*/
  	$obj->endFunctionFirst();
/*}*/

if(isset($_POST['remove-assignment'])) {
	$obj->removeFacSecAssignment($_POST);
}
if(isset($_POST['re-assignment'])) {
	$obj->assignFacSecAssignment($_POST);	
}
if(isset($_POST['select-all'])) {
	$obj->assignEnrollAll();
}
if(isset($_POST['unselect-all'])) {
	$obj->unassignEnrollAll();
}
if(isset($_POST['getChecked'])) {
	$obj->assignEnroll($_POST);
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
					<i class="fas fa-cog"></i>
					<span>System Settings</span>
				</div>
				<p>School Year: <?php $obj->getSchoolYear(); ?></p>
			</div>
			<div class="widgetContent systemContent" id="system-settings-div">
				<div class="cont1">
					<div id="accordion-container"> 
						<div class="generalSettings">
							<h2 class="accordion-header"><i class="fas fa-cog fnt2"></i>General Settings</h2> 
							<div class="accordion-content"> 
								<div class="systemContainer schoolYear">
									<form action="superadmin-system-settings" id="form1" method="POST" class="validateChangesInForm"></form>
									<form action="superadmin-system-settings" id="superadmin-end" method="POST">
										<div class="systemBox1">
											<div class="innerHeader">
												<span style="font-weight: 500 !important;">School Year:</span>
											</div>
											<?php
											$queryCheckSyExist=$this->conn->prepare("SELECT * FROM system_settings WHERE sy_status='Current'");
											$queryCheckSyExist->execute();
											$rowQueryCheckSyExist=$queryCheckSyExist->fetch(PDO::FETCH_ASSOC);
											$syStartCheck=$rowQueryCheckSyExist['sy_start'];
											if($queryCheckSyExist->rowCount() > 0){
												 foreach($obj->showSchoolYear() as $value){
													extract($value);
													echo $syStartCheck == '0000-00-00' ? '<input type="text" form="form1" name="sy_start" readonly="readonly" data-validation="required" class="datepicker-schoolyearStart" data-validation="required" value="'.$school_start.'">' : '<input type="text" form="form1" disabled name="sy_start" readonly="readonly" data-validation="required" class="datepicker-schoolyearStart" data-validation="required" value="'.$school_start.'">';
													echo'
														<span style="font-weight: 500 !important;">to</span>
														<input type="text" form="form1" name="sy_end" readonly="readonly" data-validation="required" class="datepicker-schoolyearEnd" value="'.$school_end.'" data-validation="required">
													';
												}
											}else{
												echo '
													<input type="text" form="form1" name="sy_start" readonly="readonly" class="datepicker-schoolyearStart" value="" data-validation="required"  data-validation-error-msg="Please fill out the field" 
														data-validation-error-msg-container="#sy-error-dialog" required>
													<span style="font-weight: 500 !important;">to</span>
													<input type="text" form="form1" name="sy_end" readonly="readonly" class="datepicker-schoolyearEnd" value="" data-validation="required"  data-validation-error-msg="Please fill out the field" data-validation-error-msg-container="#sy-error-dialog" required>
												';
											}
											?>
										</div>
										<div id="sy-error-dialog"></div>
										<?php
											date_default_timezone_set('Asia/Manila');
											$currDate = date('Y/m/d');
											$queryGetSysDate=$this->conn->prepare("SELECT sy_end FROM system_settings WHERE sy_status='Current'");
											$queryGetSysDate->execute();
											$rowQueryGetSysDate = $queryGetSysDate->fetch(PDO::FETCH_ASSOC);
											$syEnd=$rowQueryGetSysDate['sy_end'];
											if($queryGetSysDate->rowCount() > 0){
												if($currDate > $syEnd){
													echo '
														<p class="tright">
															<input type="hidden" name="end_school_year" value="end_year"/>
															<button name="end-button" id="end-button" class="customButton">End <i class="fas fa-step-forward fnt"></i></button>
														</p>
													';
												}else{
													echo '
													<p class="tright">
														<button name="start-button" form="form1" class="customButton">Save <i class="fas fa-save fnt"></i></button>
													</p>
													';
												}
											}else{
												echo '
													<p class="tright">
														<button name="start-button" form="form1" class="customButton">Save <i class="fas fa-save fnt"></i></button>
													</p>
													';
											}
										?>
									</form>
								</div>
								<?php 
								$queryCount=$this->conn->prepare("SELECT * FROM system_settings WHERE sy_status='Current'");
								$queryCount->execute();	
								if($queryCount->rowCount() > 0){
									echo '	
									<div class="systemContainer systemCurriculum">
										<form action="superadmin-system-settings" method="POST" class="validateChangesInFormCurriculum">
											<div class="systemBox1">
												<div class="innerHeader">
													<span style="font-weight: 500 !important;">Curriculum:</span>
												</div>';
														$queryCurrExist=$this->conn->prepare("SELECT * from system_settings WHERE (current_curriculum !=0) and sy_status='Current'");
														$queryCurrExist->execute();
														$curriculum=$obj->showCurr();
														$curriculumId=$obj->showCurrId();
														
														$queryCurrDesc=$this->conn->prepare("SELECT * from system_settings join curriculum on curr_id = current_curriculum WHERE sy_status='Current'");
														$queryCurrDesc->execute();
														$rowQueryCurrDesc=$queryCurrDesc->fetch(PDO::FETCH_ASSOC);
														$curr_desc=$rowQueryCurrDesc['curr_desc'];
														if($queryCurrExist->rowCount() > 0){
															echo '<select name="curr_desc" id="" disabled>';
															for ($c = 0; $c < sizeof($curriculum); $c++) {
																if($curr_desc==$curriculum[$c]){
																	echo '<option value="'.$curriculum[$c].'" selected>';
																}else{
																	echo '<option value="'.$curriculum[$c].'">';
																}
																echo ''.$curriculum[$c].'</option>';
															}
															echo '</select>';
														}else{
															echo'
															<select name="curr_desc" id="">
																<option value="">Select Curriculum</option>';
																$obj->showCurriculum();
															echo'
															</select>';												
														}
											echo'
											</div>
											<p class="tright">
												<button name="curriculum-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
											</p>
										</form>
									</div>
									<div class="systemContainer systemCurriculum">
										<form action="superadmin-system-settings" method="POST" class="validateChangesInForm">
											<div class="systemBox1">
												<div class="innerHeader">
													<span style="font-weight: 500 !important;">Set Grading Period:</span>
												</div>';
													
													$queryGrading=$this->conn->prepare("SELECT active_grading from system_settings WHERE sy_status='Current' LIMIT 1");
													$queryGrading->execute();
													$rowQueryGrading=$queryGrading->fetch(PDO::FETCH_ASSOC);
													$currGrading=$rowQueryGrading['active_grading'];
													$grading=['1st', '2nd', '3rd', '4th', 'Disabled'];
													if($queryGrading->rowCount() > 0){
														echo'
														<select name="active_grading">
														';
														for ($c = 0; $c < sizeof($grading); $c++) {
															echo $currGrading === $grading[$c] ? '<option value="'.$grading[$c].'" selected="selected">'.$grading[$c].'</option>' : '<option value="'.$grading[$c].'">'.$grading[$c].'</option>';	
														}
														echo '
														</select>
														';
													}else{
														echo '
														<select name="active_grading" id="">
															<option value="Disabled">Disabled</option>
															<option value="1st">1st</option>
															<option value="2nd">2nd</option>
															<option value="3rd">3rd</option>
															<option value="4th">4th</option>
														</select>
														';
													}
											echo'
											</div>
											<p class="tright">
												<button name="select-grading-period" class="customButton">Save <i class="fas fa-save fnt"></i></button>
											</p>
										</form>
									</div>
									<div class="systemContainer systemHoliday">
										<div class="systemBox1">
											<div class="innerHeader">
												<span style="font-weight: 500 !important;">Insert Holidays:</span>
											</div>
											<form action="superadmin-system-settings" method="POST">
												<p class="tleft">
													<button name="insert-holiday-button" class="customButton holidayButton">Insert Holidays <i class="fas fa-plus-square fnt"></i></button>
												</p>
											</form>
										</div>
									</div>';
								}else{
									echo '';
								}
								?>
							</div> 
						</div>
						<div class="facultSettings">
							<h2 class="accordion-header"><i class="fas fa-user-cog fnt2"></i>Faculty Settings</h2> 
							<div class="accordion-content">
								<div class="systemContainer">
									<h4>Assign a faculty to edit the schedule: </h4>
									<div class="tright" style="margin: 5px 0 10px 0;">
										<?php $obj->showModalAssignEdit(); ?>
										<button name="opener" class="customButton">Show Faculties <i class="fas fa-user-edit"></i></button>
									</div>
								</div>
								<div class="systemContainer">
									<h4>Assign faculties to enroll students: </h4>
									<div class="tright" style="margin: 5px 0 10px 0;">
										<?php $obj->showModalEnroll(); ?>
										<button name="opener" class="customButton">Show Faculties <i class="fas fa-user-edit"></i></button>
									</div>
								</div>
							</div> 
						</div>
					</div>
				</div>
				<div class="cont2">
				</div>
			</div>
		</div>
	</div>
</div>