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
	
					<div class="cont1">
						<div class="box box2">
							<p>Year:</p>
							<select name="year" id="yearSuperadminTable" class="year_level_balstatus3">
								<?php $obj->getYears(); ?>
							</select>
						</div>
						<div class="box box3">
							<p>Balance Status:</p>
							<select name="bal_status" class="year_level_balstatus2">
								<option value="">All</option>
								<option value="Cleared">Cleared</option>
								<option value="Not Cleared">Not Cleared</option>
							</select>
						</div>
						<div class="box box1">
							<p>Grade Level and Section:</p>
							<select name="gradeAndsection" id="gradeAndsection" class="year_level_balstatus1">
								<option value="">All</option>
								<?php $obj->getGradeAndSection(); ?>
							</select>
						</div>
					</div>
					<div class="cont2">
						<table id="superadmin-table-paymentHistory" class="display">
							<thead>	
								<tr>
									<th>LRN</th>
									<th>Name</th>
									<th>Grade Level</th>
									<th>Section</th>
									<th>Year</th>
									<th>Miscellaneous Fee</th>
									<th>Balance Amount</th>
									<th>Balance Status</th>
									<th>section</th>
								</tr>
							</thead>
							<tbody>
								
<?php foreach ($obj->showHistoryPayment() as $value) {
extract($value);
echo '
<tr>
	<td>'.$stud_lrno.'</td>
	<td>'.$Name.'</td>
	<td>'.$year_level.'</td>
	<td>'.$section.'</td>
	<td>'.$prev_sy.'</td>
	<td align="right">'.number_format($misc_fee, 2).'</td>
	<td align="right">'.number_format($bal_amt, 2).'</td>
	<td>'.$bal_status.'</td>
	<td>'.str_replace(' ', '', strtolower(('Grade'.$year_level.'-'.$section))).'</td>
</tr>	
';
}
?>
								
							</tbody>
							<tfoot>
								<?php foreach ($obj->showHistoryPaymentCollected() as $value) {
									extract($value);
									echo'
									<tr>
										<td><b>TOTAL AMOUNT COLLECTED:</b></td>
										<td>'. number_format($totalAmtCollected, 2) .'</td>
										<td><b>Year: </b></td>
										<td>'.$bd_prevsy.'<td>
									</tr>
									';
									
								}
								?>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>