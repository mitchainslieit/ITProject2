	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>

	<?php
	if (isset($_POST['update-button'])){
			extract($_POST);
		}
	?>

	<div class="contentpage">
		<div class="row">	
			<div class="widget">	
				<div class="header">	
					<p>	
						<i class="fas fa-money-bill fnt"></i>
						<span>Payment History</span>
					</p>
					<p>School Year: 2019-2020</p>
				</div>	
				<div class="widgetContent">
					<div class="cont1">
						<p>Miscellaneous Fee: &#x20B1; <?php $obj->getMiscFee(); ?></p>
			         </div>
					<div class="cont2">
						<table id="admin-table" class="display">
							<thead>
								<tr>
									<th>LRN</th>
									<th>Name</th>
									<th>Grade Level</th>
									<th>Section Name</th>
									<th>OR Number</th>
									<th>Payment Timestamp</th>
									<th>Amount Paid</th>									
									<th>Remaining Balance</th>
								</tr>
							</thead>
							<tbody>

<?php
 foreach($obj->showPaymentHistory('stud_lrno', 'first_name', 'middle_name', 'last_name', 'year_level', 'sec_name', 'orno', 'pay_date', 'pay_amt', 'bal_amt') as $value){
 extract($value);
 echo '
 <tr>
	 <td>'.$stud_lrno.'</td>
	 <td>'.$first_name,' ', $middle_name,' ', $last_name.'</td>
	 <td>'.$year_level.'</td>
	 <td>'.$sec_name.'</td>
	 <td>'.$orno.'</td>
 	 <td>'.$payment_date.'</td>
	 <td align="right">&#8369;'.number_format($pay_amt, 2).'</td>
 	 <td align="right">&#8369;'.number_format($remain_bal, 2).'</td>
 </tr> ';
 }
 ?>	
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>	
	</div>