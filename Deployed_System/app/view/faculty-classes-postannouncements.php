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
					<div id="Announcements_list">
						<div class="clearfix"></div>
						<div class="cont7">
							<div class="table-scroll">	
								<div class="table-wrap">
									<table id="announcements-posted">
										<thead>
											<tr>
												<th>Announcement</th>
												<th>Options</th>
											</tr>
										</thead>
										<tbody>
											<?php $getFactFunct->getAnnouncementsFaculty($_SESSION['accid']); ?>
										</tbody>
									</table>
							</div>
							<div class="cont8">
								<div name="dialog" title="Create an announcement">
									<div class="container">
										<div class="modal-cont">
											<form action="faculty-classes" method="POST" enctype="multipart/form-data">
												<textarea class="d-block mb-3" placeholder="Announcement Description" name="post" rows="5" cols="33" required></textarea>
												<?php if($adviser == true) { ?>
													<input type="hidden" name="grade_sec" value="<?php $getFactFunct->getAdviserSection($_SESSION['accid']); ?>">
												<?php } ?>
												<select name="class_posted" class="form-control mb-3" required="">
													<option value="">Select a class</option>
													<?php $getFactFunct->createSectionOptions(); ?>
												</select>
												<div class="file-upload-wrapper" data-text="Upload a file/note">
													<input name="file" type="file" class="file-upload-field" value="">
												</div>
												<p class="text-left mb-4 mt-2">Uploading a file is optional</p>
												<button name="create_announcement" type="submit" class="btn btn-info">Submit</button>
											</form>
										</div>
									</div>
								</div>
								<button type="button" name="opener" data-type="open-dialog" class="btn btn-info">Post Announcements</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
