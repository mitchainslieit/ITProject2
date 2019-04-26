	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct(); ?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->addClass($sec_id, $fac_idv);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			$obj->updateClass($sec_id, $fac_idv);
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
									<select name="fac_idv" data-validation="required" required>
										<option selected disabled hidden value="">Choose Adviser</option>
										<?php 
											$obj->facultyList();
										?>
									</select>
									<span>Section Name:</span>
									<select name="sec_id" data-validation="required" required>
										<option selected disabled hidden value="">Select Section Name</option>
										<?php
											$obj->section();	
										?> 	
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
									<th class="tleft custPad">Employee ID</th>
									<th class="tleft custPad">Name</th>
									<th class="tleft custPad">Section Name</th>
									<th class="tleft custPad">Grade Level</th>
									<th>Action</th>
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
		<td class="tleft custPad">'.$fac_no.'</td>
		<td class="tleft custPad">'.$fullname.'</td>
		<td class="tleft custPad">'.$sec_name.'</td>
		<td class="tleft custPad">'.$grade_lvl.'</td>
		<td class="action">
			<div name="content">
				<button name="opener">
					<div class="tooltip">
						<i class="fas fa-edit"></i>
						<span class="tooltiptext">edit</span>
					</div>
				</button>
				<div name="dialog" title="Update class data">
					<form action="admin-classes" method="POST" required>
						<input type="hidden" name="sec_id" value="'.$sec_id.'">
						<span>Employee ID</span>
						<input type="text" name="" value="'.$fac_no.'" disabled="disabled">
						<span>Adviser Name</span>
						<select name="fac_idv" data-validation="required" >
							';
							for ($c = 0; $c < sizeof($faculty_id); $c++) {
								if($fac_id==$faculty_id[$c]){
									echo '<option value="'.$faculty_id[$c].'" selected>';
								}else{
									echo '<option value="'.$faculty_id[$c].'"">';
								}
								echo ''.$facultyname[$c].'</option>';
							}
							echo '
						</select>
						<span>Section Name</span>
						<select name="" disabled="disabled">
							<option value="">'.$sec_name.'</option>
						</select>
						<span>Grade Level:</span>
						<select name="" disabled="disabled">
							<option value="">'.$grade_lvl.'</option>
						</select>
						<button name="update-button" class="customButton">Update <i class="fas fa-save fnt"></i></button>
					</form>
				</div>  
			</div>
		</td>
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
