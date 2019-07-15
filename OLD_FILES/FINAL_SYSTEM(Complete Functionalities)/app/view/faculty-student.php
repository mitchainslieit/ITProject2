	<?php 
		require 'app/model/faculty-funct.php'; 
		$getFactFunct = new FacultyFunct();
		if(isset($_POST['submit-req'])) {
			$getFactFunct->requestChange($_POST);
		}

		if(isset($_POST['submit-cancel'])) {
			$getFactFunct->cancelRequest($_POST);
		}
		if(isset($_POST['modify-stud-details'])) {
			$getFactFunct->updateStudentInfo($_POST);	
		}
		$adviser = $getFactFunct->isAdviser($_SESSION['accid']);
		if ((isset($_SESSION['adviser']) && $_SESSION['adviser'] !== 'Yes')) {
			echo '<script>window.location = "faculty-dashboard";</script>';
		}
	?>
	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p><i class="fas fa-id-card"></i><span>&nbsp;Advisory</span></p>
					<p>School Year: <?php $getFactFunct->getSchoolYear(); ?></p>
				</div>	
				<div class="studentContent widgetcontent">
					<div class="tabs">
						<ul>
							<li><a href="#Advisory_class">Schedule</a></li>
							<li><a href="#stud-det">Student List</a></li>
							<li><a href="#Advisory_att">Student's Attendance</a></li>
						</ul>
						<?php if($adviser == true) { ?>
						<div id="Advisory_class">
							<div class="clearfix"></div>
							<div class="classesContent">
								<div class="cont5">
									<div class="container">
										<div class="table-scroll">	
											<div class="table-wrap">
												<table>
													<?php $getFactFunct->getScheduleAdvisory(); ?>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
						<div id="stud-det">
							<div class="container">
								<div class="details">
									<div class="table-scroll">
										<div class="table-wrap">
											<table id="adv-table-4">
												<thead>
													<tr>
														<th>Name</th>
														<th>Gender</th>
														<th>Options</th>
													</tr>
												</thead>
												<tbody>
													<?php $getFactFunct->showAdvStudentEdit($_SESSION['accid']); ?>
												</tbody>
											</table>
											<input type="hidden" name="submit-req" value="request">
										</div>
									</div>
								</div>								
							</div>
						</div>
						<div id="Advisory_att">
							<div class="clearfix"></div>
							<div class="classesContent">
								<div class="cont5">
									<div class="container">
										<div class="table-wrap">
											<table id="adv-table-5">
												<thead>
													<tr>
														<th>Name</th>
														<th>Option</th>
													</tr>
												</thead>
												<tbody>
													<?php $getFactFunct->showAdvStudents_attendance($_SESSION['accid']); ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
