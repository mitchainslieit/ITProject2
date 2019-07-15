	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct(); ?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->addSubject($subj_level,$subj_dept, $subj_name);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			$obj->updateSubject($subj_id, $subj_level, $subj_dept, $subj_name);
		}
		if(isset($_POST['delete-button'])){
			extract($_POST);
			$obj->deleteSubject($subj_id);
		}
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Subjects</span>
					</div>
					<p>School Year: <?php $obj->getSchoolYear(); ?>/p>
				</div>
				<div class="widgetContent">
					<div class="cont2">
						<table class="superadmin-table" class="stripe row-border order-column">
							<thead>
								<tr>
									<th class="tleft">Subject Level</th>
									<th class="tleft">Subject Department</th>
									<th class="tleft">Subject Name</th>
								</tr>
							</thead>
							<tbody>
<?php foreach ($obj->showSingleTable("subject") as $value) {
extract($value);
$department = ['Filipino', 'Math', 'MAPEH', 'Science', 'AP', 'Math', 'English', 'TLE', 'Values'];
$subject_level = ['7', '8', '9', '10'];
echo '
	<tr>
		<td class="tleft ">'.$subj_level.'</td>
		<td class="tleft ">'.$subj_dept.'</td>
		<td class="tleft ">'.$subj_name.'</td>
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
