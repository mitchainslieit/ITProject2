	<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct(); ?>
	<?php
		if(isset($_POST['create_announcement'])) {
			$_POST['acc_id'] = $_SESSION['accid']; 
			$getFactFunct->postAnnc($_POST, $_FILES['file']);
		} else if (isset($_POST['delete-announcement'])) {
			$getFactFunct->deleteCreatedAnnouncement($_POST);
		} else if (isset($_POST['update-announcements'])) {
			$getFactFunct->updateCreatedAnnouncement($_POST, $_FILES['file']);
		}
		$adviser = $getFactFunct->isAdviser($_SESSION['accid']);
	?>
	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p>	<i class="fas fa-user-plus fnt"></i>&nbsp;<span>Student List</span></p>
					<p>School Year: <?php $getFactFunct->getSchoolYear(); ?></p>
				</div>	
				<div class="classesContent widgetcontent">
					<div class="widget">
						<table>
							<thead>
								<th>Section</th>
								<th>Subject</th>
								<th>Time</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php $getFactFunct->displayAllStudentHandledInDifferentSubjects(); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>