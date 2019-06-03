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
				<div class="widgetContent feeTypeHistoryContent">
					<div class="cont1">
						<div class="box box2">
							<p>Year:</p>
							<select name="year" id="year" class="year_level_balstatus1">
								<option value="">All</option>
								<?php $obj->getYears(); ?>
							</select>
						</div>
					</div>
					<div class="cont2">
						<table id="admin-table-feetypeHistory" class="display">
							<thead>	
								<tr>
									<th>Fee Type</th>
									<th>Amount Accumulated</th>
									<th>Account Amount</th>
									<th>Year</th>
								</tr>
							</thead>
							<tbody>
								
<?php foreach ($obj->showHistoryFeetype() as $value) {
extract($value);
echo '
<tr>
	<td>'.$bd_name.'</td>
	<td align="right">'.number_format($bd_amountalloc, 2).'</td>
	<td align="right">'.number_format($bd_accamount, 2).'</td>
	<td>'.$bd_prevsy.'</td>
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