	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct(); ?>
	<?php 
	if(isset($_POST['submit-button'])) {
		$obj->createCurriculum($_POST);
	}
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Add Subjects under a Curriculum</span>
					</div>
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent currriculumContent">
					<div class="cont1">
						<span> Curriculum Name: </span>
						<input type="text" form="form1" name="curr_name" id="curr_name" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z0-9\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphanumerics only" value="" data-validation="required"  placeholder="Curriculum Name" required />
					</div>
					<div class="cont2">
						<button id="addRow" class="customButton">Add subject</button>
						<button id="removeRow" class="customButton">Select row to remove</button>
					</div>
					<form action="admin-curriculum" method="POST" autocomplete="off" id="form1">
						<table id="curriculumTable" class="display">
							<thead>
								<th>Subject Level</th>
								<th>Subject Department</th>
								<th>Subject Name</th>
							</thead>
							
						</table>
						<p class="tright">
							<button name="submit-button" form="form1" class="customButton">Save <i class="fas fa-save fnt"></i></button>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
