	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<div class="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Faculty List</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					<table id="admin-table" class="display">
						<thead>
							<tr>
								<th>Parent Name</th>
								<th>Guardian Mobile Number</th>
								<th>Parent Address</th>
								<th>Student Name</th>
							</tr>
						</thead>
						<tbody>
<?php foreach ($obj->showTwoTables("parent", "student", "stude_id", "stud_id") as $value) {
extract($value);
echo <<<show
<tr>
	<td>$pr_fname $pr_midinitial. $pr_lname</td>
	<td>$guar_mobno</td>
	<td>$pr_address</td>
	<td>$first_name $last_name</td>
</tr>
show;
}
?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>