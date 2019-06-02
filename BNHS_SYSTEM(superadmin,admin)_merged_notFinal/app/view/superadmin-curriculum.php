	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
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
					</div>
					<br>
					<div class="cont2">
						<div class="box box1">
							<p>Curriculum Name: </p> &nbsp;
							<select name="curr_desc"  id="super_unique" class="curr_desc">
								<?php 
								foreach ($obj->getCurriculum() as $row) {
									extract($row);
									echo '<option value="'.$curr_id.'">'.$curr_desc.'</option>';
								}

							?>	
						</select>
					</div>
					<br>
					<table id="superadmin-table-curriculum" class="display">
						<thead>
							<tr>
								<th class="tleft custPad">Subject Level</th>
								<th class="tleft custPad">Subject Department</th>
								<th class="tleft custPad">Subject Name</th>
								<th>curr_id</th>
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
					</div>
				</div>
			</div>
		</div>
	</div>
