	<?php 
		require 'app/model/faculty-funct.php'; 
		$getFactFunct = new FacultyFunct();
	?>

	<?php 
		if(isset($_POST['modify-stud-details'])) {
			$getFactFunct->updateStudentInfo($_POST);
		} 
	?>
	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p>	<i class="fas fa-user-plus fnt"></i><span>Student List</span></p>
					<p>School Year: 2019-2020</p>
				</div>	
				<div class="studentContent widgetcontent">
					<div class="tabs">
						<ul>
							<li><a href="#section1">Advisory Class</a></li>
							<?php if ($_SESSION['transfer_enabled'] === 'Yes') { ?>
								<li><a href="#section2">Requests</a><span class="notification"><?php echo $_SESSION['notif']; ?></span></li>
							<?php } ?>
						</ul>
						<div id="section1">
							<div class="cont">
								<span>SECTION:</span>
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
														<th>LRN(Learner Refence No.)</i></th>
														<th>Name</i></th>
														<th>Options</i></th>
													</tr>
												</thead>
												<tbody>
													<?php $getFactFunct->showAdvStudent($_SESSION['accid']); ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>								
							</div>
						</div>
						<?php if ($_SESSION['transfer_enabled'] === 'Yes') { ?>
						<div id="section2">
							<div class="cont">
								<span>FROM SECTION:</span>
								<p><?php $getFactFunct->getOppoSection($_SESSION['accid']); ?></p>
							</div>
							<div class="clearfix"></div>
							<div class="container">
								<div class="details">
									<div class="table-scroll">	
										<div class="table-wrap">
											<table id="adv-table-2">
												<thead>
													<tr>
														<th>LRN(Learner Refence No.)</i></th>
														<th>Name</i></th>
														<th>Options</i></th>
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
					</div>
				</div>
			</div>
		</div>
	</div>
