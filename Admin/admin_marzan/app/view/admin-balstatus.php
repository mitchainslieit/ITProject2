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
					<p>School Year: 2019-2020</p>
				</div>
				<div class="widgetContent">
					<p>Miscellaneous Fee: &#x20B1; <?php $obj->getMiscFee(); ?></p>

					<div class="cont1">
						<p>Grade Level:</p>
						<select name="year_level">
							<option value="All">All</option>
							<option value="Grade 7">Grade 7</option>
				            <option value="Grade 8">Grade 8</option>
				            <option value="Grade 9">Grade 9</option>
			               	<option value="Grade 10">Grade 10</option>
						</select>
						<p>Balance Status:</p>
						<select name="bal_status">
							<option value="Cleared">Cleared</option>
							<option value="Not Cleared">Not Cleared</option>>
						</select>
						<button name="view-status" class="customButton">View</button>
					</div>
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>	
								<tr>
									<th>LRN</th>
									<th>Name</th>
									<th>Grade Level</th>
									<th>Section</th>
									<th>Amount Paid</th>
									<th>Remaining Balance</th>
									<th>Balance Status</th>
								</tr>
							</thead>
							<tbody>
								
<?php foreach ($obj->showPaymentStatus() as $value) {
extract($value);
echo '
<tr>
	<td>'.$stud_lrno.'</td>
	<td>'.$first_name,' ', $middle_name,' ', $last_name.'</td>
	<td>'.$year_level.'</td>
	<td>'.$sec_name.'</td>
	<td align="right">&#8369;'.number_format($pay_amt, 2).'</td>
	<td align="right">&#8369;'.number_format($bal_amt, 2).'</td>
	<td>'.$bal_status.'</td>
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