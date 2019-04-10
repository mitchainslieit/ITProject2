	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct(); ?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->addSubject($subj_dept, $subj_name);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			$obj->updateSubject($subj_id, $subj_dept, $subj_name);
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
						<span>Classes</span>
					</div>
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<div name="content">
							<button name="opener" class="customButton">Add subject <i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Add Class">
								<form action="admin-subjects" method="POST">
									<span>Subject Department:</span>
									<select name="subj_dept" value="" required>
										<option selected disabled hidden>Select Department</option>
										<option value="Filipino">Filipino</option>
										<option value="Math">Math</option>
										<option value="MAPEH">MAPEH</option>
										<option value="Science">Science</option>
										<option value="AP">AP</option>
										<option value="Math">Math</option>
										<option value="English">English</option>
										<option value="TLE">TLE</option>
										<option value="Math">Math</option>
									</select>
									<span>Subject Name:</span>
									<input type="text" name="subj_name" value="" required placeholder="Subject Name">
									<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="cont2">
						<table id="admin-table" class="stripe row-border order-column">
							<thead>
								<tr>
									<th>Subject Department</th>
									<th>Subject Name</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
<?php foreach ($obj->showSingleTable("subject") as $value) {
extract($value);
$department = ['Filipino', 'Math', 'MAPEH', 'Science', 'AP', 'Math', 'English', 'TLE', 'Values'];
echo '
	<tr>
		<td>'.$subj_dept.'</td>
		<td>'.$subj_name.'</td>
		<td class="action">
			<div name="content">
				<button name="opener">
					<div class="tooltip">
						<i class="fas fa-edit"></i>
						<span class="tooltiptext">edit</span>
					</div>
				</button>
				<div name="dialog" title="Update subjects data">
					<form action="admin-subjects" method="POST" required>
						<input type="hidden" name="subj_id" value="'.$subj_id.'" required>
						<span>Subject Department:</span>
						<select name="subj_dept">
						';
						for ($c = 0; $c < sizeof($department); $c++) {
							echo $subj_dept === $department[$c] ? '<option value="'.$department[$c].'" selected="selected">'.$department[$c].'</option>' : '<option value="'.$department[$c].'">'.$department[$c].'</option>';	
						}
						echo '
						</select>
						<span>Subject Name:</span>
						<input type="text" name="subj_name" value="'.$subj_name.'" required>
						<button name="update-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
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
				<div name="dialog" title="Delete subject data">
					<form action="admin-subjects" method="POST" required>
						<p>Are you sure you want to delete this subject?</p>
						<input type="hidden" value="'.$subj_id.'" name="subj_id">
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
