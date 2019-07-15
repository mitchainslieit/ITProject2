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

if(isset($_POST['end_school_year'])){
  	$obj->endFunctionFirst();
  }

/*if(isset($_POST['sy-button'])){
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
if(isset($_POST['transfer-button'])){
	extract($_POST);
	$obj->transferStudents($student_transfer);
}
if(isset($_POST['select-grading-curriculum'])) {
	$obj->selectGradingPeriod($_POST);
}*/
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
									<form action="superadmin-system-settings" method="POST" id="form1"></form>
									<form action="superadmin-system-settings" id="superadmin-end form2" method="POST">
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
													<input type="text" name="sy_end" form="form1" readonly="readonly" data-validation="required" class="datepicker-schoolyearEnd" value="'.$school_end.'" data-validation="required">
												';
											}
										}else{
											echo '
												<input type="text" form="form1" name="sy_start" readonly="readonly" class="datepicker-schoolyearStart" value="" data-validation="required"  data-validation-error-msg="Please fill out the field" 
													data-validation-error-msg-container="#sy-error-dialog">
												<span style="font-weight: 500 !important;">to</span>
												<input type="text" form="form1" name="sy_end" readonly="readonly" class="datepicker-schoolyearEnd" value="" data-validation="required"  data-validation-error-msg="Please fill out the field" data-validation-error-msg-container="#sy-error-dialog">
											';
										}
										?>
									</div>
									<div id="sy-error-dialog"></div>
									<?php
										date_default_timezone_set('Asia/Manila');
										$currDate = date('Y/m/d');
										$queryGetSysDate=$this->conn->prepare("SELECT sy_start FROM system_settings WHERE sy_status='Current'");
										$queryGetSysDate->execute();
										$rowQueryGetSysDate = $queryGetSysDate->fetch(PDO::FETCH_ASSOC);
										$syStart=$rowQueryGetSysDate['sy_start'];
										if($queryGetSysDate->rowCount() > 0){
											if($currDate > $syStart){
												echo '
													<p class="tright">
														<input type="hidden" name="end_school_year" form="form2" value="end_year"/>
														<button name="end-button" class="customButton">End <i class="fas fa-step-forward fnt"></i></button>
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
								</div>
								<div class="systemContainer systemCurriculum">
									<form action="superadmin-system-settings" method="POST" class="validateChangesInFormCurriculum">
										<div class="systemBox1">
											<div class="innerHeader">
												<span style="font-weight: 500 !important;">Curriculum:</span>
											</div>
												<?php 
													$queryCurrExist=$this->conn->prepare("SELECT * from system_settings WHERE (current_curriculum=0 or current_curriculum=NULL) and sy_status='Current'");
													$queryCurrExist->execute();
													$curriculum=$obj->showCurr();
													$curriculumId=$obj->showCurrId();
													
													$queryCurrDesc=$this->conn->prepare("SELECT * from system_settings join curriculum on curr_id = current_curriculum WHERE sy_status='Current'");
													$queryCurrDesc->execute();
													$rowQueryCurrDesc=$queryCurrDesc->fetch(PDO::FETCH_ASSOC);
													$curr_desc=$rowQueryCurrDesc['curr_desc'];
													if($queryCurrExist->rowCount() == 0){
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
												?>
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
											</div>
											<?php 
												$queryGradingExist=$this->conn->prepare("SELECT * from system_settings WHERE (active_grading=null or active_grading='') and sy_status='Current'");
												$queryGradingExist->execute();
												
												$queryGrading=$this->conn->prepare("SELECT active_grading from system_settings WHERE sy_status='Current' LIMIT 1");
												$queryGrading->execute();
												$rowQueryGrading=$queryGrading->fetch(PDO::FETCH_ASSOC);
												$currGrading=$rowQueryGrading['active_grading'];
												$grading=['1st', '2nd', '3rd', '4th'];
												if($queryGradingExist->rowCount() > 0){
													echo '
													<select name="active_grading" id="">
														<option value="">Select Grading Period</option>
														<option value="1st">1st</option>
														<option value="2nd">2nd</option>
														<option value="3rd">3rd</option>
														<option value="4th">4th</option>
													</select>
													';
												}else{
													echo'
													<select name="active_grading">
													';
													for ($c = 0; $c < sizeof($grading); $c++) {
														echo $currGrading === $grading[$c] ? '<option value="'.$grading[$c].'" selected="selected">'.$grading[$c].'</option>' : '<option value="'.$grading[$c].'">'.$grading[$c].'</option>';	
													}
													echo '
													</select>
													';
												}
											?>
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
								</div>
							</div> 
						</div>
						<div class="facultSettings">
							<h2 class="accordion-header"><i class="fas fa-user-cog fnt2"></i>Faculty Settings</h2> 
							<div class="accordion-content"> 
								<table class="systemTable">
									<thead>
										<th>Faculty Name</th>
										<th>Action</th>
									</thead>
									<tbody>
										<form action="superadmin-system-settings" id="enrollPrivilege">
										<?php foreach($obj->systemSetEnrollPrivilege() as $value){  
											extract($value);
											echo '
												<tr> 
													<td>'.$fullname.'</td>
													<td>';
														if($enroll_privilege == 'Yes'){
															echo '<input type="text" name="enroll_privilege" value="Yes" class="yes" readonly="">';
														}else{
															echo '<input type="text" name="enroll_privilege" value="No" class="no" readonly="">';
														} 
													echo'</td>
												</tr>
											';
										}
										?>
										</form>
									</tbody>
								</table>
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