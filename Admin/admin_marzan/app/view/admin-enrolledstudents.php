<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php
		if(isset($_POST['view-enrolled'])){
			extract($_POST);
		}
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>List of Enrolled Students</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent enrolledContent">
						<div class="cont1">
							<div class="box box1">
								<p>Grade Level and Section: </p>
								<select name="gradeAndsection" id="gradeAndsection" class="year_level_enrolled">
								<option value="">All</option>
								<?php $obj->getGradeAndSection(); ?>
								</select>
							</div>
						</div>
					<div class="cont2">
						<table id="admin-table-enrolled" class="display">
							<thead>	
								<tr>
									<th class="tleft">LRN</th>
									<th class="tleft">Name</th>
									<th class="tleft">Grade Level</th>
									<th class="tleft">Section</th>
									<th class="tleft">Gender</th>
									<th class="tleft">Ethnicity</th>
									<th class="tleft">Student Status</th>
									<th class="tleft">Current Status</th>
									<th class="tleft">section</th>
								</tr>
							</thead>
							<tbody>
								
<?php foreach ($obj->showEnrolled() as $value) {
extract($value);
echo '
<tr>
	<td class="tleft">'.$stud_lrno.'</td>
	<td class="tleft">'.$first_name,' ', $middle_name,' ', $last_name.'</td>
	<td class="tleft">'.$year_level.'</td>
	<td class="tleft">'.$sec_name.'</td>
	<td class="tleft">'.$gender.'</td>
	<td class="tleft">'.$ethnicity.'</td>
	<td class="tleft">'.$stud_status.'</td>
	<td class="tleft">'.$curr_stat.'</td>
	<td class="tleft">'.str_replace(' ', '', strtolower(('Grade'.$year_level.'-'.$sec_name))).'</td>
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