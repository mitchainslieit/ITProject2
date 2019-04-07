	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct(); ?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->addSubject($subjcode, $subj_name);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			$obj->updateSubject($subj_id, $subjcode, $subj_name);
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
									<span>Subject Code:</span>
									<input type="text" name="subjcode" value="" required placeholder="Subject Code">
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
									<th>Subject Code</th>
									<th>Subject Name</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
<?php foreach ($obj->showSingleTable("subject") as $value) {
extract($value);
echo '
	<tr>
		<td>'.$subjcode.'</td>
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
						<span>Subject Code:</span>
						<input type="text" name="subjcode" value="'.$subjcode.'" required>
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
