	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct(); ?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->addClass($sectionid, $fc_id);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			$obj->updateClass($sectionid, $fc_id);
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
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<div name="content">
							<button name="opener" class="customButton">Add class <i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Add Class">
								<form action="admin-classes" method="POST" autocomplete="off">
									<span>Choose Adviser</span>
									<select name="fc_id" data-validation="required" required>
										<option selected disabled hidden value="">Choose Adviser</option>
										<?php 
											$obj->facultyList();
										?>
									</select>
									<span>Section Name:</span>
									<select name="sectionid" data-validation="required" required>
										<option selected disabled hidden value="">Select Section Name</option>
										<?php
											$obj->sectionTemp();	
										?> 	
									</select>
									<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="cont2">
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
										echo $rowQueryCount > 0 ? '<th>Request</th>' : '';
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
	echo $request_status == "Temporary" ? '<td class="tleft"><span class="temporary">'.$s_name.'</span></td>' : '<td class="tleft">'.$s_name.'</td>';
	echo '<td class="tleft">'.$gr_lvl.'</td>';
 	if($rowQueryCount > 0){
	 	if($request_status == "Temporary" && ($request_type=='Adviser_Insert' || $request_type='Adviser_Update')){
	 		echo '
	 		<td>For Approval to 
	 		';
	 			if($request_type == 'Adviser_Insert'){
	 				echo 'Assign Adviser';
	 			}else if($request_type == 'Adviser_Update'){
	 				echo 'Update Adviser';
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
					<form action="admin-classes" method="POST" required autocomplete="off">
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
			<div class="widget">	
				<div class="header">	
					<p>	<i class="fa fa-user fnt"></i><span>Adviser Class Schedule</span></p>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
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
