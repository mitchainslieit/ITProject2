	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct(); ?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Curriculum</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent subjectContent">
					<div class="cont1">
						<div name="content">
							<a href="admin-curriculum" class="customButton">Add curriculum <i class="fas fa-plus fnt"></i></a>
						</div>
					</div>
					<br>
					<div class="cont2">
						<div class="box box1">
							<p>Curriculum Name: </p> &nbsp;
							<select name="curr_desc"  id="super_unique" class="curr_desc">
								<?php 
								foreach ($obj->getCurriculum() as $row) {
									extract($row);
									echo '<option value="'.$cc_id.'">'.$c_desc.'</option>';
								}

							?>	
						</select>
						</div>
					<br>
						<form action="admin-subjects" method="POST" id="form1"></form>
							<table id="admin-table-curriculum" class="display">
								<thead>
									<tr>
										<th class="tleft custPad">Subject Level</th>
										<th class="tleft custPad">Subject Department</th>
										<th class="tleft custPad">Subject Name</th>
										<th> curr_id</th>
									</tr>
								</thead>
								<tbody>
	<?php foreach ($obj->showSingleTable("subject") as $value) {
	extract($value);
	$department = ['Filipino', 'Math', 'MAPEH', 'Science', 'AP', 'Math', 'English', 'TLE', 'Values'];
	$subject_level = ['7', '8', '9', '10'];
	echo '
		<tr>
			<td class="tleft custPad">'.$subj_level.'</td>
			<td class="tleft custPad">'.$subj_dept.'</td>
			<td class="tleft custPad">'.$subj_name.'</td>
			
			<td>'.$curriculum.'</td>
		</tr>
		';
	}
	?>
								</tbody>
							</table>
							<p class="tleft"><button type="submit" form="form1" name="delete-all-button" class="customButton">Delete <i class="fas fa-trash-alt"></i></button></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- action function -->
<!-- 	<td class="action">
	<div name="content">
		<button name="opener">
			<div class="tooltip">
				<i class="fas fa-edit"></i>
				<span class="tooltiptext">edit</span>
			</div>
		</button>
		<div name="dialog" title="Update subjects data">
			<form action="admin-subjects" method="POST" required autocomplete="off">
				<input type="hidden" name="subj_id" value="'.$subj_id.'" required>
				<span>Subject Level:</span>
				<select name="subj_level" value="" data-validation="required"  required>
					';
					for ($c = 0; $c < sizeof($subject_level); $c++) {
					echo $subj_level === $subject_level[$c] ? '<option value="'.$subject_level[$c].'" selected="selected">'.$subject_level[$c].'</option>' : '<option value="'.$subject_level[$c].'">'.$subject_level[$c].'</option>';	
				}
				echo '	
			</select>
			<span>Subject Department:</span>
			<select name="subj_dept" data-validation="required" required>
				';
				for ($c = 0; $c < sizeof($department); $c++) {
				echo $subj_dept === $department[$c] ? '<option value="'.$department[$c].'" selected="selected">'.$department[$c].'</option>' : '<option value="'.$department[$c].'">'.$department[$c].'</option>';	
			}
			echo '
		</select>
		<span>Subject Name:</span>
		<input type="text" data-validation="length custom" data-validation-length="max45" data-validation-regexp="^[a-zA-Z0-9\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphanumerics only" name="subj_name" value="'.$subj_name.'" data-validation="required" required>
		<button name="update-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
	</form>
</div>  
</div>
<div name="content">
<button name="opener">
	<div class="tooltip">
		<i class="fas fa-trash-alt"></i>
		<span class="tooltiptext">delete</span>
	</div>
</button>
<div name="dialog" title="Delete subject data">
	<form action="admin-subjects" method="POST" required>
		<p>Are you sure you want to delete this subject?</p>
		<input type="hidden" value="'.$subj_id.'" name="subj_id">
		<button name="delete-button" class="customButton">Yes <i class="fas fa-save fnt"></i></button>
	</form>
</div>  
</div>
</td> -->
