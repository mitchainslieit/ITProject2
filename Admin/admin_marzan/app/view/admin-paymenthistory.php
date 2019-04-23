	<?php require 'app/model/admin-funct.php'; $obj = new AdminFunct;?>
	<?php
	if (isset($_POST['update-button'])){
			extract($_POST);
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
					<p>	
						<i class="fas fa-money-bill fnt"></i>
						<span>Student's Payment Transactions</span>
					</p>
					<p>School Year: 2019-2020</p>
				</div>	
				<div class="widgetContent">
					<p>Miscellaneous Fee: &#x20B1; <?php $obj->getMiscFee(); ?></p>

					<div class="cont1">
						<p>Grade Level:</p>
						<select name="year_level" class="year_level_payhist">
							<option value="">All</option>
							<option value="7">Grade 7</option>
				            <option value="8">Grade 8</option>
				            <option value="9">Grade 9</option>
			               	<option value="10">Grade 10</option>
						</select>
					</div>
					<div class="cont2">
						<table id="admin-table-payhist" class="display">
							<thead>
								<tr>
									<th>LRN</th>
									<th>Name</th>
									<th>Grade Level</th>
									<th>Section Name</th>
									<th>OR Number</th>
									<th>Latest Payment Timestamp</th>
									<th>Amount Paid</th>
									<th>Payment History</th>
								</tr>
							</thead>
							<tbody>

<?php
 foreach($obj->showPaymentHistory('bal_id','stud_lrno', 'first_name', 'middle_name', 'last_name', 'year_level', 'sec_name', 'orno', 'pay_date', 'pay_amt') as $value){
 extract($value);
 echo '
 <tr>
	 <td>'.$stud_lrno.'</td>
	 <td>'.$Name.'</td>	
	 <td>'.$year_level.'</td>
	 <td>'.$sec_name.'</td>
	 <td>'.$orno.'</td>
 	 <td>'.$payment_date.'</td>
 	 <input type="hidden" value="'.$bal_id.'" /> 
	 <td align="right">&#8369;'.number_format($pay_amount, 2).'</td>
	 <td class="action">
 		<div name="content">
		 <button name="opener" class="customButton">View Previous Payments</button>
			<div name="dialog" title="History of Payments">
				<div class="cont2">
					<table id="admin-table" class="display">
						<thead>
							<tr>
								<th align="center">Amount Paid</th>
								<th align="center">OR Number</th>
								<th align="center">Previous Payment Timestamp</th>
							</tr>
						</thead>
						<tbody>';
						$sql=$this->conn->prepare("SELECT pm.pay_amt, pm.orno, DATE_FORMAT(MAX(pm.pay_date), '%M %e %Y - %H:%i:%S') AS 'payment_date' FROM balance bal
						 JOIN balpay bp ON bp.bal_ida = bal.bal_id
						 JOIN payment pm ON pm.pay_id = bp.pay_ida
						 JOIN student st ON st.stud_id = bal.stud_idb
						 JOIN budget_info bi ON pm.budg_ida = bi.budget_id
						 WHERE bal_id = :bal_id GROUP BY pay_id") or die("failed!");
						$sql->execute(array(':bal_id' => $bal_id));		
						while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
							echo'
								<tr>
								 <td align="right">&#8369;'.number_format($row['pay_amt'], 2).'</td>
								 <td align="center">'.$row['orno'].'</td>
								 <td align="center">'.$row['payment_date'].'</td>
								</tr>
							';
						}
					echo'
						</tbody>
					</table>	
				</div>				
			</div>
		</div>
	 </td>
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