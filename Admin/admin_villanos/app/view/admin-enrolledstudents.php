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
				<div class="widgetContent">
					<form action="admin-enrolledstudents" method="POST">
						<div class="cont1">
							<p>Grade Level: </p>
								<select name="year_level">
					                <option value="All">All</option>
					                <option value="Grade 7">Grade 7</option>
					                <option value="Grade 8">Grade 8</option>
					                <option value="Grade 9">Grade 9</option>
				                	<option value="Grade 10">Grade 10</option>	
              					</select>
							<button name="view-enrolled" class="customButton">View</button>
						</div>
					</form>
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>	
								<tr>
									<th>LRN</th>
									<th>Name</th>
									<th>Grade Level</th>
									<th>Section</th>
									<th>Gender</th>
									<th>Ethnicity</th>
									<th>Student Status</th>
									<th>Current Status</th>
								</tr>
							</thead>
							<tbody>
								
<?php foreach ($obj->showEnrolled() as $value) {
extract($value);
echo '
<tr>
	<td>'.$stud_lrno.'</td>
	<td>'.$first_name,' ', $middle_name,' ', $last_name.'</td>
	<td>'.$year_level.'</td>
	<td>'.$sec_name.'</td>
	<td>'.$gender.'</td>
	<td>'.$ethnicity.'</td>
	<td>'.$stud_status.'</td>
	<td>'.$curr_stat.'</td>
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