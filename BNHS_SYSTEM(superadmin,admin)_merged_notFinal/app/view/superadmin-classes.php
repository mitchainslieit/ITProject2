	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct(); ?>
	<?php 
		if(isset($_POST['classaccept-button'])){
			extract($_POST);
			$obj->classsacceptRequest();
		}
		if(isset($_POST['classreject-button'])){
			extract($_POST);
			$obj->updateClass($sec_id, $fac_idv);
		}
		if(isset($_POST['accept-schedule'])) {
			$obj->acceptNewSchedule();
		}
		if(isset($_POST['reject-schedule'])) {
			$obj->rejectNewSchedule($_POST);
		}
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Classes</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont2">
						<table class="superadmin-table" class="display">
							<thead>
								<tr>
									<th class="tleft">Employee ID</th>
									<th class="tleft">Adviser</th>
									<th class="tleft">Section Name</th>
									<th class="tleft">Grade Level</th>
								</tr>
							</thead>
							<tbody>
<?php foreach ($obj->showClasses() as $value) {
extract($value);
$faculty_id = $obj->faculty_id();
$facultyname = $obj->facultyname();
$section_type=['A','B'];
echo '
	<tr>
		<td class="tleft">'.$fac_no.'</td>
		<td class="tleft">'.$fullname.'</td>
		<td class="tleft">'.$sec_name.'</td>
		<td class="tleft">'.$grade_lvl.'</td>
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