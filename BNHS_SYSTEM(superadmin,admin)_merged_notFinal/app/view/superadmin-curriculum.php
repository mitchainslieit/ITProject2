	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
	<?php
		if(isset($_POST['accept-button-all'])){
			extract($_POST);
			$obj->acceptCurriculumRequest();
		}
		if(isset($_POST['reject-button-all'])){
			extract($_POST);
			$obj->rejectCurriculumRequest();
		}
	?>
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
				<div class="widgetContent curriculumContent">
					<div class="cont1">
					</div>
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
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Adding A New Curriculum Request</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent curriculumContent">
					
					<div class="cont2">
						<form action="superadmin-curriculum" method="POST" id="form1"></form>
						<table id="superadmin-table-noFunct" class="display" style="width: 50%; margin-left: 0">
							<thead>
								<tr>
									<th><span class="selectAll">Select All</span><input type="checkbox" id="checkAl" class="selectAllCheck" form="form1"> </th>
									<th class="tleft">Curriculum Name</th>
								</tr>
							</thead>
							<tbody>
<?php foreach($obj->showCurriculumRequestDistinct() as $value){
extract($value);
echo '
	<tr>
		<td><input type="checkbox" id="checkItem" name="check[]" value="'.$request_id.'" form="form1"></td>
		<td class="tleft">'.$c_desc.'</td>
	</tr>
';	
}							
?>								
							</tbody>
						</table>
						<p class="tleft buttonContainer"><button type="submit" form="form1" name="accept-button-all" class="customButton">Accept <i class="fas fa-check"></i></button><button type="submit" form="form1" name="reject-button-all" class="customButton">Reject <i class="fas fa-trash-alt"></i></button></p>
						<div class="cont1">
							<div class="box box1">
								<p>Curriculum Name: </p> &nbsp;
								<select name="curr_desc"  id="super_unique2">
									<?php 
									foreach ($obj->getCurriculumTemp() as $row) {
										extract($row);
										echo '<option value="'.$cc_id.'">'.$c_desc.'</option>';
									}

									?>	
								</select>
							</div>
						</div>
						<table id="superadmin-table-curriculum2" class="display">
							<thead>
								<tr>
									<th>Curriculum</th>
									<th class="tleft">Subject Level</th>
									<th class="tleft">Subject Department</th>
									<th class="tleft">Subject Name</th>
									<th class="tleft">Curriculum Name</th>
								</tr>
							</thead>
							<tbody>
<?php foreach($obj->showCurriculumRequest() as $value){
extract($value);
echo '
	<tr>
		<td>'.$curriculum_idx.'</td>
		<td class="tleft">'.$s_level.'</td>
		<td class="tleft">'.$s_dept.'</td>
		<td class="tleft">'.$s_name.'</td>
		<td class="tleft">'.$c_desc.'</td>
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
