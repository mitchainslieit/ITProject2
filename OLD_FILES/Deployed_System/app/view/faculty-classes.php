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
					<div id="Classes_handled">
						<div class="clearfix"></div>
						<div class="cont3">
							<div class="table-scroll">	
								<div class="table-wrap">
									<table>
										<?php $getFactFunct->getSchedule(); ?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>