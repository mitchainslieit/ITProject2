	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php
		if(isset($_POST['view-status'])){
			extract($_POST);
		}
	?>
	<div class="contentpage" id="contentpage">
		<div class="row">
			<div class="widget">	
				<div class="header">	
					<div class="cont">	
						<i class="fas fa-money-check"></i>
						<span>List of Student Payment Status</span>
					</div>
					<p>School Year: <?php echo date("Y"); ?> - <?php echo date("Y")+1; ?></p>
				</div>
				<div class="widgetContent balContent">
					<p>Miscellaneous Fee: &#x20B1; <?php $obj->getMiscFee(); ?></p>
	
					<div class="cont1">
						<div class="box box1">
							<p>Grade Level and Section:</p>
							<select name="gradeAndsection" id="gradeAndsection" class="year_level_balstatus1">
								<option value="">All</option>
								<?php $obj->getGradeAndSection(); ?>
							</select>
						</div>
						<div class="box box2">
							<p>Balance Status:</p>
							<select name="bal_status" class="year_level_balstatus2">
								<option value="">All</option>
								<option value="Cleared">Cleared</option>
								<option value="Not Cleared">Not Cleared</option>
							</select>
						</div>
					</div>
					<div class="cont2">
						<table id="admin-table-balstatus" class="display">
							<thead>	
								<tr>
									<th>LRN</th>
									<th>Name</th>
									<th>Grade Level</th>
									<th>Section</th>
									<th>Amount Paid</th>
									<th>Remaining Balance</th>
									<th>Balance Status</th>
									<th>section</th>
								</tr>
							</thead>
							<tbody>
								
<?php foreach ($obj->showPaymentStatus() as $value) {
extract($value);
echo '
<tr>
	<td>'.$stud_lrno.'</td>
	<td>'.$Name.'</td>
	<td>'.$year_level.'</td>
	<td>'.$sec_name.'</td>
	<td align="right">'.number_format($pay_amt, 2).'</td>
	<td align="right">'.number_format($remaining_balance, 2).'</td>
	<td>'.$bal_status.'</td>
	<td>'.str_replace(' ', '', strtolower(('Grade'.$year_level.'-'.$sec_name))).'</td>
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