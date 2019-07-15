	<?php require 'app/model/Superadmin-funct.php'; $obj = new SAdminFunct;?>
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
						<span>History of Fee Type</span>
					</div>
					<p>School Year: <?php $obj->getSchoolYear(); ?></p>
				</div>
				<div class="widgetContent feeTypeHistoryContent">
					<div class="cont1">
						<div class="box box2">
							<p>Year:</p>
							<p class="tleft" ><select name="year" id="yearSuperadminTable" class="year_level_balstatus1 ">
								<?php $obj->getYearsPaymentCollected(); ?>
							</select>
							</p>
						</div>
						<div class="box box5">
							<p>Miscellaneous Fee:</p> 
							<p class="tleft"><?php $obj->showHistoryAmountAllocated(); ?></p>
						</div>
						<div class="box box4">
							<p>Total Amount Collected:</p>
							<p class="tleft"><?php $obj->showHistoryPaymentCollected(); ?></p>
						</div>
					</div>
					<div class="cont2">
						<table id="superadmin-table-feetypeHistory" class="display">
							<thead>	
								<tr>
									<th>Fee Type</th>
									<th>Allocated Amount</th>
									<th>Total Amount Collected</th>
									<th>Year</th>
								</tr>
							</thead>
							<tbody>
								
<?php foreach ($obj->showHistoryFeetype() as $value) {
extract($value);
echo '
<tr>
	<td class="tleft custPad">'.$bd_name.'</td>
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