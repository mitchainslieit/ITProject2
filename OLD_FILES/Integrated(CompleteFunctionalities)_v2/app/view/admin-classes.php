	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct(); ?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->addClass($sectionid, $fc_id);
		}
		if(isset($_POST['reject-button'])){
			extract($_POST);
			$obj->updateClass($sectionid, $fc_id);
		}
		if (isset($_POST['cancel-button'])){
			extract($_POST);
			$obj->cancelClasses($request_id);
		}
	?>
	<?php
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Classes</span>
					</div>
					<p>School Year:  <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<div name="content">
							<button name="opener" class="customButton">Add class <i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Add Class">
								<form action="admin-classes" method="POST" autocomplete="off">
									<span>Choose Adviser</span>
									<?php $obj->facultyList();?>
									<span>Section Name:</span>
									<?php $obj->sectionTemp();?> 
									<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="cont2">
						<form action="admin-classes" method="POST" id="form2"></form>
						<table id="admin-table-classes" class="display">
							<thead>
								<tr>
									<th class="tleft custPad">Employee ID</th>
									<th class="tleft custPad">Adviser</th>
									<th class="tleft custPad">Section Name</th>
									<th class="tleft custPad">Grade Level</th>
<?php 
										$queryCount=$this->conn->prepare("SELECT * from section_temp st join request r on r.request_id = st.sec_req where r.request_status = 'Temporary' and (r.request_type='Adviser_Insert' or r.request_type='Adviser_Update')");
										$queryCount->execute();
										$rowQueryCount=$queryCount->rowCount();
										echo $rowQueryCount > 0 ? '<th>Request Type</th>' : '';
										echo $rowQueryCount > 0 ? '<th>Request Status</th>' : '';
									echo'
									<th>Action</th>
								</tr>
							</thead>
							<tbody>';
foreach ($obj->showClasses() as $value) {
extract($value);
$faculty_id = $obj->faculty_id();
$facultyname = $obj->facultyname();
$section_type=['A','B'];
echo '
	<tr>
	<td class="tleft">'.$fac_no.'</td>
	<td class="tleft">'.$fullname.'</td>';
	echo $request_status == "Temporary" ? '<td class="tleft"><div class="temporaryContainer"><span class="temporary">'.$s_name.'</span><span class="temporaryDesc">There is a pending request in this section!</span></div></td>' : '<td class="tleft">'.$s_name.'</td>';
	echo '<td class="tleft">'.$gr_lvl.'</td>';
	if($rowQueryCount > 0){
	 	if($request_status == "Temporary"){
	 		echo '
	 		<td>
	 		';
	 			if($request_type == 'Adviser_Insert'){
	 				echo 'Add';
	 			}else if($request_type == 'Adviser_Update'){
	 				echo 'Update';
	 			}else{
	 				echo '';
	 			}
	 		echo'
	 		</td>
	 		';
	 	}else{
	 		echo '<td> </td>';
	 	}
 	}
 	if($rowQueryCount > 0){
	 	if($request_status == "Temporary"){
	 		echo '
	 		<td>
	 		';
	 			if($request_type == 'Adviser_Insert' || $request_type == 'Adviser_Update'){
	 				echo '<div class="pendingContainer">
	 						<button class="pending">Pending</button>
 							<input type="hidden" name="request_id" value="'.$request_id.'" form="form2">
 							<button class="cancel" name="cancel-button" form="form2"><i class="far fa-window-close"></i></button>
 						</div>';
	 			}else{
	 				echo '';
	 			}
	 		echo'
	 		</td>
	 		';
	 	}else{
	 		echo '<td> </td>';
	 	}
 	}
	echo'
		<td class="action">
			<div name="content">
				<button name="opener">
					<div class="tooltip">
						<i class="fas fa-edit"></i>
						<span class="tooltiptext">edit</span>
					</div>
				</button>
				<div name="dialog" title="Update class data">
					<form action="admin-classes" method="POST" required autocomplete="off" class="validateChangesInForm">
						<input type="hidden" name="sectionid" value="'.$sectionid.'">
						<span>Employee ID</span>
						<input type="text" name="" value="'.$fac_no.'" disabled="disabled">
						<span>Adviser Name</span>
						<select name="fc_id" data-validation="required" >
							';
							for ($c = 0; $c < sizeof($faculty_id); $c++) {
								if($fc_id==$faculty_id[$c]){
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
							<option value="">'.$s_name.'</option>
						</select>
						<span>Grade Level:</span>
						<select name="" disabled="disabled">
							<option value="">'.$gr_lvl.'</option>
						</select>
						<button name="reject-button" class="customButton">Update <i class="fas fa-save fnt"></i></button>
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
			<div class="widget">	
				<div class="header">	
					<p>	<i class="fa fa-user fnt"></i><span>Adviser Class Schedule</span></p>
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>	
				<div class="editContent widgetcontent">
					<div class="cont2">
						<div class="table-scroll">
							<div class ="cont fl">
								<span>SECTION: </span>
								<select name="sectionid" id="getCurrentLevel">
									<?php $obj->showSections(); ?>
								</select>
							</div>
							<?php $obj->showTabledSections(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
