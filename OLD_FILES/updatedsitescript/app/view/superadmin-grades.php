	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
	<?php
	if(isset($_POST['view-status'])){
		extract($_POST);
	}
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Student Grades</span>
					</div>
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent balContent">
					<div class="cont1">
						<div class="box box1">
							<p>Grade Level and Section:</p>
							<select name="gradeAndsection" id="gradeAndsection">
								<option value="">All</option>
								<?php $obj->getGradeAndSection_grades(); ?>
							</select>
						</div>
						<div class="box box2">
							<p>Subject:</p>
							<select name="subject-grades-subject" id="subject-grades-subject">
								<option value="">All</option>
								<?php $obj->getAllSubjects(); ?>
							</select>
						</div>
						<div class="box box2">
							<p>School Year:</p>
							<select name="subject-grades-sy" id="subject-grades-sy">
								<?php $obj->getAllSY(); ?>
							</select>
						</div>
					</div>
					<div class="cont2">
						<table id="superadmin-table-grades" class="display">
							<thead>	
								<tr>
									<th>LRN</th>
									<th>Name</th>
									<th>Grade Level and Section</th>
									<th>School Year</th>
									<th>Subject</th>
									<th>1st Grading</th>
									<th>2nd Grading</th>
									<th>3rd Grading</th>
									<th>4th Grading</th>
									<th>Final</th>
								</tr>
							</thead>
							<tbody>
								
								<?php foreach ($obj->showStudentGrades() as $value) {
									extract($value);
									echo '
									<tr>
									<td class="tleft">'.$stud_lrno.'</td>
									<td class="tleft">'.$stud_name.'</td>
									<td class="tleft">'.$student_sec.'</td>
									<td class="tright">'.$gg_sy.'</td>
									<td class="tleft">'.$subject_name.'</td>
									<td class="tright">'.$gg_first.'</td>
									<td class="tright">'.$gg_first.'</td>
									<td class="tright">'.$gg_third.'</td>
									<td class="tright">'.$gg_fourth.'</td>
									<td class="tright">'.number_format($gg_final, 2).'</td>
									</tr>	
									';
								}
								?>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>