<?php require 'app/model/treasurer_func.php'; $run= new TreasurerFunc ?>

<?php
$this->conn = new Connection;
$this->conn = $this->conn->connect();
?>
<?php 
if (isset($_POST['update_funds'])) {
	$run->updateBalance($_POST);
}
?>
<div class="contentpage">
	<div class="row">	
		<div class="widget">	
			<div class="header">	
				<p>	
					<i class="fas fa-user-plus fnt"></i>
					<span>Student's with Balance from Previous School Year</span>
				</p>
				<p>School Year: <?php $run->getSchoolYear(); ?></p>
			</div>	
			<div class="eventcontent statementContent">
				<div class="widgetContent">
					<div class="cont1">
						<p>Year: </p> &nbsp;
						<select name="year" class="year">
							<?php
							foreach($run->getBalYear() as $row){
								extract($row);
								echo '<option value='.$row['prev_sy'].'>'.$row['prev_sy'].'</option>';
							}
							?>
						</select>
					</div>
					<div class="cont1">
						<p>Balance Status: </p> &nbsp;
						<select name="bal_status" class="year_level">
							<option value=""> No selected </option>
							<option value="Cleared"> Cleared </option>
							<option value="Not Cleared"> Not Cleared </option>
							<?php
							/*foreach($run->getPrevBalStat() as $row){
								echo '<option value="'.$row['bal_status'].'" data-yr="">'.$row['bal_status'].'</option>';
							}*/
							?>
						</select>
					</div>
					<div class="cont1" id="unique">
						<p id="unique1">Previous Miscellaneous Fee:<span id="unique2"> <?php $run->getPrevMiscFee(); ?></span></p>
					</div>

					<div class="cont2 treasurer-table-2-class">
						<table id="treasurer-table-3" class="display">
							<thead>	
								<tr>
									<th>Student Name</th>
									<th> Remaining Balance </th>
									<th> Latest Payment Date </th>
									<th> Latest Official Receipt No. </th>
									<th> Balance Status </th>
									<th> Actions </th>
									<th>year</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($run->getStudWBalance() as $row){
									extract($row);
									echo '
									<tr>
									<td>'.$name.'</td>
									<td align="right"> &#x20B1;'.number_format($minbal,2).'</td>
									<td>'.$date.'</td>
									<td> '.$orno.'</td>
									<td> '.$bal_status.' </td>
									<td>';		
									if($bal_status === 'Not Cleared'){
										echo'
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
										$fixed_range = $run->getFundBal($stud_id);

										foreach ($fixed_range as $fix) {
											$result = explode(';',$fix['fund_bal']);
											$budget_name = explode(',',$result[0]);
											$balance = explode(',', $result[1]);
											$bd_length = count($budget_name);
											$bal_length = count($balance);
											for($i = 0; $i < $bd_length; $i++){
												$bd_name[] = $budget_name[$i];	
											}
											for($j = 0; $j < $bal_length; $j++){	
												$bal[] = $balance[$j];
											}
										}

										for($i = 0; $i < $bd_length; $i++){
											echo ' 
											<div class="balDetails">
											<span class="bold">'.$budget_name[$i].'</span>
											<span>&#x20B1;'.number_format($balance[$i],2).'</span>
											<br>
											</div>
											';	
										}

										echo '
										</div>
										</div>
										<form action="treasurer-balance" method="POST" autocomplete="off" class="update-form">
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
										$fixed_range = $run->getFundBal($stud_id);

										foreach ($fixed_range as $fix) {
											$result = explode(';',$fix['fund_bal']);
											$budget_name = explode(',',$result[0]);
											$balance = explode(',', $result[1]);
											$bd_length = count($budget_name);
											$bal_length = count($balance);
											for($i = 0; $i < $bd_length; $i++){
												$bd_name[] = $budget_name[$i];	
											}
											for($j = 0; $j < $bal_length; $j++){	
												$bal[] = $balance[$j];
											}
										}
										for($i = 0; $i < $bd_length; $i++){
											$input = $balance[$i] === '0' ? '<input type="text" id="color" name="payment[]" value="Cleared" placeholder="No balance." readonly/>' : '<input type="text" class="userInput" name="payment[]" placeholder="Enter Fees..."
										data-validation="number" data-validation-allowing="range[0;'.$balance[$i].'],float" data-validation-error-msg="Please check the balance details for the balance." value="0" data-initial ="0" />';
											echo ' 
											<div class="innerCont">
											<span class="customSpan heading">'.$budget_name[$i].'</span>
											'.$input.'
											<input type="hidden" name="budget_name[]" value="'.$budget_name[$i].'" />
											<input type="hidden" name="name" value="'.$name.'" />
											<input type="hidden" name="stud_id" value="'.$stud_id.'" />
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
										</div>	';
									} else {
										echo '';
									}

									echo'											
									</td>
									<td>'.$prev_sy.'</td>
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
</div>
