	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct(); ?>
	
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
					</div>
					<div class="cont2">
						<table id="superadmin-table-all" class="display">
							<thead>
								<tr>
									<th class="tleft">Employee ID</th>
									<th class="tleft">Adviser</th>
									<th class="tleft">Section Name</th>
									<th class="tleft">Grade Level</th>
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
		<td class="tleft">'.$fac_no.'</td>
		<td class="tleft">'.$fullname.'</td>
		<td class="tleft">'.$sec_name.'</td>
		<td class="tleft">'.$grade_lvl.'</td>
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
