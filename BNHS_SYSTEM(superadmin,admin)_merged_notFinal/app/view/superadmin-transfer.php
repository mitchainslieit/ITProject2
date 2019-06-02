	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
	<?php 
		if(isset($_POST['accept-button-all'])){
			extract($_POST);
			$obj->acceptTransferRequest();
		}
		if(isset($_POST['reject-button-all'])){
			extract($_POST);
			$obj->rejectTransferRequest();
		}
	?>
	
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>Accept Request</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent transferContent">
					<div class="cont1">
						<div class="box box1">
							<p>Grade Level and Section:</p>
							<select name="gradeAndsection" id="gradeAndsection" class="year_level">
								<option value="">All</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>
					</div>
					<div class="cont2">
						<form action="superadmin-transfer" method="POST" id="form1"></form>
						<table id="superadmin-table-transfer" class="display">
							<thead>
								<tr>
									<th><span class="selectAll">Select All</span><input type="checkbox" id="checkAl" class="selectAllCheck" form="form1"> </th>
									<th class="tleft">LRN</th>
									<th class="tleft">Name</th>
									<th class="tleft">Current Section</th>
									<th class="tleft">Year Level</th>
									<th class="tleft">Requesting Adviser</th>
									<th class="tleft">Transfer To Section</th>
								</tr>
							</thead>
							<tbody>
<?php foreach($obj->showOppoStudent() as $value){
extract($value);
echo '
<tr>
	<td><input type="checkbox" id="checkItem" name="check[]" value="'.$stud_id.'" form="form1"></td>
	<td class="tleft">'.$stud_lrno.'</td>
	<td class="tleft">'.$stud_fullname.'</td>
	<td class="tleft">'.$currentSection.'</td>
	<td class="tleft">'.$year_level.'</td>
	<td class="tleft">'.$faculty_fullname.'</td>
	<td class="tleft">'.$transferToSection	.'</td>
</tr>';	
}							
?>								
							</tbody>
						</table>
						<p class="tleft buttonContainer"><button type="submit" form="form1" name="accept-button-all" class="customButton">Accept <i class="fas fa-check"></i></button><button type="submit" form="form1" name="reject-button-all" class="customButton">Reject <i class="fas fa-trash-alt"></i></button></p>
					</div>
				</div>
			</div>
		</div>
	</div>
