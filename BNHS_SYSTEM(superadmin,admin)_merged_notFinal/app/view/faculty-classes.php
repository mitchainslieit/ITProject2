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
					<p>	<i class="fas fa-user-plus fnt"></i><span>Student List</span></p>
					<p>School Year: 2019-2020</p>
				</div>	
				<div class="classesContent widgetcontent">
					<div class="tabs">
						<ul>
							<li><a href="#Classes_handled">Class List</a></li>
							<?php if($adviser == true) { ?>
							<li><a href="#Advisory_class">Advisory Class List</a></li>
							<?php } ?>
							<li><a href="#Announcements_list">Created Announcements</a></li>
						</ul>
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
								<div class="cont4">
									<div name="dialog" title="Create an announcement" class="upload-file-dialog">
										<div class="container">
											<div class="modal-cont">
												<form action="faculty-classes" method="POST" enctype="multipart/form-data">
													<textarea placeholder="Announcement Description" name="post" rows="5" cols="33" required></textarea>
													<label>For section: <select name="grade_sec">
														<?php $getFactFunct->createSectionOptions(); ?>
													</select></label>
													<input type="file" name="file">
													<button type="submit" name="create_announcement">Submit</button>
												</form>
											</div>
										</div>
									</div>
									<button type="button" name="opener" data-type="open-dialog">Post Announcements</button>
								</div>
							</div>
						</div>
						<?php if($adviser == true) { ?>
						<div id="Advisory_class">
							<div class="clearfix"></div>
							<div class="container">
								<div class="cont5">
									<div class="table-scroll">	
										<div class="table-wrap">
											<table>
												<?php $getFactFunct->getScheduleAdvisory(); ?>
											</table>
										</div>
									</div>
									<div class="cont4">
										<div name="dialog" title="Create an announcement">
											<div class="container">
												<div class="modal-cont">
													<form action="faculty-classes" method="POST" enctype="multipart/form-data">
														<textarea placeholder="Announcement Description" name="post" rows="5" cols="33" required></textarea>
														<input type="hidden" name="grade_sec" value="<?php $getFactFunct->getAdviserSection($_SESSION['accid']); ?>">
														<input type="file" name="file">
														<p>Uploading a file is optional.</p>
														<button name="create_announcement" type="submit">Submit</button>
													</form>
												</div>
											</div>
										</div>
										<button type="button" name="opener" data-type="open-dialog">Post Announcements</button>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
						<div id="Announcements_list">
							<div class="clearfix"></div>
							<div class="cont6">
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
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>