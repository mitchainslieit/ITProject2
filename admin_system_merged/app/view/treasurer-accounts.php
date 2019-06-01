<?php require 'app/model/treasurer_func.php'; $run= new TreasurerFunc ?>

<?php
	$this->conn = new Connection;
	$this->conn = $this->conn->connect();
?>
<?php 
if (isset($_POST['update_funds'])) {
	extract($_POST);
   	$run->updateFees($_POST);
   	$run->getRange($bal_id);
}
?>
<div class="contentpage">
	<div class="row">	
		<div class="widget">	
			<div class="header">	
				<p>	
					<i class="fas fa-user-plus fnt"></i>
					<span>Payment Transaction</span>
				</p>
				<p>School Year: 2019-2020</p>
			</div>	
			<div class="eventcontent statementContent">
				<div class="cont1">
					<p>Miscellaneous Fee: <span>&#x20B1; <?php $run->getMiscellaneousFee(); ?></span></p>
				</div>
				<div class="widgetContent">
					<div class="cont1">
						<p>Grade Level: </p> &nbsp;
						<select name="year_level" class="year_level">
							<option value="">All</option>
							<option value="7">Grade 7</option>
							<option value="8">Grade 8</option>
							<option value="9">Grade 9</option>
							<option value="10">Grade 10</option>	
						</select>
					</div>
					<div class="cont2 treasurer-table-2-class">
						<table id="treasurer-table-2" class="display">
							<thead>	
								<tr>
									<th>LRN</th>
									<th>Student Name</th>
									<th> Remaining Balance </th>
									<th> Balance Status </th>
									<th> Latest Payment Date </th>
									<th> Actions </th>
									<th>level</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($run->getPaymentInfo() as $row){
									extract($row);
									echo '
									<tr>
										<td>'.$stud_lrno.'</td> 
										<td>'.$name.'</td>
										<td align="right"> &#x20B1;'.number_format($minbal,2).'</td>
										<td>'.$bal_status.'</td>
										<td>'.$date.'</td>
										<td>
											<div id="button-style">
<div name="content" id ="button1">
	<button type="button" name="opener">
		<div class="tooltip">
			<i class="fas fa-edit"></i>
			<span class="tooltiptext">Add Payment</span>
		</div>
	</button>
	<div name="dialog" title="Add Payment">		
		<div class="content">
			<div class="column left">
				<div id="columncontent">
					<p class="bold header heading" id="columncontent"><i class="fa fa-info-circle"></i>&nbsp;Student Information</p> 
					<p><span class="bold">Name:</span>&nbsp;'.$name.'</p> <br>
					<p><span class="bold">Balance:</span>&nbsp; &#x20B1;'.number_format($minbal,2).'</p>
					<br>	
				</div>
				<div>
					<div class="center">
						<p class="bold heading">Balance Details</p> 
					</div>
					<br>
					';
					$result_range = $run->getRange($bal_id);
					$fixed_range = $run->getBreakdownOfFees();
					$exist = false;
					foreach ($fixed_range as $fix) {
					foreach($result_range as $row){
					extract($row);
					/*'.$budg_namef.'*/
					if ($fix['budget_name'] === $budget_name) {
					$exist	= true;
					$budg_name = str_replace(' ', '', $budget_name);
					$budg_namef = strtolower($budg_name);
					$bal = $max === '0' ? '&#x20B1; 0.00' :'&#x20B1;'.number_format($max,2).'';
				} else {
				$exist = false;
				$budg_name = str_replace(' ', '', $fix['budget_name']);
				$budg_namef = strtolower($budg_name);
				$bal = '&#x20B1;'.number_format($fix['total_amount'],2).'';
				
			}
			$budget_name = ($exist === true ? $budget_name : $fix['budget_name']);
			if($exist === true) {
			break;
		}

	}
	echo ' 
	<div class="balDetails">
		<span class="bold">'.$budget_name.'</span>
		<span>'.$bal.'</span>
		<br>
	</div>

	';
}
echo '
</div>
</div>
<form action="treasurer-accounts" method="POST" autocomplete="off" class="update-form">
	<div class="column right">
		<div class="box1" id="columncontent">
			<label id="date">
				<span class="heading"> Select payment date: </span>
				<input type="text" name="pay_date" readonly="readonly" class="datepicker-payment" placeholder="" required/>
			</label>
			<label id ="orno">
				<span class="heading">OR Number:</span>
				<input type="text" name="orno" placeholder="Enter Official Receipt No."
				data-validation="length" data-validation-length="1-45" data-validation-error-mssg="Please input characters no more than 45 characters." maxlength="10" required />
			</label>
		</div>
		<span class="bold center"><i class="fa fa-money-bill-wave-alt"></i>&nbsp;Breakdown of Fees </span><p></p>
		<div class="box2">
			';
			$result_range = $run->getRange($bal_id);
			$fixed_range = $run->getBreakdownOfFees();
			$exist = false;
			foreach ($fixed_range as $fix) {
			foreach($result_range as $row){
			extract($row);
			if ($fix['budget_name'] === $budget_name) {
			$exist	= true;
			$budg_name = str_replace(' ', '', $budget_name);
			$budg_namef = strtolower($budg_name);
			$input = $max === '0' ? '<input type="text" id="color" name="payment[]" value="Cleared" placeholder="No balance." readonly/>' : '<input type="text" class="userInput" name="payment[]" placeholder="Enter Fees..."
			data-validation="number" data-validation-allowing="range[0;'.$max.'],float" data-validation-error-msg="Please check the balance details for the balance." value="0" data-initial ="0" />';
		} else {
		$exist = false;
		$budg_name = str_replace(' ', '', $fix['budget_name']);
		$budg_namef = strtolower($budg_name);
		$input = '<input type="text" class="userInput" name="payment[]" placeholder="Enter Fees..."
		data-validation="number" data-validation-allowing="range[0;'.$fix['total_amount'].'],float" data-validation-error-mssg="Please check the balance details for the balance." value="0" data-initial ="0" />';
		$budget_id = $fix['budget_id'];
		/*echo ' 
		<div class="innerCont">
			<span class="customSpan"><bold>'.$fix['budget_name'].'</bold> </span>
			'.$input.'
			<input type="hidden" name="bal_id" value="'.$bal_id.'	"/> 
		</div>

		';*/
	}
	$budget_name = ($exist === true ? $budget_name : $fix['budget_name']);
	if($exist === true) {
	break;
}

}
echo ' 
<div class="innerCont">
	<span class="customSpan heading">'.$budget_name.'</span>
	'.$input.'
	<input type="hidden" name="bal_id" value="'.$bal_id.'" /> 
	<input type="hidden" name="budget_id[]" value="'.$budget_id.'" />
	<input type="hidden" name="bal_amt" value="'.$bal_amt.'" />
	<input type="hidden" name="name" value="'.$name.'" />
</div>

';
}

echo '
</div>
<button id="update-button" name="update_funds" type="submit">Update</button>
</div>
</form>	

</div>
</div>
</div>
<div name="content">
	<button type="button" name="opener"> 
		<div class="tooltip">
			<i class="fas fa-eye"></i>
			<span class="tooltiptext">View Payment History</span>
		</div>
	</button>
	<div name="dialog" title="History of Payment">
	<span>Student Name: '.$name.'</span><br>
			<span>Balance: '.$minbal.'</span><br>
		<table class="display treasurer-table-4">
			<thead>	
				<tr>
					<th> Remaining Balance </th>
					<th> Amount Paid </th>
					<th> Payment Date </th>
					<th> Allocated Fund </th>
				</tr>
			</thead>
			<tbody> ';
				$query = $this->conn->prepare("SELECT 
				remain_bal,
				pay_amt,
				DATE_FORMAT(DATE(pay_date), '%M %e %Y') 'date',
				budget_name
				FROM
				balance bal
				JOIN
				balpay bp ON bp.bal_ida = bal.bal_id
				JOIN
				payment pm ON pm.pay_id = bp.pay_ida
				JOIN
				student st ON st.stud_id = bal.stud_idb
				JOIN
				budget_info bi ON pm.budg_ida = bi.budget_id
				WHERE
				bal_id = :balid
				ORDER BY 2 DESC") or die("failed!");
				$query->execute(array(':balid' => $bal_id));
				while($row=$query->fetch(PDO::FETCH_ASSOC)){
				echo '
				<tr>
					<td align="right"> &#x20B1; '.$row["remain_bal"].' </td>
					<td align="right"> &#x20B1; '.$row["pay_amt"].' </td>
					<td> '.$row["date"].' </td>
					<td> '.$row["budget_name"].' </td>
				</tr>
				';
			}

			echo ' 		
		</tbody>
	</table>
</div>
</div>
</div>	
</td>
<td>'.$year_level.'</td>
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
		<div class="tuition widget">
			<div class="container contright">
				<div class="innercont1">
					<div class="header">
						<p>	
							<i class="far fa-calendar-alt fnt"></i>
							<span>Breakdown of Fees</span>
						</p>
					</div>
					<div class="eventcontent">
						<div class="table-scroll">	
							<div class="table-wrap">	
								<table>
									<tr>
										<th>Breakdown</th>
										<th>Amount</th>   
									</tr>
									<?php 
									foreach($run->getBreakdown() as $row) {
										extract($row);
										echo '
										<tr>
										<td> '.$budget_name.' </td>
										<td align="right">'.number_format($total_amount,2).' </td> 
										</tr>
										';
									}
									?>
									<tr>
										<td><b>TOTAL AMOUNT:</b></td>
										<td><b><font color="green"><?php $run->getTotalBDOF(); ?></font></b></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container contright">
				<div class="innercont1">
					<div class="header">
						<p>	
							<i class="far fa-calendar-alt fnt"></i>
							<span>Total Accumulated Fee per Fund Type</span>
						</p>
					</div>
					<div class="eventcontent">
						<div class="table-scroll">	
							<div class="table-wrap">	
								<table>
									<tr>
										<th>Breakdown</th>
										<th>Amount</th>   
									</tr>
									<?php 
									foreach($run->getBreakdownOfFees() as $row) {
										extract($row);
										echo '
										<tr>
										<td> '.$budget_name.' </td>
										<td align="right">'.number_format($acc_amount,2).' </td> 
										</tr>
										';
									}
									?>
									<tr>
										<td><b>TOTAL AMOUNT:</b></td>
										<td><b><font color="green"><?php $run->getTotalFund(); ?></font></b></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
