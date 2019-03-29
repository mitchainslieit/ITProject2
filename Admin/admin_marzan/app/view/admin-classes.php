	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct(); ?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->addClass($sec_name, $sec_type, $grade_lvl, $fac_idv);
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
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<div name="content">
							<button name="opener" class="customButton">Add class <i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Add Class">
								<form action="admin-classes" method="POST">
									<span>Choose Adviser</span>
									<select name="fac_idv" value="">
										<option selected disabled hidden>Choose Adviser</option>\
										<?php 
											$obj->facultylist();
										?>
										<!-- <?php
											/*$facultylist=$obj->facultylist();
											for ($c = 0; $c < sizeof($facultylist); $c++) {
												echo '<option value="'.$facultylist[$c].'">'.$facultylist[$c].'</option>';
											}	*/
										?> -->
									</select>
									<span>Section Name:</span>
									<input type="text" name="sec_name" value="" placeholder="Section Name" required>
									<span>Section Type:</span>
									<select name="sec_type" value="" required>
										<option selected disabled hidden>Select Section Type</option>
										<option value="A">A</option>
										<option value="B">B</option>
									</select>
									<span>Grade Level</span>
									<select name="grade_lvl">
										<option selected disabled hidden>Select Grade Level</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
									</select>
									<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>Employee ID</th>
									<th>Name</th>
									<th>Section Name</th>
									<th>Grade Level</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
<?php foreach ($obj->showClasses() as $value) {
extract($value);
echo <<<show
	<tr>
		<td>$fac_no</td>
		<td>$fac_fname $fac_midname $fac_lname</td>
		<td>$sec_name</td>
		<td>$grade_lvl</td>
		<td></td>
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
	</div>
