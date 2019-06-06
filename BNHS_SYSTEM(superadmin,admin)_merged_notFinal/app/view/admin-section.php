	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct(); ?>
	<?php
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	?>
	<?php 
		if(isset($_POST['submit-button'])){
			extract($_POST);
			$obj->addSection($s_name, $gr_lvl);
		}
		if(isset($_POST['update-button'])){
			extract($_POST);
			$obj->updatesection($sectionid, $s_name, $gr_lvl);
		}
		if(isset($_POST['delete-button'])){
			extract($_POST);
			$obj->deleteSection($sectionid);
		}
		if(isset($_POST['delete-all-button'])){
			extract($_POST);
			$obj->multipleDeleteSection();
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
						<span>Section</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent sectionContent">
					<div class="cont1">
						<div name="content">
							<button name="opener" class="customButton">Add Section <i class="fas fa-plus fnt"></i></button>
							<div name="dialog" title="Add Section">
								<form action="admin-section" method="POST" autocomplete="off">
									<span>Grade Level</span>
									<select name="gr_lvl" value="" required>
										<option value="" selected disabled hidden>Select Grade Level</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
									</select>
									<span>Section Name:</span>
									<input type="text" name="s_name" value="" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Section Name" required>
									<button name="submit-button" class="customButton">Save <i class="fas fa-save fnt"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="cont2">
						<form method="post" action="admin-section" id="form1"></form>
							<table id="admin-table-section" class="display">
								<thead>
									<tr>
										<th><span class="selectAll">Select All</span><input type="checkbox" id="checkAl" class="selectAllCheck" form="form1"> </th>
										<th class="tleft custPad">Grade Level</th>
										<th class="tleft custPad">Section Name</th>
<?php 
										$queryCount=$this->conn->prepare("SELECT * from section_temp st join request r on r.request_id = st.sec_req where r.request_status = 'Temporary' and (r.request_type='Insert' or r.request_type='Delete' or r.request_type='Update')");
										$queryCount->execute();
										$rowQueryCount=$queryCount->rowCount();
										echo $rowQueryCount > 0 ? '<th class="tleft custPad">Request</th>' : '';
										echo '
										<th>Action</th>
									</tr>
								</thead>
								<tbody>';
foreach ($obj->showSectionTable() as $value) {
	extract($value);
	$grade_level = ['7', '8', '9', '10'];
	echo '
		<tr>
			<td><input type="checkbox" id="checkItem" name="check[]" value="'.$sectionid.'" form="form1"></td>
			<td class="tleft custPad">'.$gr_lvl.'</td>
			<td class="tleft custPad">';
			if($request_status=='Temporary'){
				echo '<span class="temporary">'.$s_name.'</span>';
			}else{
				echo $s_name;
			}
			echo'
			</td>
			';
			if($request_type == "Update" && $request_status=='Temporary'){
				echo '<td class="tleft custPad">For approval to '.$request_type.'</td>';
			}else{
				echo'';
			}if($request_type == "Insert" && $request_status=='Temporary'){
				echo '<td class="tleft custPad">For approval to '.$request_type.'</td>';
			}else{
				echo '';
			} if($request_type == "Delete" && $request_status=='Temporary'){
				echo '<td class="tleft custPad">For approval to '.$request_type.'</td>';
			}else{
				echo '';
			}
			echo'</td>
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
							<input type="hidden" value="'.$sectionid.'" name="sectionid">
							<span>Grade Level</span>
							<select name="gr_lvl" required>
							';
							for ($c = 0; $c < sizeof($grade_level); $c++) {
								echo $gr_lvl === $grade_level[$c] ? '<option value="'.$grade_level[$c].'" selected="selected">'.$grade_level[$c].'</option>' : '<option value="'.$grade_level[$c].'">'.$grade_level[$c].'</option>';	
							}
							echo '
							</select>
							<span>Section Name</span>
							<input type="text" name="s_name" value="'.$s_name.'" data-validation="length custom required" data-validation-length="max45" data-validation-regexp="^[a-zA-Z\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphabets only" placeholder="Section Name"  required>
							<button name="update-button" class="customButton" >Update <i class="fas fa-save fnt"></i></button>
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
							<input type="hidden" value="'.$sectionid.'" name="sectionid">
							<button type="submit" name="delete-button" class="customButton">Yes <i class="fas fa-save fnt"></i> </button>
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
						<p class="tleft"><button type="submit" form="form1" name="delete-all-button" class="customButton">Delete <i class="fas fa-trash-alt"></i></button></p>
					</div>
				</div>
			</div>
		</div>
	</div>
