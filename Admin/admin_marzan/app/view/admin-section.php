	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct(); ?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->addSection($sec_name, $grade_lvl);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			$obj->updatesection($sec_id, $sec_name, $grade_lvl);
		}
		if(isset($_POST['delete-button'])){
			extract($_POST);
			$obj->deleteSection($sec_id);
		}
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Section</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<div name="content">
							<button name="opener" class="customButton">Add Section <i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Add Section">
								<form action="admin-section" method="POST" autocomplete="off">
									<span>Section Name:</span>
									<input type="text" name="sec_name" value="" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Section Name" required>
									<span>Grade Level</span>
									<select name="grade_lvl" value="" required>
										<option value="" selected disabled hidden>Select Grade Level</option>
										
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
						<table class="admin-table" class="display">
							<thead>
								<tr>
									<th class="tleft custPad">Section Name</th>
									<th class="tleft custPad">Grade Level</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
<?php foreach ($obj->showSingleTable("Section") as $value) {
extract($value);
$grade_level = ['7', '8', '9', '10'];
echo '
	<tr>
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
				<div name="dialog" title="Update section data">
					<form action="admin-section" method="POST" required autocomplete="off">
						<input type="hidden" value="'.$sec_id.'" name="sec_id">
						<span>Section Name</span>
						<input type="text" name="sec_name" value="'.$sec_name.'" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Section Name" required>
						<select name="grade_lvl" required>
						';
						for ($c = 0; $c < sizeof($grade_level); $c++) {
							echo $grade_lvl === $grade_level[$c] ? '<option value="'.$grade_level[$c].'" selected="selected">'.$grade_level[$c].'</option>' : '<option value="'.$grade_level[$c].'">'.$grade_level[$c].'</option>';	
						}
						echo '
						</select>
						<button name="update-button" class="customButton">Update <i class="fas fa-save fnt"></i></button>
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
				<div name="dialog" title="Delete Section">
					<form action="admin-section" method="POST" required>
						<p>Are you sure you want to delete this Section?</p>
						<input type="hidden" value="'.$sec_id.'" name="sec_id">
						<button name="delete-button" class="customButton">Yes <i class="fas fa-save fnt"></i></button>
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
