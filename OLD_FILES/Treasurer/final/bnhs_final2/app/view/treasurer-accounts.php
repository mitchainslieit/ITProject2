<?php require 'app/model/treasurer_func.php'; $run= new TreasurerFunc ?>
k
<?php 
if (isset($_POST['update_funds'])) {
	extract($_POST);
	$run->updateFees($bal_id, $pay_date, $orno, $ptafund, $utility, $internetforstudents, $schoolpaper, $organizationsfee, $tlefee, $ssgfee, $sciencefee);
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
							<option value="All">All</option>
							<option value="Grade 7">Grade 7</option>
							<option value="Grade 8">Grade 8</option>
							<option value="Grade 9">Grade 9</option>
							<option value="Grade 10">Grade 10</option>	
						</select>
					</div>
					<div class="cont2 treasurer-table-2-class">
						<table id="treasurer-table-2" class="display">
							<?php $grade = (isset($_SESSION['tres-grade-lvl']) ? $_SESSION['tres-grade-lvl'] : 'All'); ?>
							<thead>	
								<tr>
									<th>LRN</th>
									<th>Student Name</th>
									<th> Remaining Balance </th>
									<th> Balance Status </th>
									<th> Latest Payment Date </th>
									<th> Actions </th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($run->getPaymentInfo($grade) as $row){
									extract($row);
									echo '
									<tr>
										<td>'.$stud_lrno.'</td> 
										<td>'.$name.'</td>
										<td align="right"> &#x20B1;'.number_format($minbal,2).'</td>
										<td>'.$bal_status.'</td>
										<td>'.$date.'</td>
										<td>
											<div name="content">
												<button class="customButton" name="opener">Update</button>
												<div name="dialog" title="Update Payment">
													<form action="treasurer-accounts" method="POST" autocomplete="off">
														<label>
															<span>LRN Number: '.$stud_lrno.'</span><br>
															<span>Student Name: '.$name.'</span><br>
															<span>Balance: &#x20B1;'.number_format($minbal,2).'</span><br>
														</label>
														<div class="box1">
															<label>
																<span class="customSpan"> Select payment date: </span>
																<input type="date" name="pay_date" placeholder=""/> <br>
															</label>
															<label>
																<span class="customSpan">OR Number:</span>
																<input type="text" name="orno" placeholder="Enter Official Receipt No." />
															</label>
														</div>
														<div class="box2">
														

									';
									foreach($run->getRange("$bal_id") as $row){
										extract($row);
										$budg_name = str_replace(' ', '', $budget_name);
										$budg_namef = strtolower($budg_name);
										$input = $max === '0' ? '<input type="text" name="'.$budg_namef.'" placeholder="No balance left."
										data-validation="number" data-validation-allowing="range[1;'.$max.'],float" disabled/>' : '<input type="text" name="'.$budg_namef.'" placeholder="Enter Fees..."
										data-validation="number" data-validation-allowing="range[1;'.$max.'],float" />';
										echo ' 
											
												<div class="innerCont">
													<span class="customSpan"><bold>'.$budget_name.'</bold> </span>
													 '.$input.'
													<input type="hidden" name="bal_id" value="'.$bal_id.'	"/> 
												</div>
											
										';
									}

									echo '
														</div>		
														<button name="update_funds" type="submit">Update</button>
													</form>
												</div>
											</div>
											<div name="content">
												<button class="customButton" name="opener"> View </button>
												<div name="dialog" title="History of Payment">
													<table id="treasurer-table-1" class="display">
														<span>Student Name: '.$name.'</span><br>
														<span>Balance: '.$minbal.'</span><br>
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
										</td>
									</tr>
									';
								}
								?>
							</tbody>
						</table>
						<?php unset($_SESSION['tres-grade-lvl']); ?>
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
									foreach($run->getBreakdownOfFees() as $row) {
										extract($row);
										echo '
										<tr>
										<td> '.$budget_name.' </td>
										<td align="right"> &#x20B1; '.number_format($total_amount,2).' </td> 
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
										<td align="right"> &#x20B1; '.number_format($acc_amount,2).' </td> 
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