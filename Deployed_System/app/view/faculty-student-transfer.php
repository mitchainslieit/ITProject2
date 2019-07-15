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
		if ((isset($_SESSION['transfer_enabled']) && $_SESSION['transfer_enabled'] !== 'Yes') || (isset($_SESSION['adviser']) && $_SESSION['adviser'] !== 'Yes')) {
			echo '<script>window.location = "faculty-dashboard";</script>';
		}
	?>
	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p><i class="fas fa-user-cog"></i><span>&nbsp;Student List</span></p>
					<p>School Year: <?php $getFactFunct->getSchoolYear(); ?></p>
				</div>	
				<div class="studentContent widgetcontent">
					<div class="tabs">
						<ul>
							<li><a href="#students">Students</a></li>
							<li><a href="#request">Pending Request</a></li>
						</ul>
						<div id="students">
							<form action="faculty-student-transfer" method="POST" id="student-form-request">
							<div id="section1">
								<div class="cont">
									<span>ADVISORY:</span>
									<p><?php $getFactFunct->getAdvSection($_SESSION['accid']); ?></p>
								</div>
								<div class="clearfix"></div>
								<div class="container">
									<div class="details">
										<div class="table-scroll">	
											<div class="table-wrap">
													<table id="adv-table-1">
														<thead>
															<tr>
																<th>Name</th>
																<?php if ($getFactFunct->checkIfEnabledTransfer() === true) { ?>
																	<th><input type="checkbox" class="check-all-student"></th>
																<?php } ?>
															</tr>
														</thead>
														<tbody>
															<?php $getFactFunct->showAdvStudent($_SESSION['accid']); ?>
														</tbody>
													</table>
													<input type="hidden" name="submit-req" value="request">
											</div>
										</div>
									</div>								
								</div>
							</div>
							<?php if($getFactFunct->getNumberofSec($_SESSION['accid']) === true) { ?>
								<?php if ($getFactFunct->checkIfEnabledTransfer() === true) { ?>
									<div id="submit-req">
										<button type="submit" form="student-form-request" value="submit" class="btn btn-primary"><i class="fas fa-exchange-alt"></i></button>
									</div>
									<div id="section2">
										<div class="cont">
											<span>OTHER SECTIONS:</span>
											<select name="transfer-sec" id="transfer-sec_search"><?php $getFactFunct->getOppoSection($_SESSION['accid']); ?></select>
										</div>
										<div class="clearfix"></div>
										<div class="container">
											<div class="details">
												<div class="table-scroll">	
													<div class="table-wrap">
														<table id="adv-table-2">
															<thead>
																<tr>
																	<th>Name</th>
																	<th>sec_id</th>
																</tr>
															</thead>
															<tbody>
																<?php $getFactFunct->showOppoStudent($_SESSION['accid']); ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>								
										</div>
									</div>
								<?php } ?>
							<?php } ?>			
							</form>
						</div>
						<?php if($getFactFunct->getNumberofSec($_SESSION['accid']) === true) { ?>
							<?php if ($getFactFunct->checkIfEnabledTransfer() === true) { ?>
								<div id="request">
									<div id="section1">
										<div class="cont">
											<span>ADVISORY:</span>
											<p><?php $getFactFunct->getAdvSection($_SESSION['accid']); ?></p>
										</div>
										<p>Check the box to cancel the request. Click submit to save.</p>
										<div class="clearfix"></div>
										<div class="container">
											<div class="details">
												<div class="table-scroll">	
													<div class="table-wrap">
														<form action="faculty-student-transfer" method="POST" id="student-form-request-cancel">
															<table id="adv-table-3">
																<thead>
																	<tr>
																		<th width="95%">Name</th>
																		<th width="5%"><input type="checkbox" class="check-all-student"></th>
																	</tr>
																</thead>
																<tbody>
																	<?php $getFactFunct->showReqStudent($_SESSION['accid']); ?>
																</tbody>
															</table>
															<button type="submit" name="submit-cancel" class="btn btn-info">Cancel Request</button>
														</form>
													</div>
												</div>
											</div>								
										</div>
									</div>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
