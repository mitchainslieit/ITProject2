<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct(); ?>
<?php
	if(isset($_POST['submit-grades'])) {
		$getFactFunct->submitGrades($_POST);
	} else if(isset($_POST['submit-core-values'])) {
		$getFactFunct->submitCoreValues($_POST);
	}
?>
	<div class="contentpage">
		<div class="row">
			<div class="newwidget widget">
				<div class="classattendance header">
					<p>
						<i class="fas fa-th"></i>
						<span>Grades</span>
					</p>
					<p>School Year: <?php $getFactFunct->getSchoolYear(); ?></p>
				</div>
				<div class="gradesContent widgetcontent">
					<div id="grades-cv">
						<ul>
							<li><a href="#section1">Grades</a></li>
							<?php if ($_SESSION['adviser'] === 'Yes') { ?>
								<li><a href="#section2">Core Values</a></li>
							<?php } ?>
						</ul>						
						<div id="section1">
							<p>Click on edit button to add or update the grades for that section</p>
							<div class="widget">
								<table>
									<thead>
										<th>Days</th>
										<th>Time</th>
										<th>Section</th>
										<th>Options</th>
									</thead>
									<tbody>
										<?php $getFactFunct->getScheduleGrades(); ?>
									</tbody>
								</table>
							</div>
						</div>
						<?php if ($_SESSION['adviser'] === 'Yes') { ?>
							<div id="section2">
								<p>Click on edit button to add or update the Core Values for that section</p>
								<div class="widget">
									<table>
										<thead>
											<th>Days</th>
											<th>Time</th>
											<th>Section</th>
											<th>Options</th>
										</thead>
										<tbody>
											<?php $getFactFunct->getCoreVal(); ?>
										</tbody>
									</table>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>